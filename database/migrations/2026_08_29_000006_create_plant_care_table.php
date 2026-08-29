<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plant_care', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->unique()->constrained('plants')->cascadeOnDelete();
            
            $table->enum('sunlight_level', [
                'full_sun', 'partial_sun', 'bright_indirect', 'medium_indirect', 'low_light', 'shade'
            ])->default('bright_indirect');
            $table->text('sunlight_description')->nullable();

            $table->enum('watering_frequency', [
                'daily', 'every_2_3_days', 'weekly', 'every_7_10_days', 'every_2_weeks', 'every_3_weeks', 'monthly', 'when_soil_dries', 'custom'
            ])->default('weekly');
            $table->text('watering_description')->nullable();

            $table->string('soil_type')->nullable();
            $table->decimal('soil_ph_min', 3, 1)->nullable();
            $table->decimal('soil_ph_max', 3, 1)->nullable();

            $table->integer('humidity_min')->nullable();
            $table->integer('humidity_max')->nullable();

            $table->integer('temperature_min')->nullable();
            $table->integer('temperature_max')->nullable();
            $table->string('temperature_unit')->default('C');

            $table->string('fertilizer_type')->nullable();
            $table->string('fertilizer_frequency')->nullable();
            $table->text('fertilizer_description')->nullable();

            $table->text('pruning_description')->nullable();
            $table->string('repotting_frequency')->nullable();
            $table->text('repotting_description')->nullable();

            $table->json('propagation_methods')->nullable();
            $table->text('propagation_description')->nullable();
            
            $table->text('dormancy_notes')->nullable();
            $table->text('care_tips')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_care');
    }
};
