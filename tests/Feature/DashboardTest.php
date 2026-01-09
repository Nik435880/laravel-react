<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can visit dashboard', function () {
    $user = User::factory()->create();

    $user2 = User::factory()->create();

    $this->actingAs($user);

    $page = visit('/dashboard');

    $page->assertNoSmoke();

    $page->assertNoAccessibilityIssues();

    $page->assertTitle('Dashboard - Laravel');

    $page->assertSee('Messenger');

    $page->assertSee('Chats');

    $page->assertVisible('#radix-_r_0_');

    $page->assertSee($user->name);

    $page->assertVisible('.lucide-panel-left');

    $page->assertSee('Name');

    $page->assertSee('Email');

    $page->assertSee('Action');

    $page->assertSee($user2->name);

    $page->assertSee($user2->email);

    $page->assertSee('Send Message');

});

test('user can toggle sidebar', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $page = visit('/dashboard');

    $page->press('.lucide-panel-left');

    $page->assertAttribute('#sidebar', 'data-state', 'collapsed');

    $page->press('.lucide-panel-left');

    $page->assertAttribute('#sidebar', 'data-state', 'expanded');

});

test('user can open dropdown', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $page = visit('/dashboard');

    $page->press('#radix-_r_0_');

    $page->assertAttribute('#radix-_r_0_', 'data-state', 'open');

    $page->assertSeeIn('radix-_r_1_', $user->name);

    $page->assertSeeIn('radix-_r_1_', 'Settings');

    $page->assertSeeIn('radix-_r_1_', 'Log out');

});
