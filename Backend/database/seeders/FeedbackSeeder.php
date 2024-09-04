<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve all relevant IDs
        $orderIds = DB::table('orders')->pluck('order_id')->toArray(); // Use order_id
        $menuItemIds = DB::table('menu_items')->pluck('menu_item_id')->toArray(); // Use menu_item_id
        $customerIds = DB::table('users')->where('role_id', 3)->pluck('user_id')->toArray(); // Use user_id for customers

        // Comments to be used for feedback
        $comments = [
            'Excellent quality and taste.',
            'Very good, but could use more seasoning.',
            'Not satisfied with the portion size.',
            'Great value for money!',
            'Would definitely order again.',
            'The dish was too salty for my taste.',
            'Loved the dessert, it was heavenly!',
            'The service was fast and friendly.',
            'A bit pricey for what you get.',
            'The ambiance was nice, but the food was average.'
        ];

        // Seed feedback data
        foreach (range(1, 10) as $feedbackNum) {
            $orderId = $orderIds[array_rand($orderIds)];
            $menuItemId = $menuItemIds[array_rand($menuItemIds)];
            $customerId = $customerIds[array_rand($customerIds)];
            $rating = rand(1, 5); // Random rating between 1 and 5
            $comment = $comments[array_rand($comments)];

            // Generate a random date within the last year and a different month
            $randomMonth = rand(1, 12);
            $randomYear = rand(2023, 2024); // Adjust years as needed
            $dateSubmitted = Carbon::create($randomYear, $randomMonth, rand(1, 28))->format('Y-m-d H:i:s');

            Feedback::create([
                'order_id' => $orderId,
                'menu_item_id' => $menuItemId,
                'customer_id' => $customerId,
                'rating' => $rating,
                'comments' => $comment,
                'date_submitted' => $dateSubmitted,
            ]);
        }
    }
}
