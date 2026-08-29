<?php

namespace Database\Seeders;

use App\Models\PlantCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlantCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Indoor Plants', 'short_description' => 'Lush houseplants that thrive in low to bright indirect light.', 'icon' => 'fa-house-plant', 'sort_order' => 1, 'is_featured' => true],
            ['name' => 'Outdoor Plants', 'short_description' => 'Sun-loving shrubs, garden beds, and patio greenery.', 'icon' => 'fa-sun-plant-wilt', 'sort_order' => 2, 'is_featured' => true],
            ['name' => 'Flowering Plants', 'short_description' => 'Vibrant blooming plants that add color to gardens and homes.', 'icon' => 'fa-seedling', 'sort_order' => 3, 'is_featured' => true],
            ['name' => 'Succulents & Cacti', 'short_description' => 'Drought-tolerant, low-maintenance desert plants.', 'icon' => 'fa-sun', 'sort_order' => 4, 'is_featured' => true],
            ['name' => 'Herbs', 'short_description' => 'Aromatic culinary herbs for kitchen gardens.', 'icon' => 'fa-spa', 'sort_order' => 5, 'is_featured' => true],
            ['name' => 'Vegetables', 'short_description' => 'Fresh home-grown garden vegetables.', 'icon' => 'fa-carrot', 'sort_order' => 6, 'is_featured' => true],
            ['name' => 'Fruit Plants', 'short_description' => 'Fruiting trees and shrubs for orchards.', 'icon' => 'fa-apple-whole', 'sort_order' => 7, 'is_featured' => false],
            ['name' => 'Trees', 'short_description' => 'Shade trees and ornamental garden trees.', 'icon' => 'fa-tree', 'sort_order' => 8, 'is_featured' => false],
        ];

        foreach ($categories as $cat) {
            PlantCategory::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'short_description' => $cat['short_description'],
                    'icon' => $cat['icon'],
                    'sort_order' => $cat['sort_order'],
                    'is_featured' => $cat['is_featured'],
                    'status' => 'active',
                ]
            );
        }
    }
}
