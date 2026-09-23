<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_cannot_set_admin_role_and_login_logout_work(): void
    {
        $credentials = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ];

        $this->post('/register', $credentials)->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertSame(User::ROLE_USER, User::firstOrFail()->role);

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->post('/login', [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])->assertRedirect('/');
        $this->assertAuthenticated();
    }
}
