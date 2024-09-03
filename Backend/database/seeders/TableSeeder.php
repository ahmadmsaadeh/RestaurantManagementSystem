<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tables')->insert([
            ['TableID' => 1, 'NumberOfChairs' => 4],
            ['TableID' => 2, 'NumberOfChairs' => 2],
            ['TableID' => 3, 'NumberOfChairs' => 6],
            ['TableID' => 4, 'NumberOfChairs' => 3],
            ['TableID' => 5, 'NumberOfChairs' => 5],
        ]);
    }
}
