---
layout: page
permalink: /open-source/
title: "Open source projects"
author: "Steven Maguire"
author_image: https://stevenmaguire-com.s3.amazonaws.com/assets/steven.png
---

If you [get to know me](/about), you'll learn that [I love open source software](https://github.com/stevenmaguire); contributing and consuming. I've curated the following list of {{ site.opensource.size }} open source projects that I maintain.

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
{% for project in site.opensource %}
<div class="project">
    <span class="pull-right">
        <span class="role">{{ project.role }}</span>
        <span class="language">{{ project.language }}</span>
    </span>
    <h2><a href="{{ project.url }}" target="_blank"><i class="fa fa-github"></i> {{ project.name }}</a></h2>
    <p>{{ project.description }}</p>
</div>
{% endfor %}
