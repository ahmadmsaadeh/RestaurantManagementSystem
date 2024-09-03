<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = [7, 8, 9]; // Customer role users
        $years = [2022, 2023, 2024]; // List of years

        foreach ($userIds as $userId) {
            foreach ($years as $year) {
                for ($i = 0; $i < 4; $i++) {
                    // Generate different dates and times for each year and month
                    $month = str_pad($i + 1, 2, '0', STR_PAD_LEFT); // Format month to two digits
                    $orderDate = Carbon::create($year, $month, rand(1, 28))->format('Y-m-d'); // Random day within the month
                    $orderTime = Carbon::create($year, $month, rand(1, 28))->setTime(rand(0, 23), rand(0, 59), rand(0, 59))->format('Y-m-d H:i:s'); // Full datetime

                    Order::create([
                        'user_id' => $userId,
                        'reservation_id' => rand(1, 10),
                        'total' => rand(10, 100),
                        'status' => ['Open', 'Served', 'Closed'][rand(0, 2)],
                        'order_date' => $orderDate, // Date only
                        'order_time' => $orderTime, // Full datetime
                    ]);
                }
            }
        }
    }
}
