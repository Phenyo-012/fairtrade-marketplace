<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_add_product_to_cart(): void
    {
        $user = User::factory()->create();

        $seller = SellerProfile::factory()->create([
            'verification_status' => 'approved',
        ]);

        $product = Product::factory()->create([
            'seller_profile_id' => $seller->id,
            'stock_quantity' => 10,
            'is_archived' => false,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 2,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_user_can_update_cart_item_quantity(): void
    {
        $user = User::factory()->create();

        $cartItem = CartItem::factory()->create([
            'user_id' => $user->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->patch(route('cart.update', $cartItem), [
            'quantity' => 3,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 3,
        ]);
    }

    public function test_user_can_remove_cart_item(): void
    {
        $user = User::factory()->create();

        $cartItem = CartItem::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->delete(route('cart.destroy', $cartItem));

        $response->assertRedirect();

        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id,
        ]);
    }
}