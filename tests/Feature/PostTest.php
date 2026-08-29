<?php

namespace Tests\Feature;

use App\Models\AuthorProfile;
use App\Models\ContentCategory;
use App\Models\Plant;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected User $author;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::create([
            'first_name' => 'Default',
            'last_name' => 'Author',
            'email' => 'author_default@plantora.test',
            'password' => bcrypt('password'),
            'role' => 'editor',
            'status' => 'active',
        ]);
    }

    public function test_guest_can_view_published_articles_index(): void
    {
        $category = ContentCategory::create(['name' => 'Gardening Basics', 'slug' => 'gardening-basics', 'status' => 'active']);

        $post = Post::create([
            'author_id' => $this->author->id,
            'title' => 'Top 10 Indoor Plants for Clean Air',
            'slug' => 'top-10-indoor-plants-for-clean-air',
            'type' => 'article',
            'status' => 'published',
            'published_at' => now(),
            'content_category_id' => $category->id,
            'content' => '<p>Discover the best air purifying plants for your apartment.</p>',
        ]);

        $response = $this->get('/articles');

        $response->assertStatus(200);
        $response->assertSee('Top 10 Indoor Plants for Clean Air');
    }

    public function test_guest_cannot_view_draft_article(): void
    {
        $draftPost = Post::create([
            'author_id' => $this->author->id,
            'title' => 'Unpublished Draft Article',
            'slug' => 'unpublished-draft-article',
            'type' => 'article',
            'status' => 'draft',
            'content' => '<p>Draft content</p>',
        ]);

        $response = $this->get("/articles/{$draftPost->slug}");

        $response->assertStatus(404);
    }

    public function test_guest_can_view_published_article_detail(): void
    {
        $post = Post::create([
            'author_id' => $this->author->id,
            'title' => 'How to Water Houseplants Properly',
            'slug' => 'how-to-water-houseplants-properly',
            'type' => 'article',
            'status' => 'published',
            'published_at' => now(),
            'content' => '<p>Watering guide details and tips for beginners.</p>',
        ]);

        $response = $this->get("/articles/{$post->slug}");

        $response->assertStatus(200);
        $response->assertSee('How to Water Houseplants Properly');
    }

    public function test_guest_can_view_guides_index_and_detail(): void
    {
        $guide = Post::create([
            'author_id' => $this->author->id,
            'title' => 'Ultimate Monstera Propagation Guide',
            'slug' => 'ultimate-monstera-propagation-guide',
            'type' => 'guide',
            'status' => 'published',
            'published_at' => now(),
            'content' => '<p>Step by step propagation instructions.</p>',
        ]);

        $indexResponse = $this->get('/guides');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Ultimate Monstera Propagation Guide');

        $detailResponse = $this->get("/guides/{$guide->slug}");
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Step by step propagation instructions.');
    }

    public function test_guest_can_view_news_index_and_detail(): void
    {
        $news = Post::create([
            'author_id' => $this->author->id,
            'title' => 'New Botanical Garden Opens in Lahore',
            'slug' => 'new-botanical-garden-opens-in-lahore',
            'type' => 'news',
            'status' => 'published',
            'published_at' => now(),
            'content' => '<p>A major new public green space has been unveiled today.</p>',
        ]);

        $indexResponse = $this->get('/news');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('New Botanical Garden Opens in Lahore');

        $detailResponse = $this->get("/news/{$news->slug}");
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('New Botanical Garden Opens in Lahore');
    }

    public function test_guest_can_view_author_profile_page(): void
    {
        $author = User::create([
            'first_name' => 'Botanical',
            'last_name' => 'Expert',
            'email' => 'author@plantora.test',
            'password' => bcrypt('password'),
            'role' => 'editor',
            'status' => 'active',
        ]);

        AuthorProfile::create([
            'user_id' => $author->id,
            'bio' => 'Passionate horticulturist with 15 years experience.',
        ]);

        Post::create([
            'author_id' => $author->id,
            'title' => 'Plant Care Basics by Author',
            'slug' => 'plant-care-basics-by-author',
            'type' => 'article',
            'status' => 'published',
            'published_at' => now(),
            'content' => '<p>Content by author.</p>',
        ]);

        $response = $this->get("/authors/{$author->id}");

        $response->assertStatus(200);
        $response->assertSee('Botanical Expert');
        $response->assertSee('Passionate horticulturist with 15 years experience.');
        $response->assertSee('Plant Care Basics by Author');
    }

    public function test_admin_can_create_post(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Publisher',
            'email' => 'publisher@plantora.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $category = ContentCategory::create(['name' => 'Care Tips', 'slug' => 'care-tips']);
        $tag = Tag::create(['name' => 'Indoor Gardening', 'slug' => 'indoor-gardening']);

        $response = $this->actingAs($admin)->post('/admin/posts', [
            'author_id' => $admin->id,
            'title' => 'Admin Published Article',
            'type' => 'article',
            'status' => 'published',
            'content_category_id' => $category->id,
            'content' => '<p>Comprehensive plant care content written by admin.</p>',
            'tags' => [$tag->id],
        ]);

        $response->assertRedirect('/admin/posts');
        $this->assertDatabaseHas('posts', [
            'title' => 'Admin Published Article',
            'slug' => 'admin-published-article',
            'type' => 'article',
        ]);
    }

    public function test_scheduled_posts_command_publishes_due_posts(): void
    {
        $scheduledPost = Post::create([
            'author_id' => $this->author->id,
            'title' => 'Scheduled Morning Release',
            'slug' => 'scheduled-morning-release',
            'type' => 'article',
            'status' => 'scheduled',
            'scheduled_at' => now()->subMinute(),
            'content' => '<p>Scheduled content ready to be published.</p>',
        ]);

        $this->artisan('posts:publish-scheduled')
             ->assertExitCode(0);

        $this->assertDatabaseHas('posts', [
            'id' => $scheduledPost->id,
            'status' => 'published',
        ]);
    }

    public function test_content_sitemaps_return_xml(): void
    {
        Post::create([
            'author_id' => $this->author->id,
            'title' => 'Sitemap Article',
            'slug' => 'sitemap-article',
            'type' => 'article',
            'status' => 'published',
            'published_at' => now(),
            'content' => '<p>Article for sitemap test.</p>',
        ]);

        $response = $this->get('/sitemaps/articles.xml');
        $response->assertStatus(200);
        $this->assertStringContainsString('text/xml', $response->headers->get('Content-Type'));
        $response->assertSee('sitemap-article');
    }
}
