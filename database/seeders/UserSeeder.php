<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create super admin user
        User::updateOrCreate(
            ['email' => 'admin@vipdrivingschool.com.au'],
            [
                'name' => 'Admin User',
                'email' => 'admin@vipdrivingschool.com.au',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create staff user
        User::updateOrCreate(
            ['email' => 'staff@vipdrivingschool.com.au'],
            [
                'name' => 'Staff Member',
                'email' => 'staff@vipdrivingschool.com.au',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'phone' => '0400 111 111',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
