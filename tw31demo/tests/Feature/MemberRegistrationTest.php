<?php

use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\User;
use App\Notifications\MemberRegisteredNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

test('member registration saves the member and sends notification', function () {
    Notification::fake();

    $user = User::factory()->create();

    $category = MembershipCategory::create([
        'name' => 'Regular',
        'description' => 'Regular membership category',
        'is_active' => true,
    ]);

    $level = MembershipLevel::create([
        'name' => 'Basic',
        'fee' => 500,
        'validity_months' => 12,
        'benefits' => 'Basic membership benefits',
        'is_active' => true,
    ]);

    $response = $this
        ->actingAs($user)
        ->post(route('members.store'), [
            'first_name' => 'Ana',
            'last_name' => 'Cruz',
            'email' => 'ana@example.test',
            'phone' => '09123456789',
            'address' => 'Manila',
            'latitude' => 14.5995,
            'longitude' => 120.9842,
            'birth_date' => '2000-01-01',
            'membership_category_id' => $category->id,
            'membership_level_id' => $level->id,
            'status' => 'Active',
            'registered_at' => '2026-11-12',
        ]);

    $response->assertRedirect(route('members.index'));

    $this->assertDatabaseHas('members', [
        'first_name' => 'Ana',
        'last_name' => 'Cruz',
        'email' => 'ana@example.test',
        'membership_category_id' => $category->id,
        'membership_level_id' => $level->id,
    ]);

    Notification::assertSentOnDemand(
        MemberRegisteredNotification::class
    );
});