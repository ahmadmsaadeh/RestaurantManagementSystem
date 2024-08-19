<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Feedback::create([
            'order_id' => 1,
            'menu_item_id' => 1, // Cheeseburger
            'customer_id' => 3, // Customer user_id
            'rating' => 5,
            'comments' => 'Delicious and well worth the price!',
            'date_submitted' => now(),
        ]);
        Feedback::create([
            'order_id' => 1,
            'menu_item_id' => 3, // Caesar Salad
            'customer_id' => 3, // Customer user_id
            'rating' => 4,
            'comments' => 'Fresh and tasty, but a bit too small.',
            'date_submitted' => now(),
        ]);
    }
}
