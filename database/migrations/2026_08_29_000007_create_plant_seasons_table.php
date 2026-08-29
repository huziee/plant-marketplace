<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plant_seasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained('plants')->cascadeOnDelete();
            $table->enum('season_type', ['growing', 'flowering', 'fruiting', 'sowing', 'harvesting', 'dormancy']);
            $table->integer('start_month')->nullable(); // 1 to 12
            $table->integer('end_month')->nullable();   // 1 to 12
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_seasons');
    }
};
