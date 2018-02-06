---
layout: inner
permalink: /open-source/
title: "Open Source"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/lake-michigan-sunset.jpg
description: I've curated the following list of open source projects that I maintain.
footnote: oss-opportunities
---

<div class="col-sm-10 col-sm-offset-1 text-center">
    <p>If you <a href="/about">get to know me</a>, you'll learn that <a href="https://github.com/stevenmaguire">I love open source software</a>; contributing and consuming. I've curated the following list of {{ site.opensource.size }} open source projects, with over {% if site.data.packagist_stats.downloads.total %}{{ site.data.packagist_stats.downloads.total | round_down: 1000 | comma_delimited }}{% else %}{{ site.stats.opensource_downloads | round_down: 1000 | comma_delimited }}{% endif %} downloads, that I maintain.</p>
    {% if site.data.packagist_stats.timestamp %}
    <p class="footnote"><em>Most</em> stats last updated {{ site.data.packagist_stats.timestamp | date: "%A %B %C, %Y at %I:%M:%S %p %Z" }}</p>
    {% endif%}
</div>

{% assign projects = site.opensource | sort: 'downloads' %}
{% for project in projects reversed %}
<div class="col-sm-10 col-sm-offset-1 text-center">
    <div class="open-source project">
        <h2><a href="{{ project.link }}" target="_blank" title="{{project.downloads}} downloads!"><i class="fa fa-github"></i> {{ project.name }}</a></h2>
        <p>{{ project.description }}</p>
        <p>{{ project.role }} | {{ project.language }}</p>
        <p>
            {% if project.github %}
            <a href="https://github.com/{{ project.github }}/releases"><img src="https://img.shields.io/github/release/{{ project.github }}.svg?style=flat-square" alt="Latest Version" /></a>
            <a href="https://github.com/{{ project.github }}/stargazers"><img src="https://img.shields.io/github/stars/{{ project.github }}.svg?style=social&label=stars&style=flat-square" alt="Stars"/></a>
            {% endif %}
            {% if project.packagist %}
            <a href="https://packagist.org/packages/{{ project.packagist }}"><img src="https://img.shields.io/packagist/dt/{{ project.packagist }}.svg?style=flat-square" alt="Total Downloads" /></a>
            {% endif %}
            {% if project.travis %}
            <a href="https://travis-ci.org/{{ project.travis }}"><img src="https://img.shields.io/travis/{{ project.travis }}/master.svg?style=flat-square" alt="Build Status" /></a>
            {% endif %}
            {% if project.scrutinizer %}
            <a href="https://scrutinizer-ci.com/g/{{ project.scrutinizer }}/code-structure"><img src="https://img.shields.io/scrutinizer/coverage/g/{{ project.scrutinizer }}.svg?style=flat-square" alt="Coverage Status" /></a>
            <a href="https://scrutinizer-ci.com/g/{{ project.scrutinizer }}"><img src="https://img.shields.io/scrutinizer/g/{{ project.scrutinizer }}.svg?style=flat-square" alt="Quality Score" /></a>
            {% endif %}
        </p>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "CreativeWork",
            "author": {
                "@type": "Person",
                "name": "{{site.title}}"
            },
            "creator": {
                "@type": "Person",
                "name": "{{site.title}}"
            },
            "name": "{{ project.name }}",
            "headline": "{{ project.name }}{% if project.downloads %} with {{project.downloads}} downloads{% endif %}",
            "url": "{{ project.link }}",
            "description": "{{ project.description }}",
            "about": "{{ project.language }} Project: {{ project.description }}"
        }
        </script>
    </div>
</div>
{% endfor %}
