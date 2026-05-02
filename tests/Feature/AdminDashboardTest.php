<?php

namespace Tests\Feature;

use App\Models\Dispute;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Role;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
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

    public function test_admin_dashboard_loads(): void
    {
        $admin = $this->createAdminUser();

        Order::factory()->completed()->create([
            'total_amount' => 1000,
        ]);

        Product::factory()->create();

        SellerProfile::factory()->pending()->create();

        Dispute::factory()->create([
            'status' => 'open',
        ]);

        Review::factory()->create();

        $this->actingAs($admin);

        $response = $this->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'is_super_admin' => false,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('admin.dashboard'));

        $response->assertForbidden();
    }
}