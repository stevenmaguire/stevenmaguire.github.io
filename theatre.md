---
layout: inner
permalink: /theatre/
title: "Theatre"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/my-fair-lady.jpg
description: I began this life as a carpenter, designing and building scenery for theatrical productions.
---

<div class="col-sm-10 col-sm-offset-1">
    <p>I began this post-adolescent life as a carpenter. I designed and built scenery for theatrical productions. What was a special interest in high school, grew into a passion in college. I enrolled in East Carolina University's School of Theatre and Dance. I rose through the ranks of the Design and Production program. I worked as a T.A. and Master Carpenter.</p>
    <p>I've preserved this list of theatrical credits earned during my seven year "career." A career that I left behind to pursue <a href="/artwork">graphic design</a> and <a href="/open-source">software development</a>.</p>
</div>
{% assign sorted_projects = site.theatre | sort: 'open_date' | reverse %}
{% for project in sorted_projects %}
{% assign location = site.data.locations[project.location] %}
<div class="col-sm-10 col-sm-offset-1 text-center">
    <div class="theatre project">
    <h2>{{ project.name }}{% if project.footnotes contains 'ecu-common-credit' %}*{% endif %}</h2>
    {% if project.roles %}
    <p>
    {% for role in project.roles %}
    {{ role.name }} ({{ role.department }}){% unless forloop.last %}<br />{% endunless %}
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "TheaterEvent",
        "name": "{{ project.name }}",
        "startDate": "{{ project.open_date }}",
        "endDate": "{{ project.close_date }}",
        "workPerformed": {
            "@type": "CreativeWork",
            "name": "{{ project.name }}"
        },
        {% if location %}
        "location": {
            "@type": "Place",
            "name": "{{ location.name }}",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "{{ location.street_address }}",
                "addressLocality": "{{ location.locality }}",
                "postalCode": "{{ location.postal_code }}",
                "addressRegion": "{{ location.region }}",
                "addressCountry": "{{ location.country }}"
            }
        },
        {% endif %}
        "contributor": {
            "@context": "http://schema.org",
            "@type": "Person",
            "image": "https://s3.amazonaws.com/static.stevenmaguire.com/headshot-201603.jpg",
            "jobTitle": "{{role.name}} ({{ role.department }})",
            "name": "{{site.title}}",
            "description": "{{role.name}} ({{ role.department }})"
        }
    }
    </script>
    {% endfor %}
    </p>
    {% endif %}
    <p>{{ project.season }} | {{ project.dates }}{% if location %} | {{ location.name }}{% endif %}</p>
    </div>
    <hr />
</div>
{% endfor %}
{% assign ecu_common_credits = sorted_projects | where: 'footnotes', 'ecu-common-credit' %}
{% if ecu_common_credits %}
{% assign ecu_common_credits_size = ecu_common_credits | size %}
{% capture record_term %}{% if ecu_common_credits_size == 1 %}record{% else %}records{% endif %}{% endcapture %}
<div class="col-sm-10 col-sm-offset-1 text-center">
    <p><em>* - Source: http://www.theatre-dance.ecu.edu ({{ ecu_common_credits_size }} {{ record_term }} displayed) - {{ record_term | capitalize }} billed as Steven C. Maguire and produced by ECU/Loessin Playhouse</em></p>
</div>
{% endif %}


