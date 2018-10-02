---
layout: markdown
permalink: /colophon/
title: "Colophon"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/colophon-gears.jpg
description: Steven Maguire designs and maintains this website from his home in Chicago, Illinois. Codeship.com builds and deploys the site to an AWS S3 bucket.
---

StevenMaguire.com has been a revolving door of content and implementation styles. In [2006](https://web.archive.org/web/*/stevenmaguire.com) it started as static HTML and basic CSS. Next it had a strong run as a WordPress site. Later, homegrown PHP and MySQL replaced WordPress. After discovering Laravel, the site entered the modern age of mature framework support.

Now (circa 2014) it’s back to being static HTML and CSS, with some modern goodies to help keep things manageable. These goodies include Jekyll, Bootstrap, and AWS.

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
    <li>Codeship.com - free continuous integration and deployment</li>
    <li>AWS S3 - <strike>free</strike> ridiculously cheap static file hosting</li>
</ul>


## Changelog

<ul>
    {% for event in site.data.changelog_events %}
    <li>{{ event.date | date: '%Y-%m-%d' }} - {{ event.message }} <!-- {{ event.id }} --></li>
    {% endfor %}
</ul>
