<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_feed_logs', function (Blueprint $table) {
            $table->id();
            $table->string('channel');
            $table->string('trigger_type');
            $table->string('status')->default('success');
            $table->integer('items_count')->default(0);
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_feed_logs');
    }
};
