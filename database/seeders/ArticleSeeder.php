<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds for 10 markdown articles.
     */
    public function run(): void
    {
        $this->command?->info('Running ArticleSeeder to import 10 markdown articles...');
        Artisan::call('import:articles');
        $this->command?->info(Artisan::output());
    }
}
