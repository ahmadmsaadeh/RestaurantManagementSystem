<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // 1. Seeding Roles table
        DB::table('roles')->insert([
            ['role_name' => 'Admin', 'description' => 'Full system control'],
            ['role_name' => 'Staff', 'description' => 'Manages daily tasks'],
            ['role_name' => 'Customer', 'description' => 'Makes reservations'],
        ]);

        // 2. Seeding Users table
        DB::table('users')->insert([
            [
                'username' => 'john_doe',
                'phonenumber' => '123-456-7890',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'johndoe@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'auth_token' => Str::random(60),
                'token_expiry' => now()->addDays(30),
                'remember_token' => Str::random(10),
                'role_id' => 1, // Admin role
            ],
            [
                'username' => 'Jood Hamd.',
                'phonenumber' => '123-481 5411',
                'firstname' => 'Jood',
                'lastname' => 'Hamdallah',
                'email' => 'joodh@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'auth_token' => Str::random(60),
                'token_expiry' => now()->addDays(30),
                'remember_token' => Str::random(10),
                'role_id' => 2, // Manager role
            ],
            [
                'username' => 'Tala Yass.',
                'phonenumber' => '123-895 7414',
                'firstname' => 'Tala',
                'lastname' => 'Yassen',
                'email' => 'talay@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'auth_token' => Str::random(60),
                'token_expiry' => now()->addDays(30),
                'remember_token' => Str::random(10),
                'role_id' => 3, // Customer role
            ]

        ]);

        // 3. Seeding Categories table
        DB::table('categories')->insert([
            ['category_name' => 'Appetizers'],
            ['category_name' => 'Main Courses']

        ]);

        // 4. Seeding Menu Items table
        DB::table('menu_items')->insert([
            [
                'name_item' => 'Cheeseburger',
                'description' => 'A juicy beef burger topped with cheese, lettuce, and tomato.',
                'price' => 9.99,
                'availability' => true,
                'image' => 'cheeseburger.jpg',
                'category_id' => 2, // Make sure this matches an existing category_id in the categories table
            ],
            [
                'name_item' => 'Margherita Pizza',
                'description' => 'Classic pizza with tomato, mozzarella, and basil.',
                'price' => 12.99,
                'availability' => true,
                'image' => 'margherita_pizza.jpg',
                'category_id' => 2, // Make sure this matches an existing category_id in the categories table
            ],
            [
                'name_item' => 'Caesar Salad',
                'description' => 'Fresh romaine lettuce with Caesar dressing, croutons, and parmesan.',
                'price' => 7.99,
                'availability' => true,
                'image' => 'caesar_salad.jpg',
                'category_id' => 1, // Make sure this matches an existing category_id in the categories table
            ],
            [
                'name_item' => 'Fries',
                'description' => 'Crispy golden fries.',
                'price' => 3.99,
                'availability' => true,
                'image' => 'fries.jpg',
                'category_id' => 1, // Appetizers category_id
            ]
        ]);

        // 5. Seeding Tables table
        DB::table('tables')->insert([
            [ 'NumberOfChairs' => 4],
            [ 'NumberOfChairs' => 2],
            [ 'NumberOfChairs' => 3]
        ]);

        // 6. Seeding Reservations table
        DB::table('reservations')->insert([
            [
                'UserID' => 2,
                'TableID' => 1,
                'Date' => now()->addDays(1)->toDateString(), // Use date format
                'Time' => now()->addDays(1)->format('H:i:s'), // Use time format
                'NumOfCustomers' => 4,
                'ReservationType' => 'Dinner',
                'TimeExpectedToLeave' => now()->addDays(1)->addHours(2)->format('H:i:s'), // Example expected leave time
            ],
            [
                'UserID' => 1,
                'TableID' => 2,
                'Date' => now()->addDays(2)->toDateString(), // Use date format
                'Time' => now()->addDays(2)->format('H:i:s'), // Use time format
                'NumOfCustomers' => 2,
                'ReservationType' => 'Lunch',
                'TimeExpectedToLeave' => now()->addDays(2)->addHours(1)->format('H:i:s'), // Example expected leave time
            ]
        ]);

        // 7. Seeding Orders table
        DB::table('orders')->insert([
            [
                'user_id' => 2,
                'reservation_id' => 1,
                'total' => 47.95,
                'status' => 'Open',
                'order_date' => now(), // Current timestamp for order_date
                'order_time' => now(), // Current timestamp for order_time
            ],
            [
                'user_id' => 1,
                'reservation_id' => 1,
                'total' => 24.96,
                'status' => 'Served',
                'order_date' => now(), // Current timestamp for order_date
                'order_time' => now(), // Current timestamp for order_time
            ]
        ]);

        // 8. Seeding Order Items table
        DB::table('order_items')->insert([
            [
                'order_id' => 1, // Reference to the first existing order
                'menu_item_id' => 1, // Cheeseburger
                'quantity' => 2,
                'subtotal' => 19.98, // 2 x $9.99
                'item_status' => 'Pending',
            ],
            [
                'order_id' => 1, // Reference to the first existing order
                'menu_item_id' => 3, // Caesar Salad
                'quantity' => 1,
                'subtotal' => 7.99, // 1 x $7.99
                'item_status' => 'In-progress',
            ],
            [
                'order_id' => 2, // Reference to the second existing order
                'menu_item_id' => 2, // Margherita Pizza
                'quantity' => 1,
                'subtotal' => 12.99, // 1 x $12.99
                'item_status' => 'Completed',
            ],
            [
                'order_id' => 2, // Reference to the second existing order
                'menu_item_id' => 4, // Fries
                'quantity' => 3,
                'subtotal' => 11.97, // 3 x $3.99
                'item_status' => 'Pending',
            ]
        ]);

        // 9. Seeding Feedbacks table
        DB::table('feedbacks')->insert([
            [
                'order_id' => 1,
                'menu_item_id' => 1, // Cheeseburger
                'customer_id' => 3, // Customer user_id
                'rating' => 5,
                'comments' => 'Delicious and well worth the price!',
                'date_submitted' => now(),
            ],
            [
                'order_id' => 1,
                'menu_item_id' => 3, // Caesar Salad
                'customer_id' => 3, // Customer user_id
                'rating' => 4,
                'comments' => 'Fresh and tasty, but a bit too small.',
                'date_submitted' => now(),
            ]
        ]);
    }

}
