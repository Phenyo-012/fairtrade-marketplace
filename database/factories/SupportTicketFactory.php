<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportTicketFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->name();

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'email' => fake()->safeEmail(),

            'subject' => fake()->sentence(4),
            'category' => fake()->randomElement([
                'account',
                'order',
                'payment',
                'seller',
                'technical',
                'other',
            ]),
            'message' => fake()->paragraph(),

            'status' => 'open',
        ];
    }

    public function closed(): static
    {
        return $this->state(fn () => [
            'status' => 'closed',
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn () => [
            'status' => 'in_progress',
        ]);
    }
}