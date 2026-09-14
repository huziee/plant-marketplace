<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Post;
use App\Models\User;
use App\Models\UrlRedirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_returns_valid_seo_metadata_and_json_ld()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<link rel="canonical"', false);
        $response->assertSee('index,follow,max-image-preview:large', false);
        $response->assertSee('og:title', false);
        $response->assertSee('twitter:card', false);
        $response->assertSee('application/ld+json', false);
    }

    public function test_search_page_returns_noindex()
    {
        $response = $this->get('/search?q=monstera');

        $response->assertStatus(200);
        $response->assertSee('noindex,follow', false);
    }

    public function test_cart_page_returns_noindex()
    {
        $response = $this->get('/cart');

        $response->assertStatus(200);
        $response->assertSee('noindex,follow', false);
    }

    public function test_login_page_returns_noindex()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('noindex,follow', false);
    }

    public function test_product_page_with_tracking_parameter_canonicalizes_to_clean_url()
    {
        $category = ProductCategory::create([
            'name' => 'Indoor Plants',
            'slug' => 'indoor-plants',
            'status' => 'active',
        ]);

        $product = Product::create([
            'product_category_id' => $category->id,
            'name' => 'Monstera Deliciosa',
            'slug' => 'monstera-deliciosa',
            'sku' => 'MON-001',
            'price' => 2500.00,
            'status' => 'published',
            'stock_status' => 'in_stock',
        ]);

        $response = $this->get('/shop/products/monstera-deliciosa?utm_source=facebook&utm_medium=cpc');

        $response->assertStatus(200);
        $response->assertSee('<link rel="canonical" href="' . url('/shop/products/monstera-deliciosa') . '">', false);
    }

    public function test_sitemap_index_returns_valid_xml()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('text/xml', (string) $response->headers->get('Content-Type'));
        $response->assertSee('sitemapindex', false);
    }

    public function test_products_sitemap_returns_only_published_products()
    {
        $category = ProductCategory::create([
            'name' => 'Indoor Plants',
            'slug' => 'indoor-plants',
            'status' => 'active',
        ]);

        $published = Product::create([
            'product_category_id' => $category->id,
            'name' => 'Published Plant',
            'slug' => 'published-plant',
            'sku' => 'PUB-001',
            'price' => 1500.00,
            'status' => 'published',
            'stock_status' => 'in_stock',
            'robots_index' => true,
        ]);

        $draft = Product::create([
            'product_category_id' => $category->id,
            'name' => 'Draft Plant',
            'slug' => 'draft-plant',
            'sku' => 'DFT-001',
            'price' => 1500.00,
            'status' => 'draft',
            'stock_status' => 'in_stock',
            'robots_index' => true,
        ]);

        $response = $this->get('/sitemaps/products.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('text/xml', (string) $response->headers->get('Content-Type'));
        $response->assertSee('/shop/products/published-plant');
        $response->assertDontSee('/shop/products/draft-plant');
    }

    public function test_url_redirect_returns_301_permanent_redirect()
    {
        UrlRedirect::create([
            'old_url' => '/old-monstera-page',
            'new_url' => '/plants/monstera-deliciosa',
            'status_code' => 301,
        ]);

        $response = $this->get('/old-monstera-page');

        $response->assertRedirect('/plants/monstera-deliciosa');
        $response->assertStatus(301);
    }

    public function test_json_ld_schema_in_head_is_decodable_json()
    {
        $response = $this->get('/');
        $content = $response->getContent();

        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $content, $matches);
        $this->assertNotEmpty($matches[1], 'JSON-LD scripts should be present');

        foreach ($matches[1] as $jsonString) {
            $decoded = json_decode(trim($jsonString), true);
            $this->assertNotNull($decoded, 'JSON-LD script should decode without syntax errors');
            $this->assertArrayHasKey('@context', $decoded);
        }
    }
}
