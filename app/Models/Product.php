<?php

namespace App\Models;

use App\Enums\ProductType;
use App\Enums\StockStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'plant_id',
        'product_category_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'product_type',
        'short_description',
        'description',
        'price',
        'compare_price',
        'cost_price',
        'taxable',
        'tax_class',
        'stock_status',
        'track_inventory',
        'stock_quantity',
        'low_stock_threshold',
        'allow_backorder',
        'featured_image_id',
        'status',
        'is_featured',
        'is_new',
        'is_best_seller',
        'has_variants',
        'published_at',
        'weight',
        'weight_unit',
        'length',
        'width',
        'height',
        'dimension_unit',
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
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'weight' => 'decimal:2',
            'length' => 'decimal:2',
            'width' => 'decimal:2',
            'height' => 'decimal:2',
            'taxable' => 'boolean',
            'track_inventory' => 'boolean',
            'allow_backorder' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_best_seller' => 'boolean',
            'has_variants' => 'boolean',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'published_at' => 'datetime',
            'product_type' => ProductType::class,
            'stock_status' => StockStatus::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class, 'plant_id');
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function plantProblems(): BelongsToMany
    {
        return $this->belongsToMany(PlantProblem::class, 'plant_problem_product')
                    ->withPivot('recommendation_type', 'priority', 'notes')
                    ->withTimestamps();
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_product')
                    ->withPivot('relationship_type', 'sort_order')
                    ->withTimestamps();
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id')
                    ->withPivot('sort_order')
                    ->withTimestamps();
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(ProductCollection::class, 'product_collection_product')
                    ->withPivot('sort_order')
                    ->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class)->where('status', 'approved');
    }

    public function allReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->whereIn('stock_status', [StockStatus::IN_STOCK->value, StockStatus::LOW_STOCK->value]);
    }

    public function getAverageRatingAttribute(): float
    {
        return round((float) ($this->reviews()->avg('rating') ?: 5.0), 1);
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }
}
