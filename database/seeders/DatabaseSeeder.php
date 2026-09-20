<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            ContentCategorySeeder::class,
            PlantCategorySeeder::class,
            PlantProblemSeeder::class,
            PlantSeeder::class,
            ProductCategorySeeder::class,
            ShippingMethodSeeder::class,
            ProductSeeder::class,
            PageSeeder::class,
            ArticleSeeder::class,
            ContentAutomationSeeder::class,
        ]);
    }
}
