@extends('layouts.app')
@section('title','南夜维基 · Southnight.wiki')
@section('content')
<section class="hero" aria-labelledby="hero-title">
      <div class="hero-copy">
        <p class="eyebrow">AN INDEPENDENT INTERNET COMMUNITY</p>
        <h1 id="hero-title" data-zh="向南而行，<br><em>探索智能的长夜。</em>" data-en="Journey South,<br><em>explore the long night of intelligence.</em>">向南而行，<br><em>探索智能的长夜。</em></h1>
        <p class="intro" data-zh="南夜维基是一个起源于英国、以公共价值为导向的独立互联网社区。我们关注 AI 智能体如何真正服务人类，也持续研究互联网技术并维护网络安全。" data-en="Southnight.wiki is an independent internet community originating in the United Kingdom and guided by public value. We explore how AI agents can truly serve people, alongside internet technologies and cybersecurity.">南夜维基是一个起源于英国、以公共价值为导向的独立互联网社区。我们关注 AI 智能体如何真正服务人类，也持续研究互联网技术并维护网络安全。</p>
        <div class="actions"><a class="primary" href="#about" data-zh="认识南夜维基 →" data-en="Discover SNW →">认识南夜维基 →</a><a class="secondary" href="{{ route("research") }}" data-zh="进入研究 →" data-en="Enter Research →">进入研究 →</a></div>
      </div>
      <p class="scroll" aria-hidden="true">SCROLL TO EXPLORE ↓</p>
    </section>

    <section id="about" class="about section reveal">
      <div class="about-lead"><p class="kicker"><span class="section-num">02</span> ABOUT · 关于南夜</p><h2 data-zh="一个起源于英国、以公共价值为导向的独立互联网社区。" data-en="An independent internet community guided by public value.">一个起源于英国、以公共价值为导向的独立互联网社区。</h2></div>
      <div class="about-text"><p data-zh="技术不只关乎未来，也关乎每一个人的现在。" data-en="Technology is not only about the future, but everyone’s present.">技术不只关乎未来，也关乎每一个人的现在。</p><p data-zh="我们相信，人工智能与网络技术应当被负责任地理解、实践和分享。技术的价值，最终应由它为人类带来的福祉来衡量。" data-en="We believe AI and internet technologies should be understood, practised and shared responsibly. Their value should be measured by the benefit they bring to humanity.">我们相信，人工智能与网络技术应当被负责任地理解、实践和分享。技术的价值，最终应由它为人类带来的福祉来衡量。</p><dl><div><dt data-zh="起源" data-en="Origin">起源</dt><dd data-zh="英国 · United Kingdom" data-en="United Kingdom">英国 · United Kingdom</dd></div><div><dt data-zh="关注" data-en="Focus">关注</dt><dd data-zh="AI · 开放互联网 · 安全" data-en="AI · Open Web · Security">AI · 开放互联网 · 安全</dd></div><div><dt data-zh="性质" data-en="Type">性质</dt><dd data-zh="独立互联网社区" data-en="Independent community">独立互联网社区</dd></div></dl></div>
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

    <section id="story" class="story section">
      <div class="story-copy reveal"><p class="kicker"><span class="section-num">06</span> OUR STORY · 我们的故事</p><h2 data-zh="由同行者共同写下的历史。" data-en="A history written by our companions.">由同行者共同写下的历史。</h2><p data-zh="南夜维基起源于英国，在历任站长、总策划与成员的持续维护中，逐步形成对 AI 智能体、开放互联网、网络技术和安全实践的长期关注。" data-en="Originating in the United Kingdom, Southnight.wiki has been shaped by successive directors, its general planner and members into a long-term exploration of AI agents, the open internet, network technologies and security practice.">南夜维基起源于英国，在历任站长、总策划与成员的持续维护中，逐步形成对 AI 智能体、开放互联网、网络技术和安全实践的长期关注。</p><a href="{{ route("leadership") }}" class="story-link" data-zh="了解完整历史 →" data-en="Explore our history →">了解完整历史 →</a></div>
      <div class="story-timeline"><div class="story-node"><span>ORIGIN</span><strong data-zh="起源于英国" data-en="Originating in the UK">起源于英国</strong><p data-zh="以公共价值为出发点，开始记录对技术的理解与实践。" data-en="A public-value-led beginning for understanding and practising technology.">以公共价值为出发点，开始记录对技术的理解与实践。</p></div><div class="story-node"><span>PEOPLE</span><strong data-zh="同行者接续维护" data-en="Shaped by companions">同行者接续维护</strong><p data-zh="历任站长、总策划与成员共同构成南夜的公开历史。" data-en="Successive directors, the planner and members shape the public record of SNW.">历任站长、总策划与成员共同构成南夜的公开历史。</p></div><div class="story-node"><span>PRESENT</span><strong data-zh="持续研究与实践" data-en="Research in progress">持续研究与实践</strong><p data-zh="当前关注 AI 智能体、开放互联网与网络安全。" data-en="Today, our focus is AI agents, the open internet and cybersecurity.">当前关注 AI 智能体、开放互联网与网络安全。</p></div></div>
    </section>

    <section id="announcements" class="news-preview section">
      <div class="section-heading reveal"><div><p class="kicker"><span class="section-num">07</span> LATEST · 最新动态</p><h2 data-zh="来自南夜的消息。" data-en="News from SNW.">来自南夜的消息。</h2></div><a href="https://dynamic.southnight.uk" class="section-link" data-zh="完整公告与账户中心 ↗" data-en="All announcements & account centre ↗">完整公告与账户中心 ↗</a></div>
      @include('components.announcement-list')
    </section>
@endsection
