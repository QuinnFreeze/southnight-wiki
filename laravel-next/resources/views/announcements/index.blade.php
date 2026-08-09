@extends('layouts.app')
@section('title','公告 · 南夜维基')
@section('content')
<section class="page-hero"><p class="eyebrow">LATEST · ANNOUNCEMENTS</p><h1 data-zh="来自南夜的消息。" data-en="News from Southnight.wiki.">来自南夜的消息。</h1><p data-zh="公告列表与公开动态。" data-en="Announcements and public updates.">公告列表与公开动态。</p></section>
<section class="section announcements">
@forelse($announcements as $announcement)
<article class="announcement-item"><time class="announcement-date">{{ optional($announcement->published_at)->format('Y-m-d') }}</time><div><h3><a href="{{ route('announcements.show',$announcement) }}" data-zh="{{ e($announcement->title_zh) }}" data-en="{{ e($announcement->title_en ?: $announcement->title_zh) }}">{{ $announcement->title_zh }}</a></h3><p data-zh="{{ e($announcement->body_zh) }}" data-en="{{ e($announcement->body_en ?: $announcement->body_zh) }}">{{ $announcement->body_zh }}</p></div>@if($announcement->pinned)<span data-zh="置顶" data-en="Pinned">置顶</span>@endif</article>
@empty
<p data-zh="暂无公告。" data-en="No announcements yet.">暂无公告。</p>
@endforelse
{{ $announcements->links() }}
</section>
@endsection
