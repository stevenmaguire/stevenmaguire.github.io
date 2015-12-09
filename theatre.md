---
layout: inner
permalink: /theatre/
title: "Theatre"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/my-fair-lady.jpg
---

<div class="col-sm-10 col-sm-offset-1">
    <p>If you <a href="/about">get to know me</a>, you'll learn that <a href="https://github.com/stevenmaguire">I love open source software</a>; contributing and consuming. I've curated the following list of {{ site.opensource.size }} open source projects that I maintain.</p>
</div>
{% assign sorted_projects = site.theatre | sort: 'date' | reverse %}
{% for project in sorted_projects %}
<div class="col-sm-10 col-sm-offset-1 text-center">
    <div class="theatre project">
    <h2>{{ project.name }}</h2>
    <p>{{ project.role }} ({{ project.department }})</p>
    <p>{{ project.season }} | {{ project.dates }}</p>
    </div>
</div>
{% endfor %}
<div class="col-sm-10 col-sm-offset-1 text-center">
    <p><em>* - Source: http://www.theatre-dance.ecu.edu (13 records displayed) All records billed as Steven C. Maguire and produced by ECU/Loessin Playhouse</em></p>
</div>


