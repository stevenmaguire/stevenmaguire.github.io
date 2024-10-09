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
@endsection
