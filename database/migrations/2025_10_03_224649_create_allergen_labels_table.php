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
        Schema::create('allergen_labels', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('e.g., FISH, SHELLFISH, GLUTEN');
            $table->string('name_en', 100);
            $table->string('name_nl', 100);
            $table->string('icon_class', 50)->nullable()->comment('Icon class for display');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Pivot table for menu items and allergens
        Schema::create('menu_item_allergen', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_item_id');
            $table->unsignedBigInteger('allergen_label_id');
            
            $table->primary(['menu_item_id', 'allergen_label_id']);
            $table->index('allergen_label_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_allergen');
        Schema::dropIfExists('allergen_labels');
    }
};
