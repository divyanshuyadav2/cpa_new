<?php

namespace Database\Seeders;

use App\Models\Salt;
use Illuminate\Database\Seeder;

class SaltSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salts = [
            ['name' => 'Paracetamol', 'description' => 'Analgesic and antipyretic agent used to treat fever and mild to moderate pain.'],
            ['name' => 'Amoxicillin', 'description' => 'Moderate-spectrum, bactericidal, beta-lactam antibiotic used to treat bacterial infections.'],
            ['name' => 'Metformin Hydrochloride', 'description' => 'First-line medication for the treatment of type 2 diabetes, particularly in people who are overweight.'],
            ['name' => 'Atorvastatin', 'description' => 'Statin medication used to prevent cardiovascular disease in those at high risk and lower abnormal lipid levels.'],
            ['name' => 'Ibuprofen', 'description' => 'Nonsteroidal anti-inflammatory drug (NSAID) used for treating pain, fever, and inflammation.'],
            ['name' => 'Omeprazole', 'description' => 'Proton pump inhibitor (PPI) medication used in the treatment of gastroesophageal reflux disease (GERD).'],
            ['name' => 'Cetirizine Hydrochloride', 'description' => 'Second-generation antihistamine used in the treatment of hay fever, allergies, angioedema, and urticaria.'],
            ['name' => 'Azithromycin', 'description' => 'Macrolide antibiotic used for the treatment of a number of bacterial infections.'],
            ['name' => 'Pantoprazole Sodium', 'description' => 'Proton pump inhibitor (PPI) that decreases the amount of acid produced in the stomach.'],
            ['name' => 'Amlodipine Besylate', 'description' => 'Calcium channel blocker medication used to treat high blood pressure and coronary artery disease.'],
        ];

        foreach ($salts as $salt) {
            Salt::updateOrCreate(
                ['name' => $salt['name']],
                ['description' => $salt['description']]
            );
        }
    }
}
