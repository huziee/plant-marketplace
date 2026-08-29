<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_category_id')->nullable()->constrained('plant_categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('scientific_name')->nullable();
            $table->string('family')->nullable();
            $table->string('genus')->nullable();
            $table->string('species')->nullable();
            $table->string('local_name')->nullable();
            $table->string('urdu_name')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('plant_type')->nullable();
            $table->enum('difficulty', ['easy', 'moderate', 'advanced'])->default('easy');
            $table->enum('growth_rate', ['slow', 'medium', 'fast'])->default('medium');
            $table->string('lifespan_type')->nullable();
            $table->string('origin')->nullable();
            
            $table->decimal('mature_height_min', 8, 2)->nullable();
            $table->decimal('mature_height_max', 8, 2)->nullable();
            $table->decimal('mature_width_min', 8, 2)->nullable();
            $table->decimal('mature_width_max', 8, 2)->nullable();
            $table->string('measurement_unit')->default('cm');

            $table->boolean('indoor')->default(false);
            $table->boolean('outdoor')->default(false);
            $table->boolean('pet_safe')->default(true);
            $table->boolean('air_purifying')->default(false);
            $table->boolean('flowering')->default(false);
            $table->boolean('edible')->default(false);
            $table->boolean('medicinal')->default(false);

            $table->foreignId('featured_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();

            // SEO fields
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->foreignId('og_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->boolean('robots_index')->default(true);
            $table->boolean('robots_follow')->default(true);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
