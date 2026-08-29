<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantCare extends Model
{
    use HasFactory;

    protected $table = 'plant_care';

    protected $fillable = [
        'plant_id',
        'sunlight_level',
        'sunlight_description',
        'watering_frequency',
        'watering_description',
        'soil_type',
        'soil_ph_min',
        'soil_ph_max',
        'humidity_min',
        'humidity_max',
        'temperature_min',
        'temperature_max',
        'temperature_unit',
        'fertilizer_type',
        'fertilizer_frequency',
        'fertilizer_description',
        'pruning_description',
        'repotting_frequency',
        'repotting_description',
        'propagation_methods',
        'propagation_description',
        'dormancy_notes',
        'care_tips',
    ];

    protected function casts(): array
    {
        return [
            'propagation_methods' => 'array',
        ];
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public static function sunlightLabels(): array
    {
        return [
            'full_sun' => 'Full Sun',
            'partial_sun' => 'Partial Sun / Partial Shade',
            'bright_indirect' => 'Bright Indirect Light',
            'medium_indirect' => 'Medium Indirect Light',
            'low_light' => 'Low Light Tolerant',
            'shade' => 'Shade',
        ];
    }

    public static function wateringLabels(): array
    {
        return [
            'daily' => 'Daily',
            'every_2_3_days' => 'Every 2-3 Days',
            'weekly' => 'Weekly',
            'every_7_10_days' => 'Every 7-10 Days',
            'every_2_weeks' => 'Every 2 Weeks',
            'every_3_weeks' => 'Every 3 Weeks',
            'monthly' => 'Monthly',
            'when_soil_dries' => 'When Soil Dries Completely',
            'custom' => 'Custom Care',
        ];
    }

    public function getSunlightLabelAttribute(): string
    {
        return self::sunlightLabels()[$this->sunlight_level] ?? $this->sunlight_level;
    }

    public function getWateringLabelAttribute(): string
    {
        return self::wateringLabels()[$this->watering_frequency] ?? $this->watering_frequency;
    }
}
