@extends('layouts.app')
@section('title','研究与实践 · 南夜维基')
@section('content')
<section class="page-hero page-hero-research"><p class="eyebrow">RESEARCH · 研究与实践</p><h1>探索技术，<br>也审视技术。</h1><p>我们从真实问题出发，关注人工智能与网络技术的实践价值、安全边界和公共意义。</p></section><div class="research-section">@foreach($topics as $topic)<section id="{{ $topic->slug }}" class="research-item"><div class="research-item-num">{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</div><p class="kicker">{{ strtoupper(str_replace('-',' ',$topic->slug)) }}</p><h2>{{ $topic->title_zh }}</h2><p>{{ $topic->summary_zh }}</p></section>@endforeach</div>
@endsection
