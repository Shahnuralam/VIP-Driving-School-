<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'VIP Driving School Hobart', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Learn to Drive with Confidence', 'group' => 'general'],
            
            // Contact
            ['key' => 'contact_email', 'value' => 'info@vipdrivingschool.com.au', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '0400 000 000', 'group' => 'contact'],
            ['key' => 'admin_email', 'value' => 'admin@vipdrivingschool.com.au', 'group' => 'contact'],
            ['key' => 'business_address', 'value' => '123 Main Street, Hobart TAS 7000', 'group' => 'contact'],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/vipdrivingschoolhobart', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/vipdrivingschoolhobart', 'group' => 'social'],
            ['key' => 'google_url', 'value' => '', 'group' => 'social'],
            
            // Business Hours
            ['key' => 'business_hours_weekday', 'value' => '8:00 AM - 6:00 PM', 'group' => 'hours'],
            ['key' => 'business_hours_saturday', 'value' => '8:00 AM - 4:00 PM', 'group' => 'hours'],
            ['key' => 'business_hours_sunday', 'value' => 'Closed', 'group' => 'hours'],
            
            // Booking
            ['key' => 'booking_advance_days', 'value' => '30', 'group' => 'booking'],
            ['key' => 'cancellation_notice_hours', 'value' => '24', 'group' => 'booking'],
            
            // Payment (Stripe keys stored in .env)
            ['key' => 'currency', 'value' => 'AUD', 'group' => 'payment'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
