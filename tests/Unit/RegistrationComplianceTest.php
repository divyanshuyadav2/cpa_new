<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RegistrationComplianceTest extends TestCase
{
    protected function getValidationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:retailer,salesman',
            'salesman_id' => 'nullable',
            'dl_number' => 'required_if:role,retailer|nullable|string|max:100',
            'gst_number' => 'nullable|string|max:50',
        ];
    }

    public function test_retailer_registration_fails_without_dl_number(): void
    {
        $payload = [
            'name' => 'Ramesh Medical Store',
            'email' => 'ramesh@example.com',
            'password' => 'secret123',
            'phone' => '9876543210',
            'company_name' => 'Ramesh Chemist',
            'address' => 'Station Road, Varanasi',
            'role' => 'retailer',
            'dl_number' => null, // Missing DL number
            'gst_number' => null,
        ];

        $validator = Validator::make($payload, $this->getValidationRules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('dl_number', $validator->errors()->toArray());
    }

    public function test_retailer_registration_passes_with_dl_number_and_without_gst(): void
    {
        $payload = [
            'name' => 'Gupta Pharmacy',
            'email' => 'gupta@example.com',
            'password' => 'secret123',
            'phone' => '9876543211',
            'company_name' => 'Gupta Medicos',
            'address' => 'Main Market, Lucknow',
            'role' => 'retailer',
            'dl_number' => 'DL-20B-98765/21B',
            'gst_number' => null, // GST is optional
        ];

        $validator = Validator::make($payload, $this->getValidationRules());
        $this->assertFalse($validator->fails());
    }

    public function test_retailer_registration_passes_with_both_dl_and_gst_numbers(): void
    {
        $payload = [
            'name' => 'Apex Healthcare',
            'email' => 'apex@example.com',
            'password' => 'secret123',
            'phone' => '9876543212',
            'company_name' => 'Apex Chemist',
            'address' => 'Civil Lines, Prayagraj',
            'role' => 'retailer',
            'dl_number' => 'UP-VNS-20B-554433',
            'gst_number' => '09AAACA1234A1Z5',
        ];

        $validator = Validator::make($payload, $this->getValidationRules());
        $this->assertFalse($validator->fails());
    }

    public function test_salesman_registration_does_not_require_dl_number(): void
    {
        $payload = [
            'name' => 'Amit Salesman',
            'email' => 'amit.sales@example.com',
            'password' => 'secret123',
            'phone' => '9876543213',
            'role' => 'salesman',
            'dl_number' => null, // Salesman doesn't have a pharmacy DL
        ];

        $validator = Validator::make($payload, $this->getValidationRules());
        $this->assertFalse($validator->fails());
    }
}
