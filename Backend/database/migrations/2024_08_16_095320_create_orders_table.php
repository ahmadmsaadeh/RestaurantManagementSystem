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

            $table->timestamp('order_date')->useCurrent(); // Sets default to current timestamp
            $table->timestamp('order_time')->useCurrent(); // Sets default to current timestamp

            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id'); // Reference the correct primary key in the users table
            $table->foreignId('reservation_id')->nullable()->constrained('reservations', 'ResID')->onDelete('set null');
            $table->decimal('total', 10, 2)->nullable(); // Total with precision: 10 digits, 2 after the decimal point
            $table->enum('status', ['Open', 'Served', 'Closed'])->default('Open');
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
