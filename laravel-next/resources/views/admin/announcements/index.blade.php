@extends('layouts.app')
@section('title','管理公告 · 南夜维基')
@section('content')
<section class="page-hero"><p class="eyebrow">ADMIN · ANNOUNCEMENTS</p><h1>管理公告</h1><p><a href="{{ route('admin.announcements.create') }}">创建公告 →</a></p></section>
<section class="section announcements">
    @if(session('status'))<p>{{ session('status') }}</p>@endif
    @foreach($announcements as $a)
        <article class="announcement-item">
            <time class="announcement-date">{{ optional($a->published_at)->format('Y-m-d') }}</time>
            <div><h3>{{ $a->title_zh }}</h3><p>{{ $a->status }} · {{ $a->pinned ? '置顶' : '普通' }}</p></div>
            <span>
                <a href="{{ route('admin.announcements.edit',$a) }}">编辑</a>
                <form method="post" action="{{ route('admin.announcements.destroy',$a) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <x-turnstile action="admin-announcement" appearance="interaction-only" />
                    <button type="submit">删除</button>
                </form>
            </span>
        </article>
    @endforeach
    {{ $announcements->links() }}
</section>
@endsection
