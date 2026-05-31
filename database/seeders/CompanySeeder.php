<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Cipla',
                'description' => 'A global pharmaceutical company focused on agile and sustainable growth, complex generics, and deepening portfolio in India and South Africa.',
                'is_active' => true,
                'logo' => null,
            ],
            [
                'name' => 'Lupin',
                'description' => 'A leading multinational pharmaceutical company in India producing a wide range of generic formulations and APIs.',
                'is_active' => true,
                'logo' => null,
            ],
            [
                'name' => 'Larenon',
                'description' => 'A specialized pharmaceutical formulation company delivering niche and high-quality therapeutic solutions.',
                'is_active' => true,
                'logo' => null,
            ],
            [
                'name' => 'Sun Pharma',
                'description' => 'The largest pharmaceutical company in India and the fourth largest specialty generic pharmaceutical company in the world.',
                'is_active' => true,
                'logo' => null,
            ],
        ];

        foreach ($companies as $company) {
            Company::updateOrCreate(
                ['name' => $company['name']],
                $company
            );
        }
    }
}
