@extends('_layouts.main')

@php
    $bumblingSiblingPages = $page->getSiblingPages($travel->filter(fn ($p) => in_array('#bumbling_tourist', data_get($p, 'tags'))));
    $museumSiblingPages = $page->getSiblingPages($travel->filter(fn ($p) => in_array('#oddly_specific_museums', data_get($p, 'tags'))));
    $siblingPages = $page->getSiblingPages($travel);
@endphp

@section('body')
<section class="intro">
    <div class="container">
        @if($formattedTitle = $page->splitTitleForFormat())
        <h1>{{ $formattedTitle[0] }}<span class="dot">{{ $formattedTitle[1] }}</span></h1>
        @else
        <h1>{{ $page->title }}<span class="dot">.</span></h1>
        @endif
    </div>
</section>
<section class="carousel double-accent">
    @if($page->body)
    <blockquote class="pull-quote"><p>{{ $page->body }}</p></blockquote>
    @endif
    @foreach($page->media as $url)
    @if(Illuminate\Support\Str::endsWith($url, ['.mp4']))
    <video controls style="display: inline-block">
        <source src="{{ $url }}">
        Your browser does not support the video tag.
    </video>
    @else
    <img src="{{ $url }}" alt="Photography &copy;{{ $page->createdAt()->format('Y') }} Steven Maguire. All rights reserved." />
    @endif
    @endforeach
</section>
<section class="content">
    <div class="container">
        <div class="metadata">
            <em><i class="bx bx-calendar-event"></i> Observed {{ $page->createdAt()->toFormattedDayDateString() }}</em>
            @if($page->location)
            <em><i class="bx bx-map-pin"></i> {{ $page->location }}</em>
            @endif
            @if($page->tags)
            <em><i class="bx bx-tag"></i> {{ collect($page->tags)->join(' ') }}</em>
            @endif
        </div>
    </div>
</section>
@if($bumblingSiblingPages->isNotEmpty())
<section>
    <div class="container fluid">
        <article class="pagination">
            @if($previousPost = $bumblingSiblingPages->get('previous'))
            <div class="previous"><a href="{{ $previousPost->getUrl() }}"><i class="bx bxs-left-arrow-circle bx-lg"></i> {{ $previousPost->title }}</a></div>
            @endif
            <div class="divider"><a href="/travel/bumbling-tourist/" title="Back to Bumbling Tourist"><i class="bx bx-list-ul bx-lg"></i> <span>Bumbling Tourist</span></a></div>
            @if($nextPost = $bumblingSiblingPages->get('next'))
            <div class="next"><a href="{{ $nextPost->getUrl() }}">{{ $nextPost->title }} <i class="bx bxs-right-arrow-circle bx-lg"></i></a></div>
            @endif
        </article>
    </div>
</section>
@elseif($museumSiblingPages->isNotEmpty())
<section>
    <div class="container fluid">
        <article class="pagination">
            @if($previousPost = $museumSiblingPages->get('previous'))
            <div class="previous"><a href="{{ $previousPost->getUrl() }}"><i class="bx bxs-left-arrow-circle bx-lg"></i> {{ $previousPost->title }}</a></div>
            @endif
            <div class="divider"><a href="/travel/oddly-specific-museums/" title="Back to Oddly Specific Museums"><i class="bx bx-list-ul bx-lg"></i> <span>Oddly Specific Museums</span></a></div>
            @if($nextPost = $museumSiblingPages->get('next'))
            <div class="next"><a href="{{ $nextPost->getUrl() }}">{{ $nextPost->title }} <i class="bx bxs-right-arrow-circle bx-lg"></i></a></div>
            @endif
        </article>
    </div>
</section>
@endif
@if($siblingPages->isNotEmpty())
@if($bumblingSiblingPages->isNotEmpty())
<section>
    <div class="container">
        <div class="separator">
            <span class="separator-text">
                <span><i class="bx bx-up-arrow-circle bx-md"></i> Continue with <strong>Bumbling Tourist</strong></span>
                <span class="split"></span>
                <span>Continue with <strong>All Travel Logs</strong> <i class="bx bx-down-arrow-circle bx-md"></i></span>
            </span>
        </div>
    </div>
</section>
@elseif($museumSiblingPages->isNotEmpty())
<section>
    <div class="container">
        <div class="separator">
            <span class="separator-text">
                <span><i class="bx bx-up-arrow-circle bx-md"></i> Continue with <strong>Oddly Specific Museums</strong></span>
                <span class="split"></span>
                <span>Continue with <strong>All Travel Logs</strong> <i class="bx bx-down-arrow-circle bx-md"></i></span>
            </span>
        </div>
    </div>
</section>
@endif
<section>
    <div class="container fluid">
        <article class="pagination">
            @if($previousPost = $siblingPages->get('previous'))
            <div class="previous"><a href="{{ $previousPost->getUrl() }}"><i class="bx bxs-left-arrow-circle bx-lg"></i> {{ $previousPost->title }}</a></div>
            @endif
            <div class="divider"><a href="/travel#all" title="Back to Travel"><i class="bx bx-list-ul bx-lg"></i> <span>Travel</span></a></div>
            @if($nextPost = $siblingPages->get('next'))
            <div class="next"><a href="{{ $nextPost->getUrl() }}">{{ $nextPost->title }} <i class="bx bxs-right-arrow-circle bx-lg"></i></a></div>
            @endif
        </article>
    </div>
</section>
@endif
@endsection
