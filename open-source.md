---
layout: inner
permalink: /open-source/
title: "Open Source"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/lake-michigan-sunset.jpg
footnote: oss-opportunities
---

<div class="col-sm-10 col-sm-offset-1 text-center">
    <p>If you <a href="/about">get to know me</a>, you'll learn that <a href="https://github.com/stevenmaguire">I love open source software</a>; contributing and consuming. I've curated the following list of {{ site.opensource.size }} open source projects that I maintain.</p>
</div>
{% for project in site.opensource %}
<div class="col-sm-10 col-sm-offset-1 text-center">
    <div class="open-source project">
        <h2><a href="{{ project.url }}" target="_blank"><i class="fa fa-github"></i> {{ project.name }}</a></h2>
        <p>{{ project.description }}</p>
        <p>{{ project.role }} | {{ project.language }}</p>
    </div>
</div>
{% endfor %}
