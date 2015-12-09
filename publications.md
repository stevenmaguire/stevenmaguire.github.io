---
layout: master
permalink: /publications/
title: "Publications"
author: "Steven Maguire"
author_image: http://stevenmaguire-com.s3.amazonaws.com/assets/steven.png
image: http://static.stevenmaguire.com.s3.amazonaws.com/articles/laravel-ci.jpg
---



<header class="inner" style="background-image: url('{{ page.image }}')">
    <div class="header-content">
        <div class="header-content-inner">
            <h1>{{ page.title }}</h1>
        </div>
    </div>
</header>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <p>If you <a href="/about">get to know me</a>, you'll learn that <a href="https://github.com/stevenmaguire">I love open source software</a>; contributing and consuming. I've curated the following list of {{ site.opensource.size }} open source projects that I maintain.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1  text-center">
                <a name="posts"></a>
                <h2>Posts</h2>
                <hr>
            </div>
            {% for post in site.posts %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                <div class="writing project">
                <h2><a href="{{ post.url }}">{{ post.title }}</a></h2>
                <p>{{ post.excerpt }}</p>
                <p>{{ post.date | date: "%B %e, %Y" }}</p>
                </div>
            </div>
            {% endfor %}
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1  text-center">
                <a name="presentations"></a>
                <h2>Presentations</h2>
                <hr>
            </div>
            {% for post in site.posts %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                <div class="writing project">
                <h2><a href="{{ post.url }}">{{ post.title }}</a></h2>
                <p>{{ post.excerpt }}</p>
                <p>{{ post.date | date: "%B %e, %Y" }}</p>
                </div>
            </div>
            {% endfor %}
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1  text-center">
                <a name="video"></a>
                <h2>Video Training</h2>
                <hr>
            </div>
            {% for post in site.posts %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                <div class="writing project">
                <h2><a href="{{ post.url }}">{{ post.title }}</a></h2>
                <p>{{ post.excerpt }}</p>
                <p>{{ post.date | date: "%B %e, %Y" }}</p>
                </div>
            </div>
            {% endfor %}
        </div>
    </div>
</section>
