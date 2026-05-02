<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewVoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'review_id' => Review::factory(),
            'user_id' => User::factory(),
            'is_helpful' => true,
        ];
    }

    public function notHelpful(): static
    {
        return $this->state(fn () => [
            'is_helpful' => false,
        ]);
    }
}