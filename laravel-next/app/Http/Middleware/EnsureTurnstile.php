<?php

namespace App\Http\Middleware;

use App\Rules\TurnstileToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureTurnstile
{
    public function handle(Request $request, Closure $next, string $action): Response
    {
        if (in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'], true)) {
            return $next($request);
        }

        $request->validate([
            'cf-turnstile-response' => ['bail', 'required', 'string', new TurnstileToken($action, $request)],
        ]);

        return $next($request);
    }
}
