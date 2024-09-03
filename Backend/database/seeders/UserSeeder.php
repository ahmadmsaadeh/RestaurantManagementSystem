<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin role users
        User::create([
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
        ]);
        User::create([
            'username' => 'admin_jane',
            'phonenumber' => '123-987-6543',
            'firstname' => 'Jane',
            'lastname' => 'Smith',
            'email' => 'janesmith@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 1, // Admin role
        ]);
        User::create([
            'username' => 'admin_robert',
            'phonenumber' => '123-555-7890',
            'firstname' => 'Robert',
            'lastname' => 'Brown',
            'email' => 'robertbrown@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 1, // Admin role
        ]);

        // Manager role users
        User::create([
            'username' => 'manager_jood',
            'phonenumber' => '123-481-5411',
            'firstname' => 'Jood',
            'lastname' => 'Hamdallah',
            'email' => 'joodh@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 2, // Manager role
        ]);
        User::create([
            'username' => 'manager_ali',
            'phonenumber' => '123-222-3333',
            'firstname' => 'Ali',
            'lastname' => 'Ahmed',
            'email' => 'aliahmed@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 2, // Manager role
        ]);
        User::create([
            'username' => 'manager_sara',
            'phonenumber' => '123-555-6666',
            'firstname' => 'Sara',
            'lastname' => 'Khan',
            'email' => 'sarakhan@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 2, // Manager role
        ]);

        // Customer role users
        User::create([
            'username' => 'customer_tala',
            'phonenumber' => '123-895-7414',
            'firstname' => 'Tala',
            'lastname' => 'Yassen',
            'email' => 'talay@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 3, // Customer role
        ]);
        User::create([
            'username' => 'customer_omar',
            'phonenumber' => '123-777-8888',
            'firstname' => 'Omar',
            'lastname' => 'Farouk',
            'email' => 'omarfarouk@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 3, // Customer role
        ]);
        User::create([
            'username' => 'customer_mona',
            'phonenumber' => '123-999-1111',
            'firstname' => 'Mona',
            'lastname' => 'Ibrahim',
            'email' => 'monaibrahim@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 3, // Customer role
        ]);

        // Staff role users
        User::create([
            'username' => 'chef_mohammed',
            'phonenumber' => '123-555-6789',
            'firstname' => 'Mohammed',
            'lastname' => 'Ali',
            'email' => 'mohammedali@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 4, // Staff role
        ]);
        User::create([
            'username' => 'chef_laila',
            'phonenumber' => '123-555-6790',
            'firstname' => 'Laila',
            'lastname' => 'Hassan',
            'email' => 'lailahassan@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 4, // Staff role
        ]);
        User::create([
            'username' => 'chef_ahmed',
            'phonenumber' => '123-555-6791',
            'firstname' => 'Ahmed',
            'lastname' => 'El-Sayed',
            'email' => 'ahmedelsayed@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'auth_token' => Str::random(60),
            'token_expiry' => now()->addDays(30),
            'remember_token' => Str::random(10),
            'role_id' => 4, // Staff role
        ]);
    }
}
