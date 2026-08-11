<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="@yield('description','南夜维基是一个起源于英国、以公共价值为导向的独立互联网社区。')">
<meta name="theme-color" content="#050505"><link rel="canonical" href="{{ url()->current() }}">
<meta property="og:title" content="@yield('title','南夜维基 · Southnight.wiki')"><meta property="og:description" content="@yield('description','起源于英国、以公共价值为导向的独立互联网社区。')"><meta property="og:type" content="website"><meta property="og:url" content="{{ url()->current() }}"><meta property="og:image" content="{{ asset('assets/night-sky.jpg') }}"><link rel="icon" href="{{ asset('assets/favicon.svg') }}" type="image/svg+xml"><title>@yield('title','南夜维基 · Southnight.wiki')</title><link rel="stylesheet" href="{{ asset('assets/style.css?v=20260809-24') }}"><link rel="stylesheet" href="{{ asset('assets/settings.css?v=20260810-01') }}"><link rel="stylesheet" href="{{ asset('assets/refinements.css?v=20260809-02') }}">
</head>
<body><div class="noise" aria-hidden="true"></div>
<header class="nav"><a class="brand" href="{{ route('home') }}" aria-label="南夜维基首页"><span class="mark">SNW</span><span class="brand-main">南夜维基</span><span class="brand-sub">Southnight.wiki</span></a><nav aria-label="主导航"><a class="{{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">首页</a><a class="{{ request()->routeIs('about')?'active':'' }}" href="{{ route('about') }}">关于</a><a class="{{ request()->routeIs('research')?'active':'' }}" href="{{ route('research') }}">研究</a><a class="{{ request()->routeIs('leadership')?'active':'' }}" href="{{ route('leadership') }}">成员</a><a class="{{ request()->routeIs('principles')?'active':'' }}" href="{{ route('principles') }}">理念</a></nav></header>
<main id="top">@yield('content')</main>
@php($minimalFooter=request()->routeIs('announcements.*')||request()->routeIs('settings'))
<footer class="site-footer{{ $minimalFooter ? ' site-footer-minimal' : '' }}">
@if(!$minimalFooter)
<div class="footer-brand"><strong>SOUTHNIGHT.WIKI</strong><p data-zh="向南而行，探索智能的长夜。" data-en="Journey south, into the long night of intelligence.">向南而行，探索智能的长夜。</p></div>
<div class="footer-contact"><h3 data-zh="联系" data-en="Contact">联系</h3><a href="mailto:xiaoqiuyi@qiulan.wiki">xiaoqiuyi@qiulan.wiki ↗</a></div>
@endif
<nav class="footer-policies" aria-label="政策"><h3 data-zh="政策" data-en="Policies">政策</h3><div><a href="{{ route('privacy') }}" data-zh="隐私政策" data-en="Privacy">隐私政策</a><a href="{{ route('transparency') }}" data-zh="透明度" data-en="Transparency">透明度</a><a href="{{ route('transparency') }}#disclaimer" data-zh="免责声明" data-en="Disclaimer">免责声明</a></div></nav>
@if(!$minimalFooter)
<p class="footer-copy">© <span id="year"></span> Southnight.wiki · SNW　 southnight.uk</p>
@endif
</footer>
<script src="{{ asset('assets/script.js?v=20260809-28') }}"></script>@stack('scripts')</body></html>
