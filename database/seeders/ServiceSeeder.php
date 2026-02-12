<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $drivingLessons = ServiceCategory::where('slug', 'driving-lessons')->first();
        $assessments = ServiceCategory::where('slug', 'p1-assessments')->first();
        $refresher = ServiceCategory::where('slug', 'refresher-courses')->first();

        $services = [
            // Driving Lessons
            [
                'category_id' => $drivingLessons?->id,
                'name' => '1 Hour Driving Lesson (Auto)',
                'slug' => '1-hour-driving-lesson-auto',
                'description' => 'Standard 1-hour driving lesson in an automatic vehicle. Perfect for building confidence and skills.',
                'price' => 70.00,
                'duration' => 60,
                'transmission_type' => 'auto',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'category_id' => $drivingLessons?->id,
                'name' => '1 Hour Driving Lesson (Manual)',
                'slug' => '1-hour-driving-lesson-manual',
                'description' => 'Standard 1-hour driving lesson in a manual vehicle. Master clutch control and gear changes.',
                'price' => 80.00,
                'duration' => 60,
                'transmission_type' => 'manual',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 2,
            ],
            [
                'category_id' => $drivingLessons?->id,
                'name' => '2 Hour Driving Lesson (Auto)',
                'slug' => '2-hour-driving-lesson-auto',
                'description' => 'Extended 2-hour driving lesson in an automatic vehicle. More time to practice and improve.',
                'price' => 130.00,
                'duration' => 120,
                'transmission_type' => 'auto',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            // P1 Assessments
            [
                'category_id' => $assessments?->id,
                'name' => 'P1 Driving Assessment',
                'slug' => 'p1-driving-assessment',
                'description' => 'Official P1 driver assessment. Includes pre-assessment vehicle familiarisation.',
                'price' => 230.00,
                'duration' => 60,
                'transmission_type' => 'auto',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'category_id' => $assessments?->id,
                'name' => 'P1 Assessment + 1 Hour Lesson',
                'slug' => 'p1-assessment-with-lesson',
                'description' => 'P1 assessment with a 1-hour pre-assessment driving lesson to ensure you\'re prepared.',
                'price' => 290.00,
                'duration' => 120,
                'transmission_type' => 'auto',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 2,
            ],
            // Refresher
            [
                'category_id' => $refresher?->id,
                'name' => 'Refresher Driving Lesson',
                'slug' => 'refresher-driving-lesson',
                'description' => 'Ideal for licensed drivers who need to refresh their skills and confidence.',
                'price' => 75.00,
                'duration' => 60,
                'transmission_type' => 'both',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
