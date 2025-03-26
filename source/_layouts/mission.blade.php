@extends('_layouts.main', ['title' => $page->company, 'description' => 'This is a description'])

@php
    $downstream = $page->change(true);
@endphp

@section('body')
<section class="intro">
    <div class="container">
        @if($page->logo_url)
        <h1 style="display: none;">{{ $page->company }}</h1>
        <figure class="mission-logo">
            <img src="{{ $page->logo_url }}" alt="{{ $page->company }}" />
        </figure>
        @else
        <h1>{{ $page->company }}<span class="dot">.</span></h1>
        @endif
        <div class="intro-content">
            <p>{{ $page->location }} &bull; {{ $page->tenure() }} &bull; {{ $page->role }}</p>
            <p>{{ $page->summary }}</p>
        </div>
    </div>
</section>
<section class="double-accent collapse">
    <div class="container">
        <div class="metrics">
            <div class="metric">
                <em>Business Model</em>
                <strong>{{ ucwords($page->model) }}</strong>
            </div>
            <div class="metric">
                <em>Industry</em>
                <strong>{{ ucwords($page->industry) }}</strong>
            </div>
            <div class="metric">
                <em>Vertical</em>
                <strong>{{ ucwords($page->vertical) }}</strong>
            </div>
            <div class="metric">
                <em>Valuation Change</em>
                @if($downstream = $page->change(true))
                <span class="performance">
                    <i class="bx bxs-up-arrow direction"></i>{{ $downstream }}%<a href="#downstream">**</a>
                </span>
                @elseif($change = $page->change())
                <span class="performance">
                    <i class="bx bxs-up-arrow direction"></i>{{ $change }}%
                </span>
                @else
                <span class="performance pending">
                    TBD
                </span>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container">
        @if($page->challenge)
        <article>
            <h2>Challenge</h2>
            @markdown($page->challenge)
        </article>
        @endif
        @if($page->approach)
        <article>
            <h2>Approach</h2>
            @markdown($page->approach)
        </article>
        @endif
        @if($page->solution)
        <article>
            <h2>Solution</h2>
            @markdown($page->solution)
        </article>
        @endif
        @if($page->results || $downstream)
        <article>
            <h2>Results</h2>
            @markdown($page->results)
            @if($downstream)
            <p class="alert" id="downstream">
                <strong>**</strong>
                @if($change = $page->change())
                Valuation increases of <span class="performance inline"><i class="bx bxs-up-arrow direction"></i>{{ $change }}%</span> were immediately realized during my tenure.
                @endif
                Downstream of my tenure at {{ $page->company }} larger valuation increases of <span class="performance inline"><i class="bx bxs-up-arrow direction"></i>{{ $downstream }}%</span> from initial valuation were realized due to continued operation of my technical deliverables.
                @if($downstreamEvent = data_get($page, 'downstream_event'))
                This valuation increase was a result of <strong>{{ $downstreamEvent }}</strong>.
                @endif
            </p>
            @endif
        </article>
        @elseif($page->isCurrent())
        <article>
            <h2>Results</h2>
            <div class="no-data">
                <h3 class="loading collapse">In progress</h3>
            </div>
        </article>
        @endif
        @if($page->links && count($page->links))
        <article>
            <h2>References</h2>
            <ul>
                @foreach($page->links as $link)
                <li><a href="{{ $link }}" class="dont-break-out" target="_blank" rel="nofollow">{{ $link }} <i class="bx bx-link-external"></i></a></li>
                @endforeach
            </ul>
        </article>
        @endif
    </div>
</section>
@if(($siblingPages = $page->getSiblingPages($missions))->isNotEmpty())
<section>
    <div class="container">
        <article class="pagination">
            @if($previousMission = $siblingPages->get('previous'))
            <div class="previous"><a href="{{ $previousMission->getUrl() }}"><i class="bx bxs-left-arrow-circle bx-lg"></i> {{ $previousMission->company }}</a></div>
            @endif
            <div class="divider"><a href="/missions/" title="Back to Track Record"><i class="bx bx-list-ul bx-lg"></i> <span>Track Record</span></a></div>
            @if($nextMission = $siblingPages->get('next'))
            <div class="next"><a href="{{ $nextMission->getUrl() }}">{{ $nextMission->company }} <i class="bx bxs-right-arrow-circle bx-lg"></i></a></div>
            @endif
        </article>
    </div>
</section>
@endif
@endsection
