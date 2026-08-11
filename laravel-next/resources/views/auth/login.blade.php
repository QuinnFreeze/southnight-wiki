@extends('layouts.app')
@section('title','登录 · 南夜维基')
@section('description','登录南夜维基账户，访问个人资料与社区功能。')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/auth.css?v=20260811-06') }}">
@endpush
@section('content')
<section class="page-hero page-hero-auth">
    <p class="eyebrow" data-zh="ACCOUNT · 账户" data-en="ACCOUNT">ACCOUNT · 账户</p>
    <h1 data-zh="登录南夜维基" data-en="Sign in to Southnight.wiki">登录南夜维基</h1>
    <p data-zh="访问账户与公告管理功能。" data-en="Access your account and announcement management.">访问账户与公告管理功能。</p>
</section>

<section class="section auth-section">
    <div class="auth-shell">
        <div class="auth-intro">
            <p class="auth-kicker" data-zh="WELCOME · 欢迎回来" data-en="WELCOME · WELCOME BACK">WELCOME · 欢迎回来</p>
            <h2 data-zh="回到南夜维基" data-en="Return to Southnight">回到南夜维基</h2>
            <p data-zh="登录后可以查看账户资料、参与社区，并访问你拥有权限的公告管理功能。" data-en="Sign in to view your profile, take part in the community and access announcement tools available to you.">登录后可以查看账户资料、参与社区，并访问你拥有权限的公告管理功能。</p>
            <div class="auth-note">
                <span class="auth-note-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M7 10V8a5 5 0 0 1 10 0v2"/><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M12 14v3"/></svg></span>
                <span><strong data-zh="安全访问" data-en="Secure access">安全访问</strong><small data-zh="登录连接受到会话保护。" data-en="Your sign-in session is protected.">登录连接受到会话保护。</small></span>
            </div>
        </div>

        <div class="auth-card">
            <div class="auth-card-heading">
                <span class="auth-card-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.2"/><path d="M5.5 20a6.5 6.5 0 0 1 13 0M15.5 13.5l2 2 3.5-3.5"/></svg></span>
                <span class="auth-card-copy"><strong data-zh="账户登录" data-en="Account sign in">账户登录</strong><small data-zh="使用用户名或邮箱继续" data-en="Continue with your username or email">使用用户名或邮箱继续</small></span>
            </div>

            @if($errors->any())
                <div class="auth-error" role="alert">
                    <span class="auth-error-mark" aria-hidden="true">!</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="post" action="{{ route('login.submit') }}" class="auth-form">
                @csrf
                <div class="auth-field">
                    <label for="identity" data-zh="用户名或邮箱" data-en="Username or email">用户名或邮箱</label>
                    <input id="identity" name="identity" value="{{ old('identity') }}" required autocomplete="username" data-zh-placeholder="输入用户名或邮箱" data-en-placeholder="Enter username or email" placeholder="输入用户名或邮箱">
                </div>
                <div class="auth-field">
                    <label for="password" data-zh="密码" data-en="Password">密码</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" data-zh-placeholder="输入密码" data-en-placeholder="Enter password" placeholder="输入密码">
                </div>
                <x-turnstile action="login" />
                <button class="auth-submit" type="submit" data-zh="登录" data-en="Sign in">登录</button>
            </form>

            <div class="auth-divider" aria-hidden="true"><span>SNW</span></div>
            <p class="auth-switch"><span data-zh="还没有账户？" data-en="No account yet?">还没有账户？</span> <a href="{{ route('register') }}" data-zh="创建账户" data-en="Create an account">创建账户</a></p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>(()=>{const sync=lang=>document.querySelectorAll('[data-zh-placeholder][data-en-placeholder]').forEach(input=>{input.placeholder=input.dataset[lang==='en'?'enPlaceholder':'zhPlaceholder']});const snw=window.SNW;if(!snw)return;const setLanguage=snw.setLanguage;snw.setLanguage=lang=>{const result=setLanguage(lang);sync(lang);return result};sync(snw.getLanguage()||'zh')})();</script>
@endpush
