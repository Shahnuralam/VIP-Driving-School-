<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Sarah M.',
                'customer_location' => 'Hobart',
                'content' => 'Absolutely fantastic experience! My instructor was patient and explained everything clearly. Passed my P1 test on the first try!',
                'rating' => 5,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'customer_name' => 'James W.',
                'customer_location' => 'Glenorchy',
                'content' => 'After failing my test twice with another school, VIP helped me understand my mistakes and build confidence. Highly recommend!',
                'rating' => 5,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'customer_name' => 'Emily T.',
                'customer_location' => 'Kingston',
                'content' => 'Great value for money with the 10-lesson package. The flexible scheduling made it easy to fit lessons around my work.',
                'rating' => 5,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'customer_name' => 'Michael K.',
                'customer_location' => 'Sandy Bay',
                'content' => 'As a nervous driver, I needed someone patient. My instructor was incredible and never made me feel rushed or stressed.',
                'rating' => 5,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'customer_name' => 'Jessica L.',
                'customer_location' => 'Moonah',
                'content' => 'The pick-up and drop-off service was so convenient. Professional instructors and modern cars. 10/10!',
                'rating' => 5,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'customer_name' => 'David R.',
                'customer_location' => 'Hobart',
                'content' => 'Booked a refresher course after not driving for 5 years. My instructor helped me regain my confidence quickly.',
                'rating' => 4,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['customer_name' => $testimonial['customer_name'], 'content' => $testimonial['content']],
                $testimonial
            );
        }
    }
}
