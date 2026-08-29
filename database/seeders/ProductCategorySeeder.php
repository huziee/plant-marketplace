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
                'description' => 'Air purifying, low-light tolerant, and beautiful houseplants for home & office.',
                'short_description' => 'Air purifying & house plants',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Outdoor Plants',
                'description' => 'Flowering shrubs, garden ornamentals, and sun-loving outdoor greenery.',
                'short_description' => 'Sun-loving garden greenery',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Seeds & Bulbs',
                'description' => 'Organic heirloom vegetable seeds, exotic flower seeds, and flowering bulbs.',
                'short_description' => 'Vegetable & flower seeds',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Pots & Planters',
                'description' => 'Terracotta pots, self-watering planters, ceramic pots, and hanging baskets.',
                'short_description' => 'Ceramic, terracotta & self-watering',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Fertilizers & Soil',
                'description' => 'Organic compost, potting mix, liquid plant food, and neem cake.',
                'short_description' => 'Potting mixes & organic plant food',
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
