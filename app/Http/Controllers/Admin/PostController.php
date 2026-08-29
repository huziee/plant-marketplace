<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\ContentCategory;
use App\Models\Media;
use App\Models\Plant;
use App\Models\PlantProblem;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index(Request $request)
    {
        $query = Post::with(['author', 'category', 'featuredImage'])
            ->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('slug', 'like', "%{$s}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('content_category_id', $request->category);
        }

        if ($request->filled('author')) {
            $query->where('author_id', $request->author);
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        $posts = $query->paginate(15)->withQueryString();

        $categories = ContentCategory::active()->get();
        $authors = User::whereIn('role', ['admin', 'editor', 'author'])->get();

        return view('admin.posts.index', compact('posts', 'categories', 'authors'));
    }

    public function create()
    {
        $categories = ContentCategory::active()->get();
        $tags = Tag::active()->get();
        $plants = Plant::published()->select('id', 'name')->get();
        $problems = PlantProblem::active()->select('id', 'name')->get();
        $posts = Post::published()->select('id', 'title')->get();
        $authors = User::whereIn('role', ['admin', 'editor', 'author'])->get();
        $mediaFiles = Media::latest()->take(30)->get();

        return view('admin.posts.create', compact('categories', 'tags', 'plants', 'problems', 'posts', 'authors', 'mediaFiles'));
    }

    public function store(StorePostRequest $request)
    {
        $post = $this->postService->createPost($request->validated(), $request->user());

        return redirect()->route('admin.posts.index')
            ->with('success', "Post '{$post->title}' created successfully.");
    }

    public function edit(Post $post)
    {
        $post->load(['tags', 'plants', 'problems', 'relatedPosts', 'sources']);

        $categories = ContentCategory::active()->get();
        $tags = Tag::active()->get();
        $plants = Plant::published()->select('id', 'name')->get();
        $problems = PlantProblem::active()->select('id', 'name')->get();
        $posts = Post::where('id', '!=', $post->id)->select('id', 'title')->get();
        $authors = User::whereIn('role', ['admin', 'editor', 'author'])->get();
        $mediaFiles = Media::latest()->take(30)->get();

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'plants', 'problems', 'posts', 'authors', 'mediaFiles'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->postService->updatePost($post, $request->validated(), $request->user());

        return redirect()->route('admin.posts.index')
            ->with('success', "Post '{$post->title}' updated successfully.");
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', "Post '{$post->title}' deleted successfully.");
    }

    public function duplicate(Post $post)
    {
        $newPost = $this->postService->duplicatePost($post, auth()->user());

        return redirect()->route('admin.posts.edit', $newPost->id)
            ->with('success', "Post duplicated as draft. You can now edit '{$newPost->title}'.");
    }

    public function preview(Post $post)
    {
        $relatedPosts = $this->postService->getRelatedPosts($post);
        return view('frontend.articles.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'seo' => [
                'title' => "[PREVIEW] {$post->title}",
                'description' => $post->excerpt ?: Str::limit(strip_tags($post->content), 150),
            ],
            'isPreview' => true,
        ]);
    }
}
