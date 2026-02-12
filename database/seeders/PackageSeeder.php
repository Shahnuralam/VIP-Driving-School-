<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => '5 Lesson Package',
                'slug' => '5-lesson-package',
                'lesson_count' => 5,
                'lesson_duration' => 60,
                'description' => 'Save $50! Great for beginners starting their driving journey. 5 hours of professional instruction.',
                'tagline' => 'An Affordable and Practical Start',
                'price' => 300.00,
                'original_price' => 350.00,
                'validity_days' => 90,
                'validity_text' => 'Valid for 3 months',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'name' => '10 Lesson Package',
                'slug' => '10-lesson-package',
                'lesson_count' => 10,
                'lesson_duration' => 60,
                'description' => 'Save $150! Our most popular package. Perfect for learners who want to build solid driving skills.',
                'tagline' => 'Most Popular Choice',
                'price' => 550.00,
                'original_price' => 700.00,
                'validity_days' => 180,
                'validity_text' => 'Valid for 6 months',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => '15 Lesson Package',
                'slug' => '15-lesson-package',
                'lesson_count' => 15,
                'lesson_duration' => 60,
                'description' => 'Save $300! Comprehensive package for thorough preparation. Ideal for nervous drivers.',
                'tagline' => 'Best Value for Money',
                'price' => 750.00,
                'original_price' => 1050.00,
                'validity_days' => 240,
                'validity_text' => 'Valid for 8 months',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'name' => '20 Lesson Package',
                'slug' => '20-lesson-package',
                'lesson_count' => 20,
                'lesson_duration' => 60,
                'description' => 'Save $500! The ultimate preparation package. From complete beginner to test-ready.',
                'tagline' => 'Complete Learner Package',
                'price' => 900.00,
                'original_price' => 1400.00,
                'validity_days' => 365,
                'validity_text' => 'Valid for one year',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['slug' => $package['slug']],
                $package
            );
        }
    }
}
