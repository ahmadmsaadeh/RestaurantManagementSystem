<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChefimageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'chef_image_url' => 'C:\xampp\htdocs\project\Backend\chef_images\chef1.jpg',
                'user_id' => 4,
            ],
            [
                'chef_image_url' => 'C:\xampp\htdocs\project\Backend\chef_images\chef2.png',
                'user_id' => 5,
            ],
            [
                'chef_image_url' => 'C:\xampp\htdocs\project\Backend\chef_images\chef3.png',
                'user_id' => 6,
            ],
        ];

        // Insert data into the chefs_image table
        DB::table('chefs_image')->insert($data);
    }
}
