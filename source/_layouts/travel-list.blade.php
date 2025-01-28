@extends('_layouts.main')

@section('body')
<section>
    <div class="container">
        <nav aria-label="Breadcrumb" class="breadcrumb">
            <ol>
                <li><a href="/travel/">All Travel</a></li>
                <li>
                    @foreach(['/travel/oddly-specific-museums' => 'Oddly Specific Museums', '/travel/bumbling-tourist' => 'Bumbling Tourist'] as $url => $label)
                    @if(Illuminate\Support\Str::startsWith($page->getPath(), $url))
                    <span aria-current="page" class="active">{{ $label }}</span>
                    @else
                    <a href="{{ $url }}">{{ $label }}</a>
                    @endif
                    @endforeach
                </li>
            </ol>
        </nav>
    </div>
</section>
@yield('content')
@endsection
