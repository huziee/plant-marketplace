<?php

namespace Database\Seeders;

use App\Models\AuthorProfile;
use App\Models\ContentTopic;
use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ContentAutomationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. System Author Account: Plantaric Editorial Team
        $authorUser = User::updateOrCreate(
            ['email' => 'editorial@plantora.com'],
            [
                'first_name' => 'Plantaric',
                'last_name' => 'Editorial Team',
                'phone' => '+92 300 9999999',
                'role' => 'editor',
                'status' => 'active',
                'password' => Hash::make(bin2hex(random_bytes(16))),
                'email_verified_at' => now(),
            ]
        );

        AuthorProfile::updateOrCreate(
            ['user_id' => $authorUser->id],
            [
                'bio' => 'Official botanical research, plant care, and horticultural news editorial team at Plantaric.',
                'job_title' => 'Botanical Content Desk',
                'website' => config('app.url'),
            ]
        );

        // 2. Initial Article Topics Queue
        $topics = [
            [
                'content_type' => 'article',
                'topic' => 'Soil Health & Plant Growth',
                'search_query' => 'soil pH plant growth',
                'primary_keyword' => 'soil pH plant growth',
                'priority' => 10,
                'active' => true,
            ],
            [
                'content_type' => 'article',
                'topic' => 'Indoor Plant Water Stress & Hydration',
                'search_query' => 'indoor plant water stress drought',
                'primary_keyword' => 'houseplant watering tips',
                'priority' => 9,
                'active' => true,
            ],
            [
                'content_type' => 'article',
                'topic' => 'Organic Pest Management & Biological Control',
                'search_query' => 'organic pest management houseplants crop',
                'primary_keyword' => 'organic plant pest control',
                'priority' => 8,
                'active' => true,
            ],
            [
                'content_type' => 'article',
                'topic' => 'Plant Nutrient Deficiency & Fertilization',
                'search_query' => 'plant nutrient deficiency nitrogen phosphorus potassium',
                'primary_keyword' => 'plant fertilizer nutrients',
                'priority' => 7,
                'active' => true,
            ],
            [
                'content_type' => 'article',
                'topic' => 'Crop & Houseplant Fungal Diseases',
                'search_query' => 'crop fungal disease leaf spot powdery mildew',
                'primary_keyword' => 'fungal disease prevention plants',
                'priority' => 6,
                'active' => true,
            ],
            [
                'content_type' => 'article',
                'topic' => 'Plant Propagation & Rooting Science',
                'search_query' => 'plant propagation stem cuttings rooting hormone',
                'primary_keyword' => 'plant propagation guide',
                'priority' => 5,
                'active' => true,
            ],
        ];

        foreach ($topics as $t) {
            ContentTopic::updateOrCreate(
                ['topic' => $t['topic'], 'content_type' => $t['content_type']],
                $t
            );
        }

        // 3. Settings Initialization
        $settingsService = app(SettingsService::class);
        $settingsService->set('automation.enabled', '1', 'automation', 'boolean');
        $settingsService->set('automation.articles_enabled', '1', 'automation', 'boolean');
        $settingsService->set('automation.news_enabled', '1', 'automation', 'boolean');
        $settingsService->set('automation.news_per_day', '1', 'automation', 'integer');
        $settingsService->set('automation.articles_per_day', '1', 'automation', 'integer');
        $settingsService->set('automation.auto_publish', '0', 'automation', 'boolean');
        $settingsService->set('automation.default_author_id', (string) $authorUser->id, 'automation', 'integer');
        $settingsService->set('automation.openai_model', 'gpt-4o-mini', 'automation', 'string');
    }
}
