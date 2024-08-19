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
            'name_item' => 'Cheeseburger',
            'description' => 'A juicy beef burger topped with cheese, lettuce, and tomato.',
            'price' => 9.99,
            'availability' => true,
            'image' => 'cheeseburger.jpg',
            'category_id' => 2,
        ]);
        MenuItem::create([
            'name_item' => 'Margherita Pizza',
            'description' => 'Classic pizza with tomato, mozzarella, and basil.',
            'price' => 12.99,
            'availability' => true,
            'image' => 'margherita_pizza.jpg',
            'category_id' => 2,
        ]);
        MenuItem::create([
            'name_item' => 'Caesar Salad',
            'description' => 'Fresh romaine lettuce with Caesar dressing, croutons, and parmesan.',
            'price' => 7.99,
            'availability' => true,
            'image' => 'caesar_salad.jpg',
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
