<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.email', 'budi@example.com');

        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
            'role' => 'customer',
        ]);
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'login@example.com',
            'password' => 'secret123',
        ]);

        $response->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonStructure(['data' => ['token', 'user']]);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'wrong@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'wrong@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertStatus(401)->assertJsonPath('status', 'error');
    }

    public function test_authenticated_user_can_view_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/auth/profile');

        $response->assertOk()->assertJsonPath('data.email', $user->email);
    }

    public function test_guest_cannot_view_profile(): void
    {
        $this->getJson('/api/v1/auth/profile')->assertStatus(401);
    }
}
