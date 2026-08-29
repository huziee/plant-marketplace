<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlantCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'short_description',
        'image_id',
        'icon',
        'sort_order',
        'is_featured',
        'status',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PlantCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(PlantCategory::class, 'parent_id')->orderBy('sort_order');
    }

    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class, 'plant_category_id');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_id');
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
