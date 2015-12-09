---
layout: thumbnails
permalink: /artwork/
title: "Artwork"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/desk-ruler-designer-chair.jpeg
---

<div class="col-sm-12 text-center">
    <h2>Logos</h2>
    <hr />
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
