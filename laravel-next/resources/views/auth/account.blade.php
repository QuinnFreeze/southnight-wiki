@extends('layouts.app')
@section('title','账户 · 南夜维基')
@section('content')
<section class="page-hero"><p class="eyebrow">ACCOUNT · SIGNED IN</p><h1>你好，{{ auth()->user()->username }}</h1><p>{{ auth()->user()->email }} · UID {{ auth()->user()->uid }} · {{ auth()->user()->isAdmin() ? '管理员' : '用户' }}</p></section>
<section class="section">
    @if(session('status'))<p>{{ session('status') }}</p>@endif
    @if($errors->any())<p class="announcement-error">{{ $errors->first() }}</p>@endif
    <div class="grid" style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
        <form method="post" action="{{ route('account.profile') }}" class="panel">
            @csrf @method('PUT')
            <h2>个人资料</h2>
            <label>邮箱</label><input name="email" type="email" value="{{ auth()->user()->email }}" required>
            <x-turnstile action="account-profile" appearance="interaction-only" />
            <button type="submit">保存资料</button>
        </form>
        <form method="post" action="{{ route('account.password') }}" class="panel">
            @csrf @method('PUT')
            <h2>修改密码</h2>
            <label>当前密码</label><input name="current_password" type="password" required>
            <label>新密码</label><input name="password" type="password" minlength="10" required>
            <label>确认新密码</label><input name="password_confirmation" type="password" minlength="10" required>
            <x-turnstile action="account-password" appearance="interaction-only" />
            <button type="submit">更新密码</button>
        </form>
    </div>
    <p><a href="{{ route('announcements.index') }}">查看公告 →</a>@if(auth()->user()->isAdmin())　<a href="{{ route('admin.index') }}">进入管理后台 →</a>@endif</p>
    <form method="post" action="{{ route('logout') }}">@csrf<button type="submit">退出登录</button></form>
</section>
@endsection
