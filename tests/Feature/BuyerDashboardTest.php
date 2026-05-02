<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\OrderItem;
use App\Models\SellerProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuyerDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_access_buyer_dashboard(): void
    {
        $buyerRole = Role::firstOrCreate(['name' => 'buyer']);

        $buyer = User::factory()->create();
        $buyer->roles()->attach($buyerRole);

        $this->actingAs($buyer);

        $response = $this->get(route('buyer.dashboard'));

        $response->assertOk();
        $response->assertSee('Buyer Dashboard');
    }

    public function test_buyer_dashboard_displays_buyer_activity(): void
    {
        $buyerRole = Role::firstOrCreate(['name' => 'buyer']);

        $buyer = User::factory()->create();
        $buyer->roles()->attach($buyerRole);

        Order::factory()->completed()->create([
            'buyer_id' => $buyer->id,
            'total_amount' => 500,
        ]);

        Order::factory()->shipped()->create([
            'buyer_id' => $buyer->id,
            'total_amount' => 250,
        ]);

        Wishlist::factory()->create([
            'user_id' => $buyer->id,
        ]);

        Review::factory()->create([
            'buyer_id' => $buyer->id,
        ]);

        $this->actingAs($buyer);

        $response = $this->get(route('buyer.dashboard'));

        $response->assertOk();
        $response->assertSee('Total Orders');
        $response->assertSee('Completed Spend');
        $response->assertSee('Wishlist Items');
    }
}