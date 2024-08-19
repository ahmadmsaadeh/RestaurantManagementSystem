<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            MenuItemSeeder::class,
            TableSeeder::class,
            ReservationSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            FeedbackSeeder::class,
        ]);
    }

}
