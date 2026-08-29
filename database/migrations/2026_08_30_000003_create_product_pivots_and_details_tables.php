<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Plant Problem ↔ Product pivot
        Schema::create('plant_problem_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_problem_id')->constrained('plant_problems')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('recommendation_type')->default('treatment');
            $table->integer('priority')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['plant_problem_id', 'product_id'], 'prob_prod_unique');
        });

        // Product Images Gallery
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();
            $table->string('alt_text')->nullable();
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        // Product Attributes
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('select');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // Attribute Values
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_attribute_id')->constrained('product_attributes')->cascadeOnDelete();
            $table->string('value');
            $table->string('slug');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Product Variants
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->string('name')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('stock_status')->default('in_stock');
            $table->decimal('weight', 8, 2)->nullable();
            $table->foreignId('image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // Variant ↔ Attribute Value pivot (Short FK index names)
        Schema::create('product_variant_attribute_value', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained('product_variants', 'id', 'p_var_attr_var_fk')->cascadeOnDelete();
            $table->foreignId('product_attribute_value_id')->constrained('product_attribute_values', 'id', 'p_var_attr_val_fk')->cascadeOnDelete();

            $table->unique(['product_variant_id', 'product_attribute_value_id'], 'variant_attr_val_unique');
        });

        // Post ↔ Product pivot
        Schema::create('post_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('relationship_type')->default('recommended');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['post_id', 'product_id'], 'post_prod_unique');
        });

        // Related Products pivot
        Schema::create('related_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('related_product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'related_product_id'], 'rel_prod_unique');
        });

        // Product Collections (Shop by Need)
        Schema::create('product_collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('status')->default('active');
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_collection_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_collection_id')->constrained('product_collections', 'id', 'p_col_prod_col_fk')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products', 'id', 'p_col_prod_prod_fk')->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['product_collection_id', 'product_id'], 'col_prod_unique');
        });

        // Product Bundle Items
        Schema::create('product_bundle_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_product_id')->constrained('products', 'id', 'p_bdl_bundle_fk')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products', 'id', 'p_bdl_prod_fk')->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained('product_variants', 'id', 'p_bdl_var_fk')->nullOnDelete();
            $table->integer('quantity')->default(1);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_bundle_items');
        Schema::dropIfExists('product_collection_product');
        Schema::dropIfExists('product_collections');
        Schema::dropIfExists('related_products');
        Schema::dropIfExists('post_product');
        Schema::dropIfExists('product_variant_attribute_value');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_attribute_values');
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('plant_problem_product');
    }
};
