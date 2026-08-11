@extends('layouts.app')
@section('title','设置 · 南夜维基')
@section('content')
<section class="page-hero page-hero-settings">
    <p class="eyebrow" data-zh="SETTINGS · 设置" data-en="SETTINGS">SETTINGS · 设置</p>
    <h1 data-zh="设置" data-en="Settings">设置</h1>
    <p data-zh="管理账户、偏好与网站信息。" data-en="Manage your account, preferences and website information.">管理账户、偏好与网站信息。</p>
</section>

<section class="section settings-page">
    @auth
    <a class="settings-account-card" href="{{ route('account') }}" aria-label="进入账户详情">
        <span class="settings-avatar" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(auth()->user()->username, 0, 1)) }}</span>
        <span class="settings-account-copy">
            <strong>{{ auth()->user()->username }}</strong>
            <span>{{ auth()->user()->email }}</span>
            <small>UID {{ auth()->user()->id }}</small>
        </span>
        <span class="settings-login-state is-signed-in"><i></i><span data-zh="已登录" data-en="Signed in">已登录</span></span>
        <span class="settings-chevron" aria-hidden="true">›</span>
    </a>
    @else
    <a class="settings-account-card" href="{{ route('login') }}" aria-label="登录账户">
        <span class="settings-avatar settings-avatar-guest" aria-hidden="true">SNW</span>
        <span class="settings-account-copy">
            <strong data-zh="访客" data-en="Guest">访客</strong>
            <span data-zh="登录后显示邮箱与账户资料" data-en="Sign in to view email and account details">登录后显示邮箱与账户资料</span>
            <small>UID —</small>
        </span>
        <span class="settings-login-state"><i></i><span data-zh="未登录" data-en="Signed out">未登录</span></span>
        <span class="settings-chevron" aria-hidden="true">›</span>
    </a>
    @endauth

    <div class="settings-list-section">
        <p class="settings-section-title" data-zh="账户与偏好" data-en="Account & Preferences">账户与偏好</p>
        <div class="settings-list">
            <a class="settings-item" href="@auth{{ route('account') }}@else{{ route('login') }}@endauth">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.5"/><path d="M5.5 20c.7-4 2.8-6 6.5-6s5.8 2 6.5 6"/><path d="M18 4.5l2 1v2.2c0 1.8-.8 3.3-2 4.1-1.2-.8-2-2.3-2-4.1V5.5l2-1Z"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="账户与安全" data-en="Account & Security">账户与安全</strong><small data-zh="资料、邮箱与密码" data-en="Profile, email and password">资料、邮箱与密码</small></span>
                <span class="settings-chevron" aria-hidden="true">›</span>
            </a>
            <div class="settings-item settings-language-item">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M3.5 12h17M12 3c2.5 2.5 3.5 5.5 3.5 9s-1 6.5-3.5 9c-2.5-2.5-3.5-5.5-3.5-9S9.5 5.5 12 3Z"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="语言" data-en="Language">语言</strong><small id="settings-language-label">简体中文</small></span>
                <span class="settings-language-control" aria-label="Language">
                    <button type="button" data-lang-choice="zh">中</button>
                    <button type="button" data-lang-choice="en">EN</button>
                </span>
            </div>
            <div class="settings-item">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M20 15.5A8.5 8.5 0 0 1 8.5 4 8.5 8.5 0 1 0 20 15.5Z"/><path d="M16.8 5.2h.01M19.5 8h.01"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="主题模式" data-en="Theme">主题模式</strong><small data-zh="黑色星空" data-en="Dark starfield">黑色星空</small></span>
                <span class="settings-value" data-zh="深色" data-en="Dark">深色</span>
            </div>
        </div>
    </div>

    <div class="settings-list-section">
        <p class="settings-section-title" data-zh="通知、隐私与数据" data-en="Notifications, Privacy & Data">通知、隐私与数据</p>
        <div class="settings-list">
            <a class="settings-item" href="{{ route('announcements.index') }}">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M6.5 9a5.5 5.5 0 0 1 11 0v4l2 3H4.5l2-3V9Z"/><path d="M9.5 19h5"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="通知设置" data-en="Notifications">通知设置</strong><small data-zh="通过公告中心获取更新" data-en="Updates are provided through Notices">通过公告中心获取更新</small></span>
                <span class="settings-value" data-zh="公告" data-en="Notices">公告</span><span class="settings-chevron" aria-hidden="true">›</span>
            </a>
            <a class="settings-item" href="{{ route('privacy') }}">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 3 20 6v5c0 5-3.2 8.3-8 10-4.8-1.7-8-5-8-10V6l8-3Z"/><path d="m8.5 12 2.2 2.2 4.8-5"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="隐私设置" data-en="Privacy Settings">隐私设置</strong><small data-zh="数据权利与隐私联系" data-en="Data rights and privacy contact">数据权利与隐私联系</small></span>
                <span class="settings-chevron" aria-hidden="true">›</span>
            </a>
            <a class="settings-item" href="{{ route('privacy') }}">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><ellipse cx="12" cy="6" rx="7.5" ry="3"/><path d="M4.5 6v6c0 1.7 3.4 3 7.5 3s7.5-1.3 7.5-3V6M4.5 12v6c0 1.7 3.4 3 7.5 3s7.5-1.3 7.5-3v-6"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="数据与 Cookie" data-en="Data & Cookies">数据与 Cookie</strong><small data-zh="必要技术与本地存储说明" data-en="Essential technologies and local storage">必要技术与本地存储说明</small></span>
                <span class="settings-chevron" aria-hidden="true">›</span>
            </a>
        </div>
    </div>

    <div class="settings-list-section">
        <p class="settings-section-title" data-zh="政策与关于" data-en="Policies & About">政策与关于</p>
        <div class="settings-list">
            <a class="settings-item" href="{{ route('privacy') }}">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M6 3h9l3 3v15H6V3Z"/><path d="M14 3v4h4M9 11h6M9 15h6"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="隐私政策" data-en="Privacy Policy">隐私政策</strong><small data-zh="了解个人数据如何被处理" data-en="How personal data is handled">了解个人数据如何被处理</small></span>
                <span class="settings-chevron" aria-hidden="true">›</span>
            </a>
            <a class="settings-item" href="{{ route('disclaimer') }}">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5 4h14v16H5V4Z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="用户协议" data-en="Terms of Use">用户协议</strong><small data-zh="使用说明与免责声明" data-en="Terms and disclaimer">使用说明与免责声明</small></span>
                <span class="settings-chevron" aria-hidden="true">›</span>
            </a>
            <a class="settings-item" href="{{ route('about') }}">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 10v7M12 7h.01"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="关于 Southnight" data-en="About Southnight">关于 Southnight</strong><small>Southnight.wiki · SNW</small></span>
                <span class="settings-chevron" aria-hidden="true">›</span>
            </a>
            <a class="settings-item" href="{{ route('transparency') }}">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 7h16M4 17h16M8 4v16M16 4v16"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="当前版本" data-en="Current Version">当前版本</strong><small data-static-zh="构建日期 {{ $buildDate }}" data-static-en="Build date {{ $buildDate }}">构建日期 {{ $buildDate }}</small></span>
                <span class="settings-value">{{ $version }}</span><span class="settings-chevron" aria-hidden="true">›</span>
            </a>
        </div>
    </div>

    <div class="settings-list-section settings-list-section-last">
        <p class="settings-section-title" data-zh="支持与账户" data-en="Support & Account">支持与账户</p>
        <div class="settings-list">
            <a class="settings-item" href="mailto:xiaoqiuyi@qiulan.wiki?subject=Southnight%20Feedback">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 5h16v11H9l-5 4V5Z"/><path d="M8 9h8M8 12h5"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="联系我们 / 反馈问题" data-en="Contact / Send Feedback">联系我们 / 反馈问题</strong><small>xiaoqiuyi@qiulan.wiki</small></span>
                <span class="settings-chevron" aria-hidden="true">›</span>
            </a>
            @auth
            <form method="post" action="{{ route('logout') }}" class="settings-item-form">@csrf
                <button class="settings-item settings-item-danger" type="submit">
                    <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M10 4H5v16h5M14 8l4 4-4 4M8 12h10"/></svg></span>
                    <span class="settings-item-copy"><strong data-zh="退出登录" data-en="Sign Out">退出登录</strong><small data-zh="安全退出当前账户" data-en="Sign out of this account securely">安全退出当前账户</small></span>
                    <span class="settings-chevron" aria-hidden="true">›</span>
                </button>
            </form>
            @else
            <a class="settings-item" href="{{ route('login') }}">
                <span class="settings-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M10 4H5v16h5M14 8l4 4-4 4M8 12h10"/></svg></span>
                <span class="settings-item-copy"><strong data-zh="登录账户" data-en="Sign In">登录账户</strong><small data-zh="登录或注册 Southnight 账户" data-en="Sign in or create a Southnight account">登录或注册 Southnight 账户</small></span>
                <span class="settings-chevron" aria-hidden="true">›</span>
            </a>
            @endauth
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>(()=>{const sync=lang=>{const label=document.querySelector('#settings-language-label');if(label)label.textContent=lang==='en'?'English':'简体中文';document.querySelectorAll('[data-lang-choice]').forEach(button=>button.setAttribute('aria-pressed',String(button.dataset.langChoice===lang)))};document.querySelectorAll('[data-lang-choice]').forEach(button=>button.addEventListener('click',()=>{window.SNW?.setLanguage(button.dataset.langChoice);sync(button.dataset.langChoice)}));sync(window.SNW?.getLanguage()||'zh')})();</script>
@endpush
