<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentResearchSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_candidate_id',
        'post_id',
        'provider',
        'source_type',
        'source_title',
        'source_url',
        'source_domain',
        'external_id',
        'doi',
        'published_at',
        'metadata',
        'is_public',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'metadata' => 'array',
        'is_public' => 'boolean',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(ContentCandidate::class, 'content_candidate_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
