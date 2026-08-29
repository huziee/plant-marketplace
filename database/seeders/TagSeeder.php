<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'monstera',
            'snake-plant',
            'repotting',
            'pest-control',
            'watering',
            'propagation',
            'fertilizers',
            'indoor-plants',
            'succulents',
            'balcony-gardening',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => $tag],
                [
                    'name' => Str::headline($tag),
                    'status' => 'active',
                ]
            );
        }
    }
}
