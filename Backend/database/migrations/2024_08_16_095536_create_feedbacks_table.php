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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('menu_item_id')->nullable(); // Make nullable
            $table->unsignedBigInteger('customer_id');
            $table->tinyInteger('rating')->unsigned();
            $table->text('comments')->nullable();
            $table->timestamp('date_submitted')->useCurrent();
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('menu_item_id')->references('menu_item_id')->on('menu_items')->onDelete('set null'); // Set to null on deletion
            $table->foreign('customer_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
