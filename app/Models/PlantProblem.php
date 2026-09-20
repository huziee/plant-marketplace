<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantProblem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'problem_type',
        'short_description',
        'description',
        'severity',
        'featured_image_id',
        'status',
        'is_featured',
        'seo_title',
        'meta_description',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image_id',
        'robots_index',
        'robots_follow',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
        ];
    }

    public function symptoms(): HasMany
    {
        return $this->hasMany(PlantProblemSymptom::class)->orderBy('sort_order');
    }

    public function causes(): HasMany
    {
        return $this->hasMany(PlantProblemCause::class)->orderBy('sort_order');
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(PlantProblemTreatment::class)->orderBy('sort_order');
    }

    public function preventions(): HasMany
    {
        return $this->hasMany(PlantProblemPrevention::class)->orderBy('sort_order');
    }

    public function plants(): BelongsToMany
    {
        return $this->belongsToMany(Plant::class, 'plant_problem')
                    ->withPivot('frequency', 'notes')
                    ->withTimestamps();
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'plant_problem_post')
                    ->withPivot('relationship_type', 'sort_order')
                    ->orderBy('plant_problem_post.sort_order');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'plant_problem_product')
                    ->withPivot('recommendation_type', 'priority', 'notes')
                    ->withTimestamps();
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
