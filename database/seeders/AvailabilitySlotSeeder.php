<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AvailabilitySlot;
use App\Models\Location;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AvailabilitySlotSeeder extends Seeder
{
    public function run(): void
    {
        $hobartLocation = Location::where('slug', 'hobart-cbd')->first();
        
        // Create slots for the next 30 days
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(30);
        
        $period = CarbonPeriod::create($startDate, $endDate);
        
        // Time slots for weekdays
        $weekdaySlots = [
            ['start' => '09:00', 'end' => '10:00'],
            ['start' => '10:00', 'end' => '11:00'],
            ['start' => '11:00', 'end' => '12:00'],
            ['start' => '13:00', 'end' => '14:00'],
            ['start' => '14:00', 'end' => '15:00'],
            ['start' => '15:00', 'end' => '16:00'],
            ['start' => '16:00', 'end' => '17:00'],
        ];
        
        // Time slots for Saturday
        $saturdaySlots = [
            ['start' => '08:00', 'end' => '09:00'],
            ['start' => '09:00', 'end' => '10:00'],
            ['start' => '10:00', 'end' => '11:00'],
            ['start' => '11:00', 'end' => '12:00'],
            ['start' => '13:00', 'end' => '14:00'],
            ['start' => '14:00', 'end' => '15:00'],
        ];
        
        foreach ($period as $date) {
            // Skip Sundays
            if ($date->isSunday()) {
                continue;
            }
            
            $slots = $date->isSaturday() ? $saturdaySlots : $weekdaySlots;
            
            foreach ($slots as $slot) {
                AvailabilitySlot::updateOrCreate(
                    [
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $slot['start'],
                        'location_id' => $hobartLocation?->id,
                    ],
                    [
                        'service_id' => null, // Available for all services
                        'location_id' => $hobartLocation?->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $slot['start'],
                        'end_time' => $slot['end'],
                        'max_bookings' => 1,
                        'current_bookings' => 0,
                        'is_available' => true,
                        'is_blocked' => false,
                    ]
                );
            }
        }
    }
}
