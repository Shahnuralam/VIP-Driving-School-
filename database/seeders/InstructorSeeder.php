<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\Suburb;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have suburbs for instructors
        $suburbData = [
            ['name' => 'Hobart', 'slug' => 'hobart', 'postcode' => '7000', 'state' => 'TAS', 'is_serviced' => true, 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Glenorchy', 'slug' => 'glenorchy', 'postcode' => '7010', 'state' => 'TAS', 'is_serviced' => true, 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Kingston', 'slug' => 'kingston', 'postcode' => '7050', 'state' => 'TAS', 'is_serviced' => true, 'is_active' => true, 'sort_order' => 3],
        ];
        foreach ($suburbData as $s) {
            Suburb::firstOrCreate(['slug' => $s['slug']], $s);
        }

        $instructors = [
            [
                'name' => 'David Brown',
                'email' => 'david.brown@vipdrivingschool.com.au',
                'phone' => '0401 111 222',
                'bio' => 'David has been teaching driving for over 12 years. He specialises in helping nervous learners build confidence and pass their test first time.',
                'qualifications' => 'Accredited Driving Instructor, Defensive Driving Certified',
                'years_experience' => 12,
                'specializations' => ['automatic', 'manual', 'test_preparation'],
                'available_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                'available_from' => '08:00',
                'available_to' => '17:00',
                'rating' => 4.9,
                'total_reviews' => 127,
                'total_lessons' => 2100,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Emma Roberts',
                'email' => 'emma.roberts@vipdrivingschool.com.au',
                'phone' => '0402 222 333',
                'bio' => 'Emma is passionate about road safety and making every lesson count. She has a calm, patient approach that students love.',
                'qualifications' => 'Accredited Driving Instructor, First Aid Certified',
                'years_experience' => 8,
                'specializations' => ['automatic', 'defensive'],
                'available_days' => ['tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
                'available_from' => '09:00',
                'available_to' => '18:00',
                'rating' => 4.95,
                'total_reviews' => 89,
                'total_lessons' => 1450,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'James Taylor',
                'email' => 'james.taylor@vipdrivingschool.com.au',
                'phone' => '0403 333 444',
                'bio' => 'James teaches both automatic and manual vehicles. He is known for his clear instructions and focus on hazard perception.',
                'qualifications' => 'Accredited Driving Instructor, Manual & Automatic',
                'years_experience' => 6,
                'specializations' => ['automatic', 'manual', 'test_preparation'],
                'available_days' => ['monday', 'wednesday', 'friday', 'saturday'],
                'available_from' => '08:30',
                'available_to' => '16:30',
                'rating' => 4.85,
                'total_reviews' => 64,
                'total_lessons' => 980,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        $suburbIds = Suburb::pluck('id')->toArray();

        foreach ($instructors as $data) {
            $instructor = Instructor::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
            // Attach all suburbs if none attached
            if ($instructor->suburbs()->count() === 0 && !empty($suburbIds)) {
                $instructor->suburbs()->sync(array_slice($suburbIds, 0, 3));
            }
        }
    }
}
