<?php

namespace Tests\Feature;

use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\PlantProblem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlantTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_published_plants_index(): void
    {
        PlantCategory::create(['name' => 'Indoor Plants', 'slug' => 'indoor-plants']);
        
        Plant::create([
            'name' => 'Monstera Deliciosa',
            'slug' => 'monstera-deliciosa',
            'difficulty' => 'easy',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/plants');

        $response->assertStatus(200);
        $response->assertSee('Monstera Deliciosa');
    }

    public function test_guest_cannot_view_draft_plant(): void
    {
        $draftPlant = Plant::create([
            'name' => 'Draft Orchid',
            'slug' => 'draft-orchid',
            'difficulty' => 'easy',
            'status' => 'draft',
        ]);

        $response = $this->get("/plants/{$draftPlant->slug}");

        $response->assertStatus(404);
    }

    public function test_guest_can_view_published_plant_detail(): void
    {
        $publishedPlant = Plant::create([
            'name' => 'Peace Lily',
            'slug' => 'peace-lily',
            'scientific_name' => 'Spathiphyllum wallisii',
            'difficulty' => 'easy',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get("/plants/{$publishedPlant->slug}");

        $response->assertStatus(200);
        $response->assertSee('Peace Lily');
        $response->assertSee('Spathiphyllum wallisii');
    }

    public function test_admin_can_create_plant_category(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@plantora.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->post('/admin/plant-categories', [
            'name' => 'Succulents',
            'status' => 'active',
        ]);

        $response->assertRedirect('/admin/plant-categories');
        $this->assertDatabaseHas('plant_categories', ['name' => 'Succulents', 'slug' => 'succulents']);
    }

    public function test_admin_can_create_plant(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin2@plantora.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);
        
        $cat = PlantCategory::create(['name' => 'Indoor Plants', 'slug' => 'indoor-plants']);

        $response = $this->actingAs($admin)->post('/admin/plants', [
            'name' => 'Fiddle Leaf Fig',
            'plant_category_id' => $cat->id,
            'difficulty' => 'moderate',
            'growth_rate' => 'medium',
            'status' => 'published',
        ]);

        $response->assertRedirect('/admin/plants');
        $this->assertDatabaseHas('plants', ['name' => 'Fiddle Leaf Fig', 'slug' => 'fiddle-leaf-fig']);
    }

    public function test_guest_can_view_plant_problems(): void
    {
        PlantProblem::create([
            'name' => 'Yellow Leaves',
            'slug' => 'yellow-leaves',
            'problem_type' => 'watering',
            'severity' => 'medium',
            'status' => 'active',
        ]);

        $response = $this->get('/plant-problems');
        $response->assertStatus(200);
        $response->assertSee('Yellow Leaves');

        $detailResponse = $this->get('/plant-problems/yellow-leaves');
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Yellow Leaves');
    }

    public function test_sitemap_index_returns_sub_sitemaps(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $this->assertStringContainsString('text/xml', $response->headers->get('Content-Type'));
        $response->assertSee('/sitemaps/plants.xml');
        $response->assertSee('/sitemaps/plant-categories.xml');
        $response->assertSee('/sitemaps/plant-problems.xml');
    }
}
