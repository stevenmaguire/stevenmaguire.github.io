---
extends: _layouts.main
title: "Track Record"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/desk-ruler-designer-chair.jpeg
description: My track record proves I deliver digital transformations by building strong tech teams and deploying effective software solutions that drive results.
section: body
---

<section class="intro">
    <div class="container">
        <h1>Track Record<span class="dot">.</span></h1>
        <div class="intro-content">
            <p>I've been building software since 2004. For the last {{ Carbon\Carbon::now()->diffInYears(Carbon\Carbon::now()->setYear(2013)) }} years, I'm focused on digital transformations and profitable turnarounds. I do that by delivering on two things. First, by building healthy, productive technology teams. Second, by deploying smart, reliable software solutions. The teams I build offer stability, continuing education, mentorship, and career tracks. The software I deploy is cost-conscious, solves real problems and promotes self-sufficient productivity.</p>
            <p>I'm proud of the work I do and my track record proves it produces results. Take a look at some of my case studies to see for yourself.</p>
        </div>
    </div>
</section>
@if($missions->isNotEmpty())
<section id="missions" class="accent content">
    <div class="container">
        @foreach ($missions as $mission)
        <article class="mission-summary">
            <div class="company">
                @if($mission->logo_url)
                <figure class="mission-logo">
                    <h2 style="display: none;">{{ $mission->company }}</h2>
                    <img src="{{ $mission->logo_url }}" alt="{{ $mission->company }}" />
                </figure>
                @else
                <h2>{{ $mission->company }}</h2>
                @endif
            </div>
            <div class="result">
                @if($downstream = $mission->change(true))
                <span class="performance">
                    <i class="bx bxs-up-arrow direction"></i><acronym title="Valuation Change">{{ $downstream }}%</acronym>
                </span>
                @elseif($change = $mission->change())
                <span class="performance">
                    <i class="bx bxs-up-arrow direction"></i><acronym title="Valuation Change">{{ $change }}%</acronym>
                </span>
                @else
                <span class="performance pending">
                    TBD
                </span>
                @endif
            </div>
            <div class="cta">
                <a href="{{ $mission->getUrl() }}" class="btn">View Case Study</a>
            </div>
            <div class="description">
                <p><em>{{ $mission->tenure() }}</em></p>
                <p>
                    <strong><acronym title="Business Model">{{ ucwords($mission->model) }}</acronym></strong>
                    &bull;
                    <strong><acronym title="Industry">{{ ucwords($mission->industry) }}</acronym></strong>
                    &bull;
                    <strong><acronym title="Vertical">{{ ucwords($mission->vertical) }}</acronym></strong>
                </p>
                <p>{{ $mission->summary }}</p>
            </div>
        </article>
        @endforeach
    </div>
</section>
@endif
