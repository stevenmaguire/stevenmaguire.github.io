---
layout: master
permalink: /art/
title: "Artwork"
author: "Steven Maguire"
author_image: http://stevenmaguire-com.s3.amazonaws.com/assets/steven.png
image: http://static.stevenmaguire.com.s3.amazonaws.com/articles/desk-ruler-designer-chair.jpeg
---

<header class="inner" style="background-image: url('{{ page.image }}')">
    <div class="header-content">
        <div class="header-content-inner">
            <h1>{{ page.title }}</h1>
        </div>
    </div>
</header>
<section class="no-padding" id="logos">
    <div class="container-fluid">
        <div class="row no-gutter">
            {% for logo in site.logos %}
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <a href="#" class="portfolio-box">
                    <img src="http://static.stevenmaguire.com.s3.amazonaws.com/logos/{{ logo.image }}" class="img-responsive" alt="">
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
        </div>
    </div>
</section>
