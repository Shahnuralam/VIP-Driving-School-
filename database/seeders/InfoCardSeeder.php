<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InfoCard;

class InfoCardSeeder extends Seeder
{
    public function run(): void
    {
        $infoCards = [
            // Homepage
            [
                'title' => 'Auto & Manual',
                'content' => 'Choose between automatic or manual transmission vehicles for your lessons.',
                'icon' => 'fas fa-car',
                'page' => 'home',
                'section' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Valid Licence Required',
                'content' => 'You must hold a valid learner\'s licence to book lessons with us.',
                'icon' => 'fas fa-id-card',
                'page' => 'home',
                'section' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Experienced Instructors',
                'content' => 'All our instructors are fully qualified, accredited, and patient.',
                'icon' => 'fas fa-user-graduate',
                'page' => 'home',
                'section' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Dual Control Vehicles',
                'content' => 'Learn in safe, modern dual-control vehicles for your peace of mind.',
                'icon' => 'fas fa-shield-alt',
                'page' => 'home',
                'section' => null,
                'is_active' => true,
                'sort_order' => 4,
            ],

            // Lesson Packages Page
            [
                'title' => 'Flexible Scheduling',
                'content' => 'Book lessons at times that suit you. We offer weekday and weekend appointments.',
                'icon' => 'fas fa-calendar-check',
                'page' => 'lesson-packages',
                'section' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Pick-up & Drop-off',
                'content' => 'We pick you up from home, work, or school within our service areas.',
                'icon' => 'fas fa-map-marker-alt',
                'page' => 'lesson-packages',
                'section' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Book Online Page
            [
                'title' => 'Easy Online Booking',
                'content' => 'Book your lesson in minutes with our simple online booking system.',
                'icon' => 'fas fa-laptop',
                'page' => 'book-online',
                'section' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Secure Payments',
                'content' => 'Pay securely online with credit card. All payments are encrypted.',
                'icon' => 'fas fa-lock',
                'page' => 'book-online',
                'section' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => '24-Hour Notice',
                'content' => 'Please provide at least 24 hours notice for cancellations or changes.',
                'icon' => 'fas fa-clock',
                'page' => 'book-online',
                'section' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],

            // P1 Assessments - Things to Know
            [
                'title' => 'Minimum Driving Experience',
                'content' => 'You must have held your learner licence for at least 12 months.',
                'icon' => 'fas fa-calendar',
                'page' => 'p1-assessments',
                'section' => 'things-to-know',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Log Book Hours',
                'content' => 'Complete minimum 50 hours of supervised driving including 10 night hours.',
                'icon' => 'fas fa-book',
                'page' => 'p1-assessments',
                'section' => 'things-to-know',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // P1 Assessments - Things to Bring
            [
                'title' => 'Learner Licence',
                'content' => 'Bring your current valid learner licence.',
                'icon' => 'fas fa-id-card',
                'page' => 'p1-assessments',
                'section' => 'things-to-bring',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Log Book',
                'content' => 'Bring your completed log book if required.',
                'icon' => 'fas fa-clipboard-list',
                'page' => 'p1-assessments',
                'section' => 'things-to-bring',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($infoCards as $card) {
            InfoCard::updateOrCreate(
                ['title' => $card['title'], 'page' => $card['page']],
                $card
            );
        }
    }
}
