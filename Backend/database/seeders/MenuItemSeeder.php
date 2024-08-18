<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        MenuItem::create([
            'name_item' => 'Margherita Pizza',
            'description' => 'Classic cheese pizza with tomato sauce and basil.',
            'price' => 8.99,
            'availability' => true,
            'image' => 'margherita.jpg',
            'category_id' => 1, // Assuming 1 is the ID of the 'Pizza' category
        ]);
        //
    }
}
