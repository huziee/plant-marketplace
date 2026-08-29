<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Post Tag pivot
        Schema::create('post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
        });

        // Plant Post pivot
        Schema::create('plant_post', function (Blueprint $table) {
            $table->foreignId('plant_id')->constrained('plants')->cascadeOnDelete();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('relationship_type')->nullable(); // related, care_guide, problem_guide, growing_guide
            $table->integer('sort_order')->default(0);
            $table->primary(['plant_id', 'post_id']);
        });

        // Plant Problem Post pivot
        Schema::create('plant_problem_post', function (Blueprint $table) {
            $table->foreignId('plant_problem_id')->constrained('plant_problems')->cascadeOnDelete();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('relationship_type')->nullable();
            $table->integer('sort_order')->default(0);
            $table->primary(['plant_problem_id', 'post_id']);
        });

        // Post Related pivot
        Schema::create('post_related', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('related_post_id')->constrained('posts')->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->primary(['post_id', 'related_post_id']);
        });

        // Post Sources for references
        Schema::create('post_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('title');
            $table->string('url');
            $table->string('publisher')->nullable();
            $table->date('published_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_sources');
        Schema::dropIfExists('post_related');
        Schema::dropIfExists('plant_problem_post');
        Schema::dropIfExists('plant_post');
        Schema::dropIfExists('post_tag');
    }
};
