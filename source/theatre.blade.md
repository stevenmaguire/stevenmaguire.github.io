---
extends: _layouts.main
title: "Theatre"
image: https://static.stevenmaguire.com/articles/my-fair-lady.jpg
description: I began this life as a carpenter, designing and building scenery for theatrical productions.
section: body
---

@php
    $ecuCommonCredits = $theatre->filter(fn ($c) => collect($c->footnotes)->contains('ecu-common-credit'))
@endphp

<section class="intro">
    <div class="container">
        <h1>Theatre<span class="dot">.</span></h1>
        <div class="intro-content">
            <p>I began this post-adolescent life as a carpenter. I designed and built scenery for theatrical productions. What was a special interest in high school, grew into a passion in college. I enrolled in East Carolina University's School of Theatre and Dance. I rose through the ranks of the Design and Production program. I worked as a T.A. and Master Carpenter.</p>
            <p>I've preserved this list of theatrical credits earned during my seven year "career." A career that I left behind to pursue <a href="/artwork">graphic design</a> and <a href="/open-source">software development</a>.</p>
        </div>
    </div>
</section>
@if($theatre->isNotEmpty())
<section id="opensource" class="accent content">
    <div class="container">
        <h2>Production Credits</h2>
        @foreach($theatre as $credit)
        <article>
        @php
            $location = $credit->locationMeta();
        @endphp
        <h3>{{ $credit->name }}@if(collect($credit->footnotes)->contains('ecu-common-credit'))*@endif</h3>
        <p>{{ $credit->season }} | {{ $credit->dates }}@if($location) | {{ $location['name'] }}@endif</p>
        @if(count($credit->roles))
        <p><strong>Roles:</strong> {{ collect($credit->roles)->map(fn ($r) => sprintf('%s (%s)', $r['name'], $r['department']))->join(', ') }}</p>
        @foreach($credit->roles as $role)
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "TheaterEvent",
            "name": "{{ $credit->name }}",
            "startDate": "{{ $credit->open_date }}",
            "endDate": "{{ $credit->close_date }}",
            "workPerformed": {
                "@type": "CreativeWork",
                "name": "{{ $credit->name }}"
            },
            @if($location)
            "location": {
                "@type": "Place",
                "name": "{{ $location['name'] }}",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "{{ $location['street_address'] }}",
                    "addressLocality": "{{ $location['locality'] }}",
                    "postalCode": "{{ $location['postal_code'] }}",
                    "addressRegion": "{{ $location['region'] }}",
                    "addressCountry": "{{ $location['country'] }}"
                }
            },
            @endif
            "contributor": {
                "@context": "http://schema.org",
                "@type": "Person",
                "image": "https://static.stevenmaguire.com/headshot-201603.jpg",
                "jobTitle": "{{$credit->name}} ({{ $credit->department }})",
                "name": "Steven Maguire",
                "description": "{{$credit->name}} ({{ $credit->department }})"
            }
        }
        </script>
        @endforeach
        @endif
        </article>
        @endforeach
    </div>
</section>
@if($ecuCommonCredits->isNotEmpty())
<section class="accent content">
    <div class="container">
        <p><em>* - Source: http://www.theatre-dance.ecu.edu ({{ $ecuCommonCredits->count() }} {{ Illuminate\Support\Str::plural('record', $ecuCommonCredits->count()) }} displayed) - {{ Illuminate\Support\Str::plural('record', $ecuCommonCredits->count()) }} billed as Steven C. Maguire and produced by ECU/Loessin Playhouse</em></p>
    </div>
</section>
@endif
@endif
