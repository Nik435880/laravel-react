<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can visit settings', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $page = visit('/settings/profile');

    $page->assertNoSmoke();

    $page->assertNoAccessibilityIssues();

    $page->assertSee('Settings');

    $page->assertSee('Manage your profile and account settings');

    $page->assertSee('Profile');

    $page->assertSee('Password');

    $page->assertSee('Appearance');

    $page->assertSee('Profile information');

    $page->assertSee('Update your name and email address');

    $page->assertSee('Name');

    $page->assertSee($user->name);

    $page->assertSee('Email');

    $page->assertSee('Avatar');

    $page->assertSee('Save');

    $page->assertSee('Delete account');

    $page->assertSee('Delete your account and all of its resources');

    $page->assertSee('Warning');

    $page->assertSee('Please proceed with caution, this cannot be undone.');

    $page->assertSee('Delete account');

});

test('user can update profile', function (): void {

    $user = User::factory()->create(['name' => 'Original Name', 'email' => 'original@example.com']);

    $this->actingAs($user);

    $name = 'John Doe';

    $email = '2xt2a@example.com';

    $response = $this->patch('/settings/profile', [
        'name' => $name,
        'email' => $email,
    ]);

    $response->assertSessionHasNoErrors();

    $response->assertRedirect('/settings/profile');

    $user->refresh();

    expect($user->name)->toBe($name);

    expect($user->email)->toBe($email);

});

test('user can delete account', function (): void {

    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->delete('/settings/profile', [
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();

    $response->assertRedirect('/');

    $this->assertGuest();

    expect($user->fresh())->toBeNull();

});
