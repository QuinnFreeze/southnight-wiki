@extends('layouts.app')
@section('title','南夜维基 · Southnight.wiki')
@section('content')
<section class="hero" aria-labelledby="hero-title">
      <div class="hero-copy">
        <p class="eyebrow">AN INDEPENDENT INTERNET COMMUNITY</p>
        <h1 id="hero-title" data-zh="向南而行，<br><em>探索智能的长夜。</em>" data-en="Journey South,<br><em>explore the long night of intelligence.</em>">向南而行，<br><em>探索智能的长夜。</em></h1>
        <p class="intro" data-zh="南夜维基是一个起源于英国、以公共价值为导向的独立互联网社区。我们关注 AI 智能体如何真正服务人类，也持续研究互联网技术并维护网络安全。" data-en="Southnight.wiki is an independent internet community originating in the United Kingdom and guided by public value. We explore how AI agents can truly serve people, alongside internet technologies and cybersecurity.">南夜维基是一个起源于英国、以公共价值为导向的独立互联网社区。我们关注 AI 智能体如何真正服务人类，也持续研究互联网技术并维护网络安全。</p>
        <div class="actions"><a class="primary" href="#explore-title" data-zh="探索南夜 →" data-en="Explore SNW →">探索南夜 →</a></div>
      </div>
      <p class="scroll" aria-hidden="true">SCROLL TO EXPLORE ↓</p>
    </section>

    <section class="explore-portals section" aria-labelledby="explore-title">
      <div class="portal-heading reveal"><p class="kicker"><span class="section-num">02</span> EXPLORE · 探索南夜</p><h2 id="explore-title" data-zh="从这里开始。" data-en="Start here.">从这里开始。</h2></div>
      <div class="portal-grid">
        <a class="portal-card reveal" href="{{ route('about') }}"><span>01 · ABOUT</span><strong data-zh="关于我们" data-en="About us">关于我们</strong><p data-zh="认识南夜的起源、定位与公共价值。" data-en="Our origins, identity and public values.">认识南夜的起源、定位与公共价值。</p><i aria-hidden="true">↗</i></a>
        <a class="portal-card reveal" href="{{ route('research') }}"><span>02 · RESEARCH</span><strong data-zh="研究方向" data-en="Research">研究方向</strong><p data-zh="了解 AI、开放互联网与网络安全研究。" data-en="AI, the open internet and cybersecurity.">了解 AI、开放互联网与网络安全研究。</p><i aria-hidden="true">↗</i></a>
        <a class="portal-card reveal" href="{{ route('leadership') }}"><span>03 · PEOPLE</span><strong data-zh="成员与历史" data-en="People & history">成员与历史</strong><p data-zh="查看共同维护南夜的成员与组织历程。" data-en="The people and history that shaped Southnight.wiki.">查看共同维护南夜的成员与组织历程。</p><i aria-hidden="true">↗</i></a>
        <a class="portal-card reveal" href="{{ route('principles') }}"><span>04 · PRINCIPLES</span><strong data-zh="理念与原则" data-en="Principles">理念与原则</strong><p data-zh="理解我们对技术与公共价值的判断。" data-en="How we think about technology and public value.">理解我们对技术与公共价值的判断。</p><i aria-hidden="true">↗</i></a>
      </div>
    </section>

    <section id="research" class="research-home section">
      <div class="section-heading reveal"><div><p class="kicker"><span class="section-num">03</span> RESEARCH · 研究与实践</p><h2 data-zh="我们关注什么。" data-en="What we study.">我们关注什么。</h2></div><p data-zh="从智能体的真实应用，到更可靠的互联网基础设施。" data-en="From real-world agents to more dependable internet infrastructure.">从智能体的真实应用，到更可靠的互联网基础设施。</p></div>
      <div class="research-list">
        <a class="research-row reveal" href="{{ route("research") }}#ai-agents"><span class="research-row-num">01</span><span class="research-row-title"><b>AI AGENTS</b><strong data-zh="智能体与人机协作" data-en="Agents and human collaboration">智能体与人机协作</strong></span><span class="research-row-desc" data-zh="探索智能体如何承担任务、连接工具并协助人类。" data-en="How agents perform tasks, connect tools and assist people.">探索智能体如何承担任务、连接工具并协助人类。</span><span class="row-arrow" aria-hidden="true">↗</span></a>
        <a class="research-row reveal" href="{{ route("research") }}#internet-technology"><span class="research-row-num">02</span><span class="research-row-title"><b>OPEN INTERNET</b><strong data-zh="开放网络与互联网基础设施" data-en="Open networks and infrastructure">开放网络与互联网基础设施</strong></span><span class="research-row-desc" data-zh="研究网络系统如何运行、协作与持续演进。" data-en="How networked systems operate, collaborate and evolve.">研究网络系统如何运行、协作与持续演进。</span><span class="row-arrow" aria-hidden="true">↗</span></a>
        <a class="research-row reveal" href="{{ route("research") }}#cyber-security"><span class="research-row-num">03</span><span class="research-row-title"><b>SECURITY</b><strong data-zh="安全、隐私与可靠性" data-en="Security, privacy and resilience">安全、隐私与可靠性</strong></span><span class="research-row-desc" data-zh="关注网络空间中的风险、责任和韧性。" data-en="Risk, responsibility and resilience in cyberspace.">关注网络空间中的风险、责任和韧性。</span><span class="row-arrow" aria-hidden="true">↗</span></a>
      </div>
    </section>

    <section id="projects" class="projects section">
      <div class="section-heading reveal"><div><p class="kicker"><span class="section-num">04</span> FEATURED PROJECTS · 项目与成果</p><h2 data-zh="把研究带入真实场景。" data-en="Research in real settings.">把研究带入真实场景。</h2></div><p data-zh="Research 是我们研究什么；Projects 是我们正在做什么。" data-en="Research is what we study. Projects are what we are making.">Research 是我们研究什么；Projects 是我们正在做什么。</p></div>
      <div class="project-grid">
        @php($statusLabels=['in_progress'=>'进行中 · IN PROGRESS','exploring'=>'探索中','maintained'=>'长期维护'])
        @php($projectAnchors=['ai-agent-practice'=>'ai-agents','open-internet'=>'internet-technology','cybersecurity-privacy'=>'cyber-security'])
        @foreach($projects as $project)
        <article class="project-card {{ $loop->first ? 'project-feature' : '' }} reveal"><span class="project-status">{{ $statusLabels[$project->status] ?? $project->status }}</span><p class="project-index">PROJECT {{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}{{ $loop->first ? ' · FEATURED' : '' }}</p><h3>{{ $project->title_zh }}</h3><p>{{ $project->summary_zh }}</p><a href="{{ route('research') }}#{{ $projectAnchors[$project->slug] ?? '' }}" data-zh="了解项目 →" data-en="Discover project →">了解项目 →</a></article>
        @endforeach
      </div>
    </section>

    <section id="home-principles" class="home-principles section">
      <div class="section-heading reveal"><div><p class="kicker"><span class="section-num">05</span> OUR PRINCIPLES · 我们的原则</p><h2 data-zh="技术向善，实践求真。" data-en="Technology for good. Practice grounded in truth.">技术向善，实践求真。</h2></div><a href="{{ route("principles") }}" class="section-link" data-zh="查看完整理念 →" data-en="View our principles →">查看完整理念 →</a></div>
      <div class="principle-editorial"><article class="reveal"><b>01</b><h3 data-zh="人本" data-en="HUMAN">人本</h3><p data-zh="技术应服务于真实的人，而不是让人适应技术。" data-en="Technology should serve real people, not force people to adapt to it.">技术应服务于真实的人，而不是让人适应技术。</p></article><article class="reveal offset"><b>02</b><h3 data-zh="开放" data-en="OPEN">开放</h3><p data-zh="鼓励开放互联网、知识共享与技术探索。" data-en="We encourage the open internet, shared knowledge and exploration.">鼓励开放互联网、知识共享与技术探索。</p></article><article class="reveal"><b>03</b><h3 data-zh="安全" data-en="SAFE">安全</h3><p data-zh="重视隐私、安全、稳定性与负责任的技术实践。" data-en="We value privacy, security, stability and responsible practice.">重视隐私、安全、稳定性与负责任的技术实践。</p></article><article class="reveal offset"><b>04</b><h3 data-zh="公共价值" data-en="PUBLIC VALUE">公共价值</h3><p data-zh="优先考虑长期公共价值，而不是短期商业利益。" data-en="We prioritise long-term public value over short-term commercial gain.">优先考虑长期公共价值，而不是短期商业利益。</p></article></div>
    </section>

    <section id="announcements" class="news-preview section">
      <div class="section-heading reveal"><div><p class="kicker"><span class="section-num">06</span> LATEST · 最新动态</p><h2 data-zh="来自南夜的消息。" data-en="News from SNW.">来自南夜的消息。</h2></div><a href="{{ route('announcements.index') }}" class="section-link" data-zh="查看全部公告 →" data-en="View all notices →">查看全部公告 →</a></div>
      @include('components.announcement-list')
    </section>
@endsection
