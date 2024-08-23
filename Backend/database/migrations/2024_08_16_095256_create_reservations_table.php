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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('ResID'); // Primary key, auto-incremented
            $table->unsignedBigInteger('UserID'); // Foreign key to users
            $table->unsignedBigInteger('TableID'); // Foreign key to tables
            $table->date('Date');
            $table->time('Time');
            $table->integer('NumOfCustomers');
            $table->string('ReservationType');
            $table->time('TimeExpectedToLeave');

            // Define foreign key constraints
            $table->foreign('UserID')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('TableID')->references('TableID')->on('tables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
