<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyDivisions = [
            'Cipla' => [
                ['name' => 'Cipla Respiratory', 'description' => 'Specializes in inhalers, bronchiodilators, and asthma care.'],
                ['name' => 'Cipla Cardiology', 'description' => 'High-quality medications for hypertension, stroke prevention, and heart care.'],
                ['name' => 'Cipla Generics', 'description' => 'Affordable and accessible essential medicines.'],
            ],
            'Lupin' => [
                ['name' => 'Lupin Maxima', 'description' => 'Focuses on critical care and anti-infectives.'],
                ['name' => 'Lupin Gastro', 'description' => 'Therapies for acid reflux, ulcers, and bowel disorders.'],
            ],
            'Larenon' => [
                ['name' => 'Larenon CNS', 'description' => 'Niche division for neuropsychiatry and central nervous system disorders.'],
                ['name' => 'Larenon Derma', 'description' => 'Topical formulations, eczema creams, and hair care treatments.'],
            ],
            'Sun Pharma' => [
                ['name' => 'Sun Neurology', 'description' => 'Treatment formulations for epilepsy, migraine, and cognitive health.'],
                ['name' => 'Sun Ophthalmology', 'description' => 'Advanced eye drops, lubricants, and anti-glaucoma agents.'],
            ],
        ];

        foreach ($companyDivisions as $companyName => $divisions) {
            $company = Company::where('name', $companyName)->first();
            if ($company) {
                foreach ($divisions as $divData) {
                    Division::updateOrCreate(
                        [
                            'company_id' => $company->id,
                            'name' => $divData['name']
                        ],
                        [
                            'description' => $divData['description'],
                            'is_active' => true,
                        ]
                    );
                }
            }
        }
    }
}
