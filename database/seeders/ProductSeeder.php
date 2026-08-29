<?php

namespace Database\Seeders;

use App\Enums\ProductType;
use App\Enums\StockStatus;
use App\Models\Plant;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $indoorCat = ProductCategory::where('slug', 'indoor-plants')->first();
        $outdoorCat = ProductCategory::where('slug', 'outdoor-plants')->first();
        $soilCat = ProductCategory::where('slug', 'fertilizers-soil')->first();

        $monstera = Plant::where('slug', 'monstera-deliciosa')->first();
        $snake = Plant::where('slug', 'snake-plant-laurentii')->first();

        $products = [
            [
                'name' => 'Monstera Deliciosa Potted Plant',
                'slug' => 'monstera-deliciosa-potted-plant',
                'sku' => 'PLT-MONSTERA-01',
                'product_category_id' => $indoorCat?->id ?: 1,
                'plant_id' => $monstera?->id,
                'product_type' => ProductType::PLANT->value,
                'short_description' => 'Healthy Swiss Cheese plant in 8-inch nursery pot.',
                'description' => 'Bring tropical vibes to your living space with our premium healthy Monstera Deliciosa.',
                'price' => 2450.00,
                'compare_price' => 2900.00,
                'stock_quantity' => 25,
                'stock_status' => StockStatus::IN_STOCK->value,
                'is_featured' => true,
                'is_best_seller' => true,
                'status' => 'published',
            ],
            [
                'name' => 'Snake Plant Laurentii (Air Purifier)',
                'slug' => 'snake-plant-laurentii-air-purifier',
                'sku' => 'PLT-SNAKE-01',
                'product_category_id' => $indoorCat?->id ?: 1,
                'plant_id' => $snake?->id,
                'product_type' => ProductType::PLANT->value,
                'short_description' => 'Low-maintenance air purifying indoor houseplant.',
                'description' => 'Virtually indestructible snake plant ideal for bedrooms, desks, and dimly lit spaces.',
                'price' => 1650.00,
                'compare_price' => 1950.00,
                'stock_quantity' => 40,
                'stock_status' => StockStatus::IN_STOCK->value,
                'is_featured' => true,
                'is_new' => true,
                'status' => 'published',
            ],
            [
                'name' => 'Premium Organic Potting Soil Mix (5kg)',
                'slug' => 'premium-organic-potting-soil-mix-5kg',
                'sku' => 'SOIL-ORGANIC-5KG',
                'product_category_id' => $soilCat?->id ?: 1,
                'product_type' => ProductType::SOIL->value,
                'short_description' => 'Enriched nutrient potting soil with perlite and compost.',
                'description' => 'Optimal drainage and root aerating formula for all indoor and outdoor houseplants.',
                'price' => 850.00,
                'compare_price' => 1000.00,
                'stock_quantity' => 100,
                'stock_status' => StockStatus::IN_STOCK->value,
                'is_featured' => false,
                'status' => 'published',
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['sku' => $p['sku']],
                $p
            );
        }
    }
}
