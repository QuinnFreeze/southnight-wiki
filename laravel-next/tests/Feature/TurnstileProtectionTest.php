<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TurnstileProtectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_web_login_requires_turnstile(): void
    {
        $response = $this->from('/login')->post('/login', [
            'identity' => 'someone',
            'password' => 'password',
        ]);

        $response->assertRedirect('/login')->assertSessionHasErrors('cf-turnstile-response');
    }

    public function test_web_register_requires_turnstile(): void
    {
        $response = $this->from('/register')->post('/register', [
            'username' => 'turnstile-user',
            'email' => 'turnstile@example.com',
            'password' => 'password-for-tests',
            'password_confirmation' => 'password-for-tests',
        ]);

        $response->assertRedirect('/register')->assertSessionHasErrors('cf-turnstile-response');
    }

    public function test_password_update_requires_turnstile(): void
    {
        $user = $this->user('password-owner');

        $response = $this->actingAs($user)->from('/account')->put('/account/password', [
            'current_password' => 'password-for-tests',
            'password' => 'updated-password-for-tests',
            'password_confirmation' => 'updated-password-for-tests',
        ]);

        $response->assertRedirect('/account')->assertSessionHasErrors('cf-turnstile-response');
    }

    public function test_admin_user_update_requires_turnstile(): void
    {
        $admin = $this->user('turnstile-admin', 'admin');
        $target = $this->user('turnstile-target');

        $response = $this->actingAs($admin)->from('/admin/users')->put('/admin/users/'.$target->id, [
            'role' => 'user',
            'status' => 'blocked',
        ]);

        $response->assertRedirect('/admin/users')->assertSessionHasErrors('cf-turnstile-response');
    }

    public function test_api_login_requires_turnstile(): void
    {
        $this->postJson('/api/auth/login', [
            'identity' => 'someone',
            'password' => 'password',
        ])->assertStatus(422)->assertJsonValidationErrors('cf-turnstile-response');
    }

    public function test_turnstile_rejects_a_token_for_the_wrong_action(): void
    {
        config([
            'services.turnstile.secret_key' => 'test-secret',
            'services.turnstile.allowed_hostnames' => ['southnight.uk'],
        ]);
        Http::fake(['https://challenges.cloudflare.com/*' => Http::response([
            'success' => true,
            'action' => 'register',
            'hostname' => 'southnight.uk',
        ], 200)]);

        $response = $this->from('/login')->post('/login', [
            'identity' => 'someone',
            'password' => 'password',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertRedirect('/login')->assertSessionHasErrors('cf-turnstile-response');
    }

    public function test_turnstile_rejects_a_token_for_the_wrong_hostname(): void
    {
        config([
            'services.turnstile.secret_key' => 'test-secret',
            'services.turnstile.allowed_hostnames' => ['southnight.uk'],
        ]);
        Http::fake(['https://challenges.cloudflare.com/*' => Http::response([
            'success' => true,
            'action' => 'login',
            'hostname' => 'attacker.example',
        ], 200)]);

        $response = $this->from('/login')->post('/login', [
            'identity' => 'someone',
            'password' => 'password',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertRedirect('/login')->assertSessionHasErrors('cf-turnstile-response');
    }

    public function test_valid_turnstile_allows_login(): void
    {
        config([
            'services.turnstile.secret_key' => 'test-secret',
            'services.turnstile.allowed_hostnames' => ['southnight.uk'],
        ]);
        Http::fake(['https://challenges.cloudflare.com/*' => Http::response([
            'success' => true,
            'action' => 'login',
            'hostname' => 'southnight.uk',
        ], 200)]);

        User::createWithUniqueUid([
            'name' => 'turnstile-login',
            'username' => 'turnstile-login',
            'email' => 'turnstile-login@example.com',
            'password' => password_hash('password-for-tests', PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'active',
        ]);

        $response = $this->post('/login', [
            'identity' => 'turnstile-login',
            'password' => 'password-for-tests',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertRedirect(route('account'));
        Http::assertSent(fn ($request) => $request['secret'] === 'test-secret' && $request['response'] === 'test-token');
    }

    public function test_valid_turnstile_allows_registration(): void
    {
        config([
            'services.turnstile.secret_key' => 'test-secret',
            'services.turnstile.allowed_hostnames' => ['southnight.uk'],
        ]);
        Http::fake(['https://challenges.cloudflare.com/*' => Http::response([
            'success' => true,
            'action' => 'register',
            'hostname' => 'southnight.uk',
        ], 200)]);

        $response = $this->post('/register', [
            'username' => 'turnstile-register',
            'email' => 'turnstile-register@example.com',
            'password' => 'password-for-tests',
            'password_confirmation' => 'password-for-tests',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertRedirect(route('account'));
        $this->assertDatabaseHas('users', ['username' => 'turnstile-register']);
    }

    private function user(string $username, string $role = 'user'): User
    {
        return User::createWithUniqueUid([
            'name' => $username,
            'username' => $username,
            'email' => $username.'@example.com',
            'password' => password_hash('password-for-tests', PASSWORD_DEFAULT),
            'role' => $role,
            'status' => 'active',
        ]);
    }
}
