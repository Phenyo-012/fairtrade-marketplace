<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SellerProfile;

class SellerProfileSeeder extends Seeder
{
    public function run(): void
    {
        SellerProfile::create([
            'user_id' => 2, // assuming seller user with ID 2 exists
            'store_name' => 'Seller Store',
            'store_description' => 'Description for seller store',
            'total_sales_count' => 0,
            'successful_delivery_rate' => 0.0,
            'commission_rate' => 5.0,
        ]);
    }
}