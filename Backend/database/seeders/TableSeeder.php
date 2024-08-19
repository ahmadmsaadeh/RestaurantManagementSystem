<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Table::create([ 'NumberOfChairs' => 4]);
       Table::create([ 'NumberOfChairs' => 2]);
       Table::create([ 'NumberOfChairs' => 3]);
    }
}
