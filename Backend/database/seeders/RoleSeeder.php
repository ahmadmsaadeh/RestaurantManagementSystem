<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['role_name' => 'Admin', 'description' => 'Full system control']);
        Role::create(['role_name' => 'Management', 'description' => 'Manages daily tasks']);
        Role::create(['role_name' => 'Customer', 'description' => 'Makes reservations']);
        Role::create(['role_name' => 'Kitchen Staff', 'description' => 'Making dishes']);
        Role::create(['role_name' => 'Wait Staff', 'description' => 'Serves food and drinks to customers']);
        Role::create(['role_name' => 'Bartender', 'description' => 'Prepares and serves drinks']);
        Role::create(['role_name' => 'Dishwasher', 'description' => 'Cleans dishes and kitchen equipment']);

    }
}
