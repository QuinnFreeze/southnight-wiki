@extends('layouts.app')
@section('title','管理用户 · 南夜维基')
@section('content')
<section class="page-hero"><p class="eyebrow">ADMIN · USERS</p><h1>管理用户</h1><p><a href="{{ route('admin.index') }}">返回后台 →</a></p></section><section class="section">@if(session('status'))<p>{{ session('status') }}</p>@endif@foreach($users as $user)<article class="announcement-item"><div><h3>{{ $user->username }}</h3><p>{{ $user->email }} · {{ $user->created_at?->format('Y-m-d') }}</p></div><form method="post" action="{{ route('admin.users.update',$user) }}">@csrf @method('PUT')<select name="role"><option value="user" @selected($user->role==='user')>user</option><option value="admin" @selected($user->role==='admin')>admin</option></select><select name="status"><option value="active" @selected($user->status==='active')>active</option><option value="blocked" @selected($user->status==='blocked')>blocked</option></select><button type="submit">保存</button></form></article>@endforeach</section>
@endsection
