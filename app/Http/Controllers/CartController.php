<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * View the shopping cart page.
     */
    public function view()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['qty'] * $item['price'];
        }

        return view('cart', compact('cart', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10000',
        ]);

        $product = Product::with('company')->findOrFail($request->input('product_id'));
        if (!$product->is_active) {
            return redirect()->back()->with('error', "{$product->name} is currently not available for ordering.");
        }

        $qty = (int) $request->input('quantity');

        $cart = session()->get('cart', []);
        if (!is_array($cart)) {
            $cart = [];
        }

        if (isset($cart[$product->id])) {
            $newQty = min(10000, $cart[$product->id]['qty'] + $qty);
            $cart[$product->id]['qty'] = $newQty;
            $cart[$product->id]['price'] = (float) $product->mrp;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'packing' => $product->packing,
                'composition' => $product->composition,
                'company' => $product->company?->name ?? 'N/A',
                'price' => (float) $product->mrp,
                'qty' => $qty,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$product->name} added to cart successfully!");
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10000',
        ]);

        $productId = $request->input('product_id');
        $qty = (int) $request->input('quantity');

        $product = Product::findOrFail($productId);
        if (!$product->is_active) {
            return redirect()->back()->with('error', "{$product->name} is currently inactive.");
        }

        $cart = session()->get('cart', []);
        if (!is_array($cart)) {
            $cart = [];
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] = $qty;
            $cart[$productId]['price'] = (float) $product->mrp;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', "Cart updated successfully!");
        }

        return redirect()->back()->with('error', "Product not found in cart.");
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);
        if (!is_array($cart)) {
            $cart = [];
        }

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', "Product removed from cart!");
        }

        return redirect()->back()->with('error', "Product not found in cart.");
    }

    /**
     * Handle the checkout and redirect to WhatsApp.
     */
    public function whatsapp(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('cart.view');
        }

        $request->validate([
            'store_name'     => 'required|string|min:3|max:255',
            'dl_number'      => 'required|string|min:3|max:100',
            'gst_number'     => 'nullable|string|max:50',
            'city_pincode'   => 'required|string|min:3|max:100',
            'contact_person' => 'required|string|min:2|max:255',
            'phone'          => 'nullable|string|max:25',
            'dl_confirmed'   => 'accepted',
        ], [
            'store_name.required'     => 'Please enter your Pharmacy / Store Name.',
            'store_name.min'          => 'Pharmacy / Store Name must be at least 3 characters.',
            'dl_number.required'      => 'A valid Drug License Number (Form 20/21) is required for wholesale order inquiries.',
            'dl_number.min'           => 'Drug License Number must be at least 3 characters.',
            'city_pincode.required'   => 'Please enter your City and Pincode.',
            'contact_person.required' => 'Please enter the Contact Person name.',
            'dl_confirmed.accepted'   => 'You must confirm that you represent a licensed retail pharmacy / medical establishment with a valid Drug License.',
        ]);

        $cart = session()->get('cart', []);
        if (!is_array($cart) || empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        // Helper to sanitize text fields and strip newline/tab injection in WhatsApp URL
        $clean = function (?string $val): string {
            $val = preg_replace('/[\r\n\t]+/', ' ', (string) $val);
            $val = preg_replace('/\s{2,}/', ' ', $val);
            return trim($val);
        };

        $storeName = $clean($request->input('store_name'));
        $dlNumber = $clean($request->input('dl_number'));
        $gstNumber = $clean($request->input('gst_number')) ?: 'N/A';
        $cityPincode = $clean($request->input('city_pincode'));
        $contactPerson = $clean($request->input('contact_person'));
        $phone = $clean($request->input('phone')) ?: 'Via WhatsApp';

        // Authoritative price re-verification, active check, and sanitization from DB
        $total = 0;
        $verifiedItems = [];

        foreach ($cart as $item) {
            if (!is_array($item) || empty($item['id'])) {
                continue;
            }

            $product = Product::with('company')->find($item['id']);
            if (!$product || !$product->is_active) {
                $productName = is_array($item) && !empty($item['name']) ? $item['name'] : 'Selected medicine';
                return redirect()->route('cart.view')->with('error', "{$productName} is currently unavailable or inactive in catalog.");
            }

            $qty = max(1, (int) ($item['qty'] ?? 1));
            $unitPrice = (float) $product->mrp;
            $total += $qty * $unitPrice;

            $verifiedItems[] = [
                'id'          => $product->id,
                'name'        => $product->name,
                'packing'     => $product->packing,
                'composition' => $product->composition,
                'company'     => $product->company?->name ?? 'N/A',
                'price'       => $unitPrice,
                'qty'         => $qty,
                'image'       => $product->image,
            ];
        }

        if (empty($verifiedItems)) {
            return redirect()->route('cart.view')->with('error', 'Your cart does not contain any valid active items.');
        }

        $notesContent = "B2B Pharmacy Verification:\n" .
            "• Store: {$storeName}\n" .
            "• D.L. No: {$dlNumber}\n" .
            "• GSTIN: {$gstNumber}\n" .
            "• City/Pin: {$cityPincode}\n" .
            "• Contact: {$contactPerson}\n" .
            "• Phone: {$phone}\n" .
            "• D.L. Declaration: Confirmed by buyer";

        // Create Order in Database
        $order = Order::create([
            'customer_name' => "{$storeName} ({$contactPerson})",
            'phone'         => $phone,
            'total'         => $total,
            'status'        => 'Pending',
            'cart'          => $verifiedItems,
            'notes'         => $notesContent,
        ]);

        // Clear Cart
        session()->forget('cart');

        // Build Structured WhatsApp Message Payload
        $message = "📦 *NEW B2B WHOLESALE ORDER INQUIRY*\n";
        $message .= "----------------------------------------\n";
        $message .= "🏪 *Pharmacy Details:*\n";
        $message .= "• Store: {$storeName}\n";
        $message .= "• D.L. No: {$dlNumber}\n";
        $message .= "• GSTIN: {$gstNumber}\n";
        $message .= "• City/Pin: {$cityPincode}\n";
        $message .= "• Contact: {$contactPerson}" . ($phone !== 'Via WhatsApp' ? " ({$phone})" : "") . "\n";
        $message .= "\n📋 *Items Requested:*\n";

        $i = 1;
        foreach ($verifiedItems as $item) {
            $packing = !empty($item['packing']) ? " ({$item['packing']})" : "";
            $price = number_format($item['price'], 2);
            $message .= "{$i}. {$item['name']}{$packing} - Qty: {$item['qty']} (MRP: ₹{$price})\n";
            $i++;
        }

        $message .= "----------------------------------------\n";
        $message .= "⚠️ *Note:* This order was initiated from the B2B portal. Please verify the Drug License copy before issuing invoice and dispatch.";

        // Retrieve WhatsApp Number
        $waNumber = setting('whatsapp_number') ?: setting('phone', '8299770727');
        // Clean non-digits
        $waNumber = preg_replace('/[^0-9]/', '', (string) $waNumber);
        if (strlen($waNumber) === 10) {
            $waNumber = '91' . $waNumber;
        }
        if (empty($waNumber)) {
            $waNumber = '918299770727';
        }

        // Build URL redirect
        $url = "https://wa.me/{$waNumber}?text=" . rawurlencode($message);

        return redirect()->away($url);
    }
}
