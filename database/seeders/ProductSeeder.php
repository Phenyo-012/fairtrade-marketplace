<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Product 1',
            'description' => 'Description for product 1',
            'price' => 100.00,
            'stock_quantity' => 10,
            'seller_profile_id' => 1, // assuming seller with ID 2 exists
            'category' => 'Category 1',
            'condition' => 'New',
        ]);

        Product::create([
            'name' => 'Product 2',
            'description' => 'Description for product 2',
            'price' => 200.00,
            'stock_quantity' => 20,
            'seller_profile_id' => 1, // assuming seller with ID 2 exists
            'category' => 'Category 2',
            'condition' => 'New',
        ]);

        
    }
}