@extends('layouts.app')
@section('title',$announcement->title_zh.' · 南夜维基')
@section('content')
<section class="page-hero"><p class="eyebrow" data-zh="ANNOUNCEMENT · 公告" data-en="ANNOUNCEMENT">ANNOUNCEMENT · 公告</p><h1 data-page-title-zh="{{ e($announcement->title_zh) }} · 南夜维基" data-page-title-en="{{ e($announcement->title_en ?: $announcement->title_zh) }} · Southnight.wiki" data-zh="{{ e($announcement->title_zh) }}" data-en="{{ e($announcement->title_en ?: $announcement->title_zh) }}">{{ $announcement->title_zh }}</h1><p>{{ optional($announcement->published_at)->format('Y-m-d H:i') }}</p></section>
<section class="section prose"><div data-lang-content="zh"><p>{!! nl2br(e($announcement->body_zh)) !!}</p></div><div data-lang-content="en" hidden><p>{!! nl2br(e($announcement->body_en ?: $announcement->body_zh)) !!}</p></div></section>
@endsection
