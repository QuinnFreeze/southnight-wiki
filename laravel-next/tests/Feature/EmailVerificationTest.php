<?php

namespace Tests\Feature;

use App\Http\Middleware\EnsureTurnstile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([ValidateCsrfToken::class, EnsureTurnstile::class]);
        config([
            'app.key' => 'base64:'.base64_encode(random_bytes(32)),
            'services.resend.key' => 'test-resend-key',
            'mail.from.address' => 'xiaoqiuyi@qiulan.wiki',
            'mail.from.name' => '小秋易',
        ]);
    }

    public function test_verified_email_can_authorize_password_change(): void
    {
        $user = $this->user('verified-owner');
        $code = null;
        $this->fakeResend($code);

        $this->actingAs($user)->from('/account')->post('/account/email/send')->assertRedirect('/account');
        $this->assertNotNull($code);

        $this->actingAs($user)->post('/account/email/verify', [
            'email_code' => $code,
        ])->assertRedirect('/account')->assertSessionHas('status');

        $this->actingAs($user)->put('/account/password/email', [
            'password' => 'email-updated-password',
            'password_confirmation' => 'email-updated-password',
        ])->assertRedirect('/account');

        $this->assertTrue($user->fresh()->verifyPassword('email-updated-password'));
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_recovery_code_can_reset_password_and_sign_in(): void
    {
        $user = $this->user('recovery-owner', verified: true);
        $code = null;
        $this->fakeResend($code);

        $this->post('/account/recovery/code', [
            'email' => $user->email,
        ])->assertRedirect('/account/recovery');
        $this->assertNotNull($code);

        $this->post('/account/recovery/verify', [
            'email' => $user->email,
            'email_code' => $code,
        ])->assertRedirect('/account/recovery');

        $this->post('/account/recovery/password', [
            'password' => 'recovered-password',
            'password_confirmation' => 'recovered-password',
        ])->assertRedirect('/account');
        $this->assertAuthenticatedAs($user);

        $this->assertTrue($user->fresh()->verifyPassword('recovered-password'));
    }

    public function test_wrong_code_is_limited_and_correct_code_cannot_be_reused(): void
    {
        $user = $this->user('limited-owner');
        $code = null;
        $this->fakeResend($code);

        $this->actingAs($user)->post('/account/email/send');
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->actingAs($user)->post('/account/email/verify', ['email_code' => '000000'])
                ->assertSessionHasErrors('email_code');
        }

        $this->actingAs($user)->post('/account/email/verify', ['email_code' => $code])
            ->assertSessionHasErrors('email_code');
        $this->assertDatabaseHas('email_verification_challenges', [
            'email' => $user->email,
            'attempts' => 5,
            'consumed_at' => null,
        ]);
    }

    private function fakeResend(?string &$code): void
    {
        Http::fake([
            'https://api.resend.com/emails' => function (ClientRequest $request) use (&$code) {
                preg_match('/\\b([0-9]{6})\\b/', (string) ($request->data()['text'] ?? ''), $matches);
                $code = $matches[1] ?? null;
                return Http::response(['id' => 'test-email-id'], 200);
            },
        ]);
    }

    private function user(string $username, bool $verified = false): User
    {
        return User::createWithUniqueUid([
            'name' => $username,
            'username' => $username,
            'email' => $username.'@example.com',
            'password' => password_hash('password-for-tests', PASSWORD_DEFAULT),
            'email_verified_at' => $verified ? now() : null,
            'role' => 'user',
            'status' => 'active',
        ]);
    }
}
