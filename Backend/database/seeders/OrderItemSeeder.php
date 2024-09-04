<?php

namespace Database\Seeders;

use App\Models\Order_item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve all menu item IDs and order IDs
        $menuItemIds = DB::table('menu_items')->pluck('menu_item_id')->toArray(); // Convert to array
        $orderIds = DB::table('orders')->pluck('order_id')->toArray(); // Convert to array

        foreach ($orderIds as $orderId) {
            foreach (range(1, 4) as $itemNum) {
                Order_item::create([
                    'order_id' => $orderId,
                    'menu_item_id' => $menuItemIds[array_rand($menuItemIds)], // Use array_rand() on array
                    'quantity' => rand(1, 3),
                    'subtotal' => rand(5, 20),
                    'item_status' => ['Pending', 'In-progress', 'Completed'][array_rand(['Pending', 'In-progress', 'Completed'])],
                ]);
            }
        }
    }
}
