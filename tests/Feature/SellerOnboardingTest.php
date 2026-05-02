<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellerOnboardingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_start_seller_setup(): void
    {
        Role::firstOrCreate(['name' => 'seller']);

        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('seller.store'));

        $response->assertRedirect(route('seller.onboarding'));

        $this->assertDatabaseHas('seller_profiles', [
            'user_id' => $user->id,
            'verification_status' => 'not_submitted',
            'onboarding_step' => 1,
            'kyc_submitted' => false,
        ]);

        $this->assertTrue($user->fresh()->hasRole('seller'));
    }

    public function test_user_cannot_create_duplicate_seller_profile(): void
    {
        Role::firstOrCreate(['name' => 'seller']);

        $user = User::factory()->create();

        SellerProfile::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('seller.store'));

        $response->assertRedirect(route('seller.store.edit'));

        $this->assertEquals(1, SellerProfile::where('user_id', $user->id)->count());
    }

    public function test_seller_can_save_store_details_step(): void
    {
        $user = User::factory()->create();

        SellerProfile::factory()->notSubmitted()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('seller.onboarding.store'), [
            'store_name' => 'Fair Test Store',
            'about' => 'This is a test store.',
            'pickup_address' => '123 Test Street',
            'pickup_city' => 'Johannesburg',
            'pickup_province' => 'Gauteng',
            'pickup_postal_code' => '2000',
            'pickup_country' => 'South Africa',
        ]);

        $response->assertRedirect(route('seller.onboarding'));

        $this->assertDatabaseHas('seller_profiles', [
            'user_id' => $user->id,
            'store_name' => 'Fair Test Store',
            'about' => 'This is a test store.',
            'pickup_province' => 'Gauteng',
            'onboarding_step' => 2,
        ]);
    }

    public function test_seller_can_submit_kyc_step(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        SellerProfile::factory()->notSubmitted()->create([
            'user_id' => $user->id,
            'onboarding_step' => 2,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('seller.onboarding.kyc'), [
            'id_document' => UploadedFile::fake()->image('id.jpg'),
            'selfie_document' => UploadedFile::fake()->image('selfie.jpg'),
        ]);

        $response->assertRedirect(route('seller.pending'));

        $seller = $user->fresh()->sellerProfile;

        $this->assertEquals('pending', $seller->verification_status);
        $this->assertTrue((bool) $seller->kyc_submitted);
        $this->assertEquals(3, $seller->onboarding_step);
        $this->assertNotNull($seller->id_document);
        $this->assertNotNull($seller->selfie_document);
    }
}