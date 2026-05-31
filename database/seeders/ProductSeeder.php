<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Division;
use App\Models\Salt;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsData = [
            // Cipla Products
            [
                'name' => 'Paracip 650',
                'company' => 'Cipla',
                'division' => 'Cipla Generics',
                'salt' => 'Paracetamol',
                'composition' => 'Paracetamol IP 650mg',
                'packing' => '15 Tablets',
                'mrp' => 32.50,
                'ptr' => 23.20,
                'pts' => 21.00,
                'stock_qty' => 150,
            ],
            [
                'name' => 'Asthalin Inhaler',
                'company' => 'Cipla',
                'division' => 'Cipla Respiratory',
                'salt' => 'Cetirizine Hydrochloride',
                'composition' => 'Salbutamol 100mcg',
                'packing' => '200 MD',
                'mrp' => 155.00,
                'ptr' => 110.00,
                'pts' => 99.50,
                'stock_qty' => 45,
            ],
            [
                'name' => 'Ciplar-LA 40',
                'company' => 'Cipla',
                'division' => 'Cipla Cardiology',
                'salt' => 'Amlodipine Besylate',
                'composition' => 'Propranolol Hydrochloride 40mg',
                'packing' => '15 Tablets',
                'mrp' => 54.20,
                'ptr' => 38.70,
                'pts' => 35.00,
                'stock_qty' => 8, // low stock alert test
            ],
            [
                'name' => 'Novamox 500',
                'company' => 'Cipla',
                'division' => 'Cipla Generics',
                'salt' => 'Amoxicillin',
                'composition' => 'Amoxicillin Trihydrate 500mg',
                'packing' => '15 Capsules',
                'mrp' => 112.50,
                'ptr' => 80.30,
                'pts' => 72.50,
                'stock_qty' => 200,
            ],
            [
                'name' => 'Montair 10',
                'company' => 'Cipla',
                'division' => 'Cipla Respiratory',
                'salt' => 'Cetirizine Hydrochloride',
                'composition' => 'Montelukast Sodium 10mg',
                'packing' => '15 Tablets',
                'mrp' => 210.00,
                'ptr' => 150.00,
                'pts' => 135.50,
                'stock_qty' => 85,
            ],

            // Lupin Products
            [
                'name' => 'Lupimet 500',
                'company' => 'Lupin',
                'division' => 'Lupin Maxima',
                'salt' => 'Metformin Hydrochloride',
                'composition' => 'Metformin Hydrochloride 500mg',
                'packing' => '20 Tablets',
                'mrp' => 28.00,
                'ptr' => 20.00,
                'pts' => 18.20,
                'stock_qty' => 300,
            ],
            [
                'name' => 'Lupisulin M30',
                'company' => 'Lupin',
                'division' => 'Lupin Maxima',
                'salt' => 'Metformin Hydrochloride',
                'composition' => 'Biphasic Isophane Insulin Injection 30/70',
                'packing' => '10ml Vial',
                'mrp' => 188.00,
                'ptr' => 134.30,
                'pts' => 121.20,
                'stock_qty' => 5, // low stock alert test
            ],
            [
                'name' => 'Lupigard-A 10',
                'company' => 'Lupin',
                'division' => 'Lupin Maxima',
                'salt' => 'Atorvastatin',
                'composition' => 'Atorvastatin Calcium 10mg',
                'packing' => '15 Tablets',
                'mrp' => 78.50,
                'ptr' => 56.00,
                'pts' => 50.50,
                'stock_qty' => 90,
            ],
            [
                'name' => 'Lupiloc 20',
                'company' => 'Lupin',
                'division' => 'Lupin Gastro',
                'salt' => 'Omeprazole',
                'composition' => 'Omeprazole Gastro-resistant 20mg',
                'packing' => '15 Capsules',
                'mrp' => 45.00,
                'ptr' => 32.10,
                'pts' => 29.00,
                'stock_qty' => 250,
            ],
            [
                'name' => 'Cetzine 10',
                'company' => 'Lupin',
                'division' => 'Lupin Maxima',
                'salt' => 'Cetirizine Hydrochloride',
                'composition' => 'Cetirizine Dihydrochloride 10mg',
                'packing' => '10 Tablets',
                'mrp' => 18.90,
                'ptr' => 13.50,
                'pts' => 12.10,
                'stock_qty' => 400,
            ],

            // Larenon Products
            [
                'name' => 'Lare CNS-5',
                'company' => 'Larenon',
                'division' => 'Larenon CNS',
                'salt' => 'Pantoprazole Sodium',
                'composition' => 'Olanzapine IP 5mg',
                'packing' => '10 Tablets',
                'mrp' => 60.00,
                'ptr' => 42.80,
                'pts' => 38.50,
                'stock_qty' => 12,
            ],
            [
                'name' => 'Derma-L Cream',
                'company' => 'Larenon',
                'division' => 'Larenon Derma',
                'salt' => 'Ibuprofen',
                'composition' => 'Luliconazole 1% w/w Cream',
                'packing' => '30g Tube',
                'mrp' => 245.00,
                'ptr' => 175.00,
                'pts' => 158.00,
                'stock_qty' => 60,
            ],
            [
                'name' => 'Lare-Gab 300',
                'company' => 'Larenon',
                'division' => 'Larenon CNS',
                'salt' => 'Pantoprazole Sodium',
                'composition' => 'Gabapentin 300mg',
                'packing' => '10 Capsules',
                'mrp' => 125.00,
                'ptr' => 89.30,
                'pts' => 80.50,
                'stock_qty' => 70,
            ],
            [
                'name' => 'Derma-Cal Lotion',
                'company' => 'Larenon',
                'division' => 'Larenon Derma',
                'salt' => 'Ibuprofen',
                'composition' => 'Calamine, Light Liquid Paraffin Lotion',
                'packing' => '100ml Bottle',
                'mrp' => 99.00,
                'ptr' => 70.70,
                'pts' => 63.80,
                'stock_qty' => 110,
            ],

            // Sun Pharma Products
            [
                'name' => 'Lipvas 10',
                'company' => 'Sun Pharma',
                'division' => 'Sun Neurology',
                'salt' => 'Atorvastatin',
                'composition' => 'Atorvastatin Calcium 10mg',
                'packing' => '15 Tablets',
                'mrp' => 88.00,
                'ptr' => 62.80,
                'pts' => 56.50,
                'stock_qty' => 180,
            ],
            [
                'name' => 'Tears-Sun eye drops',
                'company' => 'Sun Pharma',
                'division' => 'Sun Ophthalmology',
                'salt' => 'Cetirizine Hydrochloride',
                'composition' => 'Carboxymethylcellulose Sodium 0.5% w/v',
                'packing' => '10ml Vial',
                'mrp' => 140.00,
                'ptr' => 100.00,
                'pts' => 90.00,
                'stock_qty' => 75,
            ],
            [
                'name' => 'Amlasun 5',
                'company' => 'Sun Pharma',
                'division' => 'Sun Neurology',
                'salt' => 'Amlodipine Besylate',
                'composition' => 'Amlodipine Besylate 5mg',
                'packing' => '15 Tablets',
                'mrp' => 22.00,
                'ptr' => 15.70,
                'pts' => 14.10,
                'stock_qty' => 500,
            ],
            [
                'name' => 'Pantocid 40',
                'company' => 'Sun Pharma',
                'division' => 'Sun Neurology',
                'salt' => 'Pantoprazole Sodium',
                'composition' => 'Pantoprazole Sodium Gastro-resistant 40mg',
                'packing' => '15 Tablets',
                'mrp' => 165.00,
                'ptr' => 117.80,
                'pts' => 106.00,
                'stock_qty' => 3, // low stock alert test
            ],
            [
                'name' => 'Azisun 500',
                'company' => 'Sun Pharma',
                'division' => 'Sun Neurology',
                'salt' => 'Azithromycin',
                'composition' => 'Azithromycin Dihydrate 500mg',
                'packing' => '5 Tablets',
                'mrp' => 119.00,
                'ptr' => 85.00,
                'pts' => 76.50,
                'stock_qty' => 95,
            ],
            [
                'name' => 'Amoxisun 250',
                'company' => 'Sun Pharma',
                'division' => 'Sun Neurology',
                'salt' => 'Amoxicillin',
                'composition' => 'Amoxicillin 250mg',
                'packing' => '10 Capsules',
                'mrp' => 48.00,
                'ptr' => 34.30,
                'pts' => 30.90,
                'stock_qty' => 120,
            ],
        ];

        foreach ($productsData as $prod) {
            $company = Company::where('name', $prod['company'])->first();
            $division = Division::where('name', $prod['division'])->first();
            $salt = Salt::where('name', $prod['salt'])->first();

            // Fallbacks in case seeders mismatch
            $companyId = $company ? $company->id : Company::first()->id;
            $divisionId = $division ? $division->id : Division::where('company_id', $companyId)->first()->id;
            $saltId = $salt ? $salt->id : Salt::first()->id;

            Product::updateOrCreate(
                ['name' => $prod['name'], 'company_id' => $companyId],
                [
                    'division_id' => $divisionId,
                    'salt_id' => $saltId,
                    'composition' => $prod['composition'],
                    'packing' => $prod['packing'],
                    'mrp' => $prod['mrp'],
                    'ptr' => $prod['ptr'],
                    'pts' => $prod['pts'],
                    'stock_qty' => $prod['stock_qty'],
                    'image' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}
