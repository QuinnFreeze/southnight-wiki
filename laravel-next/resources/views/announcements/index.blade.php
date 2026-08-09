@extends('layouts.app')
@section('title','公告 · 南夜维基')
@section('content')
<section class="page-hero"><p class="eyebrow">LATEST · ANNOUNCEMENTS</p><h1>来自南夜的消息。</h1><p>公告列表与公开动态。</p></section><section class="section announcements">@foreach($announcements as $announcement)<article class="announcement-item"><time class="announcement-date">{{ optional($announcement->published_at)->format('Y-m-d') }}</time><div><h3><a href="{{ route('announcements.show',$announcement) }}">{{ $announcement->title_zh }}</a></h3><p>{{ $announcement->body_zh }}</p></div><span>{{ $announcement->pinned ? '置顶' : '' }}</span></article>@endforeach{{ $announcements->links() }}</section>
@endsection
