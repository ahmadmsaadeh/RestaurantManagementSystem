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
            'image' => 'Breakfast_pastry.jpg',
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
            'image' => 'Fries.jpg',
            'category_id' => 1, // Appetizers category_id
        ]);
        // new
        MenuItem::create([
            'name_item' => 'Lemonade',
            'description' => 'Freshly squeezed lemonade with a hint of mint.',
            'price' => 2.99,
            'availability' => true,
            'image' => 'Lemonade.jpg',
            'category_id' => 4, // Beverages
        ]);

        MenuItem::create([
            'name_item' => 'Grilled Salmon',
            'description' => 'Perfectly grilled salmon served with a lemon butter sauce.',
            'price' => 18.99,
            'availability' => true,
            'image' => 'Grilled Salmon.jpg',
            'category_id' => 2, // Main Courses
        ]);
        MenuItem::create([
            'name_item' => 'Chocolate Lava Cake',
            'description' => 'Warm chocolate cake with a gooey molten center.',
            'price' => 6.99,
            'availability' => true,
            'image' => 'Chocolate Lava Cake.jpg',
            'category_id' => 3, // Desserts
        ]);

        MenuItem::create([
            'name_item' => 'Ice Cream Sundae',
            'description' => 'Classic ice cream sundae with your choice of toppings.',
            'price' => 4.99,
            'availability' => true,
            'image' => 'Ice Cream Sundaee.jpg',
            'category_id' => 3, // Desserts
        ]);
    }
}
