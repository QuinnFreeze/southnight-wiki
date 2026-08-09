<div id="announcement-list" class="news-list">
@if($announcements->isEmpty())
<p class="announcement-empty">暂无公告 / No announcements yet.</p>
@else
@foreach($announcements as $announcement)
<article class="announcement-item"><time class="announcement-date">{{ optional($announcement->published_at ?? $announcement->created_at)->format('Y-m-d') }}</time><div><h3>{{ app()->getLocale()==='en' ? $announcement->title_en : $announcement->title_zh }}</h3><p>{{ app()->getLocale()==='en' ? $announcement->body_en : $announcement->body_zh }}</p></div><a href="{{ route('announcements.show',$announcement) }}">查看详情 ↗</a></article>
@endforeach
@endif
</div>
