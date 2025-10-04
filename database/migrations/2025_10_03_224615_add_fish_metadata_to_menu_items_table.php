<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->date('freshness_date')->nullable()->after('menu_status');
            $table->string('origin_region', 100)->nullable()->after('freshness_date');
            $table->json('allergens')->nullable()->after('origin_region');
            $table->decimal('storage_temp', 4, 1)->nullable()->after('allergens')->comment('Temperature in Celsius');
            $table->enum('catch_method', ['wild', 'farmed', 'organic'])->nullable()->after('storage_temp');
            $table->boolean('is_catch_of_day')->default(false)->after('catch_method');
            $table->text('preparation_notes')->nullable()->after('is_catch_of_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn([
                'freshness_date',
                'origin_region',
                'allergens',
                'storage_temp',
                'catch_method',
                'is_catch_of_day',
                'preparation_notes',
            ]);
        });
    }
};
