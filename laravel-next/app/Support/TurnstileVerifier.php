<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final class TurnstileVerifier
{
    public function verify(?string $token, ?string $remoteIp, string $expectedAction): bool
    {
        $secret = (string) config('services.turnstile.secret_key');
        $endpoint = (string) config('services.turnstile.verify_url');

        if ($token === null || $token === '' || strlen($token) > 2048 || $secret === '' || $endpoint === '') {
            Log::warning('Turnstile verification unavailable or invalid input.', [
                'action' => $expectedAction,
                'configured' => $secret !== '' && $endpoint !== '',
            ]);

            return false;
        }

        try {
            $response = Http::asJson()
                ->acceptJson()
                ->connectTimeout(3)
                ->timeout(8)
                ->retry(2, 250, throw: false)
                ->post($endpoint, [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $remoteIp,
                    'idempotency_key' => (string) Str::uuid(),
                ]);
        } catch (\Throwable $exception) {
            Log::warning('Turnstile verification request failed.', [
                'action' => $expectedAction,
                'exception' => $exception::class,
            ]);

            return false;
        }

        $payload = $response->json();
        $success = $response->successful() && is_array($payload) && ($payload['success'] ?? false) === true;

        if (!$success) {
            Log::notice('Turnstile rejected a request.', [
                'action' => $expectedAction,
                'status' => $response->status(),
                'errors' => is_array($payload) ? ($payload['error-codes'] ?? []) : [],
            ]);

            return false;
        }

        if (($payload['action'] ?? null) !== $expectedAction) {
            Log::warning('Turnstile action mismatch.', [
                'expected' => $expectedAction,
                'received' => $payload['action'] ?? null,
            ]);

            return false;
        }

        $allowedHostnames = config('services.turnstile.allowed_hostnames', []);
        if ($allowedHostnames !== [] && !in_array($payload['hostname'] ?? null, $allowedHostnames, true)) {
            Log::warning('Turnstile hostname mismatch.', [
                'expected' => $allowedHostnames,
                'received' => $payload['hostname'] ?? null,
            ]);

            return false;
        }

        return true;
    }
}
