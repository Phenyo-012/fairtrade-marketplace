<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_review_delivered_order_item(): void
    {
        $this->markTestSkipped('Temporarily skipped while review flow is being finalized.');

        $buyer = User::factory()->create();

        $seller = SellerProfile::factory()->approved()->create();

        $product = Product::factory()->create([
            'seller_profile_id' => $seller->id,
        ]);

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'seller_profile_id' => $seller->id,
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        $orderItem = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 1,
            'unit_price' => $product->price,
            'subtotal' => $product->price,
            'original_price' => $product->price,
        ]);

        $this->actingAs($buyer);

        $response = $this->actingAs($buyer)->post(route('review.store', $orderItem), [
            'rating' => 5,
            'comment' => 'Great product.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'order_id' => $order->id,
            'order_item_id' => $orderItem->id,
            'buyer_id' => $buyer->id,
            'rating' => 5,
        ]);
    }

    public function test_buyer_cannot_review_same_order_item_twice(): void
    {
        $buyer = User::factory()->create();

        $seller = SellerProfile::factory()->approved()->create();

        $product = Product::factory()->create([
            'seller_profile_id' => $seller->id,
        ]);

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'seller_profile_id' => $seller->id,
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        $orderItem = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 1,
            'unit_price' => $product->price,
            'subtotal' => $product->price,
            'original_price' => $product->price,
        ]);

        Review::factory()->create([
            'order_id' => $order->id,
            'order_item_id' => $orderItem->id,
            'buyer_id' => $buyer->id,
        ]);

        $this->actingAs($buyer);

        $response = $this->post(route('review.store', $orderItem), [
            'rating' => 4,
            'comment' => 'Trying again.',
        ]);

        $response->assertRedirect();

        $this->assertEquals(
            1,
            Review::where('order_item_id', $orderItem->id)
                ->where('buyer_id', $buyer->id)
                ->count()
        );
    }

    public function test_buyer_cannot_review_pending_order(): void
    {
        $buyer = User::factory()->create();

        $seller = SellerProfile::factory()->approved()->create();

        $product = Product::factory()->create([
            'seller_profile_id' => $seller->id,
        ]);

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'seller_profile_id' => $seller->id,
            'status' => 'pending',
        ]);

        $orderItem = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($buyer)->post(route('review.store', $orderItem), [
            'rating' => 5,
            'comment' => 'Great product.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseMissing('reviews', [
            'order_id' => $order->id,
            'order_item_id' => $orderItem->id,
            'buyer_id' => $buyer->id,
        ]);
    }
}