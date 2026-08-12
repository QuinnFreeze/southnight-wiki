<?php

namespace App\Support;

use App\Models\EmailVerificationChallenge;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

final class EmailVerification
{
    public const PURPOSE_EMAIL = 'email_verification';
    public const PURPOSE_RECOVERY = 'account_recovery';
    public const TTL_MINUTES = 10;
    public const MAX_ATTEMPTS = 5;
    public const COOLDOWN_SECONDS = 60;

    /**
     * @return array{sent: bool, retry_after?: int}
     */
    public function issue(string $email, string $purpose): array
    {
        $email = self::normalizeEmail($email);
        $now = now();
        $recent = EmailVerificationChallenge::query()
            ->where('email', $email)
            ->where('purpose', $purpose)
            ->where('created_at', '>=', $now->copy()->subSeconds(self::COOLDOWN_SECONDS))
            ->latest('created_at')
            ->first();

        if ($recent) {
            return [
                'sent' => false,
                'retry_after' => max(1, self::COOLDOWN_SECONDS - $now->diffInSeconds($recent->created_at)),
            ];
        }

        EmailVerificationChallenge::query()
            ->where('email', $email)
            ->where('purpose', $purpose)
            ->whereNull('consumed_at')
            ->delete();

        $code = (string) random_int(100000, 999999);
        $challenge = EmailVerificationChallenge::query()->create([
            'email' => $email,
            'purpose' => $purpose,
            'code_hash' => $this->hashCode($email, $purpose, $code),
            'expires_at' => $now->copy()->addMinutes(self::TTL_MINUTES),
            'attempts' => 0,
        ]);

        try {
            $this->send($email, $code, $purpose);
        } catch (Throwable $exception) {
            $challenge->delete();
            Log::error('Email verification delivery failed.', [
                'purpose' => $purpose,
                'exception' => $exception::class,
            ]);
            throw new RuntimeException('邮件暂时无法发送，请稍后再试。', 0, $exception);
        }

        return ['sent' => true];
    }

    public function verify(string $email, string $purpose, string $code): bool
    {
        $email = self::normalizeEmail($email);
        $challenge = EmailVerificationChallenge::query()
            ->where('email', $email)
            ->where('purpose', $purpose)
            ->whereNull('consumed_at')
            ->latest('created_at')
            ->first();

        if (!$challenge || $challenge->expires_at->isPast() || $challenge->attempts >= self::MAX_ATTEMPTS) {
            return false;
        }

        $expected = $this->hashCode($email, $purpose, $code);
        if (!hash_equals($challenge->code_hash, $expected)) {
            $challenge->increment('attempts');
            return false;
        }

        $challenge->forceFill(['consumed_at' => now()])->save();
        return true;
    }

    public static function normalizeEmail(string $email): string
    {
        return mb_strtolower(trim($email));
    }

    private function hashCode(string $email, string $purpose, string $code): string
    {
        return hash_hmac('sha256', $purpose.'|'.$email.'|'.$code, (string) config('app.key'));
    }

    private function send(string $email, string $code, string $purpose): void
    {
        $apiKey = (string) config('services.resend.key');
        $fromAddress = (string) config('mail.from.address');
        $fromName = (string) config('mail.from.name');

        if ($apiKey === '' || $fromAddress === '') {
            throw new RuntimeException('Resend 邮件服务未配置。');
        }

        $recovery = $purpose === self::PURPOSE_RECOVERY;
        $subject = $recovery ? 'SouthNight 账号找回验证码' : 'SouthNight 邮箱认证验证码';
        $heading = $recovery ? '账号找回验证码' : '邮箱认证验证码';
        $safeCode = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
        $html = '<!doctype html><html><body style="margin:0;background:#050505;color:#ededeb;font-family:-apple-system,BlinkMacSystemFont,Segoe UI,sans-serif;padding:32px">'
            .'<div style="max-width:520px;margin:auto;border:1px solid #292929;border-radius:16px;padding:28px;background:#101010">'
            .'<p style="color:#888;font-size:11px;letter-spacing:.16em">SOUTHNIGHT.WIKI</p>'
            .'<h1 style="font-size:24px;font-weight:500">'.$heading.'</h1>'
            .'<p style="color:#aaa;line-height:1.7">你正在操作 SouthNight.wiki 的账户功能。验证码为：</p>'
            .'<div style="margin:24px 0;padding:18px;text-align:center;border:1px solid #444;border-radius:12px;background:#050505;font-size:32px;letter-spacing:.3em;font-weight:700">'.$safeCode.'</div>'
            .'<p style="color:#888;font-size:13px;line-height:1.7">验证码 10 分钟内有效，仅可使用一次。如果不是你本人操作，请忽略此邮件。</p>'
            .'<p style="color:#777;font-size:12px;margin-top:28px">小秋易 · SouthNight.wiki</p>'
            .'</div></body></html>';
        $text = $heading."\n\n你正在操作 SouthNight.wiki 的账户功能。验证码：$code\n\n验证码 10 分钟内有效，仅可使用一次。如果不是你本人操作，请忽略此邮件。\n\n小秋易 · SouthNight.wiki";

        $response = Http::withToken($apiKey)
            ->withHeaders(['Idempotency-Key' => (string) Str::uuid()])
            ->asJson()
            ->acceptJson()
            ->connectTimeout(5)
            ->timeout(15)
            ->retry(2, 250, throw: false)
            ->post('https://api.resend.com/emails', [
                'from' => $fromName !== '' ? $fromName.' <'.$fromAddress.'>' : $fromAddress,
                'to' => [$email],
                'subject' => $subject,
                'html' => $html,
                'text' => $text,
            ]);

        if (!$response->successful()) {
            Log::warning('Resend rejected an email verification message.', [
                'purpose' => $purpose,
                'status' => $response->status(),
            ]);
            throw new RuntimeException('邮件服务拒绝了发送请求。');
        }
    }
}
