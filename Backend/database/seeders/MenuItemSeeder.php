<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItem::create([
            'name_item' => 'Garlic-Butter Chicken & French Fries',
            'description' => 'Delicious cheese Garlic-Butter Chicken & French Fr...',
            'price' => 12.99,
            'availability' => true,
            'image' => 'chickenfranch.png',
            'category_id' => 2,
        ]);
        MenuItem::create([
            'name_item' => 'Jammy Pastries',
            'description' => 'Delicious cheese Jammy Pastries',
            'price' => 10.99,
            'availability' => true,
            'image' => 'tea.png',
            'category_id' => 1,
        ]);
        MenuItem::create([
            'name_item' => 'Chicken Gyro Meatball Salad',
            'description' => 'This chicken gyro salad celebrates the fantastic f...',
            'price' => 9.99,
            'availability' => true,
            'image' => 'gyro chicken.png',
            'category_id' => 1,
        ]);
        MenuItem::create([
            'name_item' => 'Fries',
            'description' => 'Crispy golden fries.',
            'price' => 3.99,
            'availability' => true,
            'image' => 'fries.jpg',
            'category_id' => 1, // Appetizers category_id
        ]);


    }
}
