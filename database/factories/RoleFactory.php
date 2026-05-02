<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'buyer',
                'seller',
                'admin',
            ]),
        ];
    }

    public function buyer(): static
    {
        return $this->state(fn () => [
            'name' => 'buyer',
        ]);
    }

    public function seller(): static
    {
        return $this->state(fn () => [
            'name' => 'seller',
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'name' => 'admin',
        ]);
    }
}