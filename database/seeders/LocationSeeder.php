<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Hobart CBD',
                'slug' => 'hobart-cbd',
                'address' => 'Hobart CBD, TAS 7000',
                'departure_info' => 'Central Hobart area including city streets, residential areas, and main roads.',
                'available_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']),
                'available_days_text' => 'Monday - Saturday',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Glenorchy',
                'slug' => 'glenorchy',
                'address' => 'Glenorchy, TAS 7010',
                'departure_info' => 'Glenorchy area including Main Road, shopping centre vicinity, and surrounding suburbs.',
                'available_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday']),
                'available_days_text' => 'Monday - Friday',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Kingston',
                'slug' => 'kingston',
                'address' => 'Kingston, TAS 7050',
                'departure_info' => 'Kingston and surrounding southern suburbs.',
                'available_days' => json_encode(['tuesday', 'thursday', 'saturday']),
                'available_days_text' => 'Tuesday, Thursday & Saturday',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Moonah',
                'slug' => 'moonah',
                'address' => 'Moonah, TAS 7009',
                'departure_info' => 'Moonah area including Main Road and surrounding streets.',
                'available_days' => json_encode(['monday', 'wednesday', 'friday']),
                'available_days_text' => 'Monday, Wednesday & Friday',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Sandy Bay',
                'slug' => 'sandy-bay',
                'address' => 'Sandy Bay, TAS 7005',
                'departure_info' => 'Sandy Bay area including university precinct and surrounding residential areas.',
                'available_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday']),
                'available_days_text' => 'Monday - Friday',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(
                ['slug' => $location['slug']],
                $location
            );
        }
    }
}
