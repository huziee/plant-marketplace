<?php

namespace App\Services;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Post;
use App\Models\UrlRedirect;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostService
{
    public function __construct(
        protected ContentSanitizerService $sanitizer
    ) {}

    public function createPost(array $data, User $user): Post
    {
        return DB::transaction(function () use ($data, $user) {
            $content = $this->sanitizer->sanitize($data['content'] ?? '');
            
            $post = Post::create([
                'author_id' => $data['author_id'] ?? $user->id,
                'content_category_id' => $data['content_category_id'] ?? null,
                'type' => $data['type'] ?? PostType::ARTICLE->value,
                'title' => $data['title'],
                'slug' => !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['title']),
                'excerpt' => $data['excerpt'] ?? null,
                'content' => $content,
                'featured_image_id' => $data['featured_image_id'] ?? null,
                'status' => $data['status'] ?? PostStatus::DRAFT->value,
                'is_featured' => !empty($data['is_featured']),
                'is_editor_pick' => !empty($data['is_editor_pick']),
                'allow_comments' => !empty($data['allow_comments']),
                'published_at' => ($data['status'] ?? '') === PostStatus::PUBLISHED->value ? ($data['published_at'] ?? now()) : null,
                'scheduled_at' => ($data['status'] ?? '') === PostStatus::SCHEDULED->value ? $data['scheduled_at'] : null,
                'reading_time' => Post::computeReadingTime($content),
                'seo_title' => $data['seo_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'canonical_url' => $data['canonical_url'] ?? null,
                'focus_keyword' => $data['focus_keyword'] ?? null,
                'og_title' => $data['og_title'] ?? null,
                'og_description' => $data['og_description'] ?? null,
                'og_image_id' => $data['og_image_id'] ?? null,
                'robots_index' => isset($data['robots_index']) ? (bool)$data['robots_index'] : true,
                'robots_follow' => isset($data['robots_follow']) ? (bool)$data['robots_follow'] : true,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            // Sync Tags
            if (isset($data['tags'])) {
                $post->tags()->sync($data['tags']);
            }

            // Sync Plants
            if (isset($data['plants'])) {
                $post->plants()->sync($data['plants']);
            }

            // Sync Problems
            if (isset($data['problems'])) {
                $post->problems()->sync($data['problems']);
            }

            // Sync Related Posts
            if (isset($data['related_posts'])) {
                $post->relatedPosts()->sync($data['related_posts']);
            }

            // Sync Sources
            if (!empty($data['sources']) && is_array($data['sources'])) {
                foreach ($data['sources'] as $sourceData) {
                    if (!empty($sourceData['title']) && !empty($sourceData['url'])) {
                        $post->sources()->create([
                            'title' => $sourceData['title'],
                            'url' => $sourceData['url'],
                            'publisher' => $sourceData['publisher'] ?? null,
                            'published_at' => $sourceData['published_at'] ?? null,
                        ]);
                    }
                }
            }

            return $post;
        });
    }

    public function updatePost(Post $post, array $data, User $user): Post
    {
        return DB::transaction(function () use ($post, $data, $user) {
            $oldSlug = $post->slug;
            $newSlug = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['title']);

            // 301 Redirect on slug change if published
            if ($oldSlug !== $newSlug && $post->status === PostStatus::PUBLISHED) {
                $typePrefix = $post->type instanceof PostType ? $post->type->routePrefix() : PostType::from($post->type)->routePrefix();
                UrlRedirect::createRedirect("/{$typePrefix}/{$oldSlug}", "/{$typePrefix}/{$newSlug}", 301);
            }

            $content = $this->sanitizer->sanitize($data['content'] ?? $post->content);

            $post->update([
                'author_id' => $data['author_id'] ?? $post->author_id,
                'content_category_id' => $data['content_category_id'] ?? $post->content_category_id,
                'type' => $data['type'] ?? $post->type,
                'title' => $data['title'],
                'slug' => $newSlug,
                'excerpt' => $data['excerpt'] ?? $post->excerpt,
                'content' => $content,
                'featured_image_id' => $data['featured_image_id'] ?? $post->featured_image_id,
                'status' => $data['status'] ?? $post->status,
                'is_featured' => isset($data['is_featured']) ? (bool)$data['is_featured'] : $post->is_featured,
                'is_editor_pick' => isset($data['is_editor_pick']) ? (bool)$data['is_editor_pick'] : $post->is_editor_pick,
                'allow_comments' => isset($data['allow_comments']) ? (bool)$data['allow_comments'] : $post->allow_comments,
                'published_at' => ($data['status'] ?? '') === PostStatus::PUBLISHED->value ? ($post->published_at ?? now()) : $post->published_at,
                'scheduled_at' => ($data['status'] ?? '') === PostStatus::SCHEDULED->value ? ($data['scheduled_at'] ?? $post->scheduled_at) : null,
                'seo_title' => $data['seo_title'] ?? $post->seo_title,
                'meta_description' => $data['meta_description'] ?? $post->meta_description,
                'canonical_url' => $data['canonical_url'] ?? $post->canonical_url,
                'focus_keyword' => $data['focus_keyword'] ?? $post->focus_keyword,
                'og_title' => $data['og_title'] ?? $post->og_title,
                'og_description' => $data['og_description'] ?? $post->og_description,
                'og_image_id' => $data['og_image_id'] ?? $post->og_image_id,
                'robots_index' => isset($data['robots_index']) ? (bool)$data['robots_index'] : $post->robots_index,
                'robots_follow' => isset($data['robots_follow']) ? (bool)$data['robots_follow'] : $post->robots_follow,
                'updated_by' => $user->id,
            ]);

            if (isset($data['tags'])) {
                $post->tags()->sync($data['tags']);
            }
            if (isset($data['plants'])) {
                $post->plants()->sync($data['plants']);
            }
            if (isset($data['problems'])) {
                $post->problems()->sync($data['problems']);
            }
            if (isset($data['related_posts'])) {
                $post->relatedPosts()->sync($data['related_posts']);
            }

            return $post;
        });
    }

    public function duplicatePost(Post $post, User $user): Post
    {
        return DB::transaction(function () use ($post, $user) {
            $newPost = $post->replicate(['views']);
            $newPost->title = "{$post->title} (Copy)";
            $newPost->slug = Str::slug($newPost->title) . '-' . Str::random(4);
            $newPost->status = PostStatus::DRAFT->value;
            $newPost->published_at = null;
            $newPost->scheduled_at = null;
            $newPost->is_featured = false;
            $newPost->is_editor_pick = false;
            $newPost->views = 0;
            $newPost->created_by = $user->id;
            $newPost->updated_by = $user->id;
            $newPost->save();

            $newPost->tags()->sync($post->tags->pluck('id'));
            $newPost->plants()->sync($post->plants->pluck('id'));
            $newPost->problems()->sync($post->problems->pluck('id'));

            return $newPost;
        });
    }

    /**
     * Get automatic related content recommendation for public post detail page.
     */
    public function getRelatedPosts(Post $post, int $limit = 4)
    {
        // 1. Manually specified related posts first
        $manual = $post->relatedPosts()->published()->take($limit)->get();
        if ($manual->count() >= $limit) {
            return $manual;
        }

        // 2. Automatic fallback: same category or shared tags
        $needed = $limit - $manual->count();
        $excludeIds = $manual->pluck('id')->push($post->id);

        $auto = Post::published()
            ->whereNotIn('id', $excludeIds)
            ->where(function ($q) use ($post) {
                if ($post->content_category_id) {
                    $q->where('content_category_id', $post->content_category_id);
                }
                if ($post->tags->count() > 0) {
                    $q->orWhereHas('tags', function ($tq) use ($post) {
                        $tq->whereIn('tags.id', $post->tags->pluck('id'));
                    });
                }
            })
            ->latest('published_at')
            ->take($needed)
            ->get();

        return $manual->concat($auto);
    }
}
