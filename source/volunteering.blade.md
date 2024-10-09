---
extends: _layouts.main
title: "Volunteering"
image: https://static.stevenmaguire.com/articles/all-stars-talent-show.jpg
description: Those who can, do. Those who can do more, volunteer.
section: body
---

<section class="intro">
    <div class="container">
        <h1>Volunteering<span class="dot">.</span></h1>
        <div class="intro-content">
            <blockquote>
                <p>Those who can, do. Those who can do more, volunteer.</p>
            </blockquote>
            <p>I am grateful for the help I received from others through my life. Caring mentors offered me help and guidance at almost every turn. I love to pay it forward. I am proud to volunteer with organizations. I gravitate toward organizations that provide economic education and development to underserved populations.</p>
            <p>I volunteer to give back to my community.</p>
        </div>
    </div>
</section>
@if($volunteering->isNotEmpty())
<section id="opensource" class="accent content">
    <div class="container">
        <h2>Volunteering Experience</h2>
        @foreach($volunteering as $credit)
        <article>
        <h3>{{ $credit->role }}</h3>
        <p>{{ $credit->organization }} ({{ $credit->dates }})</p>
        <p>{{ $credit->description }}</p>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Person",
            "image": "https://static.stevenmaguire.com/headshot-201603.jpg",
            "jobTitle": "{{ $credit->role }}",
            "name": "Steven Maguire",
            "worksFor": {
                "@type": "Organization",
                "name": "{{ $credit->organization }}"
            },
            "description": "{{ $credit->description }}"
        }
        </script>
        @endforeach
</section>
@endif

{{--
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
    "image": "https://static.stevenmaguire.com/headshot-201603.jpg",
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
--}}


