<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plant_problem_symptoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_problem_id')->constrained('plant_problems')->cascadeOnDelete();
            $table->string('symptom');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('plant_problem_causes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_problem_id')->constrained('plant_problems')->cascadeOnDelete();
            $table->string('cause');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('plant_problem_treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_problem_id')->constrained('plant_problems')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('instruction');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('plant_problem_preventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_problem_id')->constrained('plant_problems')->cascadeOnDelete();
            $table->text('instruction');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_problem_preventions');
        Schema::dropIfExists('plant_problem_treatments');
        Schema::dropIfExists('plant_problem_causes');
        Schema::dropIfExists('plant_problem_symptoms');
    }
};
