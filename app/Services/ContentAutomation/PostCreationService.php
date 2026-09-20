<?php

namespace App\Services\ContentAutomation;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\ContentCategory;
use App\Models\ContentCandidate;
use App\Models\ContentResearchSource;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\PostService;
use App\Services\SettingsService;
use Illuminate\Support\Str;

class PostCreationService
{
    public function __construct(
        protected PostService $postService,
        protected SettingsService $settingsService
    ) {}

    /**
     * Store generated content payload into existing posts table and link candidate.
     */
    public function createPost(ContentCandidate $candidate, array $payload): Post
    {
        $authorUser = $this->resolveAuthor();
        $category = $this->resolveCategory($payload['category_slug'] ?? null, $candidate->topic);
        $tagIds = $this->resolveTags($payload['tags'] ?? []);

        $autoPublish = (bool) $this->settingsService->get('automation.auto_publish', false);
        $status = $autoPublish ? PostStatus::PUBLISHED->value : PostStatus::DRAFT->value;

        $postType = ($candidate->content_type === 'news') ? PostType::NEWS->value : PostType::ARTICLE->value;

        $postData = [
            'author_id' => $authorUser->id,
            'content_category_id' => $category?->id,
            'type' => $postType,
            'title' => $payload['title'],
            'slug' => !empty($payload['slug']) ? Str::slug($payload['slug']) : Str::slug($payload['title']),
            'excerpt' => $payload['excerpt'] ?? null,
            'content' => $payload['body'],
            'status' => $status,
            'published_at' => $autoPublish ? now() : null,
            'seo_title' => $payload['seo_title'] ?? $payload['title'],
            'meta_description' => $payload['meta_description'] ?? ($payload['excerpt'] ?? null),
            'focus_keyword' => $payload['focus_keyword'] ?? null,
            'tags' => $tagIds,
        ];

        $post = $this->postService->createPost($postData, $authorUser);

        // Update candidate post_id and status
        $finalCandidateStatus = $autoPublish ? 'published' : 'generated';
        $candidate->update([
            'post_id' => $post->id,
            'status' => $finalCandidateStatus,
        ]);

        // Link private research sources to post_id for internal admin audit
        ContentResearchSource::where('content_candidate_id', $candidate->id)
            ->update(['post_id' => $post->id]);

        return $post;
    }

    /**
     * Resolve system author user (Plantaric Editorial Team).
     */
    public function resolveAuthor(): User
    {
        $configuredId = $this->settingsService->get('automation.default_author_id');
        if ($configuredId && ($user = User::find($configuredId))) {
            return $user;
        }

        $editorialUser = User::where('email', 'editorial@plantora.com')->first();
        if ($editorialUser) {
            return $editorialUser;
        }

        $editorUser = User::whereIn('role', ['admin', 'editor', 'author'])->first();
        if ($editorUser) {
            return $editorUser;
        }

        // Fallback user creation
        return User::create([
            'first_name' => 'Plantaric',
            'last_name' => 'Editorial Team',
            'email' => 'editorial@plantora.com',
            'role' => 'editor',
            'status' => 'active',
            'password' => bcrypt(Str::random(16)),
        ]);
    }

    /**
     * Resolve existing content category by slug or fallback.
     */
    protected function resolveCategory(?string $slug, ?string $topic): ?ContentCategory
    {
        if (!empty($slug)) {
            $cat = ContentCategory::where('slug', Str::slug($slug))->first();
            if ($cat) {
                return $cat;
            }
        }

        if (!empty($topic)) {
            $topicSlug = Str::slug($topic);
            $cat = ContentCategory::where('slug', $topicSlug)
                ->orWhere('name', 'like', "%{$topic}%")
                ->first();
            if ($cat) {
                return $cat;
            }
        }

        return ContentCategory::active()->first();
    }

    /**
     * Resolve or create tags.
     */
    protected function resolveTags(array $tagNames): array
    {
        $tagIds = [];
        foreach (array_slice($tagNames, 0, 5) as $name) {
            $name = trim($name);
            if (empty($name)) {
                continue;
            }
            $slug = Str::slug($name);
            $tag = Tag::firstOrCreate(
                ['slug' => $slug],
                ['name' => ucwords($name), 'status' => 'active']
            );
            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }
}
