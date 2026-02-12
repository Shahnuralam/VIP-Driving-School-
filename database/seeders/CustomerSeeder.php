<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Use plain password - Customer model's 'hashed' cast will hash it when saving
        $customers = [
            [
                'name' => 'John Smith',
                'email' => 'john@demo.com',
                'password' => 'password',
                'phone' => '0412 345 678',
                'address' => '123 Collins Street',
                'suburb' => 'Hobart',
                'postcode' => '7000',
                'license_number' => 'L1234567',
                'preferred_transmission' => 'auto',
                'is_active' => true,
                'email_notifications' => true,
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@demo.com',
                'password' => 'password',
                'phone' => '0423 456 789',
                'address' => '45 Main Road',
                'suburb' => 'Glenorchy',
                'postcode' => '7010',
                'preferred_transmission' => 'manual',
                'is_active' => true,
                'email_notifications' => true,
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@demo.com',
                'password' => 'password',
                'phone' => '0434 567 890',
                'address' => '78 Channel Highway',
                'suburb' => 'Kingston',
                'postcode' => '7050',
                'license_number' => 'L7654321',
                'preferred_transmission' => 'auto',
                'is_active' => true,
            ],
        ];

        foreach ($customers as $data) {
            Customer::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}
