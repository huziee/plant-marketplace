<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id',
        'content_category_id',
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_id',
        'status',
        'is_featured',
        'is_editor_pick',
        'allow_comments',
        'published_at',
        'scheduled_at',
        'content_updated_at',
        'reading_time',
        'views',
        'seo_title',
        'meta_description',
        'canonical_url',
        'focus_keyword',
        'og_title',
        'og_description',
        'og_image_id',
        'robots_index',
        'robots_follow',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'type' => PostType::class,
            'status' => PostStatus::class,
            'is_featured' => 'boolean',
            'is_editor_pick' => 'boolean',
            'allow_comments' => 'boolean',
            'published_at' => 'datetime',
            'scheduled_at' => 'datetime',
            'content_updated_at' => 'datetime',
            'reading_time' => 'integer',
            'views' => 'integer',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->reading_time) && !empty($post->content)) {
                $post->reading_time = static::computeReadingTime($post->content);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('content')) {
                $post->reading_time = static::computeReadingTime($post->content);
                $post->content_updated_at = now();
            }
        });
    }

    public static function computeReadingTime(string $content): int
    {
        $text = strip_tags($content);
        $wordCount = str_word_count($text);
        return (int) max(1, ceil($wordCount / 225));
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ContentCategory::class, 'content_category_id');
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function ogImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'og_image_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function plants(): BelongsToMany
    {
        return $this->belongsToMany(Plant::class, 'plant_post')
                    ->withPivot('relationship_type', 'sort_order')
                    ->orderBy('plant_post.sort_order');
    }

    public function problems(): BelongsToMany
    {
        return $this->belongsToMany(PlantProblem::class, 'plant_problem_post')
                    ->withPivot('relationship_type', 'sort_order')
                    ->orderBy('plant_problem_post.sort_order');
    }

    public function relatedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_related', 'post_id', 'related_post_id')
                    ->withPivot('sort_order')
                    ->orderBy('post_related.sort_order');
    }

    public function sources(): HasMany
    {
        return $this->hasMany(PostSource::class)->orderBy('sort_order');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::PUBLISHED->value)
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    public function scopeOfType($query, string|PostType $type)
    {
        $val = $type instanceof PostType ? $type->value : $type;
        return $query->where('type', $val);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeEditorPick($query)
    {
        return $query->where('is_editor_pick', true);
    }

    /**
     * Get public canonical URL for post type.
     */
    public function getPublicUrlAttribute(): string
    {
        $prefix = $this->type instanceof PostType ? $this->type->routePrefix() : PostType::from($this->type)->routePrefix();
        return url("/{$prefix}/{$this->slug}");
    }

    /**
     * Internal SEO Checklist score calculator (0-100).
     */
    public function getSeoScoreAttribute(): array
    {
        $checks = [
            'Title exists' => !empty($this->title),
            'SEO title exists' => !empty($this->seo_title),
            'Meta description exists' => !empty($this->meta_description),
            'Slug is valid' => !empty($this->slug),
            'Featured image exists' => !empty($this->featured_image_id),
            'Excerpt exists' => !empty($this->excerpt),
            'Content length adequate' => strlen(strip_tags($this->content)) >= 300,
            'Internal plant linked' => $this->plants()->count() > 0,
            'Focus keyword defined' => !empty($this->focus_keyword),
            'Robots indexable' => $this->robots_index === true,
        ];

        $passed = count(array_filter($checks));
        $total = count($checks);
        $score = (int) round(($passed / $total) * 100);

        return [
            'score' => $score,
            'checks' => $checks,
        ];
    }
}
