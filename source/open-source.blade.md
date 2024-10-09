---
extends: _layouts.main
title: "Open Source"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/lake-michigan-sunset.jpg
description: I've curated the following list of open source projects that I maintain.
section: body
---

<section class="intro">
    <div class="container">
        <h1>Open Source<span class="dot">.</span></h1>
        <div class="intro-content">
            <p>If you get to know me, you'll learn that <a href="https://github.com/stevenmaguire">I love open source software</a>; contributing and consuming. I've curated the following list of <strong class="number">{{ $opensource->count() }}</strong> open source projects, with over <strong class="number">{{ number_format(10000 * floor($page->opensource_total_downloads/10000)) }}</strong> downloads, that I maintain.</p>
            @if($page->opensource_last_refreshed)
            <p><em>Most</em> stats last updated {{ $page->opensource_last_refreshed }}</p>
            @endif
        </div>
    </div>
</section>
@if($opensource->isNotEmpty())
<section id="opensource" class="accent content text-center">
    <div class="container">
        @foreach ($opensource as $project)
        <article>
            <h3><a href="{{ $project->link }}"><i class="bx bxl-github"></i> {{ $project->name }}</a></h3>
            <p>
                {{ $project->description }}
                <br />
                {{ $project->role }}
                | {{ $project->language }}
                @if($project->downloads)
                | <strong>{{ number_format($project->downloads) }}</strong> Downloads
                @endif
                <br />
                @if($project->github)
                <a href="https://github.com/{{ $project->github }}/releases"><img data-src="https://img.shields.io/github/release/{{ $project->github }}.svg?style=flat-square" alt="Latest Version" /></a>
                <a href="https://github.com/{{ $project->github }}/stargazers"><img data-src="https://img.shields.io/github/stars/{{ $project->github }}.svg?style=social&label=stars&style=flat-square" alt="Stars"/></a>
                @endif
                @if($project->packagist)
                <a href="https://packagist.org/packages/{{ $project->packagist }}"><img data-src="https://img.shields.io/packagist/dt/{{ $project->packagist }}.svg?style=flat-square" alt="Total Downloads" /></a>
                @endif
                @if($project->travis)
                <a href="https://travis-ci.org/{{ $project->travis }}"><img data-src="https://img.shields.io/travis/{{ $project->travis }}/master.svg?style=flat-square" alt="Build Status" /></a>
                @endif
                @if($project->scrutinizer)
                <a href="https://scrutinizer-ci.com/g/{{ $project->scrutinizer }}/code-structure"><img data-src="https://img.shields.io/scrutinizer/coverage/g/{{ $project->scrutinizer }}.svg?style=flat-square" alt="Coverage Status" /></a>
                <a href="https://scrutinizer-ci.com/g/{{ $project->scrutinizer }}"><img data-src="https://img.shields.io/scrutinizer/g/{{ $project->scrutinizer }}.svg?style=flat-square" alt="Quality Score" /></a>
                @endif
            </p>
            <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "CreativeWork",
                "author": {
                    "@type": "Person",
                    "name": "Steven Maguire"
                },
                "creator": {
                    "@type": "Person",
                    "name": "Steven Maguire"
                },
                "name": "{{ $project->name }}",
                "headline": "{{ $project->name }}@if($project->downloads) with {{ $project->downloads }} downloads @endif",
                "url": "{{ $project->link }}",
                "description": "{{ $project->description }}",
                "about": "{{ $project->language }} Project: {{ $project->description }}"
            }
            </script>
        </article>
        @endforeach
    </div>
</section>
@endif
<section class="accent">
    <div class="container">
        <h2>My eyes and ears are open.</h2>
        <p>I am on the lookout for more open source projects and opportunities. If you've got one, let's talk!</p>
    </div>
</section>
