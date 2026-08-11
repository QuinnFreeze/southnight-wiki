@extends('layouts.app')
@section('title', $announcement->exists ? '编辑公告 · 南夜维基' : '创建公告 · 南夜维基')
@section('content')
<section class="page-hero"><p class="eyebrow">ADMIN · EDITOR</p><h1>{{ $announcement->exists ? '编辑公告' : '创建公告' }}</h1></section>
<section class="section">
    <form method="post" action="{{ $announcement->exists ? route('admin.announcements.update',$announcement) : route('admin.announcements.store') }}" class="panel">
        @csrf
        @if($announcement->exists) @method('PUT') @endif
        <label>中文标题</label><input name="title_zh" value="{{ old('title_zh',$announcement->title_zh) }}" required>
        <label>中文正文</label><textarea name="body_zh" required>{{ old('body_zh',$announcement->body_zh) }}</textarea>
        <label>English title</label><input name="title_en" value="{{ old('title_en',$announcement->title_en) }}" required>
        <label>English body</label><textarea name="body_en" required>{{ old('body_en',$announcement->body_en) }}</textarea>
        <label>状态</label><select name="status"><option value="published" @selected(old('status',$announcement->status)==='published')>立即发布</option><option value="draft" @selected(old('status',$announcement->status)==='draft')>草稿</option></select>
        <label><input type="checkbox" name="pinned" value="1" @checked(old('pinned',$announcement->pinned))> 置顶</label>
        <x-turnstile action="admin-announcement" appearance="interaction-only" />
        <button class="primary" type="submit">保存公告</button>
    </form>
</section>
@endsection
