<?php

namespace Database\Factories;

use App\Models\SellerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'seller_profile_id' => SellerProfile::factory(),

            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 50, 5000),
            'stock_quantity' => fake()->numberBetween(1, 50),

            'category' => fake()->randomElement([
                'Electronics',
                'Clothing',
                'Shoes',
                'Home',
                'Beauty',
                'Books',
            ]),

            'condition' => fake()->randomElement([
                'new',
                'second_hand',
            ]),

            'image' => null,

            'discount_percentage' => null,
            'discount_ends_at' => null,
            'free_shipping' => false,

            'is_archived' => false,
            'is_approved' => true,
            'is_active' => true,

            'shipping_size' => fake()->randomElement([
                'small',
                'medium',
                'large',
            ]),
        ];
    }

    public function archived(): static
    {
        return $this->state(fn () => [
            'is_archived' => true,
        ]);
    }

    public function discounted(): static
    {
        return $this->state(fn () => [
            'discount_percentage' => 15,
            'discount_ends_at' => now()->addHours(24),
        ]);
    }

    public function freeShipping(): static
    {
        return $this->state(fn () => [
            'free_shipping' => true,
        ]);
    }

    public function small(): static
    {
        return $this->state(fn () => [
            'shipping_size' => 'small',
        ]);
    }

    public function medium(): static
    {
        return $this->state(fn () => [
            'shipping_size' => 'medium',
        ]);
    }

    public function large(): static
    {
        return $this->state(fn () => [
            'shipping_size' => 'large',
        ]);
    }
}