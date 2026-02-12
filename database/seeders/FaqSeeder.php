<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // General
            [
                'question' => 'What do I need to bring to my driving lesson?',
                'answer' => 'You must bring your valid learner\'s licence to every lesson. We also recommend wearing comfortable clothing and flat shoes. If you wear glasses or contact lenses for driving, please bring them.',
                'category' => 'general',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Do you offer pick-up and drop-off?',
                'answer' => 'Yes! We offer free pick-up and drop-off within our service areas including Hobart CBD, Glenorchy, Kingston, Moonah, and Sandy Bay. Just let us know your preferred location when booking.',
                'category' => 'general',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'question' => 'How do I book a lesson?',
                'answer' => 'You can book online through our website 24/7, or call us during business hours. Online booking is the quickest way to secure your preferred time slot.',
                'category' => 'general',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Packages
            [
                'question' => 'What happens if I don\'t use all my package lessons?',
                'answer' => 'Package lessons are valid for the period specified at purchase (typically 3-12 months depending on the package). Unused lessons after this period will expire. We recommend booking lessons regularly to make the most of your package.',
                'category' => 'packages',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Can I share my package with someone else?',
                'answer' => 'No, lesson packages are non-transferable and can only be used by the person who purchased them.',
                'category' => 'packages',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'question' => 'What is the difference between your packages?',
                'answer' => 'Our packages differ in the number of lessons included and the savings offered. Larger packages provide better value per lesson and are ideal for learners who need more practice. The 10-lesson package is our most popular choice for most learners.',
                'category' => 'packages',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Booking
            [
                'question' => 'What is your cancellation policy?',
                'answer' => 'We require at least 24 hours notice for cancellations or reschedules. Cancellations made less than 24 hours before the lesson may incur a 50% fee. No-shows will be charged the full lesson amount.',
                'category' => 'booking',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Can I reschedule my booking?',
                'answer' => 'Yes, you can reschedule with at least 24 hours notice at no extra charge. Please contact us or use our online booking system to make changes.',
                'category' => 'booking',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Payment
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept all major credit and debit cards (Visa, Mastercard, American Express) for online payments. Payment is required at the time of booking.',
                'category' => 'payment',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Are your prices inclusive of GST?',
                'answer' => 'Yes, all prices displayed on our website are inclusive of GST.',
                'category' => 'payment',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
