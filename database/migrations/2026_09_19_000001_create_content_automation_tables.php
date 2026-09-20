<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('content_candidates')) {
            Schema::create('content_candidates', function (Blueprint $table) {
                $table->id();
                $table->string('content_type')->default('article'); // article, news
                $table->string('source_type')->default('mixed'); // gdelt, openalex, internal_database, mixed
                $table->string('topic')->nullable();
                $table->string('template_key')->nullable();
                $table->string('suggested_title')->nullable();
                $table->string('primary_keyword')->nullable();
                $table->string('fingerprint')->unique();
                $table->json('source_data')->nullable();
                $table->json('research_context')->nullable();
                $table->string('status')->default('discovered'); // discovered, selected, researching, ready, generating, generated, rejected, failed, published
                $table->foreignId('post_id')->nullable()->constrained('posts')->nullOnDelete();
                $table->timestamp('scheduled_for')->nullable();
                $table->timestamp('generated_at')->nullable();
                $table->text('failure_reason')->nullable();
                $table->timestamps();

                $table->index(['content_type', 'status']);
                $table->index('scheduled_for');
            });
        }

        if (!Schema::hasTable('content_research_sources')) {
            Schema::create('content_research_sources', function (Blueprint $table) {
                $table->id();
                $table->foreignId('content_candidate_id')->nullable()->constrained('content_candidates')->cascadeOnDelete();
                $table->foreignId('post_id')->nullable()->constrained('posts')->nullOnDelete();
                $table->string('provider'); // gdelt, openalex, internal
                $table->string('source_type')->nullable();
                $table->text('source_title');
                $table->text('source_url');
                $table->string('source_domain')->nullable();
                $table->string('external_id')->nullable();
                $table->string('doi')->nullable();
                $table->timestamp('published_at')->nullable();
                $table->json('metadata')->nullable();
                $table->boolean('is_public')->default(false);
                $table->timestamps();

                $table->index(['provider', 'external_id']);
            });
        }

        if (!Schema::hasTable('content_topics')) {
            Schema::create('content_topics', function (Blueprint $table) {
                $table->id();
                $table->string('content_type')->default('article'); // article, news
                $table->string('topic');
                $table->string('search_query');
                $table->string('primary_keyword')->nullable();
                $table->integer('priority')->default(0);
                $table->boolean('active')->default(true);
                $table->timestamp('last_used_at')->nullable();
                $table->timestamps();

                $table->index(['content_type', 'active', 'priority']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('content_research_sources');
        Schema::dropIfExists('content_candidates');
        Schema::dropIfExists('content_topics');
    }
};
