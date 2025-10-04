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
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_item_id');
            $table->integer('change')->comment('Positive for additions, negative for deductions');
            $table->enum('reason', ['order', 'manual', 'spoilage', 'restocking', 'adjustment'])->default('manual');
            $table->string('reference')->nullable()->comment('Order ID or admin note');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('menu_item_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ledgers');
    }
};
