<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="@yield('description','南夜维基是一个起源于英国、以公共价值为导向的独立互联网社区。')">
<meta name="theme-color" content="#050505"><meta name="robots" content="@yield('robots', 'index, follow')"><link rel="canonical" href="{{ url()->current() }}">
<meta property="og:title" content="@yield('title','南夜维基 · Southnight.wiki')"><meta property="og:description" content="@yield('description','起源于英国、以公共价值为导向的独立互联网社区。')"><meta property="og:type" content="website"><meta property="og:url" content="{{ url()->current() }}"><meta property="og:image" content="{{ asset('assets/night-sky.jpg') }}"><meta property="og:site_name" content="南夜维基"><meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="@yield('title','南夜维基 · Southnight.wiki')"><meta name="twitter:description" content="@yield('description','起源于英国、以公共价值为导向的独立互联网社区。')"><meta name="twitter:image" content="{{ asset('assets/night-sky.jpg') }}"><link rel="icon" href="{{ asset('assets/favicon.svg') }}" type="image/svg+xml"><title>@yield('title','南夜维基 · Southnight.wiki')</title><link rel="stylesheet" href="{{ asset('assets/style.css?v=20260809-24') }}"><link rel="stylesheet" href="{{ asset('assets/settings.css?v=20260810-01') }}"><link rel="stylesheet" href="{{ asset('assets/refinements.css?v=20260809-02') }}">@stack('styles')
<script type="application/ld+json">{"@@context":"https://schema.org","@@graph":[{"@@type":"WebSite","name":"南夜维基","alternateName":["SouthNight","SouthNight Wiki"],"url":"https://southnight.uk","description":"起源于英国、以公共价值为导向的独立互联网社区。关注 AI、互联网技术与网络安全。","inLanguage":["zh-CN","en"]},{"@@type":"Organization","name":"南夜维基","alternateName":["SouthNight","SouthNight Wiki"],"url":"https://southnight.uk","description":"起源于英国、以公共价值为导向的独立互联网社区。关注 AI、互联网技术与网络安全。","foundingLocation":{"@@type":"Place","name":"英国"},"contactPoint":{"@@type":"ContactPoint","email":"xiaoqiuyi@qiulan.wiki","contactType":"general"}}]}</script>
</head>
@php($authPage=request()->routeIs('login') || request()->routeIs('register'))
<body class="{{ $authPage ? 'auth-page' : '' }}"><div class="noise" aria-hidden="true"></div>
<header class="nav{{ $authPage ? ' nav-auth' : '' }}">@if($authPage)<a class="auth-back" href="{{ route('settings') }}" aria-label="返回设置 / Back to settings"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6"/></svg><span data-zh="返回设置" data-en="Back to settings">返回设置</span></a>@endif<a class="brand" href="{{ route('home') }}" aria-label="南夜维基首页"><span class="mark">SNW</span><span class="brand-main">南夜维基</span><span class="brand-sub">Southnight.wiki</span></a><nav aria-label="主导航"><a class="{{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">首页</a><a class="{{ request()->routeIs('about')?'active':'' }}" href="{{ route('about') }}">关于</a><a class="{{ request()->routeIs('research')?'active':'' }}" href="{{ route('research') }}">研究</a><a class="{{ request()->routeIs('leadership')?'active':'' }}" href="{{ route('leadership') }}">成员</a><a class="{{ request()->routeIs('principles')?'active':'' }}" href="{{ route('principles') }}">理念</a></nav></header>
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
<script src="{{ asset('assets/script.js?v=20260811-29') }}"></script>@stack('scripts')</body></html>
