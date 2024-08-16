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
            $table->integer('ResID')->primary()->autoIncrement();
            $table->integer('UserID');
            $table->date('Date');
            $table->time('Time');
            $table->integer('NumOfCustomers');
            $table->string('ReservationType');
            $table->integer('TableID');
            $table->time('TimeExpectedToLeave');

//            $table->foreign('UserID')->references('id')->on('users');
//            $table->foreign('TableID')->references('id')->on('tables');
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
