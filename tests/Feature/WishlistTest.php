<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_product_to_wishlist(): void
    {
        $user = User::factory()->create();

        $seller = SellerProfile::factory()->create([
            'verification_status' => 'approved',
        ]);

        $product = Product::factory()->create([
            'seller_profile_id' => $seller->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('wishlist.toggle', $product));

        $response->assertRedirect();

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_can_remove_product_from_wishlist_using_toggle(): void
    {
        $user = User::factory()->create();

        $wishlist = Wishlist::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('wishlist.toggle', $wishlist->product));

        $response->assertRedirect();

        $this->assertDatabaseMissing('wishlists', [
            'id' => $wishlist->id,
        ]);
    }
}