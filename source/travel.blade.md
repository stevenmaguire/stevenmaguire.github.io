---
extends: _layouts.main
title: "Travel"
section: body
---

<section class="intro">
    <div class="container">
        <h1>Travel<span class="dot">.</span></h1>
        <div class="intro-content">
            <p>Traveling is important to me. It gives me the chance to see the world from different perspectives. I get to meet new people and learn about other ways of life. It's a way to step out of my routine and grow, making me appreciate both the big and small things in life even more.</p>
            <p>I take photos and video along the way. Sometimes I share them online. That is what you can expect to find here.</p>
            <p>Over the years, two unique patterns in these posts emerged as unique series. I've organized those series in separate lists - as well as the full log - below. Enjoy.</p>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <article>
            <div class="cards">
                <div class="card">
                    <i class="bx bxs-castle bx-lg"></i>
                    <h3>Oddly Specific Museums</h3>
                    <p>A trend of visiting niche and unusually small museums.</p>
                    <p><a href="/travel/oddly-specific-museums/">Oddly Specific Museums &raquo;</a></p>
                </div>
                <div class="card">
                    <i class="bx bx-walk bx-lg"></i>
                    <h3>Bumbling Tourist</h3>
                    <p>A satirical take on travel in the voice of a bumbling tourist.</p>
                    <p><a href="/travel/bumbling-tourist/">Bumbling Tourist &raquo;</a></p>
                </div>
            </div>
        </article>
    </div>
</section>
@if($travel->isNotEmpty())
<section class="accent content" id="all">
    <div class="container">
        <h2>All Travel Logs <small class="extra dot">{{ count($travel) }}</small></h2>
        <x-travel-list :travel-logs="$travel" />
    </div>
</section>
@endif
