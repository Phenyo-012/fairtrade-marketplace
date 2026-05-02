<?php

namespace Tests\Feature;

use App\Models\Dispute;
use App\Models\Order;
use App\Models\Role;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisputeTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_review_delivered_order_item(): void
    {
        $this->markTestSkipped('Needs final alignment with review submission route/request structure.');
    }

    public function test_user_cannot_open_dispute_for_someone_elses_order(): void
    {
        $buyer = User::factory()->create();
        $otherUser = User::factory()->create();

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'status' => 'delivered',
        ]);

        $this->actingAs($otherUser);

        $response = $this->post(route('disputes.store', $order), [
            'reason' => 'Trying to dispute another user order.',
        ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('disputes', [
            'order_id' => $order->id,
            'opened_by' => $otherUser->id,
        ]);
    }

    public function test_seller_can_respond_to_dispute(): void
    {
        $this->markTestSkipped('Needs final alignment with seller dispute authorization rules.');
    }
}