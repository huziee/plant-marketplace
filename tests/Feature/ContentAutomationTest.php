<?php

namespace Tests\Feature;

use App\Models\AuthorProfile;
use App\Models\ContentCategory;
use App\Models\ContentCandidate;
use App\Models\ContentResearchSource;
use App\Models\ContentTopic;
use App\Models\Post;
use App\Models\User;
use App\Services\ContentAutomation\GdeltService;
use App\Services\ContentAutomation\OpenAlexService;
use App\Services\ContentAutomation\NewsDiscoveryService;
use App\Services\ContentAutomation\ArticleDiscoveryService;
use App\Services\ContentAutomation\ContentGenerationService;
use App\Services\ContentAutomation\PostCreationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ContentAutomationTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $editorialTeamUser;
    protected ContentCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin_test@plantora.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $this->editorialTeamUser = User::create([
            'first_name' => 'Plantaric',
            'last_name' => 'Editorial Team',
            'email' => 'editorial@plantora.com',
            'password' => bcrypt('password'),
            'role' => 'editor',
            'status' => 'active',
        ]);

        AuthorProfile::create([
            'user_id' => $this->editorialTeamUser->id,
            'bio' => 'Official botanical research team',
        ]);

        $this->category = ContentCategory::create([
            'name' => 'Plant Health',
            'slug' => 'plant-health',
            'status' => 'active',
        ]);

        ContentTopic::create([
            'content_type' => 'article',
            'topic' => 'Soil Health',
            'search_query' => 'soil pH plant growth',
            'primary_keyword' => 'soil pH plant growth',
            'priority' => 10,
            'active' => true,
        ]);
    }

    public function test_gdelt_service_parses_news_response(): void
    {
        Http::fake([
            'https://api.gdeltproject.org/api/v2/doc/doc*' => Http::response([
                'articles' => [
                    [
                        'url' => 'https://example-news.com/botanical-discovery',
                        'title' => 'New Plant Species Discovered in Amazon',
                        'domain' => 'example-news.com',
                        'language' => 'English',
                        'sourcecountry' => 'United States',
                        'seendate' => '20260919T020000Z',
                    ]
                ]
            ], 200),
        ]);

        $service = app(GdeltService::class);
        $results = $service->fetchNews();

        $this->assertCount(1, $results);
        $this->assertEquals('New Plant Species Discovered in Amazon', $results[0]['title']);
        $this->assertEquals('https://example-news.com/botanical-discovery', $results[0]['url']);
    }

    public function test_openalex_service_reconstructs_abstract(): void
    {
        $service = app(OpenAlexService::class);
        $invertedIndex = [
            'Soil' => [0],
            'microbiome' => [1],
            'enhances' => [2],
            'plant' => [3],
            'immunity.' => [4],
        ];

        $reconstructed = $service->reconstructAbstract($invertedIndex);
        $this->assertEquals('Soil microbiome enhances plant immunity.', $reconstructed);
    }

    public function test_news_discovery_creates_candidate_and_private_source(): void
    {
        Http::fake([
            'https://api.gdeltproject.org/api/v2/doc/doc*' => Http::response([
                'articles' => [
                    [
                        'url' => 'https://botanynews.org/fungal-breakthrough',
                        'title' => 'New Fungal Disease Resistance Found in Wheat',
                        'domain' => 'botanynews.org',
                        'language' => 'English',
                        'seendate' => '20260919T020000Z',
                    ]
                ]
            ], 200),
        ]);

        $service = app(NewsDiscoveryService::class);
        $count = $service->discover(1);

        $this->assertEquals(1, $count);
        $this->assertDatabaseHas('content_candidates', [
            'content_type' => 'news',
            'source_type' => 'gdelt',
            'topic' => 'plant-disease',
            'suggested_title' => 'New Fungal Disease Resistance Found in Wheat',
        ]);

        $candidate = ContentCandidate::first();
        $this->assertDatabaseHas('content_research_sources', [
            'content_candidate_id' => $candidate->id,
            'provider' => 'gdelt',
            'is_public' => false,
        ]);
    }

    public function test_article_discovery_creates_candidate_from_openalex(): void
    {
        Http::fake([
            'https://api.openalex.org/works*' => Http::response([
                'results' => [
                    [
                        'id' => 'https://openalex.org/W12345678',
                        'title' => 'Influence of Soil pH on Tomato Nutrient Uptake',
                        'doi' => 'https://doi.org/10.1000/182',
                        'publication_date' => '2026-01-15',
                        'abstract_inverted_index' => [
                            'Soil' => [0],
                            'pH' => [1],
                            'regulates' => [2],
                            'tomato' => [3],
                            'growth.' => [4],
                        ],
                    ]
                ]
            ], 200),
        ]);

        $service = app(ArticleDiscoveryService::class);
        $count = $service->discover(1);

        $this->assertEquals(1, $count);
        $this->assertDatabaseHas('content_candidates', [
            'content_type' => 'article',
            'topic' => 'Soil Health',
        ]);
    }

    public function test_content_generation_creates_draft_post_with_system_author(): void
    {
        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'title' => 'How Soil pH Directly Affects Indoor Plant Vitality',
                                'slug' => 'how-soil-ph-affects-indoor-plant-vitality',
                                'excerpt' => 'Discover the crucial role of soil acidity and alkalinity in nutrient absorption for house plants.',
                                'body' => '<h2>Understanding Soil pH</h2><p>Soil pH dictates how easily plant roots absorb essential macronutrients. Maintaining proper pH levels ensures robust foliage and root health.</p>',
                                'seo_title' => 'Soil pH Guide for Houseplants',
                                'meta_description' => 'Learn how soil pH impacts plant health and growth.',
                                'focus_keyword' => 'soil pH plant growth',
                                'category_slug' => 'plant-health',
                                'tags' => ['Soil', 'Plant Care', 'Gardening'],
                            ]),
                        ],
                    ],
                ],
            ], 200),
        ]);

        $candidate = ContentCandidate::create([
            'content_type' => 'article',
            'source_type' => 'openalex',
            'topic' => 'Soil Health',
            'suggested_title' => 'Soil pH Guide',
            'fingerprint' => 'test-fingerprint-12345',
            'research_context' => ['type' => 'article', 'topic' => 'Soil Health'],
            'status' => 'ready',
        ]);

        config(['services.openai.api_key' => 'sk-test-fake-key-for-testing']);

        $genService = app(ContentGenerationService::class);
        $postService = app(PostCreationService::class);

        $result = $genService->generate($candidate);
        dd($result);
        $this->assertTrue($result['success']);

        $post = $postService->createPost($candidate, $result['data']);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('article', $post->type->value);
        $this->assertEquals('draft', $post->status->value);
        $this->assertEquals($this->editorialTeamUser->id, $post->author_id);
        $this->assertEquals('How Soil pH Directly Affects Indoor Plant Vitality', $post->title);

        // Verify post_sources is empty on post so private research is NOT rendered publicly
        $this->assertEquals(0, $post->sources()->count());
    }

    public function test_guest_cannot_access_content_automation_admin_routes(): void
    {
        $response = $this->get('/admin/content-automation');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_content_automation_admin_routes(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/content-automation');
        $response->assertStatus(200);
        $response->assertSee('Content Automation Engine');
    }
}
