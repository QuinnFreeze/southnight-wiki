@extends('layouts.app')
@section('title','注册 · 南夜维基')
@section('description','创建南夜维基账户，加入社区并使用账户功能。')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/auth.css?v=20260811-04') }}">
@endpush
@section('content')
<section class="page-hero page-hero-auth">
    <p class="eyebrow" data-zh="ACCOUNT · 账户" data-en="ACCOUNT">ACCOUNT · 账户</p>
    <h1 data-zh="创建账户" data-en="Create an account">创建账户</h1>
    <p data-zh="加入南夜维基，建立你的社区身份。" data-en="Join Southnight.wiki and create your community identity.">加入南夜维基，建立你的社区身份。</p>
</section>

<section class="section auth-section">
    <div class="auth-shell auth-shell-register">
        <div class="auth-intro">
            <p class="auth-kicker" data-zh="WELCOME · 加入南夜" data-en="WELCOME · JOIN SNW">WELCOME · 加入南夜</p>
            <h2 data-zh="从这里开始" data-en="Start here">从这里开始</h2>
            <p data-zh="创建账户后，你可以管理个人资料、参与社区，并在需要时访问南夜维基的账户功能。" data-en="Create an account to manage your profile, take part in the community and access Southnight account features.">创建账户后，你可以管理个人资料、参与社区，并在需要时访问南夜维基的账户功能。</p>
            <div class="auth-note">
                <span class="auth-note-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><path d="M3.5 20a5.5 5.5 0 0 1 11 0M16 8v6M13 11h6"/></svg></span>
                <span><strong data-zh="简单注册" data-en="Simple registration">简单注册</strong><small data-zh="只需要用户名、邮箱和一个至少 10 位的密码。" data-en="You only need a username, email and a password of at least 10 characters.">只需要用户名、邮箱和一个至少 10 位的密码。</small></span>
            </div>
        </div>

        <div class="auth-card auth-card-register">
            <div class="auth-card-heading">
                <span class="auth-card-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 20a5.5 5.5 0 0 1 11 0M16 8v6M13 11h6"/></svg></span>
                <span class="auth-card-copy"><strong data-zh="创建账户" data-en="Create account">创建账户</strong><small data-zh="填写信息，开始使用 Southnight" data-en="Enter your details to get started">填写信息，开始使用 Southnight</small></span>
            </div>

            @if($errors->any())
                <div class="auth-error" role="alert">
                    <span class="auth-error-mark" aria-hidden="true">!</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="post" action="{{ route('register.submit') }}" class="auth-form">
                @csrf
                <div class="auth-field">
                    <label for="username" data-zh="用户名" data-en="Username">用户名</label>
                    <input id="username" name="username" value="{{ old('username') }}" required minlength="3" maxlength="24" autocomplete="username" data-zh-placeholder="输入用户名" data-en-placeholder="Choose a username" placeholder="输入用户名">
                </div>
                <div class="auth-field">
                    <label for="email" data-zh="邮箱" data-en="Email">邮箱</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" data-zh-placeholder="输入邮箱地址" data-en-placeholder="Enter your email address" placeholder="输入邮箱地址">
                </div>
                <div class="auth-field">
                    <label for="password" data-zh="密码" data-en="Password">密码</label>
                    <input id="password" name="password" type="password" required minlength="10" autocomplete="new-password" data-zh-placeholder="设置密码" data-en-placeholder="Create a password" placeholder="设置密码">
                    <p class="auth-field-hint" data-zh="密码至少需要 10 位。" data-en="Use at least 10 characters.">密码至少需要 10 位。</p>
                </div>
                <div class="auth-field">
                    <label for="password_confirmation" data-zh="确认密码" data-en="Confirm password">确认密码</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required minlength="10" autocomplete="new-password" data-zh-placeholder="再次输入密码" data-en-placeholder="Repeat your password" placeholder="再次输入密码">
                </div>
                <button class="auth-submit" type="submit" data-zh="创建账户" data-en="Create account">创建账户</button>
            </form>

            <div class="auth-divider" aria-hidden="true"><span>SNW</span></div>
            <p class="auth-switch"><span data-zh="已经有账户？" data-en="Already have an account?">已经有账户？</span> <a href="{{ route('login') }}" data-zh="登录" data-en="Sign in">登录</a></p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>(()=>{const sync=lang=>document.querySelectorAll('[data-zh-placeholder][data-en-placeholder]').forEach(input=>{input.placeholder=input.dataset[lang==='en'?'enPlaceholder':'zhPlaceholder']});const snw=window.SNW;if(!snw)return;const setLanguage=snw.setLanguage;snw.setLanguage=lang=>{const result=setLanguage(lang);sync(lang);return result};sync(snw.getLanguage()||'zh')})();</script>
@endpush
