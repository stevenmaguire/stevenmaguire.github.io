---
extends: _layouts.travel-list
title: "All Travel Logs"
section: content
---
@php
    $museumPosts = $travel->filter(fn ($p) => in_array('#oddly_specific_museums', data_get($p, 'tags') ?? []))
@endphp
<section class="accent content">
    <div class="container">
        <h2>Oddly Specific Museums <small class="extra dot">{{ count($museumPosts) }}</small></h2>
        <p>A trend of visiting niche and unusually small museums.</p>
        <x-travel-list :travel-logs="$museumPosts" />
    </div>
</section>
