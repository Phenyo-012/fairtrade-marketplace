<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 3);
        $totalAmount = fake()->randomFloat(2, 100, 3000);
        $shippingFee = fake()->randomElement([50, 70, 100, 130, 180]);

        return [
            'buyer_id' => User::factory(),
            'seller_profile_id' => SellerProfile::factory(),

            'total_amount' => $totalAmount,
            'status' => 'pending',

            'delivery_code' => strtoupper(Str::random(6)),

            'delivered_at' => null,
            'seller_deadline' => now()->addDays(2),
            'payment_status' => 'paid',
            'is_late' => false,
            'shipped_at' => null,

            'shipping_name' => fake()->name(),
            'shipping_phone' => fake()->numerify('07########'),
            'shipping_address' => fake()->streetAddress(),
            'shipping_city' => fake()->city(),
            'shipping_province' => fake()->randomElement([
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
            'shipping_postal_code' => fake()->postcode(),
            'shipping_country' => 'South Africa',

            'payment_method' => fake()->randomElement([
                'card',
                'eft',
                'ozow',
                'cod',
            ]),
            'payment_reference' => 'PAY-' . strtoupper(Str::random(8)),

            'shipping_fee' => $shippingFee,

            'courier_name' => null,
            'courier_service' => null,
            'courier_tracking_number' => null,
            'courier_fee' => null,
            'courier_booked_at' => null,
        ];
    }

    public function awaitingShipment(): static
    {
        return $this->state(fn () => [
            'status' => 'awaiting_shipment',
        ]);
    }

    public function shipped(): static
    {
        return $this->state(fn () => [
            'status' => 'shipped',
            'shipped_at' => now(),
            'courier_name' => 'Demo Courier',
            'courier_service' => 'Standard Delivery',
            'courier_tracking_number' => 'TRK-' . strtoupper(Str::random(8)),
            'courier_fee' => 100,
            'courier_booked_at' => now(),
        ]);
    }

    public function delivered(): static
    {
        return $this->state(fn () => [
            'status' => 'delivered',
            'shipped_at' => now()->subDay(),
            'delivered_at' => now(),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => 'completed',
            'shipped_at' => now()->subDays(2),
            'delivered_at' => now()->subDay(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn () => [
            'status' => 'cancelled',
        ]);
    }

    public function disputed(): static
    {
        return $this->state(fn () => [
            'status' => 'disputed',
        ]);
    }

    public function late(): static
    {
        return $this->state(fn () => [
            'is_late' => true,
            'seller_deadline' => now()->subDay(),
            'shipped_at' => now(),
        ]);
    }
}