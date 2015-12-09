---
layout: inner
permalink: /volunteering/
title: "Volunteering"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/all-stars-talent-show.jpg
---

{% assign sorted_projects = site.volunteering | sort: 'date' | reverse %}
{% for project in sorted_projects %}
<div class="col-sm-10 col-sm-offset-1 text-center">
    <div class="theatre project">
    <h2>{{ project.role }}</h2>
    <p>{{ project.organization }} ({{ project.dates }})</p>
    <p>{{ project.description }}</p>
    </div>
</div>
{% endfor %}


