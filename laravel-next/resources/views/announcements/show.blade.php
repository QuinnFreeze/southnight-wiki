@extends('layouts.app')
@section('title',$announcement->title_zh.' · 南夜维基')
@section('content')
<section class="page-hero"><p class="eyebrow">ANNOUNCEMENT · 公告</p><h1>{{ $announcement->title_zh }}</h1><p>{{ optional($announcement->published_at)->format('Y-m-d H:i') }}</p></section><section class="section prose"><p>{!! nl2br(e($announcement->body_zh)) !!}</p><hr><h2>{{ $announcement->title_en }}</h2><p>{!! nl2br(e($announcement->body_en)) !!}</p></section>
@endsection
