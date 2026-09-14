<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('gtin')->nullable()->after('barcode');
            $table->string('mpn')->nullable()->after('gtin');
            $table->string('brand_name')->nullable()->after('mpn');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['gtin', 'mpn', 'brand_name']);
        });
    }
};
