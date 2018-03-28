---
layout: page
permalink: /publications/
title: "Thoughts &amp; Ideas"
image: https://s3.amazonaws.com/static.stevenmaguire.com/articles/laravel-ci.jpg
description: I've curated the following list of posts, presentations, video training courses, and interviews that I've published.
---

<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2  text-center">
                <p>I've curated the following list of <a href="#posts" class="page-scroll">posts</a>, <a href="#presentations" class="page-scroll">presentations</a>, <a href="#video-training" class="page-scroll">video training courses</a>, and <a href="#interviews" class="page-scroll">interviews</a> that I've published.</p>
            </div>
        </div>
    </div>
    <div class="container multi-row">
        <hr />
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1  text-center" id="posts">
                <h2>Posts</h2>
            </div>
            {% for post in site.posts %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                <div class="writing project">
                <h2><a href="{{ post.url }}">{{ post.title }}</a></h2>
                {% if post.description %}<blockquote><p>{{ post.description }}</p></blockquote>{% endif %}
                <p>{{ post.excerpt }}</p>
                <p>{{ post.date | date: "%B %e, %Y" }}</p>
                </div>
            </div>
            {% endfor %}
        </div>
        <hr />
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 text-center" id="presentations">
                <h2>Presentations</h2>
            </div>
            {% assign sorted_presentations = site.publications | sort: 'date' | reverse | where: 'category', 'presentation' %}
            {% for presentation in sorted_presentations %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                {% assign publication = presentation %}
                {% include publication.html content=publication %}
            </div>
            {% endfor %}
        </div>
        <hr />
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1  text-center" id="video-training">
                <h2>Video Training</h2>
            </div>
            {% assign sorted_training = site.publications | sort: 'date' | reverse | where: 'category', 'training' %}
            {% for training in sorted_training %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                {% assign publication = training %}
                {% include publication.html content=publication %}
            </div>
            {% endfor %}
        </div>
        <hr />
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1  text-center" id="interviews">
                <h2>Interviews</h2>
            </div>
            {% assign sorted_interviews = site.publications | sort: 'date' | reverse | where: 'category', 'interview' %}
            {% for interview in sorted_interviews %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                {% assign publication = interview %}
                {% include publication.html content=publication %}
            </div>
            {% endfor %}
        </div>
    </div>
</section>
