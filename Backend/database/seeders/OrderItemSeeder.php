<?php

namespace Database\Seeders;

use App\Models\Order_item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     Order_item::create([
         'order_id' => 1, // Reference to the first existing order
         'menu_item_id' => 1, // Cheeseburger
         'quantity' => 2,
         'subtotal' => 19.98, // 2 x $9.99
         'item_status' => 'Pending',
     ]);
     Order_item::create([
         'order_id' => 1, // Reference to the first existing order
         'menu_item_id' => 3, // Caesar Salad
         'quantity' => 1,
         'subtotal' => 7.99, // 1 x $7.99
         'item_status' => 'In-progress',
     ]);
     Order_item::create([
            'order_id' => 2, // Reference to the second existing order
            'menu_item_id' => 2, // Margherita Pizza
            'quantity' => 1,
            'subtotal' => 12.99, // 1 x $12.99
            'item_status' => 'Completed',
        ]);
        Order_item::create([
            'order_id' => 2, // Reference to the second existing order
            'menu_item_id' => 4, // Fries
            'quantity' => 3,
            'subtotal' => 11.97, // 3 x $3.99
            'item_status' => 'Pending',
        ]);


    }
}
