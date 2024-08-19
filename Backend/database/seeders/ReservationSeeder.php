<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reservation::create([
            'UserID' => 2,
            'TableID' => 1,
            'Date' => now()->addDays(1)->toDateString(), // Use date format
            'Time' => now()->addDays(1)->format('H:i:s'), // Use time format
            'NumOfCustomers' => 4,
            'ReservationType' => 'Dinner',
            'TimeExpectedToLeave' => now()->addDays(1)->addHours(2)->format('H:i:s'), // Example expected leave time
        ]);

        Reservation::create([
            'UserID' => 1,
            'TableID' => 2,
            'Date' => now()->addDays(2)->toDateString(), // Use date format
            'Time' => now()->addDays(2)->format('H:i:s'), // Use time format
            'NumOfCustomers' => 2,
            'ReservationType' => 'Lunch',
            'TimeExpectedToLeave' => now()->addDays(2)->addHours(1)->format('H:i:s'), // Example expected leave time
        ]);
    }
}
