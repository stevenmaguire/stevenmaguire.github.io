---
extends: _layouts.main
title: "Open Source"
image: https://static.stevenmaguire.com/articles/lake-michigan-sunset.jpg
description: I've curated the following list of open source projects that I maintain.
section: body
---

<section class="intro">
    <div class="container">
        <h1>Open Source<span class="dot">.</span></h1>
        <div class="intro-content">
            <p>If you get to know me, you'll learn that <a href="https://github.com/stevenmaguire">I love open source software</a>; contributing and consuming. I've curated the following list of <strong class="number">{{ $opensource->count() }}</strong> open source projects, with over <strong class="number">{{ number_format(10000 * floor($page->opensource_total_downloads/10000)) }}</strong> downloads, that I maintain.</p>
            <p>I'd love to know that you are getting value from one of these projects - you can <a href="https://steven.pizza">buy me a pizza</a> or <a href="https://github.com/sponsors/stevenmaguire">sponsor me on Github</a>.</p>
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
            <h3>
                @if($project->primary_url)
                <a href="{{ $project->primary_url }}"><i class="bx bxl-github"></i> {{ $project->name }}</a>
                @else
                <i class="bx bxl-github"></i> {{ $project->name }}
                @endif
            </h3>
            <p>
                {{ $project->description }}
                <br />
                {{ $project->role }}
                | {{ $project->language }}
                @if($project->downloads)
                | <strong>{{ number_format($project->downloads) }}</strong> Downloads
                @endif
                <br />
                @if($project->github_ref)
                <a href="https://github.com/{{ $project->github_ref }}/releases"><img data-src="https://img.shields.io/github/release/{{ $project->github_ref }}.svg?style=flat-square" alt="Latest Version" /></a>
                <a href="https://github.com/{{ $project->github_ref }}/stargazers"><img data-src="https://img.shields.io/github/stars/{{ $project->github_ref }}.svg?style=social&label=stars&style=flat-square" alt="Stars"/></a>
                @endif
                @if($project->packagist_ref)
                <a href="https://packagist.org/packages/{{ $project->packagist_ref }}"><img data-src="https://img.shields.io/packagist/dt/{{ $project->packagist_ref }}.svg?style=flat-square" alt="Total Downloads" /></a>
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
                "url": "{{ $project->primary_url }}",
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
