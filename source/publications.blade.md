---
extends: _layouts.main
title: "Thoughts & Ideas"
section: body
---

@php
    $publicationsByGroup = $publications->groupBy('category');
    $presentations = $publicationsByGroup->get('presentation');
    $trainings = $publicationsByGroup->get('training');
    $interviews = $publicationsByGroup->get('interview');
@endphp

<section class="intro">
    <div class="container">
        <h1>Thoughts & Ideas<span class="dot">.</span></h1>
        <div class="intro-content">
            <p>I publish things from time to time. I've curated the following list of <a href="#posts">posts</a>, <a href="#presentations">presentations</a>, <a href="#video-training">video training courses</a>, and <a href="#interviews">interviews</a>.</p>
        </div>
    </div>
</section>
@if($posts->isNotEmpty())
<section id="posts" class="accent content">
    <div class="container">
        <h2>Posts</h2>
        @foreach ($posts as $post)
        <article>
        <h3><a href="{{ $post->getUrl() }}">{{ $post->title }}</a></h3>
        <blockquote>
            <p>{{ $post->description }}</p>
        </blockquote>
        {!! $post->excerpt() !!}
        <p><small><em>Published {{ $post->publishedAt()->toFormattedDateString() }}</em></small></p>
        </article>
        @endforeach
    </div>
</section>
@endif
@if($presentations->isNotEmpty())
<section id="presentations" class="accent content">
    <div class="container">
        <h2>Presentations</h2>
        @foreach ($presentations as $publication)
        <article>
        <h3><a href="{{ $publication->link }}" rel="nofollow">{{ $publication->title }}</a></h3>
        {!! $publication->getContent() !!}
        @if(count($publication->audiences))
        <p>Presented to:</p>
        <ul>
            @foreach($publication->audiences as $audience)
            <li><strong>{{ data_get($audience, 'name') }}</strong> on {{ Carbon\Carbon::parse(data_get($audience, 'date'))->toFormattedDateString() }}</li>
            @endforeach
        </ul>
        @endif
        </article>
        @endforeach
    </div>
</section>
@endif
@if($trainings->isNotEmpty())
<section id="video-training" class="accent content">
    <div class="container">
        <h2>Trainings</h2>
        @foreach ($trainings as $publication)
        <article>
        <h3><a href="{{ $publication->link }}" rel="nofollow">{{ $publication->title }}</a></h3>
        {!! $publication->getContent() !!}
        @if(count($publication->audiences))
        <p>Published on:</p>
        <ul>
            @foreach($publication->audiences as $audience)
            <li><strong>{{ data_get($audience, 'name') }}</strong> on {{ Carbon\Carbon::parse(data_get($audience, 'date'))->toFormattedDateString() }}</li>
            @endforeach
        </ul>
        @endif
        </article>
        @endforeach
    </div>
</section>
@endif
@if($interviews->isNotEmpty())
<section id="interviews" class="accent content">
    <div class="container">
        <h2>Interviews</h2>
        @foreach ($interviews as $publication)
        <article>
        <h3><a href="{{ $publication->link }}" rel="nofollow">{{ $publication->title }}</a></h3>
        {!! $publication->getContent() !!}
        @if(count($publication->audiences))
        <p>Discussed on:</p>
        <ul>
            @foreach($publication->audiences as $audience)
            <li><strong>{{ data_get($audience, 'name') }}</strong> on {{ Carbon\Carbon::parse(data_get($audience, 'date'))->toFormattedDateString() }}</li>
            @endforeach
        </ul>
        @endif
        </article>
        @endforeach
    </div>
</section>
@endif
