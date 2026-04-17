<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'phone' => '0000000000',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('StrongPassword123'),
                'is_super_admin' => true,
            ]
        );

        $adminRole = Role::where('name', 'admin')->first();

        $user->roles()->sync([$adminRole->id]);
    }
}
