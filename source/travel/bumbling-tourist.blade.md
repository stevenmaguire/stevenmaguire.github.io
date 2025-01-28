---
extends: _layouts.travel-list
title: "All Travel Logs"
section: content
---
@php
    $bumblingPosts = $travel->filter(fn ($p) => in_array('#bumbling_tourist', data_get($p, 'tags') ?? []))
@endphp
<section class="accent content">
    <div class="container">
        <h2>Bumbling Tourist <small class="extra dot">{{ count($bumblingPosts) }}</small></h2>
        <p>A satirical take on travel in the voice of a bumbling tourist.</p>
        <x-travel-list :travel-logs="$bumblingPosts" />
    </div>
</section>
