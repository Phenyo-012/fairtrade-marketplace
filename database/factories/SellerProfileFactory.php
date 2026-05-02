<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SellerProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'store_name' => fake()->unique()->company(),
            'logo' => null,
            'about' => fake()->paragraph(),

            'verification_status' => 'approved',
            'verification_notes' => null,

            'id_document' => 'kyc/test-id.jpg',
            'selfie_document' => 'kyc/test-selfie.jpg',
            'kyc_submitted' => true,
            'onboarding_step' => 3,

            'pickup_address' => fake()->streetAddress(),
            'pickup_city' => fake()->city(),
            'pickup_postal_code' => fake()->postcode(),
            'pickup_province' => fake()->randomElement([
                'Gauteng',
                'Western Cape',
                'Eastern Cape',
                'KwaZulu-Natal',
                'Free State',
                'Limpopo',
                'Mpumalanga',
                'North West',
                'Northern Cape',
            ]),
            'pickup_country' => 'South Africa',
        ];
    }

   public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'approved',
            'kyc_submitted' => true,
            'onboarding_step' => 3,
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'pending',
            'kyc_submitted' => true,
            'onboarding_step' => 3,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'rejected',
            'kyc_submitted' => true,
            'onboarding_step' => 3,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'archived',
            'kyc_submitted' => true,
            'onboarding_step' => 3,
        ]);
    }

    public function notSubmitted(): static
    {
        return $this->state(fn () => [
            'verification_status' => 'not_submitted',
            'verification_notes' => null,
            'id_document' => null,
            'selfie_document' => null,
            'kyc_submitted' => false,
            'onboarding_step' => 1,
        ]);
    }
}