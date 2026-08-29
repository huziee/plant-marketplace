<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\PlantProblem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlantSeeder extends Seeder
{
    public function run(): void
    {
        $indoorCat = PlantCategory::where('slug', 'indoor-plants')->first();
        $outdoorCat = PlantCategory::where('slug', 'outdoor-plants')->first();
        $floweringCat = PlantCategory::where('slug', 'flowering-plants')->first();
        $succulentCat = PlantCategory::where('slug', 'succulents-cacti')->first();
        $herbCat = PlantCategory::where('slug', 'herbs')->first();
        $vegCat = PlantCategory::where('slug', 'vegetables')->first();

        $yellowLeavesProb = PlantProblem::where('slug', 'yellow-leaves')->first();
        $rootRotProb = PlantProblem::where('slug', 'root-rot')->first();
        $spiderMitesProb = PlantProblem::where('slug', 'spider-mites')->first();

        $plants = [
            [
                'name' => 'Monstera Deliciosa',
                'scientific_name' => 'Monstera deliciosa',
                'plant_category_id' => $indoorCat?->id,
                'difficulty' => 'easy',
                'growth_rate' => 'fast',
                'indoor' => true,
                'outdoor' => false,
                'pet_safe' => false,
                'air_purifying' => true,
                'is_featured' => true,
                'short_description' => 'Famous for its dramatic split tropical leaves. An iconic indoor statement plant.',
                'description' => 'Monstera Deliciosa, commonly known as the Swiss Cheese Plant, is native to tropical forests of southern Mexico. It is admired for its heart-shaped glossy green leaves that develop natural perforations.',
                'common_names' => ['Swiss Cheese Plant', 'Split-Leaf Philodendron'],
                'care' => [
                    'sunlight_level' => 'bright_indirect',
                    'sunlight_description' => 'Thrives in bright indirect sunlight. Avoid harsh direct sun which scorches leaves.',
                    'watering_frequency' => 'weekly',
                    'watering_description' => 'Water when top 3cm of soil is dry. Reduce watering in winter.',
                    'soil_type' => 'Peat-based potting mix with perlite and orchid bark.',
                    'temperature_min' => 18,
                    'temperature_max' => 30,
                    'humidity_min' => 50,
                    'humidity_max' => 80,
                    'care_tips' => 'Wipe leaves periodically with a moist cloth to keep pores clean and shiny.',
                ],
            ],
            [
                'name' => 'Snake Plant',
                'scientific_name' => 'Dracaena trifasciata',
                'plant_category_id' => $indoorCat?->id,
                'difficulty' => 'easy',
                'growth_rate' => 'slow',
                'indoor' => true,
                'outdoor' => true,
                'pet_safe' => false,
                'air_purifying' => true,
                'is_featured' => true,
                'short_description' => 'Extremely resilient architectural plant that excels in low-light indoor spaces.',
                'description' => 'Snake Plant (Sansevieria) is an indestructible succulent with upright sword-like leaves boasting yellow and green bands.',
                'common_names' => ['Sansevieria', 'Mother-in-Law\'s Tongue'],
                'care' => [
                    'sunlight_level' => 'low_light',
                    'sunlight_description' => 'Tolerates low light environments as well as bright indirect sun.',
                    'watering_frequency' => 'every_2_weeks',
                    'watering_description' => 'Allow soil to dry completely between waterings. Highly susceptible to overwatering.',
                    'soil_type' => 'Cactus and succulent coarse sandy mix.',
                    'temperature_min' => 12,
                    'temperature_max' => 32,
                    'humidity_min' => 30,
                    'humidity_max' => 60,
                    'care_tips' => 'Do not leave standing water inside the leaf rosette.',
                ],
            ],
            [
                'name' => 'Peace Lily',
                'scientific_name' => 'Spathiphyllum wallisii',
                'plant_category_id' => $floweringCat?->id ?: $indoorCat?->id,
                'difficulty' => 'easy',
                'growth_rate' => 'medium',
                'indoor' => true,
                'outdoor' => false,
                'pet_safe' => false,
                'air_purifying' => true,
                'is_featured' => true,
                'short_description' => 'Lush tropical plant producing elegant white flowers and deep green foliage.',
                'description' => 'Peace Lily is renowned for its air-purifying qualities and graceful white spathes that bloom continuously in bright rooms.',
                'common_names' => ['Spathiphyllum', 'White Sails'],
                'care' => [
                    'sunlight_level' => 'medium_indirect',
                    'sunlight_description' => 'Prefers medium to bright indirect light.',
                    'watering_frequency' => 'weekly',
                    'watering_description' => 'Keep soil consistently moist but never waterlogged. Plant will droop visibly when thirsty.',
                    'soil_type' => 'Rich organic potting soil with perlite.',
                    'temperature_min' => 16,
                    'temperature_max' => 28,
                    'humidity_min' => 50,
                    'humidity_max' => 80,
                    'care_tips' => 'Remove spent flowers at the base to encourage new blooms.',
                ],
            ],
            [
                'name' => 'Aloe Vera',
                'scientific_name' => 'Aloe barbadensis Miller',
                'plant_category_id' => $succulentCat?->id,
                'difficulty' => 'easy',
                'growth_rate' => 'slow',
                'indoor' => true,
                'outdoor' => true,
                'pet_safe' => false,
                'air_purifying' => true,
                'medicinal' => true,
                'is_featured' => true,
                'short_description' => 'Medicinal succulent with soothing gel leaves for skin burns.',
                'description' => 'Aloe Vera is a popular drought-tolerant succulent with thick fleshy leaves containing cooling gel.',
                'common_names' => ['First Aid Plant', 'True Aloe'],
                'care' => [
                    'sunlight_level' => 'full_sun',
                    'sunlight_description' => 'Requires 6+ hours of bright direct or indirect sunlight daily.',
                    'watering_frequency' => 'every_3_weeks',
                    'watering_description' => 'Drench soil thoroughly then allow it to dry out 100%.',
                    'soil_type' => 'Fast-draining cactus soil.',
                    'temperature_min' => 15,
                    'temperature_max' => 35,
                    'humidity_min' => 20,
                    'humidity_max' => 50,
                    'care_tips' => 'Use terracotta pots with drainage holes to allow rapid soil drying.',
                ],
            ],
            [
                'name' => 'Garden Rose',
                'scientific_name' => 'Rosa rubiginosa',
                'plant_category_id' => $floweringCat?->id ?: $outdoorCat?->id,
                'difficulty' => 'moderate',
                'growth_rate' => 'medium',
                'indoor' => false,
                'outdoor' => true,
                'pet_safe' => true,
                'flowering' => true,
                'is_featured' => true,
                'short_description' => 'Classic outdoor garden shrub bearing fragrant multi-petaled blossoms.',
                'description' => 'Garden Roses bring timeless beauty and perfume to gardens across Pakistan.',
                'common_names' => ['Gulab', 'Rose Shrub'],
                'care' => [
                    'sunlight_level' => 'full_sun',
                    'sunlight_description' => 'Requires full direct sunlight for at least 6 hours per day to bloom heavily.',
                    'watering_frequency' => 'every_2_3_days',
                    'watering_description' => 'Water deeply at the base of roots. Avoid wetting leaves to prevent fungal mildew.',
                    'soil_type' => 'Loamy rich soil with organic compost.',
                    'temperature_min' => 10,
                    'temperature_max' => 38,
                    'humidity_min' => 40,
                    'humidity_max' => 70,
                    'care_tips' => 'Prune dead stems in early spring to encourage vigorous flowering branches.',
                ],
            ],
            [
                'name' => 'Money Plant',
                'scientific_name' => 'Epipremnum aureum',
                'plant_category_id' => $indoorCat?->id,
                'difficulty' => 'easy',
                'growth_rate' => 'fast',
                'indoor' => true,
                'outdoor' => false,
                'pet_safe' => false,
                'air_purifying' => true,
                'is_featured' => true,
                'short_description' => 'Fast-growing trailing vine with heart-shaped variegated green & gold leaves.',
                'description' => 'Money Plant (Golden Pothos) is one of the easiest indoor trailing plants to propagate and maintain.',
                'common_names' => ['Golden Pothos', 'Devil\'s Ivy'],
                'care' => [
                    'sunlight_level' => 'bright_indirect',
                    'sunlight_description' => 'Adapts to low light, but variegated patterns become brightest in bright indirect light.',
                    'watering_frequency' => 'weekly',
                    'watering_description' => 'Water when soil feels dry to touch.',
                    'soil_type' => 'Standard houseplant potting mix.',
                    'temperature_min' => 15,
                    'temperature_max' => 30,
                    'humidity_min' => 40,
                    'humidity_max' => 80,
                    'care_tips' => 'Can grow easily in water vases or soil pots.',
                ],
            ],
            [
                'name' => 'Spider Plant',
                'scientific_name' => 'Chlorophytum comosum',
                'plant_category_id' => $indoorCat?->id,
                'difficulty' => 'easy',
                'growth_rate' => 'medium',
                'indoor' => true,
                'outdoor' => false,
                'pet_safe' => true,
                'air_purifying' => true,
                'is_featured' => true,
                'short_description' => 'Pet-friendly arching plant that produces baby spiderettes.',
                'description' => 'Spider Plant is famous for its narrow ribbon-like leaves and hanging baby plantlets.',
                'common_names' => ['Ribbon Plant', 'Spider Ivy'],
                'care' => [
                    'sunlight_level' => 'bright_indirect',
                    'sunlight_description' => 'Prefers bright indirect sunshine.',
                    'watering_frequency' => 'weekly',
                    'watering_description' => 'Water moderately during spring and summer.',
                    'soil_type' => 'Well-draining potting soil.',
                    'temperature_min' => 13,
                    'temperature_max' => 28,
                    'humidity_min' => 40,
                    'humidity_max' => 70,
                    'care_tips' => 'Snip off plantlets and root them in water to share with friends.',
                ],
            ],
            [
                'name' => 'Fiddle Leaf Fig',
                'scientific_name' => 'Ficus lyrata',
                'plant_category_id' => $indoorCat?->id,
                'difficulty' => 'moderate',
                'growth_rate' => 'medium',
                'indoor' => true,
                'outdoor' => false,
                'pet_safe' => false,
                'air_purifying' => true,
                'is_featured' => true,
                'short_description' => 'Architectural indoor tree with massive violin-shaped leaves.',
                'description' => 'Fiddle Leaf Fig is a striking indoor tree with glossy, leathery violin-shaped foliage.',
                'common_names' => ['Ficus Lyrata', 'Banjo Fig'],
                'care' => [
                    'sunlight_level' => 'bright_indirect',
                    'sunlight_description' => 'Needs bright indirect light near a sunny window.',
                    'watering_frequency' => 'every_7_10_days',
                    'watering_description' => 'Water when top 5cm of soil dries out.',
                    'soil_type' => 'Peat mix with perlite.',
                    'temperature_min' => 18,
                    'temperature_max' => 28,
                    'humidity_min' => 50,
                    'humidity_max' => 75,
                    'care_tips' => 'Avoid moving the plant around once it finds a cozy spot.',
                ],
            ],
            [
                'name' => 'Sweet Basil',
                'scientific_name' => 'Ocimum basilicum',
                'plant_category_id' => $herbCat?->id,
                'difficulty' => 'easy',
                'growth_rate' => 'fast',
                'indoor' => true,
                'outdoor' => true,
                'pet_safe' => true,
                'edible' => true,
                'is_featured' => true,
                'short_description' => 'Fragrant culinary herb essential for pesto, pasta, and fresh salads.',
                'description' => 'Sweet Basil is a tender annual herb with bright green aromatic leaves.',
                'common_names' => ['Niazbo', 'Genovese Basil'],
                'care' => [
                    'sunlight_level' => 'full_sun',
                    'sunlight_description' => 'Needs 6 to 8 hours of sun daily.',
                    'watering_frequency' => 'every_2_3_days',
                    'watering_description' => 'Keep soil consistently moist.',
                    'soil_type' => 'Rich fertile potting soil.',
                    'temperature_min' => 15,
                    'temperature_max' => 32,
                    'humidity_min' => 40,
                    'humidity_max' => 70,
                    'care_tips' => 'Pinch flower buds to encourage bushier leaf growth.',
                ],
            ],
            [
                'name' => 'Cherry Tomato',
                'scientific_name' => 'Solanum lycopersicum var. cerasiforme',
                'plant_category_id' => $vegCat?->id,
                'difficulty' => 'moderate',
                'growth_rate' => 'fast',
                'indoor' => false,
                'outdoor' => true,
                'pet_safe' => false,
                'edible' => true,
                'is_featured' => true,
                'short_description' => 'High-yielding garden vegetable producing sweet bite-sized tomatoes.',
                'description' => 'Cherry Tomatoes are easy-to-grow garden vegetables suitable for pots or garden beds.',
                'common_names' => ['Tamatar', 'Bite Tomatoes'],
                'care' => [
                    'sunlight_level' => 'full_sun',
                    'sunlight_description' => 'Requires full direct sun all day.',
                    'watering_frequency' => 'daily',
                    'watering_description' => 'Water deeply every day in summer heat.',
                    'soil_type' => 'Rich compost-heavy soil.',
                    'temperature_min' => 18,
                    'temperature_max' => 35,
                    'humidity_min' => 40,
                    'humidity_max' => 70,
                    'care_tips' => 'Support heavy fruiting branches with bamboo stakes or cages.',
                ],
            ],
        ];

        foreach ($plants as $pData) {
            $careData = $pData['care'];
            $commonNames = $pData['common_names'];
            unset($pData['care'], $pData['common_names']);

            $pData['slug'] = Str::slug($pData['name']);
            $pData['status'] = 'published';
            $pData['published_at'] = now();

            $plant = Plant::updateOrCreate(['slug' => $pData['slug']], $pData);

            // Create Care
            $plant->care()->updateOrCreate(['plant_id' => $plant->id], $careData);

            // Create Common Names
            $plant->commonNames()->delete();
            foreach ($commonNames as $cn) {
                $plant->commonNames()->create(['name' => $cn]);
            }

            // Link Problems
            if ($yellowLeavesProb) {
                $plant->problems()->syncWithoutDetaching([
                    $yellowLeavesProb->id => ['frequency' => 'common', 'notes' => "Commonly caused by overwatering or drainage stress in {$plant->name}."],
                ]);
            }
            if ($rootRotProb) {
                $plant->problems()->syncWithoutDetaching([
                    $rootRotProb->id => ['frequency' => 'occasional', 'notes' => "Avoid leaving standing water in {$plant->name} planter."],
                ]);
            }
        }
    }
}
