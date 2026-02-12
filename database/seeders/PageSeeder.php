<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'meta_description' => 'Learn about VIP Driving School Hobart - your trusted partner for professional driving lessons and P1 assessments in Tasmania.',
                'content' => '<h2>Welcome to VIP Driving School Hobart</h2>
<p>VIP Driving School has been providing professional driving instruction in Hobart and surrounding areas for over 10 years. Our mission is to help learner drivers develop the skills and confidence they need to become safe, responsible drivers.</p>

<h3>Our Commitment</h3>
<p>We believe that learning to drive should be a positive experience. Our patient, friendly instructors create a supportive learning environment where students can develop their skills at their own pace.</p>

<h3>Why Choose Us?</h3>
<ul>
    <li>Fully qualified and accredited instructors</li>
    <li>Modern, dual-control vehicles</li>
    <li>Flexible lesson times including weekends</li>
    <li>Pick-up and drop-off service</li>
    <li>Competitive pricing with package discounts</li>
</ul>

<h3>Our Team</h3>
<p>Our team of experienced instructors are passionate about road safety and dedicated to helping you achieve your driving goals. All instructors hold current accreditation and undergo regular professional development.</p>',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'meta_description' => 'Terms and conditions for VIP Driving School Hobart services.',
                'content' => '<h2>Terms and Conditions</h2>

<h3>1. Booking and Cancellation Policy</h3>
<p>All lessons must be booked in advance. Cancellations must be made at least 24 hours before the scheduled lesson time. Late cancellations or no-shows may incur a cancellation fee.</p>

<h3>2. Payment Terms</h3>
<p>Payment is required at the time of booking unless otherwise arranged. We accept all major credit cards, debit cards, and bank transfers.</p>

<h3>3. Lesson Requirements</h3>
<p>Students must hold a valid learner\'s licence and present it at the start of each lesson. Students under the influence of alcohol or drugs will not be permitted to take their lesson.</p>

<h3>4. Package Validity</h3>
<p>Lesson packages are valid for 12 months from the date of purchase unless otherwise stated. Packages are non-transferable and non-refundable.</p>

<h3>5. Instructor Assignment</h3>
<p>While we endeavor to maintain consistency with instructor assignments, we reserve the right to assign alternative instructors when necessary.</p>

<h3>6. Liability</h3>
<p>VIP Driving School maintains comprehensive insurance coverage. However, students are responsible for any damage caused by deliberate misconduct or failure to follow instructor directions.</p>',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'meta_description' => 'Privacy policy for VIP Driving School Hobart - how we collect, use, and protect your personal information.',
                'content' => '<h2>Privacy Policy</h2>

<h3>Information We Collect</h3>
<p>We collect personal information necessary to provide our driving instruction services, including:</p>
<ul>
    <li>Name and contact details</li>
    <li>Learner\'s licence information</li>
    <li>Payment information</li>
    <li>Booking and lesson history</li>
</ul>

<h3>How We Use Your Information</h3>
<p>Your information is used to:</p>
<ul>
    <li>Process bookings and payments</li>
    <li>Communicate with you about lessons</li>
    <li>Improve our services</li>
    <li>Comply with legal requirements</li>
</ul>

<h3>Information Security</h3>
<p>We take reasonable steps to protect your personal information from unauthorized access, modification, or disclosure.</p>

<h3>Third Party Disclosure</h3>
<p>We do not sell or share your personal information with third parties except as necessary to provide our services or as required by law.</p>

<h3>Contact Us</h3>
<p>If you have questions about our privacy practices, please contact us.</p>',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Refund Policy',
                'slug' => 'refund-policy',
                'meta_description' => 'Refund policy for VIP Driving School Hobart lessons and packages.',
                'content' => '<h2>Refund Policy</h2>

<h3>Individual Lessons</h3>
<p>Individual lessons cancelled with more than 24 hours notice will receive a full refund or credit. Late cancellations (less than 24 hours notice) may forfeit up to 50% of the lesson fee.</p>

<h3>Lesson Packages</h3>
<p>Lesson packages may be refunded within 14 days of purchase if no lessons have been used. After lessons have commenced, packages are non-refundable but may be transferred to another person with management approval.</p>

<h3>How to Request a Refund</h3>
<p>To request a refund, please contact us with your booking details. Refunds are typically processed within 5-7 business days.</p>

<h3>Exceptional Circumstances</h3>
<p>We understand that unexpected circumstances can arise. Please contact us to discuss your situation and we will do our best to accommodate your needs.</p>',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
