<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantSeason extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_id',
        'season_type',
        'start_month',
        'end_month',
        'notes',
    ];

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
