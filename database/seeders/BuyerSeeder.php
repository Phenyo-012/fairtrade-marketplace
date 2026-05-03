<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BuyerUserSeeder extends Seeder
{
    public function run(): void
    {
        $buyerRole = Role::firstOrCreate([
            'name' => 'buyer',
        ]);

        $buyers = [
            [
                'first_name' => 'Thabo',
                'last_name' => 'Mokoena',
                'email' => 'buyer1@fairtrade.test',
                'phone' => '0710000001',
            ],
            [
                'first_name' => 'Lerato',
                'last_name' => 'Dlamini',
                'email' => 'buyer2@fairtrade.test',
                'phone' => '0710000002',
            ],
            [
                'first_name' => 'Sipho',
                'last_name' => 'Khumalo',
                'email' => 'buyer3@fairtrade.test',
                'phone' => '0710000003',
            ],
            [
                'first_name' => 'Ayesha',
                'last_name' => 'Pillay',
                'email' => 'buyer4@fairtrade.test',
                'phone' => '0710000004',
            ],
            [
                'first_name' => 'Naledi',
                'last_name' => 'Molefe',
                'email' => 'buyer5@fairtrade.test',
                'phone' => '0710000005',
            ],
            [
                'first_name' => 'Kabelo',
                'last_name' => 'Nkosi',
                'email' => 'buyer6@fairtrade.test',
                'phone' => '0710000006',
            ],
            [
                'first_name' => 'Zanele',
                'last_name' => 'Ndlovu',
                'email' => 'buyer7@fairtrade.test',
                'phone' => '0710000007',
            ],
            [
                'first_name' => 'Muhammad',
                'last_name' => 'Patel',
                'email' => 'buyer8@fairtrade.test',
                'phone' => '0710000008',
            ],
            [
                'first_name' => 'Emma',
                'last_name' => 'Botha',
                'email' => 'buyer9@fairtrade.test',
                'phone' => '0710000009',
            ],
            [
                'first_name' => 'Neo',
                'last_name' => 'Mabena',
                'email' => 'buyer10@fairtrade.test',
                'phone' => '0710000010',
            ],
        ];

        foreach ($buyers as $buyerData) {
            $user = User::updateOrCreate(
                ['email' => $buyerData['email']],
                [
                    'first_name' => $buyerData['first_name'],
                    'last_name' => $buyerData['last_name'],
                    'phone' => $buyerData['phone'],
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                    'is_archived' => false,
                    'is_super_admin' => false,
                ]
            );

            $user->roles()->syncWithoutDetaching([
                $buyerRole->id,
            ]);
        }
    }
}