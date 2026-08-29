<?php

namespace App\Enums;

enum ProductType: string
{
    case PLANT = 'plant';
    case SEED = 'seed';
    case FERTILIZER = 'fertilizer';
    case SOIL = 'soil';
    case POT = 'pot';
    case TOOL = 'tool';
    case TREATMENT = 'treatment';
    case ACCESSORY = 'accessory';
    case BUNDLE = 'bundle';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::PLANT => 'Plant',
            self::SEED => 'Seeds & Bulbs',
            self::FERTILIZER => 'Fertilizer & Nutrition',
            self::SOIL => 'Soil & Compost',
            self::POT => 'Pots & Planters',
            self::TOOL => 'Gardening Tool',
            self::TREATMENT => 'Plant Treatment',
            self::ACCESSORY => 'Accessory',
            self::BUNDLE => 'Plant Bundle / Kit',
            self::OTHER => 'Other',
        };
    }
}
