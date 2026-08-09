@extends('layouts.app')
@section('title','组织成员 · 南夜维基')
@section('content')
<section class="page-hero page-hero-timeline"><p class="eyebrow">PEOPLE · 组织成员</p><h1>同行者，构成<br>南夜的历史。</h1><p>南夜维基的发展由历任成员共同推动。这里记录组织的策划者、历任站长及名誉站长。</p></section><section class="section leadership-page"><div class="role-feature"><p class="kicker">GENERAL PLANNER · 总策划</p><h2>小琪</h2><p>南夜维基总策划，同时担任第一任站长。</p></div><div class="leader-list">@foreach($members as $member)<article><b>{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</b><div><small>{{ $member->role }}</small><h3>{{ $member->display_name }}</h3><p>{{ $member->real_name ?: '未实名' }}</p></div></article>@endforeach</div><aside class="honor wide"><span>HONORARY DIRECTOR</span><div><p>名誉站长</p><h3>小雪</h3><p>陈若雪</p></div><i>✦</i></aside></section>
@endsection
