---
layout: inner
permalink: /artwork/
title: "Artwork"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/desk-ruler-designer-chair.jpeg
description: After transitioning from designing and building thatrical scenery to a digital focus, I taught myself to craft of graphic and web design.
---

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <p>After <a href="/theatre">designing and building theatrical scenery</a>, I taught myself graphic and web design. I designed artwork in the form of vector illustrations, websites, and photography. Later, I got paid for that work by East Carolina University, the City of Greenville N.C., and a host of more than 30 clients. Some of that work is here.</p>
    </div>
    <div class="col-sm-12 text-center">
        <h2>Logos</h2>
        <hr />
    </div>
</div>
{% for logo in site.logos %}
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <a class="portfolio-box">
        <img src="https://s3.amazonaws.com/static.stevenmaguire.com/logos/{{ logo.image }}" class="img-responsive" alt="">
        <div class="portfolio-box-caption">
            <div class="portfolio-box-caption-content">
                <div class="project-category text-faded">
                    Client
                </div>
                <div class="project-name">
                    {{ logo.client }}
                </div>
            </div>
        </div>
    </a>
</div>
{% endfor %}
