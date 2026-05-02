<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_from_approved_seller_can_show(): void
    {
        $sellerUser = User::factory()->create();

        $sellerProfile = SellerProfile::factory()->create([
            'user_id' => $sellerUser->id,
            'verification_status' => 'approved',
        ]);

        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'is_archived' => false,
        ]);

        $response = $this->get(route('marketplace.show', $product));

        $response->assertOk();
    }

    public function test_archived_product_redirects_from_product_show(): void
    {
        $sellerUser = User::factory()->create();

        $sellerProfile = SellerProfile::factory()->create([
            'user_id' => $sellerUser->id,
            'verification_status' => 'approved',
        ]);

        $product = Product::factory()->archived()->create([
            'seller_profile_id' => $sellerProfile->id,
        ]);

        $response = $this->get(route('marketplace.show', $product));

        $response->assertRedirect(route('marketplace.index'));
        $response->assertSessionHas('error');
    }

    public function test_rejected_seller_store_is_not_accessible(): void
    {
        $sellerUser = User::factory()->create();

        $sellerProfile = SellerProfile::factory()->rejected()->create([
            'user_id' => $sellerUser->id,
        ]);

        $response = $this->get(route('store.show', $sellerProfile));

        $response->assertRedirect();
    }

    public function test_archived_seller_store_is_not_accessible(): void
    {
        $sellerUser = User::factory()->create();

        $sellerProfile = SellerProfile::factory()->archived()->create([
            'user_id' => $sellerUser->id,
        ]);

        $response = $this->get(route('store.show', $sellerProfile));

        $response->assertRedirect();
    }
}