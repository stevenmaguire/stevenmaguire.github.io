---
layout: markdown
permalink: /colophon/
title: "Colophon"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/colophon-gears.jpg
description: About this site, specifically how it's built.
---

My personal website has been a revolving door of content and implementation styles [since 2006](https://web.archive.org/web/*/stevenmaguire.com). It started out as static HTML and CSS, then had a strong run as a WordPress site, evolving into homegrown PHP and MySQL, which later matured into a Laravel project.

Now (circa 2014) with the help of Jekyll it's back to being static HTML and CSS, with some modern goodies to help keep things manageable.

## Frontend

<ul>
    <li>Jekyll - static site generator</li>
    <li>Bootstrap - responsive CSS framework</li>
</ul>

## Backend

<ul>
    <li>AWS Lambda - http accessible functions that run code without worrying about servers</li>
</ul>

## Hosting

<ul>
    <li>Github Pages - free hosting provided by Github</li>
</ul>


## Changelog

<ul>
    {% for event in site.data.changelog_events %}
    <li>{{ event.date | date: '%Y-%m-%d' }} - {{ event.message }} <!-- {{ event.id }} --></li>
    {% endfor %}
</ul>
