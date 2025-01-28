@extends('_layouts.main')

@section('body')
<section class="intro">
    <div class="container">
        <h1>{{ $page->title }}<span class="dot">.</span></h1>
    </div>
</section>
<section class="content">
    <div class="container">
        @yield('content')
    </div>
</section>
@if(($siblingPages = $page->getSiblingPages($posts))->isNotEmpty())
<section>
    <div class="container fluid">
        <article class="pagination">
            @if($previousPost = $siblingPages->get('previous'))
            <div class="previous"><a href="{{ $previousPost->getUrl() }}"><i class="bx bxs-left-arrow-circle bx-lg"></i> {{ $previousPost->title }}</a></div>
            @endif
            <div class="divider"><a href="/publications/" title="Back to Thoughts &amp; Ideas"><i class="bx bx-list-ul bx-lg"></i> <span>Thoughts &amp; Ideas</span></a></div>
            @if($nextPost = $siblingPages->get('next'))
            <div class="next"><a href="{{ $nextPost->getUrl() }}">{{ $nextPost->title }} <i class="bx bxs-right-arrow-circle bx-lg"></i></a></div>
            @endif
        </article>
    </div>
</section>
@endif
@endsection
