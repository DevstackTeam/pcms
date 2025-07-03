<?php

use App\Models\User;

test('successfully renders auth login page', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);

    $response->assertInertia(fn ($page) =>
        $page->component('Auth/Login')
    );
});

test('redirects user to dashboard page after login', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'remember' => false,
    ]);

    $response->assertRedirect(route('dashboard'));
});

test('redirects user to intended page after login', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));

    $response = $this->followingRedirects()->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertSee('Dashboard'); 
});

test('fails to login with invalid credentials', function () {
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => bcrypt('correct-password'), 
    ]);

    $response = $this->from(route('login'))->post('/login', [
        'email' => 'user@example.com',
        'password' => 'wrong-password', 
    ]);

    $response->assertRedirect(route('login')); 
    $response->assertSessionHasErrors(['email']); 
});
