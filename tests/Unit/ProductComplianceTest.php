<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Division;
use App\Models\Product;
use App\Models\Salt;
use Tests\TestCase;

class ProductComplianceTest extends TestCase
{
    public function test_explicit_schedule_attribute_triggers_restriction(): void
    {
        $product = new Product(['schedule' => 'H']);
        $this->assertTrue($product->isRestrictedSchedule());

        $productH1 = new Product(['schedule' => 'H1']);
        $this->assertTrue($productH1->isRestrictedSchedule());

        $productX = new Product(['schedule' => 'X']);
        $this->assertTrue($productX->isRestrictedSchedule());

        $productNrx = new Product(['schedule' => 'NRX']);
        $this->assertTrue($productNrx->isRestrictedSchedule());
    }

    public function test_nrx_or_schedule_in_product_name_triggers_restriction(): void
    {
        $product1 = new Product(['name' => 'Cloze MD 0.50 NRX']);
        $this->assertTrue($product1->isRestrictedSchedule());

        $product2 = new Product(['name' => 'Alprax 0.5mg (Schedule-H Drug)']);
        $this->assertTrue($product2->isRestrictedSchedule());

        $product3 = new Product(['name' => 'Tramadol SR Tab (Rx)']);
        $this->assertTrue($product3->isRestrictedSchedule());
    }

    public function test_restricted_composition_triggers_restriction(): void
    {
        $product = new Product([
            'name' => 'D-Ventee 50',
            'composition' => 'Desvenlafaxine Succinate 50mg',
        ]);
        $this->assertTrue($product->isRestrictedSchedule());

        $productPsychotropic = new Product([
            'name' => 'Preega M 75',
            'composition' => 'Pregabalin 75mg + Methylcobalamin 750mcg',
        ]);
        $this->assertTrue($productPsychotropic->isRestrictedSchedule());

        $productAntibiotic = new Product([
            'name' => 'Azithro 500',
            'composition' => 'Azithromycin 500mg',
        ]);
        $this->assertTrue($productAntibiotic->isRestrictedSchedule());
    }

    public function test_salt_relationship_triggers_restriction_when_composition_is_null(): void
    {
        $salt = new Salt([
            'name' => 'Clonazepam',
            'description' => 'Anticonvulsant & anxiolytic benzodiazepine (Schedule H)',
        ]);

        $product = new Product([
            'name' => 'Generic Brand X',
            'composition' => null,
            'packing' => '10x10 Tablets',
        ]);
        $product->setRelation('salt', $salt);

        $this->assertTrue($product->isRestrictedSchedule());
        $this->assertTrue($product->is_restricted_schedule);
    }

    public function test_non_restricted_products_return_false(): void
    {
        $product = new Product([
            'name' => 'C-Vite Orange 500mg',
            'composition' => 'Ascorbic Acid (Vitamin C) 500mg',
            'packing' => 'Bottle of 30 Chews',
        ]);
        $this->assertFalse($product->isRestrictedSchedule());
        $this->assertFalse($product->is_restricted_schedule);
    }
}
