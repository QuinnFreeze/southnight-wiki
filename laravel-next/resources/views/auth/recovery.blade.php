@extends('layouts.app')
@section('title','找回账户 · 南夜维基')
@section('description','通过已认证邮箱找回 SouthNight.wiki 账户并重置密码。')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/auth.css?v=20260811-07') }}">
@endpush
@section('content')
<section class="page-hero page-hero-auth account-hero">
    <p class="eyebrow" data-zh="ACCOUNT · 账户" data-en="ACCOUNT">ACCOUNT · 账户</p>
    <h1 data-zh="找回账户" data-en="Recover account">找回账户</h1>
    <p data-zh="使用已认证邮箱找回账户并重置密码。" data-en="Recover your account and reset your password with a verified email.">使用已认证邮箱找回账户并重置密码。</p>
</section>

<section class="section auth-section account-section">
    <div class="recovery-shell">
        @if(session('status'))<div class="account-alert account-alert-success" role="status">{{ session('status') }}</div>@endif
        @if($errors->any())<div class="account-alert account-alert-error" role="alert">{{ $errors->first() }}</div>@endif

        @if($recoveryUser)
            <article class="auth-card recovery-card">
                <div class="auth-card-heading"><span class="auth-card-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5 5h14v14H5z"/><path d="m8 12 2.5 2.5L16 9"/></svg></span><span class="auth-card-copy"><strong data-zh="邮箱已认证" data-en="Email verified">邮箱已认证</strong><small>{{ $recoveryUser->email }}</small></span></div>
                <p class="account-card-description"><span data-lang-content="zh">已找到对应账户：{{ $recoveryUser->username }} · UID {{ $recoveryUser->uid }}。请设置新密码。</span><span data-lang-content="en" hidden>Account found: {{ $recoveryUser->username }} · UID {{ $recoveryUser->uid }}. Set a new password below.</span></p>
                <form method="post" action="{{ route('account.recovery.reset') }}" class="auth-form">
                    @csrf
                    <div class="auth-field"><label for="recovery-password" data-zh="新密码" data-en="New password">新密码</label><input id="recovery-password" name="password" type="password" minlength="10" required autocomplete="new-password"></div>
                    <div class="auth-field"><label for="recovery-password-confirmation" data-zh="确认新密码" data-en="Confirm new password">确认新密码</label><input id="recovery-password-confirmation" name="password_confirmation" type="password" minlength="10" required autocomplete="new-password"></div>
                    <x-turnstile action="recovery-reset" />
                    <button class="auth-submit" type="submit" data-zh="重置密码并登录" data-en="Reset password and sign in">重置密码并登录</button>
                </form>
            </article>
        @else
            <article class="auth-card recovery-card">
                <div class="auth-card-heading"><span class="auth-card-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3.5" y="5.5" width="17" height="13" rx="2"/><path d="m5 7 7 5 7-5"/></svg></span><span class="auth-card-copy"><strong data-zh="邮箱找回" data-en="Recover by email">邮箱找回</strong><small data-zh="验证码 10 分钟内有效" data-en="Code valid for 10 minutes">验证码 10 分钟内有效</small></span></div>
                <form method="post" action="{{ route('account.recovery.send') }}" class="auth-form">
                    @csrf
                    <div class="auth-field"><label for="recovery-email" data-zh="账户邮箱" data-en="Account email">账户邮箱</label><input id="recovery-email" name="email" type="email" value="{{ old('email', $recoveryEmail) }}" required autocomplete="email" data-zh-placeholder="输入注册时使用的邮箱" data-en-placeholder="Enter the email used to register" placeholder="输入注册时使用的邮箱"></div>
                    <x-turnstile action="recovery-send" />
                    <button class="auth-submit" type="submit" data-zh="发送找回验证码" data-en="Send recovery code">发送找回验证码</button>
                </form>
                @if($recoveryEmail)
                    <div class="auth-divider" aria-hidden="true"><span>VERIFY</span></div>
                    <form method="post" action="{{ route('account.recovery.verify') }}" class="auth-form">
                        @csrf
                        <input type="hidden" name="email" value="{{ $recoveryEmail }}">
                        <div class="auth-field"><label for="recovery-code" data-zh="6 位验证码" data-en="6-digit code">6 位验证码</label><input id="recovery-code" name="email_code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" autocomplete="one-time-code" required data-zh-placeholder="输入邮件中的验证码" data-en-placeholder="Enter the code from your email" placeholder="输入邮件中的验证码"></div>
                        <x-turnstile action="recovery-verify" appearance="interaction-only" />
                        <button class="auth-submit auth-submit-secondary" type="submit" data-zh="验证邮箱" data-en="Verify email">验证邮箱</button>
                    </form>
                @endif
            </article>
        @endif
        <p class="auth-switch recovery-switch"><a href="{{ auth()->check() ? route('account') : route('login') }}" data-zh="← 返回账户" data-en="← Back to account">← 返回账户</a></p>
    </div>
</section>
@endsection

@push('scripts')
<script>(()=>{const sync=lang=>document.querySelectorAll('[data-zh-placeholder][data-en-placeholder]').forEach(input=>{input.placeholder=input.dataset[lang==='en'?'enPlaceholder':'zhPlaceholder']});const snw=window.SNW;if(!snw)return;const setLanguage=snw.setLanguage;snw.setLanguage=lang=>{const result=setLanguage(lang);sync(lang);return result};sync(snw.getLanguage()||'zh')})();</script>
@endpush
