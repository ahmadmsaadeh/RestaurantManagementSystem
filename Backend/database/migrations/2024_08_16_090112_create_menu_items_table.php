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
      /*  Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });*/
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id('menu_item_id');
            $table->string('name_item');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->boolean('availability')->default(true);
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
