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
            'UserID' => 1, // Reference to an existing user_id
            'TableID' => 1, // Reference to an existing TableID
            'Date' => now()->addDays(1)->toDateString(), // Date for reservation
            'Time' => now()->addDays(1)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 4,
            'ReservationType' => 'Dinner',
            'TimeExpectedToLeave' => now()->addDays(1)->addHours(2)->format('H:i:s'),
        ]);

        Reservation::create([
            'UserID' => 2, // Reference to another existing user_id
            'TableID' => 2, // Reference to another existing TableID
            'Date' => now()->addDays(2)->toDateString(), // Date for reservation
            'Time' => now()->addDays(2)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 2,
            'ReservationType' => 'Lunch',
            'TimeExpectedToLeave' => now()->addDays(2)->addHours(1)->format('H:i:s'),
        ]);

        Reservation::create([
            'UserID' => 3, // Reference to another existing user_id
            'TableID' => 3, // Reference to another existing TableID
            'Date' => now()->addDays(3)->toDateString(), // Date for reservation
            'Time' => now()->addDays(3)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 6,
            'ReservationType' => 'Brunch',
            'TimeExpectedToLeave' => now()->addDays(3)->addHours(3)->format('H:i:s'),
        ]);

        Reservation::create([
            'UserID' => 4, // Reference to another existing user_id
            'TableID' => 4, // Reference to another existing TableID
            'Date' => now()->addDays(4)->toDateString(), // Date for reservation
            'Time' => now()->addDays(4)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 3,
            'ReservationType' => 'Dinner',
            'TimeExpectedToLeave' => now()->addDays(4)->addHours(2)->format('H:i:s'),
        ]);

        Reservation::create([
            'UserID' => 5, // Reference to another existing user_id
            'TableID' => 5, // Reference to another existing TableID
            'Date' => now()->addDays(5)->toDateString(), // Date for reservation
            'Time' => now()->addDays(5)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 5,
            'ReservationType' => 'Lunch',
            'TimeExpectedToLeave' => now()->addDays(5)->addHours(1)->format('H:i:s'),
        ]);

        Reservation::create([
            'UserID' => 1, // Reusing existing user_id
            'TableID' => 2, // Reusing existing TableID
            'Date' => now()->addDays(6)->toDateString(), // Date for reservation
            'Time' => now()->addDays(6)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 2,
            'ReservationType' => 'Dinner',
            'TimeExpectedToLeave' => now()->addDays(6)->addHours(2)->format('H:i:s'),
        ]);

        Reservation::create([
            'UserID' => 2, // Reusing existing user_id
            'TableID' => 3, // Reusing existing TableID
            'Date' => now()->addDays(7)->toDateString(), // Date for reservation
            'Time' => now()->addDays(7)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 4,
            'ReservationType' => 'Brunch',
            'TimeExpectedToLeave' => now()->addDays(7)->addHours(3)->format('H:i:s'),
        ]);

        Reservation::create([
            'UserID' => 3, // Reusing existing user_id
            'TableID' => 4, // Reusing existing TableID
            'Date' => now()->addDays(8)->toDateString(), // Date for reservation
            'Time' => now()->addDays(8)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 6,
            'ReservationType' => 'Dinner',
            'TimeExpectedToLeave' => now()->addDays(8)->addHours(2)->format('H:i:s'),
        ]);

        Reservation::create([
            'UserID' => 4, // Reusing existing user_id
            'TableID' => 5, // Reusing existing TableID
            'Date' => now()->addDays(9)->toDateString(), // Date for reservation
            'Time' => now()->addDays(9)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 3,
            'ReservationType' => 'Lunch',
            'TimeExpectedToLeave' => now()->addDays(9)->addHours(1)->format('H:i:s'),
        ]);

        Reservation::create([
            'UserID' => 5, // Reusing existing user_id
            'TableID' => 1, // Reusing existing TableID
            'Date' => now()->addDays(10)->toDateString(), // Date for reservation
            'Time' => now()->addDays(10)->format('H:i:s'), // Time for reservation
            'NumOfCustomers' => 5,
            'ReservationType' => 'Dinner',
            'TimeExpectedToLeave' => now()->addDays(10)->addHours(2)->format('H:i:s'),
        ]);
    }
}
