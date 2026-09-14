<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('canonical_url')->nullable()->after('meta_description');
            $table->string('og_title')->nullable()->after('canonical_url');
            $table->text('og_description')->nullable()->after('og_title');
            $table->foreignId('og_image_id')->nullable()->constrained('media')->nullOnDelete()->after('og_description');
            $table->boolean('robots_index')->default(true)->after('og_image_id');
            $table->boolean('robots_follow')->default(true)->after('robots_index');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['og_image_id']);
            $table->dropColumn([
                'canonical_url',
                'og_title',
                'og_description',
                'og_image_id',
                'robots_index',
                'robots_follow',
            ]);
        });
    }
};
