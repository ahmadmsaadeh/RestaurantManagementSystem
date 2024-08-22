<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Order::create([
           'user_id' => 2,
           'reservation_id' => 1,
           'total' => 27.97,
           'status' => 'Open',
           'order_date' => now(), // Current timestamp for order_date
           'order_time' => now(), // Current timestamp for order_time
       ]);
       Order::create([
           'user_id' => 1,
           'reservation_id' => 1,
           'total' => 24.96,
           'status' => 'Served',
           'order_date' => now(), // Current timestamp for order_date
           'order_time' => now(), // Current timestamp for order_time
       ]);


    }
}
