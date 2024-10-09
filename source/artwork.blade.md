---
extends: _layouts.main
title: "Artwork"
image: https://static.stevenmaguire.com/articles/desk-ruler-designer-chair.jpeg
description: After transitioning from designing and building thatrical scenery to a digital focus, I taught myself to craft of graphic and web design.
section: body
---

<section class="intro">
    <div class="container">
        <h1>Artwork<span class="dot">.</span></h1>
        <div class="intro-content">
            <p>After <a href="/theatre">designing and building theatrical scenery</a>, I taught myself graphic and web design. I designed artwork in the form of vector illustrations, websites, and photography. Later, I got paid for that work by East Carolina University, the City of Greenville N.C., and a host of more than 30 clients. Some of that work is here.</p>
        </div>
    </div>
</section>
@if($logos->isNotEmpty())
<section id="opensource" class="accent content">
    <div class="container">
        <h2>Logos</h2>
        <div class="cards">
            @foreach ($logos as $logo)
            <div class="card text-center">
                <figure>
                    <img data-src="https://static.stevenmaguire.com/logos/{{ $logo->image }}" alt="{{ $logo->client }}">
                    <figcaption>{{ $logo->client }}</figcaption>
                </figure>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
