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
                'chef_image_url' => 'chef1.jpg',
                'user_id' => 10,
            ],
            [
                'chef_image_url' => 'chef2.jpg',
                'user_id' => 11,
            ],
            [
                'chef_image_url' => 'chef3.jpg',
                'user_id' => 12,
            ],
        ];

        // Insert data into the chefs_image table
        DB::table('chefimages')->insert($data);
    }
}
