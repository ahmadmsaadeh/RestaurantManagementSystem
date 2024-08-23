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
        Schema::create('chefs_image', function (Blueprint $table) {
            $table->id('chef_image_id');
            $table->string('chef_image_url');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chefs_image');

        Schema::table('chefs_image', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
