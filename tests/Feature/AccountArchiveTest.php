<?php

namespace Tests\Feature;

use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountArchiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_account_archive_keeps_record_but_frees_email_and_phone(): void
    {
        $user = User::factory()->create([
            'email' => 'archive@example.com',
            'phone' => '0712345678',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user);

        $response = $this->delete(route('profile.destroy'), [
            'password' => 'password',
        ]);

        $response->assertRedirect('/');

        $user->refresh();

        $this->assertTrue((bool) $user->is_archived);
        $this->assertEquals('archive@example.com', $user->archived_email);
        $this->assertEquals('0712345678', $user->archived_phone);
        $this->assertNotEquals('archive@example.com', $user->email);
        $this->assertNotEquals('0712345678', $user->phone);

        $newUser = User::factory()->create([
            'email' => 'archive@example.com',
            'phone' => '0712345678',
        ]);

        $this->assertEquals('archive@example.com', $newUser->email);
        $this->assertEquals('0712345678', $newUser->phone);
    }

    public function test_archiving_seller_account_sets_seller_profile_to_archived(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $seller = SellerProfile::factory()->create([
            'user_id' => $user->id,
            'verification_status' => 'approved',
        ]);

        $this->actingAs($user);

        $this->delete(route('profile.destroy'), [
            'password' => 'password',
        ]);

        $seller->refresh();

        $this->assertEquals('archived', $seller->verification_status);
    }
}