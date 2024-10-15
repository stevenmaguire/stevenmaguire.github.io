---
extends: _layouts.markdown
title: "Colophon"
image: https://static.stevenmaguire.com/articles/colophon-gears.jpg
description: Steven Maguire designs and maintains this website from his home in Chicago, Illinois. Codeship.com builds and deploys the site to an AWS S3 bucket.
---

StevenMaguire.com has been a revolving door of content and implementation styles. In [2006](https://web.archive.org/web/*/stevenmaguire.com) it started as static HTML and basic CSS. Next it had a strong run as a WordPress site. Later, homegrown PHP and MySQL replaced WordPress. After discovering Laravel, the site entered the modern age of mature framework support.

Since 2014 it’s back to being static HTML and CSS, with some modern goodies to help keep things manageable.

## Frontend

<ul>
    <li>Jigsaw - static site generator</li>
</ul>

## Backend

<ul>
    <li>AWS Lambda - http accessible functions that run code without worrying about servers</li>
</ul>

## Hosting

<ul>
    <li>Github Actions - free continuous integration and deployment</li>
    <li>AWS S3 - <strike>free</strike> ridiculously cheap static file hosting</li>
</ul>


@if($changelog->isNotEmpty())
## Changelog

<ul>
    @foreach($changelog as $event)
    <li>{{ Carbon\Carbon::parse($event->date)->format('Y-m-d') }} - {{ $event->message }}</li>
    @endforeach
</ul>
@endif
