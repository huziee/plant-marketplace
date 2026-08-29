<?php

namespace Database\Seeders;

use App\Models\ContentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Indoor Gardening', 'type' => 'article', 'description' => 'Guides and tips for growing beautiful indoor house plants.'],
            ['name' => 'Plant Care Tutorials', 'type' => 'guide', 'description' => 'Step-by-step plant care, watering, and pruning tutorials.'],
            ['name' => 'Soil & Fertilizers', 'type' => 'article', 'description' => 'Potting mix recipes, organic compost, and fertilizer guides.'],
            ['name' => 'Urban Farming News', 'type' => 'news', 'description' => 'News and developments in balcony and urban agriculture.'],
            ['name' => 'Pest & Disease Solutions', 'type' => 'guide', 'description' => 'Diagnosing and treating plant diseases and pests.'],
            ['name' => 'Botanical Science', 'type' => 'news', 'description' => 'Latest botanical research and plant science discoveries.'],
        ];

        foreach ($categories as $index => $cat) {
            ContentCategory::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'type' => $cat['type'],
                    'description' => $cat['description'],
                    'status' => 'active',
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
