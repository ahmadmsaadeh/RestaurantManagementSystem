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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id');
            $table->foreignId('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreignId('menu_item_id')->references('menu_item_id')->on('menu_items')->onDelete('cascade');
            $table->unsignedInteger('quantity');
            $table->decimal('subtotal', 10, 2)->nullable(); // Subtotal with precision: 10 digits, 2 after the decimal point
            $table->enum('item_status', ['Pending', 'In-progress', 'Completed', 'Served'])->default('Pending');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
