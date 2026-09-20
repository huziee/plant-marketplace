<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type',
        'topic',
        'search_query',
        'primary_keyword',
        'priority',
        'active',
        'last_used_at',
    ];

    protected $casts = [
        'active' => 'boolean',
        'priority' => 'integer',
        'last_used_at' => 'datetime',
    ];
}
