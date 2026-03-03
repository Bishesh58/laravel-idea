<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest can register and is authenticated', function (): void {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);
});

test('guest can login with valid credentials', function (): void {
    $user = User::factory()->create([
        'password' => 'password123',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
});

test('guest cannot login with invalid credentials', function (): void {
    $user = User::factory()->create([
        'password' => 'password123',
    ]);

    $response = $this->from('/login')->post('/login', [
        'email' => $user->email,
        'password' => 'invalid-password',
    ]);

    $response->assertRedirect('/login');
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('authenticated user can logout', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});

test('guest cannot access logout endpoint', function (): void {
    $response = $this->post('/logout');

    $response->assertRedirect(route('login'));
});

test('authenticated user is redirected away from guest auth pages', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/login')->assertRedirect('/');
    $this->actingAs($user)->get('/register')->assertRedirect('/');
});
