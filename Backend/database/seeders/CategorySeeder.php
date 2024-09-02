<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['category_name' => 'Appetizers']);
        Category::create(['category_name' => 'Main Courses']);
        Category::create(['category_name' => 'Desserts']);
        Category::create(['category_name' => 'Beverages']);

    }
}
