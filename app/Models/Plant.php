<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'plant_category_id',
        'name',
        'slug',
        'scientific_name',
        'family',
        'genus',
        'species',
        'local_name',
        'urdu_name',
        'short_description',
        'description',
        'plant_type',
        'difficulty',
        'growth_rate',
        'lifespan_type',
        'origin',
        'mature_height_min',
        'mature_height_max',
        'mature_width_min',
        'mature_width_max',
        'measurement_unit',
        'indoor',
        'outdoor',
        'pet_safe',
        'air_purifying',
        'flowering',
        'edible',
        'medicinal',
        'featured_image_id',
        'status',
        'is_featured',
        'published_at',
        'seo_title',
        'meta_description',
        'canonical_url',
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
            'indoor' => 'boolean',
            'outdoor' => 'boolean',
            'pet_safe' => 'boolean',
            'air_purifying' => 'boolean',
            'flowering' => 'boolean',
            'edible' => 'boolean',
            'medicinal' => 'boolean',
            'is_featured' => 'boolean',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PlantCategory::class, 'plant_category_id');
    }

    public function care(): HasOne
    {
        return $this->hasOne(PlantCare::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PlantImage::class)->orderBy('sort_order');
    }

    public function commonNames(): HasMany
    {
        return $this->hasMany(PlantCommonName::class);
    }

    public function seasons(): HasMany
    {
        return $this->hasMany(PlantSeason::class);
    }

    public function problems(): BelongsToMany
    {
        return $this->belongsToMany(PlantProblem::class, 'plant_problem')
                    ->withPivot('frequency', 'notes')
                    ->withTimestamps();
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'plant_post')
                    ->withPivot('relationship_type', 'sort_order')
                    ->orderBy('plant_post.sort_order');
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeIndoor($query)
    {
        return $query->where('indoor', true);
    }

    public function scopeOutdoor($query)
    {
        return $query->where('outdoor', true);
    }
}
