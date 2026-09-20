<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Indoor Plants',
                'slug' => 'indoor-plants',
                'icon' => 'fa-house-plant',
                'description' => 'Air purifying, low-light tolerant, and beautiful houseplants for home & office.',
                'short_description' => 'Air purifying & house plants',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Outdoor Plants',
                'slug' => 'outdoor-plants',
                'icon' => 'fa-sun-plant-wilt',
                'description' => 'Flowering shrubs, garden ornamentals, and sun-loving outdoor greenery.',
                'short_description' => 'Sun-loving garden greenery',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Seeds',
                'slug' => 'seeds',
                'icon' => 'fa-seedling',
                'description' => 'Organic heirloom vegetable seeds, exotic flower seeds, and flowering bulbs.',
                'short_description' => 'Vegetable & flower seeds',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Pots & Planters',
                'slug' => 'pots-planters',
                'icon' => 'fa-jar',
                'description' => 'Terracotta pots, self-watering planters, ceramic pots, and hanging baskets.',
                'short_description' => 'Ceramic, terracotta & self-watering',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Soil & Fertilizer',
                'slug' => 'soil-fertilizer',
                'icon' => 'fa-basket-shopping',
                'description' => 'Organic compost, potting mix, liquid plant food, and neem cake.',
                'short_description' => 'Potting mixes & organic plant food',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Plant Care',
                'slug' => 'plant-care',
                'icon' => 'fa-spray-can',
                'description' => 'Eco-friendly pest control, leaf shine, humidity trays, and care kits.',
                'short_description' => 'Pest control & leaf sprays',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Garden Tools',
                'slug' => 'garden-tools',
                'icon' => 'fa-scissors',
                'description' => 'Pruning shears, watering cans, moisture meters, and gardening trowels.',
                'short_description' => 'Pruners, shears & watering tools',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Bundles',
                'slug' => 'bundles',
                'icon' => 'fa-box-open',
                'description' => 'Curated starter plant bundles, housewarming gift sets, and care combos.',
                'short_description' => 'Starter sets & gift bundles',
                'is_featured' => true,
                'status' => 'active',
            ],
        ];

        foreach ($categories as $cat) {
            ProductCategory::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                array_merge($cat, ['slug' => Str::slug($cat['name'])])
            );
        }
    }
}
