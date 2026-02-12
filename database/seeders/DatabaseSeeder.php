<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            ServiceCategorySeeder::class,
            LocationSeeder::class,
            ServiceSeeder::class,
            PackageSeeder::class,
            InfoCardSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            AvailabilitySlotSeeder::class,
            CustomerSeeder::class,
            InstructorSeeder::class,
            BlogDemoSeeder::class,
        ]);
    }
}
