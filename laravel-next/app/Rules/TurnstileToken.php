<?php

namespace App\Rules;

use App\Support\TurnstileVerifier;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

final class TurnstileToken implements ValidationRule
{
    public function __construct(
        private readonly string $action,
        private readonly Request $request,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!(new TurnstileVerifier())->verify(
            is_string($value) ? $value : null,
            $this->request->header('CF-Connecting-IP') ?: $this->request->ip(),
            $this->action,
        )) {
            $fail('人机验证未通过，请重新完成验证后再试。');
        }
    }
}
