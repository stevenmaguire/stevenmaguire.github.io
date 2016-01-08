---
layout: inner
permalink: /artwork/
title: "Artwork"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/desk-ruler-designer-chair.jpeg
description: After transitioning from designing and building thatrical scenery to a digital focus, I taught myself to craft of graphic and web design.
---

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <p>After transitioning from <a href="/theatre">designing and building thatrical scenery</a> to a digital focus, I taught myself to craft of graphic and web design. I worked for East Carolina University, the City of Greenville City Manager's office, and a host of more than 30 clients designing and delivering artwork in the form of vector illustrations, websites, and photography. Some of that work is presented here.</p>
    </div>
    <div class="col-sm-12 text-center">
        <h2>Logos</h2>
        <hr />
    </div>
</div>
{% for logo in site.logos %}
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <a href="#" class="portfolio-box">
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
