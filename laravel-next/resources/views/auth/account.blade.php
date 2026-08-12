@extends('layouts.app')
@section('title','账户管理 · 南夜维基')
@section('description','管理 SouthNight.wiki 账户资料、邮箱认证和密码。')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/auth.css?v=20260811-07') }}">
@endpush
@section('content')
<section class="page-hero page-hero-auth account-hero">
    <p class="eyebrow" data-zh="ACCOUNT · 账户" data-en="ACCOUNT">ACCOUNT · 账户</p>
    <h1 data-zh="账户管理" data-en="Account management">账户管理</h1>
    <p>{{ $user->username }} · UID {{ $user->uid }} · {{ $user->isAdmin() ? '管理员' : '用户' }}</p>
</section>

<section class="section auth-section account-section">
    <div class="account-shell">
        @if(session('status'))
            <div class="account-alert account-alert-success" role="status">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="account-alert account-alert-error" role="alert">{{ $errors->first() }}</div>
        @endif

        <div class="account-grid">
            <article class="auth-card account-card account-profile-card">
                <div class="auth-card-heading">
                    <span class="auth-card-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.2"/><path d="M5.5 20a6.5 6.5 0 0 1 13 0"/></svg></span>
                    <span class="auth-card-copy"><strong data-zh="个人资料" data-en="Profile">个人资料</strong><small data-zh="管理用户名之外的账户信息" data-en="Manage account details beyond your username">管理用户名之外的账户信息</small></span>
                </div>
                <form method="post" action="{{ route('account.profile') }}" class="auth-form">
                    @csrf @method('PUT')
                    <div class="auth-field">
                        <label for="email" data-zh="邮箱地址" data-en="Email address">邮箱地址</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                        <p class="auth-field-hint" data-zh="修改邮箱需要输入当前密码，并需要重新认证。" data-en="Changing your email requires your current password and a new verification.">修改邮箱需要输入当前密码，并需要重新认证。</p>
                    </div>
                    <div class="auth-field">
                        <label for="profile-current-password" data-zh="当前密码（修改邮箱时填写）" data-en="Current password (required to change email)">当前密码（修改邮箱时填写）</label>
                        <input id="profile-current-password" name="current_password" type="password" autocomplete="current-password" data-zh-placeholder="修改邮箱时填写" data-en-placeholder="Required to change email" placeholder="修改邮箱时填写">
                    </div>
                    <x-turnstile action="account-profile" appearance="interaction-only" />
                    <button class="auth-submit" type="submit" data-zh="保存资料" data-en="Save profile">保存资料</button>
                </form>
            </article>

            <article class="auth-card account-card account-email-card">
                <div class="auth-card-heading">
                    <span class="auth-card-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3.5" y="5.5" width="17" height="13" rx="2"/><path d="m5 7 7 5 7-5"/></svg></span>
                    <span class="auth-card-copy"><strong data-zh="邮箱认证" data-en="Email verification">邮箱认证</strong><small>{{ $user->email }}</small></span>
                    <span class="account-status {{ $user->email_verified_at ? 'is-verified' : 'is-pending' }}">{{ $user->email_verified_at ? '已认证' : '待认证' }}</span>
                </div>
                <p class="account-card-description" data-zh="认证邮箱后，可以用邮箱认证修改密码，也可以在忘记登录信息时找回账户。" data-en="Verify your email to change your password by email and recover your account when you cannot sign in.">认证邮箱后，可以用邮箱认证修改密码，也可以在忘记登录信息时找回账户。</p>
                <div class="account-code-actions">
                    <form method="post" action="{{ route('account.email.send') }}" class="auth-form account-inline-form">
                        @csrf
                        <x-turnstile action="email-verification-send" appearance="interaction-only" />
                        <button class="auth-submit auth-submit-secondary" type="submit" data-zh="发送验证码" data-en="Send code">发送验证码</button>
                    </form>
                    <form method="post" action="{{ route('account.email.verify') }}" class="auth-form">
                        @csrf
                        <div class="auth-field">
                            <label for="email-code" data-zh="6 位验证码" data-en="6-digit code">6 位验证码</label>
                            <input id="email-code" name="email_code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" autocomplete="one-time-code" required data-zh-placeholder="输入邮件中的验证码" data-en-placeholder="Enter the code from your email" placeholder="输入邮件中的验证码">
                        </div>
                        <x-turnstile action="email-verification-verify" appearance="interaction-only" />
                        <button class="auth-submit" type="submit" data-zh="认证邮箱" data-en="Verify email">认证邮箱</button>
                    </form>
                </div>
            </article>

            <article class="auth-card account-card account-password-card">
                <div class="auth-card-heading">
                    <span class="auth-card-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M7 10V8a5 5 0 0 1 10 0v2M12 14v3"/></svg></span>
                    <span class="auth-card-copy"><strong data-zh="修改密码" data-en="Change password">修改密码</strong><small data-zh="使用当前密码，或使用已认证邮箱" data-en="Use your current password or verified email">使用当前密码，或使用已认证邮箱</small></span>
                </div>
                <form method="post" action="{{ route('account.password') }}" class="auth-form account-password-form">
                    @csrf @method('PUT')
                    <div class="auth-field">
                        <label for="current-password" data-zh="当前密码" data-en="Current password">当前密码</label>
                        <input id="current-password" name="current_password" type="password" required autocomplete="current-password">
                    </div>
                    <div class="auth-field">
                        <label for="password" data-zh="新密码" data-en="New password">新密码</label>
                        <input id="password" name="password" type="password" minlength="10" required autocomplete="new-password">
                    </div>
                    <div class="auth-field">
                        <label for="password-confirmation" data-zh="确认新密码" data-en="Confirm new password">确认新密码</label>
                        <input id="password-confirmation" name="password_confirmation" type="password" minlength="10" required autocomplete="new-password">
                    </div>
                    <x-turnstile action="account-password" appearance="interaction-only" />
                    <button class="auth-submit" type="submit" data-zh="使用当前密码更新" data-en="Update with current password">使用当前密码更新</button>
                </form>

                <div class="account-email-password">
                    <div class="account-subheading"><strong data-zh="使用邮箱认证修改" data-en="Change with email verification">使用邮箱认证修改</strong><span class="account-status {{ $emailPasswordAvailable ? 'is-verified' : 'is-pending' }}">{{ $emailPasswordAvailable ? '已授权' : '需认证' }}</span></div>
                    @if($emailPasswordAvailable)
                        <form method="post" action="{{ route('account.password.email') }}" class="auth-form">
                            @csrf @method('PUT')
                            <div class="auth-field">
                                <label for="email-password" data-zh="新密码" data-en="New password">新密码</label>
                                <input id="email-password" name="password" type="password" minlength="10" required autocomplete="new-password">
                            </div>
                            <div class="auth-field">
                                <label for="email-password-confirmation" data-zh="确认新密码" data-en="Confirm new password">确认新密码</label>
                                <input id="email-password-confirmation" name="password_confirmation" type="password" minlength="10" required autocomplete="new-password">
                            </div>
                            <x-turnstile action="account-password-email" appearance="interaction-only" />
                            <button class="auth-submit auth-submit-secondary" type="submit" data-zh="使用邮箱认证更新" data-en="Update with email verification">使用邮箱认证更新</button>
                        </form>
                    @else
                        <p class="account-card-description" data-zh="请在上方发送并输入邮箱验证码，认证成功后本区域会开放。" data-en="Send and enter the email code above. This section opens after verification.">请在上方发送并输入邮箱验证码，认证成功后本区域会开放。</p>
                    @endif
                </div>
            </article>
        </div>

        <div class="account-links">
            <a href="{{ route('account.recovery') }}" data-zh="忘记密码或找回账户 →" data-en="Forgot password or recover account →">忘记密码或找回账户 →</a>
            <a href="{{ route('announcements.index') }}" data-zh="查看公告 →" data-en="View announcements →">查看公告 →</a>
            @if($user->isAdmin())<a href="{{ route('admin.index') }}" data-zh="进入管理后台 →" data-en="Open admin dashboard →">进入管理后台 →</a>@endif
        </div>
        <form method="post" action="{{ route('logout') }}" class="account-logout-form">@csrf<button class="auth-submit auth-submit-danger" type="submit" data-zh="退出登录" data-en="Sign out">退出登录</button></form>
    </div>
</section>
@endsection

@push('scripts')
<script>(()=>{const sync=lang=>document.querySelectorAll('[data-zh-placeholder][data-en-placeholder]').forEach(input=>{input.placeholder=input.dataset[lang==='en'?'enPlaceholder':'zhPlaceholder']});const snw=window.SNW;if(!snw)return;const setLanguage=snw.setLanguage;snw.setLanguage=lang=>{const result=setLanguage(lang);sync(lang);return result};sync(snw.getLanguage()||'zh')})();</script>
@endpush
