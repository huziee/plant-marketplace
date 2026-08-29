<?php

namespace Database\Seeders;

use App\Models\PlantProblem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlantProblemSeeder extends Seeder
{
    public function run(): void
    {
        $problems = [
            [
                'name' => 'Yellow Leaves',
                'problem_type' => 'watering',
                'severity' => 'medium',
                'is_featured' => true,
                'short_description' => 'Yellowing foliage is most commonly caused by improper watering, poor drainage, or nitrogen deficiency.',
                'description' => 'When plant leaves lose their rich chlorophyll pigment and turn pale yellow, it signals root stress or nutrient imbalance. Overwatering is the #1 cause.',
                'symptoms' => ['Lower leaves turn soft pale yellow', 'Soil feels constantly soggy', 'Stunted leaf growth'],
                'causes' => ['Overwatering and poor drainage', 'Lack of nitrogen in soil', 'Root restriction in pot'],
                'treatments' => [
                    'Allow top 3-4 cm of soil to dry out completely before watering again.',
                    'Trim severely yellowed or decaying leaves with sanitized shears.',
                    'Repot into fresh pot with drainage holes and potting mix.',
                ],
                'preventions' => ['Check soil moisture with a finger test before every watering cycle.'],
            ],
            [
                'name' => 'Brown Leaf Tips',
                'problem_type' => 'environment',
                'severity' => 'low',
                'is_featured' => true,
                'short_description' => 'Crispy brown tips are triggered by dry indoor air, low humidity, or mineral build-up from tap water.',
                'description' => 'Browning leaf margins indicate moisture loss from leaf tips faster than roots can absorb water.',
                'symptoms' => ['Dry crispy brown tips on leaves', 'Curled leaf margins'],
                'causes' => ['Low indoor air humidity (<40%)', 'High fluoride/salts in tap water', 'Underwatering'],
                'treatments' => [
                    'Use filtered or rainwater instead of chlorinated tap water.',
                    'Mist foliage or use a humidity tray near the plant.',
                    'Trim brown edges carefully without cutting into healthy green tissue.',
                ],
                'preventions' => ['Maintain indoor humidity around 50-60%.'],
            ],
            [
                'name' => 'Root Rot',
                'problem_type' => 'disease',
                'severity' => 'high',
                'is_featured' => true,
                'short_description' => 'Fungal pathogen infection caused by waterlogged soil that destroys the root system.',
                'description' => 'Root rot rapidly suffocates roots, preventing water and nutrient absorption.',
                'symptoms' => ['Black, mushy, foul-smelling roots', 'Widespread wilting despite wet soil', 'Yellowing leaves'],
                'causes' => ['Overwatering', 'No drainage holes in planter', 'Heavy compacted soil'],
                'treatments' => [
                    'Unpot plant and wash roots under lukewarm water.',
                    'Prune away all black, mushy root sections with sterile shears.',
                    'Repot in sterile potting mix and refrain from watering for 3 days.',
                ],
                'preventions' => ['Always use well-draining soil mixed with perlite or coarse sand.'],
            ],
            [
                'name' => 'Spider Mites',
                'problem_type' => 'pest',
                'severity' => 'medium',
                'is_featured' => true,
                'short_description' => 'Tiny sap-sucking arachnids that form delicate webbing under leaves.',
                'description' => 'Spider mites thrive in hot, dry conditions and puncture plant cells to suck out juices.',
                'symptoms' => ['Fine silky webbing between stems and leaves', 'Yellow speckling on leaf surfaces', 'Dull fading leaves'],
                'causes' => ['Hot, dry indoor air', 'Dusty leaf surfaces'],
                'treatments' => [
                    'Wipe down all leaves with mild insecticidal soap solution.',
                    'Spray neem oil spray evenly under and over leaf surfaces once a week.',
                ],
                'preventions' => ['Increase room humidity and dust leaves regularly.'],
            ],
            [
                'name' => 'Aphids',
                'problem_type' => 'pest',
                'severity' => 'medium',
                'is_featured' => true,
                'short_description' => 'Small green, black, or white sap-sucking insects that cluster on new growth.',
                'description' => 'Aphids multiply rapidly on succulent stems and secrete sticky honeydew that attracts ants.',
                'symptoms' => ['Clusters of small insects on soft stems', 'Sticky residue on foliage', 'Distorted new growth'],
                'causes' => ['High nitrogen fertilizer use', 'Warm spring weather'],
                'treatments' => [
                    'Rinse foliage with a strong jet of water to dislodge pests.',
                    'Apply organic neem oil or insecticidal soap solution twice weekly.',
                ],
                'preventions' => ['Introduce beneficial insects like ladybugs outdoors.'],
            ],
        ];

        foreach ($problems as $p) {
            $problem = PlantProblem::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'name' => $p['name'],
                    'problem_type' => $p['problem_type'],
                    'severity' => $p['severity'],
                    'is_featured' => $p['is_featured'],
                    'short_description' => $p['short_description'],
                    'description' => $p['description'],
                    'status' => 'active',
                ]
            );

            // Sync Symptoms
            $problem->symptoms()->delete();
            foreach ($p['symptoms'] as $idx => $sym) {
                $problem->symptoms()->create(['symptom' => $sym, 'sort_order' => $idx]);
            }

            // Sync Causes
            $problem->causes()->delete();
            foreach ($p['causes'] as $idx => $cause) {
                $problem->causes()->create(['cause' => $cause, 'sort_order' => $idx]);
            }

            // Sync Treatments
            $problem->treatments()->delete();
            foreach ($p['treatments'] as $idx => $inst) {
                $problem->treatments()->create(['instruction' => $inst, 'sort_order' => $idx]);
            }

            // Sync Preventions
            $problem->preventions()->delete();
            foreach ($p['preventions'] as $idx => $prev) {
                $problem->preventions()->create(['instruction' => $prev, 'sort_order' => $idx]);
            }
        }
    }
}
