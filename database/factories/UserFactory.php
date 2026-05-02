<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => fake()->unique()->numerify('07########'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_super_admin' => false,
            'is_archived' => false,
            'archived_at' => null,
            'archived_email' => null,
            'archived_phone' => null,
        ];
    }

    public function archived(): static
    {
        return $this->state(function () {
            $email = fake()->unique()->safeEmail();
            $phone = fake()->unique()->numerify('07########');

            return [
                'email' => 'archived_user_' . fake()->unique()->numberBetween(1000, 999999) . '_' . $email,
                'phone' => 'archived_user_' . fake()->unique()->numberBetween(1000, 999999) . '_' . $phone,
                'archived_email' => $email,
                'archived_phone' => $phone,
                'is_archived' => true,
                'archived_at' => now(),
            ];
        });
    }

    public function superAdmin(): static
    {
        return $this->state(fn () => [
            'is_super_admin' => true,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }
}