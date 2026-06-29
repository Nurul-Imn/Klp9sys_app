<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature tests dasar untuk memastikan aplikasi berjalan dengan benar.
 */
class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** Halaman utama bisa diakses tanpa autentikasi. */
    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** Halaman login bisa diakses oleh guest. */
    public function test_login_page_is_accessible_for_guest(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** Halaman register bisa diakses oleh guest. */
    public function test_register_page_is_accessible_for_guest(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /** Guest yang mengakses dashboard harus diredirect ke login. */
    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /** User yang sudah login tidak bisa mengakses halaman login (redirect ke dashboard). */
    public function test_authenticated_user_cannot_access_login_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect();
    }

    /** User yang sudah login tidak bisa mengakses halaman register. */
    public function test_authenticated_user_cannot_access_register_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect();
    }

    /** User yang sudah login bisa mengakses dashboard. */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    /** User yang sudah login bisa mengakses halaman profile. */
    public function test_authenticated_user_can_access_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
    }

    /** Guest yang mengakses profile harus diredirect ke login. */
    public function test_profile_page_requires_authentication(): void
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }
}
