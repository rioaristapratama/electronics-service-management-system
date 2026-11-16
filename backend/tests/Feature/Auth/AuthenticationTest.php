<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(bool $isActive = true): User
    {
        $role = Role::create([
            'name' => 'Technician',
            'description' => 'Role untuk pengujian',
        ]);

        return User::factory()->create([
            'role_id' => $role->id,
            'is_active' => $isActive,
        ]);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = $this->createUser();

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = $this->createUser();

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = $this->createUser(false);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post(route('logout'));

        $this->assertGuest();

        $response->assertRedirect(route('login'));
    }

    public function test_inactive_user_is_logged_out_when_accessing_dashboard(): void
    {
        $user = $this->createUser();

        $this->actingAs($user);

        // Simulasikan akun dinonaktifkan oleh administrator.
        $user->is_active = false;
        $user->save();

        $response = $this->get(route('dashboard'));

        $this->assertGuest();

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
    }

    public function test_login_is_rate_limited_after_five_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login.store'), [
                'email' => 'unknown@example.com',
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->post(route('login.store'), [
            'email' => 'unknown@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertTooManyRequests();
    }
}
