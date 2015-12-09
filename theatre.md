---
layout: master
permalink: /theatre/
title: "Theatre"
author: "Steven Maguire"
author_image: http://stevenmaguire-com.s3.amazonaws.com/assets/steven.png
image: http://static.stevenmaguire.com.s3.amazonaws.com/articles/my-fair-lady.jpg
---

<header class="inner" style="background-image: url('{{ page.image }}')">
    <div class="header-content">
        <div class="header-content-inner">
            <h1>{{ page.title }}</h1>
        </div>
    </div>
</header>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <p>If you <a href="/about">get to know me</a>, you'll learn that <a href="https://github.com/stevenmaguire">I love open source software</a>; contributing and consuming. I've curated the following list of {{ site.opensource.size }} open source projects that I maintain.</p>
            </div>
            {% for project in site.theatre %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                <div class="theatre project">
                <h2>{{ project.title }}</h2>
                <p>{{ project.role }} ({{ project.department }})</p>
                <p>{{ project.season }} | {{ project.dates }}</p>
                </div>
            </div>
            {% endfor %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                <p><em>* - Source: http://www.theatre-dance.ecu.edu (13 records displayed) All records billed as Steven C. Maguire and produced by ECU/Loessin Playhouse</em></p>
            </div>
        </div>
    </div>
</section>


