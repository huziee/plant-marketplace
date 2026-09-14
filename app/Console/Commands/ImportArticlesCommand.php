<?php

namespace App\Console\Commands;

use App\Models\ContentCategory;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportArticlesCommand extends Command
{
    protected $signature = 'import:articles';
    protected $description = 'Import 10 markdown articles into Plantaric CMS';

    public function handle()
    {
        $this->info('Starting sequence import of 10 markdown articles...');

        $articles = [
            [
                'file' => '01-vegetable-garden-beginners.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_vegetable_garden_1788693234989.jpg',
                'category_slug' => 'urban-gardening',
                'author_email' => 'tariq@plantaric.com',
            ],
            [
                'file' => '02-sustainable-farming-practices.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_sustainable_farming_1788693270780.jpg',
                'category_slug' => 'agricultural-innovation',
                'author_email' => 'sara@plantaric.com',
            ],
            [
                'file' => '03-indoor-plants-air-purification.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_indoor_air_plants_1788693321880.jpg',
                'category_slug' => 'plant-care-guides',
                'author_email' => 'sara@plantaric.com',
            ],
            [
                'file' => '04-understanding-soil-health.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_soil_health_1788693359160.jpg',
                'category_slug' => 'soil-fertilizers',
                'author_email' => 'tariq@plantaric.com',
            ],
            [
                'file' => '05-organic-pest-control.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_organic_pest_control_1788693399464.jpg',
                'category_slug' => 'pest-disease-control',
                'author_email' => 'sara@plantaric.com',
            ],
            [
                'file' => '06-crop-rotation-benefits.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_crop_rotation_1788693451153.jpg',
                'category_slug' => 'agricultural-innovation',
                'author_email' => 'tariq@plantaric.com',
            ],
            [
                'file' => '07-watering-schedules.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_watering_schedules_1788693500156.jpg',
                'category_slug' => 'plant-care-guides',
                'author_email' => 'sara@plantaric.com',
            ],
            [
                'file' => '08-companion-planting-guide.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_companion_planting_1788693549952.jpg',
                'category_slug' => 'urban-gardening',
                'author_email' => 'tariq@plantaric.com',
            ],
            [
                'file' => '09-climate-smart-agriculture.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_climate_agriculture_1788693612806.jpg',
                'category_slug' => 'agricultural-innovation',
                'author_email' => 'sara@plantaric.com',
            ],
            [
                'file' => '10-composting-101.md',
                'image' => 'C:\\Users\\HOME\\.gemini\\antigravity-ide\\brain\\f57c4436-b1db-4350-b823-1b1fe0b37bdb\\article_composting_101_1788693688860.jpg',
                'category_slug' => 'soil-fertilizers',
                'author_email' => 'tariq@plantaric.com',
            ],
        ];

        // Ensure storage directories exist
        $storagePostsDir = storage_path('app/public/posts');
        $publicPostsDir = public_path('storage/posts');
        File::ensureDirectoryExists($storagePostsDir);
        File::ensureDirectoryExists($publicPostsDir);

        foreach ($articles as $index => $item) {
            $filePath = resource_path('content/articles/' . $item['file']);
            if (!File::exists($filePath)) {
                $this->error("File not found: {$filePath}");
                continue;
            }

            $rawContent = File::get($filePath);
            
            // Extract Title (# Title)
            preg_match('/^#\s+(.+)$/m', $rawContent, $titleMatches);
            $title = isset($titleMatches[1]) ? trim($titleMatches[1]) : 'Untitled Article ' . ($index + 1);
            $slug = Str::slug($title);

            // Extract Meta Description
            preg_match('/\*\*Meta Description:\*\*\s*(.+)$/m', $rawContent, $metaMatches);
            $metaDescription = isset($metaMatches[1]) ? trim($metaMatches[1]) : Str::limit(strip_tags($rawContent), 155);

            // Extract Target Keyword
            preg_match('/\*\*Target Keyword:\*\*\s*(.+)$/m', $rawContent, $kwMatches);
            $targetKeyword = isset($kwMatches[1]) ? trim($kwMatches[1]) : null;

            // Clean Body Content (remove H1, Meta Description, Target Keywords lines, and hr dividers)
            $lines = explode("\n", $rawContent);
            $cleanLines = [];
            $headerPassed = false;
            foreach ($lines as $line) {
                if (str_starts_with($line, '# ') || str_contains($line, '**Meta Description:**') || str_contains($line, '**Target Keyword:**') || str_contains($line, '**Secondary Keywords:**')) {
                    continue;
                }
                if (trim($line) === '---' && !$headerPassed) {
                    $headerPassed = true;
                    continue;
                }
                $cleanLines[] = $line;
            }

            $markdownBody = implode("\n", $cleanLines);
            $htmlContent = Str::markdown($markdownBody);

            // Extract Excerpt (first non-empty paragraph)
            $firstPara = '';
            foreach ($cleanLines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '' && !str_starts_with($trimmed, '#') && !str_starts_with($trimmed, '-')) {
                    $firstPara = $trimmed;
                    break;
                }
            }
            $excerpt = Str::limit(strip_tags($firstPara), 200);

            // Process Featured Image
            $imageFilename = "{$slug}.jpg";
            $storageDest = "{$storagePostsDir}/{$imageFilename}";
            $publicDest = "{$publicPostsDir}/{$imageFilename}";

            if (File::exists($item['image'])) {
                File::copy($item['image'], $storageDest);
                File::copy($item['image'], $publicDest);
            }

            $media = Media::updateOrCreate(
                ['file_path' => "posts/{$imageFilename}"],
                [
                    'file_name' => $imageFilename,
                    'original_name' => $imageFilename,
                    'file_path' => "posts/{$imageFilename}",
                    'disk' => 'public',
                    'mime_type' => 'image/jpeg',
                    'extension' => 'jpg',
                    'size' => File::exists($storageDest) ? File::size($storageDest) : 100000,
                    'width' => 1200,
                    'height' => 675,
                    'alt_text' => $title,
                    'title' => $title,
                ]
            );

            // Find Author and Category
            $author = User::where('email', $item['author_email'])->first() ?: User::first();
            if (!$author) {
                $author = User::create([
                    'first_name' => 'Plantaric',
                    'last_name' => 'Editorial',
                    'email' => $item['author_email'],
                    'role' => 'author',
                    'status' => 'active',
                    'password' => bcrypt('password123'),
                ]);
            }

            $category = ContentCategory::where('slug', $item['category_slug'])->first() ?: ContentCategory::first();
            if (!$category) {
                $category = ContentCategory::create([
                    'name' => 'Plant Care & Gardening',
                    'slug' => 'plant-care-gardening',
                    'type' => 'article',
                    'status' => 'active',
                ]);
            }

            // Word count and reading time
            $wordCount = str_word_count(strip_tags($markdownBody));
            $readingTime = max(1, (int) ceil($wordCount / 200));

            // Create or Update Post
            $post = Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'author_id' => $author->id,
                    'content_category_id' => $category?->id,
                    'type' => 'article',
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'content' => $htmlContent,
                    'featured_image_id' => $media->id,
                    'status' => 'published',
                    'is_featured' => $index < 3,
                    'published_at' => now()->subDays(10 - $index),
                    'reading_time' => $readingTime,
                    'seo_title' => "{$title} | Plantaric",
                    'meta_description' => $metaDescription,
                    'focus_keyword' => $targetKeyword,
                    'canonical_url' => url("/articles/{$slug}"),
                    'og_title' => $title,
                    'og_description' => $metaDescription,
                    'og_image_id' => $media->id,
                    'robots_index' => true,
                    'robots_follow' => true,
                ]
            );

            $this->info("Imported [" . ($index + 1) . "/10]: {$title}");
        }

        $this->info('Successfully imported all 10 articles into Plantaric CMS!');
    }
}
