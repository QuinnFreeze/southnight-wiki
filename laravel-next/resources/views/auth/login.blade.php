@extends('layouts.app')
@section('title','登录 · 南夜维基')
@section('content')
<section class="page-hero"><p class="eyebrow">ACCOUNT · 账户</p><h1>登录南夜维基</h1><p>访问账户与公告管理功能。</p></section><section class="section"><form method="post" action="{{ route('login.submit') }}" class="panel" style="max-width:520px;margin:auto">@csrf<label>用户名或邮箱</label><input name="identity" value="{{ old('identity') }}" required autocomplete="username">@error('identity')<p class="announcement-error">{{ $message }}</p>@enderror<label>密码</label><input name="password" type="password" required autocomplete="current-password"><button class="primary" type="submit">登录</button><p>还没有账户？<a href="{{ route('register') }}">注册</a></p></form></section>
@endsection
