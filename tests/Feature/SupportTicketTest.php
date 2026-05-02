<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportTicketTest extends TestCase
{
    use RefreshDatabase;

    private function createAdminUser(): User
    {
        $admin = User::factory()->create([
            'is_super_admin' => true,
        ]);

        $role = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $admin->roles()->syncWithoutDetaching([$role->id]);

        return $admin;
    }

    public function test_authenticated_user_can_create_support_ticket(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('support.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Need help',
            'category' => 'order',
            'message' => 'I need help with my order.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('support_tickets', [
            'user_id' => $user->id,
            'email' => 'test@example.com',
            'subject' => 'Need help',
            'category' => 'order',
            'status' => 'open',
        ]);
    }

    public function test_admin_can_update_support_ticket_status(): void
    {
        $admin = $this->createAdminUser();

        $ticket = SupportTicket::factory()->create([
            'status' => 'open',
        ]);

        $this->actingAs($admin);

        $response = $this->patch(route('admin.support.updateStatus', $ticket), [
            'status' => 'closed',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('support_tickets', [
            'id' => $ticket->id,
            'status' => 'closed',
        ]);
    }

    public function test_non_admin_cannot_update_support_ticket_status(): void
    {
        $user = User::factory()->create();

        $ticket = SupportTicket::factory()->create([
            'status' => 'open',
        ]);

        $this->actingAs($user);

        $response = $this->patch(route('admin.support.updateStatus', $ticket), [
            'status' => 'closed',
        ]);

        $response->assertForbidden();
    }
}