<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Driving Lessons',
                'slug' => 'driving-lessons',
                'description' => 'Professional driving lessons for learners at all skill levels.',
                'icon' => 'fas fa-car',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'P1 Assessments',
                'slug' => 'p1-assessments',
                'description' => 'Practical driving assessment to obtain your P1 licence.',
                'icon' => 'fas fa-clipboard-check',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Refresher Courses',
                'slug' => 'refresher-courses',
                'description' => 'Refresh your driving skills and boost your confidence on the road.',
                'icon' => 'fas fa-sync-alt',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
