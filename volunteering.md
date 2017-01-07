---
layout: inner
permalink: /volunteering/
title: "Volunteering"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/all-stars-talent-show.jpg
description: Those who can, do. Those who can do more, volunteer.
---

<div class="col-sm-10 col-sm-offset-1">
    <blockquote>
        <p>Those who can, do. Those who can do more, volunteer.</p>
    </blockquote>
    <p>I am grateful for the help I received from others through my life. I've been blessed with caring mentors offering help and guidance at every turn. I believe in paying it forward and am very proud to volunteer with organizations who, among other things, provide economic education and development to underserved populations.</p>
    <p>I volunteer to give back to my community.</p>
</div>
<div class="col-sm-10 col-sm-offset-1 text-center">
    <h2>Volunteer Experience</h2>
    <hr>
</div>
{% assign sorted_projects = site.volunteering | sort: 'date' | reverse %}
{% for project in sorted_projects %}
<div class="col-sm-10 col-sm-offset-1 text-center">
    <div class="theatre project">
    <h2>{{ project.role }}</h2>
    <p>{{ project.organization }} ({{ project.dates }})</p>
    <p>{{ project.description }}</p>
    </div>
</div>
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Person",
    "image": "https://s3.amazonaws.com/static.stevenmaguire.com/headshot-201603.jpg",
    "jobTitle": "{{project.role}}",
    "name": "{{site.title}}",
    "worksFor": {
        "@type": "Organization",
        "name": "{{ project.organization }}"
    },
    "description": "{{ project.description }}"
}
</script>
{% endfor %}


