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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->date('order_date');
            $table->time('order_time');
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id'); // Reference the correct primary key in the users table
            $table->foreignId('reservation_id')->nullable()->constrained('reservations', 'ResID')->onDelete('set null');
            $table->unsignedInteger('total');
            $table->string('status');
            $table->timestamps();
        });
        
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
