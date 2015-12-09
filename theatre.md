---
layout: inner
permalink: /theatre/
title: "Theatre"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/my-fair-lady.jpg
---

<div class="col-sm-10 col-sm-offset-1">
    <p>I began this life as a carpenter, desigining and building scenery for theatrical productions. What was a special interest in high school, grew into a passion in college. After rising through the ranks of the Design and Production program at the School of Theatre and Dance at East Carolina University I moved on to the digital worlds of <a href="/artwork">graphic design</a> and <a href="/open-source">software development</a>.</p>
    <p>I've preserved this list of theatrical credits earned during my seven year rise from high school "techie" to Master Carpenter at ECU.</p>
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


