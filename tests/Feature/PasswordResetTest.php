<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_renders_with_forgot_password_and_register_links(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee(route('password.request'));
        $response->assertSee('Quên mật khẩu?');
        $response->assertSee(route('register'));
        $response->assertSee('Đăng ký ngay');
        $response->assertSee('hoặc');
    }

    public function test_register_screen_renders_with_login_link(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee(route('login'));
        $response->assertSee('Đăng nhập');
        $response->assertSee('hoặc');
    }

    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertSee('Quên mật khẩu');
        $response->assertSee('Gửi liên kết');
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@lunara.test',
        ]);

        $response = $this->post(route('password.email'), [
            'email' => 'customer@lunara.test',
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'customer@lunara.test',
        ]);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->get(route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Đặt lại mật khẩu');
        $response->assertSee($token);
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@lunara.test',
            'password' => Hash::make('old-password-123'),
        ]);

        $token = Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => 'customer@lunara.test',
            'password' => 'new-secure-password-456',
            'password_confirmation' => 'new-secure-password-456',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');

        $this->assertTrue(Hash::check('new-secure-password-456', $user->fresh()->password));

        // Verify can login with new password
        $this->post(route('login'), [
            'email' => 'customer@lunara.test',
            'password' => 'new-secure-password-456',
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_password_cannot_be_reset_with_invalid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@lunara.test',
            'password' => Hash::make('old-password-123'),
        ]);

        $response = $this->post(route('password.update'), [
            'token' => 'invalid-token',
            'email' => 'customer@lunara.test',
            'password' => 'new-secure-password-456',
            'password_confirmation' => 'new-secure-password-456',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertTrue(Hash::check('old-password-123', $user->fresh()->password));
    }
}
