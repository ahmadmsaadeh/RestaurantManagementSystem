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
        Schema::create('Reservations', function (Blueprint $table) {
            $table->integer('ResID')->primary();
            $table->integer('UserID');
            $table->date('Date');
            $table->time('Time');
            $table->integer('NumOfCustomers');
            $table->string('ReservationType');
            $table->integer('TableID');
            $table->time('TimeExpectedToLeave');
        });

        Schema::create('Tables', function (Blueprint $table) {
            $table->integer('TableID')->primary();
            $table->integer('NumberOfChairs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Reservations');
        Schema::dropIfExists('Tables');
    }
};
