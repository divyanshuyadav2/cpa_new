<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Division;
use App\Models\Order;
use App\Models\Product;
use App\Models\Salt;
use Tests\TestCase;

class B2BComplianceCheckoutTest extends TestCase
{
    /**
     * Helper to get an active product or create one for test execution.
     */
    protected function getTestProduct(array $overrides = []): Product
    {
        $existing = Product::where('is_active', true)->first();
        if ($existing && empty($overrides)) {
            return $existing;
        }

        $company = Company::first() ?? Company::create(['name' => 'Test Pharma Co']);
        $division = Division::first() ?? Division::create(['name' => 'General', 'company_id' => $company->id]);
        $salt = Salt::first() ?? Salt::create(['name' => 'Paracetamol']);

        return Product::create(array_merge([
            'name' => 'Test Pharma Brand 500',
            'company_id' => $company->id,
            'division_id' => $division->id,
            'salt_id' => $salt->id,
            'composition' => 'Paracetamol 500mg',
            'packing' => '10x10 Tablets',
            'mrp' => 120.00,
            'ptr' => 80.00,
            'pts' => 70.00,
            'stock_qty' => 50,
            'is_active' => true,
        ], $overrides));
    }

    /**
     * Requirement 1: Global Disclaimers on Header and Footer.
     */
    public function test_global_disclaimers_rendered_on_pages(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Header Sticky Notice
        $response->assertSee('B2B Supply Only: This portal is exclusively for licensed chemists, pharmacies, and healthcare distributors.');

        // Footer Legal Disclaimer
        $response->assertSee('We are a licensed wholesale drug distributor. We do not sell or deliver medicines to individual retail consumers or patients.');
        $response->assertSee('Drugs and Cosmetics Act, 1940');
    }

    /**
     * Requirement 2: Catalog cards contain Retailers Only badge.
     */
    public function test_product_catalog_contains_b2b_retailer_badges(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('For Licensed Retailers Only');
    }

    /**
     * Requirement 3: Checkout validation fails if dl_confirmed checkbox is missing.
     */
    public function test_checkout_fails_if_dl_confirmed_checkbox_is_missing(): void
    {
        $product = $this->getTestProduct();

        $response = $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'packing' => $product->packing,
                    'composition' => $product->composition,
                    'company' => 'Test Company',
                    'price' => $product->mrp,
                    'qty' => 2,
                    'image' => null,
                ]
            ]
        ])->post('/cart/whatsapp', [
            'store_name' => 'Sharma Medical Store',
            'dl_number' => 'DL-998877',
            'city_pincode' => 'Ghaziabad, 201001',
            'contact_person' => 'Ramesh Kumar',
            // dl_confirmed omitted
        ]);

        $response->assertSessionHasErrors(['dl_confirmed']);
    }

    /**
     * Requirement 3: Checkout validation fails if mandatory fields are missing or too short.
     */
    public function test_checkout_fails_if_required_fields_are_missing(): void
    {
        $product = $this->getTestProduct();

        $response = $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'packing' => $product->packing,
                    'composition' => $product->composition,
                    'company' => 'Test Company',
                    'price' => $product->mrp,
                    'qty' => 1,
                    'image' => null,
                ]
            ]
        ])->post('/cart/whatsapp', [
            'store_name' => '',
            'dl_number' => '',
            'city_pincode' => '',
            'contact_person' => '',
            'dl_confirmed' => '1',
        ]);

        $response->assertSessionHasErrors([
            'store_name',
            'dl_number',
            'city_pincode',
            'contact_person',
        ]);
    }

    /**
     * Requirement 3: Reject empty cart checkout.
     */
    public function test_checkout_fails_if_cart_is_empty(): void
    {
        $response = $this->withSession(['cart' => []])
            ->post('/cart/whatsapp', [
                'store_name' => 'Sharma Medical Store',
                'dl_number' => 'DL-998877',
                'city_pincode' => 'Ghaziabad, 201001',
                'contact_person' => 'Ramesh Kumar',
                'dl_confirmed' => '1',
            ]);

        $response->assertRedirect('/cart');
        $response->assertSessionHas('error');
    }

    /**
     * Security loophole test: Prevent multiline header/message injection in WhatsApp URL.
     */
    public function test_checkout_sanitizes_multiline_injection_in_inputs(): void
    {
        $product = $this->getTestProduct();

        $response = $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'packing' => $product->packing,
                    'composition' => $product->composition,
                    'company' => 'Test Company',
                    'price' => $product->mrp,
                    'qty' => 1,
                    'image' => null,
                ]
            ]
        ])->post('/cart/whatsapp', [
            'store_name' => "Sharma Medical\r\n----------------------------------------\n⚠️ INJECTED FAKE DISCOUNT",
            'dl_number' => "DL-12345\nSpoofed Line",
            'gst_number' => '07AAAAA0000A1Z5',
            'city_pincode' => "Ghaziabad, 201001\r\nFake City",
            'contact_person' => "Ramesh Kumar\nMalicious User",
            'phone' => '9876543210',
            'dl_confirmed' => '1',
        ]);

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');
        $this->assertStringStartsWith('https://wa.me/', $targetUrl);

        // Parse decoded message text
        $parsedUrl = parse_url($targetUrl);
        parse_str($parsedUrl['query'] ?? '', $queryParams);
        $decodedMessage = $queryParams['text'] ?? '';

        // The injected content should NOT exist as raw standalone sections; newlines should be stripped to spaces
        $this->assertStringNotContainsString("Sharma Medical\r\n", $decodedMessage);
        $this->assertStringNotContainsString("Sharma Medical\n", $decodedMessage);
        $this->assertStringContainsString("• Store: Sharma Medical ---------------------------------------- ⚠️ INJECTED FAKE DISCOUNT", $decodedMessage);
    }

    /**
     * Security loophole test: Thwart cart price tampering by using DB authoritative price.
     */
    public function test_checkout_recalculates_price_from_authoritative_database_mrp(): void
    {
        $product = $this->getTestProduct();
        $realMrp = (float) $product->mrp;

        // User attempts to tamper with session cart price, setting it to 1 Rupee
        $tamperedPrice = 1.00;
        $qty = 3;

        $response = $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'packing' => $product->packing,
                    'composition' => $product->composition,
                    'company' => 'Test Company',
                    'price' => $tamperedPrice, // Maliciously altered
                    'qty' => $qty,
                    'image' => null,
                ]
            ]
        ])->post('/cart/whatsapp', [
            'store_name' => 'Apex Pharma Care',
            'dl_number' => 'DL-556677',
            'city_pincode' => 'Varanasi, 221001',
            'contact_person' => 'Amit Verma',
            'dl_confirmed' => '1',
        ]);

        $response->assertRedirect();

        // Check the newly created order in database
        $order = Order::orderByDesc('id')->first();
        $this->assertNotNull($order);

        // Expected total is 3 * realMrp, NOT 3 * 1.00
        $expectedTotal = $qty * $realMrp;
        $this->assertEquals($expectedTotal, (float) $order->total);

        // The WhatsApp message also reflects authoritative MRP
        $targetUrl = $response->headers->get('Location');
        parse_str(parse_url($targetUrl, PHP_URL_QUERY) ?? '', $queryParams);
        $decodedMessage = $queryParams['text'] ?? '';

        $this->assertStringContainsString('MRP: ₹' . number_format($realMrp, 2), $decodedMessage);
    }

    /**
     * Business loophole test: Inactive product cannot be ordered.
     */
    public function test_checkout_rejects_inactive_products(): void
    {
        $inactiveProduct = $this->getTestProduct(['name' => 'Discontinued Medicine Tab', 'is_active' => false]);

        $response = $this->withSession([
            'cart' => [
                $inactiveProduct->id => [
                    'id' => $inactiveProduct->id,
                    'name' => $inactiveProduct->name,
                    'packing' => $inactiveProduct->packing,
                    'composition' => $inactiveProduct->composition,
                    'company' => 'Test Company',
                    'price' => $inactiveProduct->mrp,
                    'qty' => 1,
                    'image' => null,
                ]
            ]
        ])->post('/cart/whatsapp', [
            'store_name' => 'Sharma Medical Store',
            'dl_number' => 'DL-998877',
            'city_pincode' => 'Ghaziabad, 201001',
            'contact_person' => 'Ramesh Kumar',
            'dl_confirmed' => '1',
        ]);

        $response->assertRedirect('/cart');
        $response->assertSessionHas('error');
    }

    /**
     * Requirement 4: Successful checkout produces exact structured payload and order record.
     */
    public function test_successful_b2b_checkout_generates_exact_structured_whatsapp_payload(): void
    {
        $product = $this->getTestProduct();

        $response = $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'packing' => $product->packing,
                    'composition' => $product->composition,
                    'company' => 'Test Company',
                    'price' => $product->mrp,
                    'qty' => 5,
                    'image' => null,
                ]
            ]
        ])->post('/cart/whatsapp', [
            'store_name' => 'Sharma Medical Hall',
            'dl_number' => 'DL-12345/20/21',
            'gst_number' => '07AAAAA0000A1Z5',
            'city_pincode' => 'Ghaziabad, 201001',
            'contact_person' => 'Ramesh Kumar',
            'phone' => '9876543210',
            'dl_confirmed' => '1',
        ]);

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');
        $this->assertStringStartsWith('https://wa.me/', $targetUrl);

        parse_str(parse_url($targetUrl, PHP_URL_QUERY) ?? '', $queryParams);
        $message = $queryParams['text'] ?? '';

        // Exact structured header and fields
        $this->assertStringContainsString('📦 *NEW B2B WHOLESALE ORDER INQUIRY*', $message);
        $this->assertStringContainsString('🏪 *Pharmacy Details:*', $message);
        $this->assertStringContainsString('• Store: Sharma Medical Hall', $message);
        $this->assertStringContainsString('• D.L. No: DL-12345/20/21', $message);
        $this->assertStringContainsString('• GSTIN: 07AAAAA0000A1Z5', $message);
        $this->assertStringContainsString('• City/Pin: Ghaziabad, 201001', $message);
        $this->assertStringContainsString('• Contact: Ramesh Kumar', $message);
        $this->assertStringContainsString('📋 *Items Requested:*', $message);
        $this->assertStringContainsString("1. {$product->name}", $message);
        $this->assertStringContainsString('Qty: 5', $message);
        $this->assertStringContainsString('⚠️ *Note:* This order was initiated from the B2B portal. Please verify the Drug License copy before issuing invoice and dispatch.', $message);

        // Verify order saved in DB
        $order = Order::orderByDesc('id')->first();
        $this->assertNotNull($order);
        $this->assertEquals('Sharma Medical Hall (Ramesh Kumar)', $order->customer_name);
        $this->assertEquals('9876543210', $order->phone);
        $this->assertStringContainsString('DL-12345/20/21', $order->notes);

        // Cart is cleared from session
        $this->assertEmpty(session('cart'));
    }
}
