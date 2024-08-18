<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Category::create(['category_name' => 'Pizza']);
        Category::create(['category_name' => 'Pasta']);
        Category::create(['category_name' => 'Salads']);
        //
    }
}
