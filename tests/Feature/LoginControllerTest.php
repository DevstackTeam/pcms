<?php

use App\Models\User;

test('successfully renders auth login page', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);

    $response->assertInertia(fn ($page) =>
        $page->component('Auth/Login')
    );
});

test('redirects user to dashboard after login', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'remember' => false,
    ]);

    $response->assertRedirect(route('dashboard'));
});
