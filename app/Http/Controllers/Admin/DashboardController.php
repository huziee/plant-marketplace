<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\NewsletterSubscriber;
use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\PlantProblem;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'customers' => User::where('role', 'customer')->count(),
            'nursery_owners' => User::where('role', 'nursery_owner')->count(),
            'content_creators' => User::whereIn('role', ['editor', 'author'])->count(),
            'total_plants' => Plant::count(),
            'published_plants' => Plant::published()->count(),
            'plant_categories' => PlantCategory::count(),
            'plant_problems' => PlantProblem::count(),
            'total_products' => \App\Models\Product::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_posts' => Post::count(),
            'published_articles' => Post::published()->ofType(PostType::ARTICLE)->count(),
            'published_guides' => Post::published()->ofType(PostType::GUIDE)->count(),
            'published_news' => Post::published()->ofType(PostType::NEWS)->count(),
            'draft_posts' => Post::where('status', PostStatus::DRAFT->value)->count(),
            'scheduled_posts' => Post::where('status', PostStatus::SCHEDULED->value)->count(),
            'media_files' => Media::count(),
            'subscribers' => NewsletterSubscriber::where('status', 'active')->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentPosts = Post::with(['author', 'category'])->latest()->take(5)->get();

        $systemInfo = [
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'db_driver' => config('database.default'),
            'environment' => config('app.env'),
        ];

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentPosts', 'systemInfo'));
    }
}
