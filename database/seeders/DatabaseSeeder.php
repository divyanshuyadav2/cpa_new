<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the entity seeders
        $this->call([
            AdminUserSeeder::class,
            CompanySeeder::class,
            DivisionSeeder::class,
            SaltSeeder::class,
            ProductSeeder::class,
        ]);

        // Seed site configurations
        $settings = [
            'company_name' => 'Chitranshu Pharmaceuticals Agency',
            'tagline' => 'Your Trusted Pharmaceutical Distribution Partner',
            'whatsapp_number' => '918299770727',
            'address' => 'Nathupur Bhullanpur P.A.C Varanasi',
            'phone' => '8299770727',
            'email' => 'info@chitranshupharma.com',
            'gst_number' => '23AAAAA1111A1Z1',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
