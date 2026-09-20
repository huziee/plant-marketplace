<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type',
        'source_type',
        'topic',
        'template_key',
        'suggested_title',
        'primary_keyword',
        'fingerprint',
        'source_data',
        'research_context',
        'status',
        'post_id',
        'scheduled_for',
        'generated_at',
        'failure_reason',
    ];

    protected $casts = [
        'source_data' => 'array',
        'research_context' => 'array',
        'scheduled_for' => 'datetime',
        'generated_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function researchSources(): HasMany
    {
        return $this->hasMany(ContentResearchSource::class, 'content_candidate_id');
    }
}
