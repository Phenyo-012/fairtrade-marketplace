<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@test.com',
            'phone' => '0810000000',
            'password' => bcrypt('password'),
        ]);
        $admin->roles()->attach([1]); // attach admin role

        // Seller
        $seller = User::create([
            'first_name' => 'Seller',
            'last_name' => 'User',
            'email' => 'seller@test.com',
            'phone' => '0810000001',
            'password' => bcrypt('password'),
        ]);
        $seller->roles()->attach([2]); // attach seller role

        // Buyer
        $buyer = User::create([
            'first_name' => 'Buyer',
            'last_name' => 'User',
            'email' => 'buyer@test.com',
            'phone' => '0810000002',
            'password' => bcrypt('password'),
        ]);
        $buyer->roles()->attach([3]); // attach buyer role
    }
}