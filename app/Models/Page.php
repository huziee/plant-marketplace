<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image_id',
        'robots_index',
        'robots_follow',
        'status',
        'show_in_footer',
        'is_system',
    ];

    protected $casts = [
        'show_in_footer' => 'boolean',
        'is_system' => 'boolean',
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
    ];

    public function ogImage()
    {
        return $this->belongsTo(Media::class, 'og_image_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeInFooter($query)
    {
        return $query->where('show_in_footer', true);
    }
}
