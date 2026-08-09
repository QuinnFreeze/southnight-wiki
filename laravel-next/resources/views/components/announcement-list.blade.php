<div id="announcement-list" class="news-list">
@if($announcements->isEmpty())
<p class="announcement-empty">暂无公告 / No announcements yet.</p>
@else
@foreach($announcements as $announcement)
<article class="news-item"><time>{{ optional($announcement->published_at ?? $announcement->created_at)->format('Y-m-d') }}</time><div><h3>{{ $announcement->title_zh }}</h3><p>{{ $announcement->body_zh }}</p></div><a href="{{ route('announcements.show',$announcement) }}">查看详情 ↗</a></article>
@endforeach
@endif
</div>
