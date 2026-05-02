<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisputeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'opened_by' => User::factory(),

            'reason' => fake()->paragraph(),
            'status' => 'open',

            'resolution_notes' => null,
            'resolved_by' => null,

            'seller_response' => null,
            'seller_responded_at' => null,
        ];
    }

    public function underReview(): static
    {
        return $this->state(fn () => [
            'status' => 'under_review',
        ]);
    }

    public function resolved(): static
    {
        return $this->state(fn () => [
            'status' => 'resolved',
            'resolution_notes' => fake()->paragraph(),
            'resolved_by' => User::factory(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn () => [
            'status' => 'rejected',
            'resolution_notes' => fake()->paragraph(),
            'resolved_by' => User::factory(),
        ]);
    }

    public function withSellerResponse(): static
    {
        return $this->state(fn () => [
            'seller_response' => fake()->paragraph(),
            'seller_responded_at' => now(),
        ]);
    }
}