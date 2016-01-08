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
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1  text-center" id="posts">
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
            <div class="col-sm-10 col-sm-offset-1  text-center" id="presentations">
                <h2>Presentations</h2>
                <hr>
            </div>
            {% assign sorted_presentations = site.publications | sort: 'date' | reverse | where: 'category', 'presentation' %}
            {% for presentation in sorted_presentations %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                <div class="writing project">
                <h2><a href="{{ presentation.link }}">{{ presentation.title }}</a></h2>
                <p>{{ presentation.content }}</p>
                <p>Presented to <strong>{{ presentation.audience }}</strong> on {{ presentation.date | date: "%B %e, %Y" }}</p>
                </div>
            </div>
            {% endfor %}
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1  text-center" id="video-training">
                <h2>Video Training</h2>
                <hr>
            </div>
            {% assign sorted_training = site.publications | sort: 'date' | reverse | where: 'category', 'training' %}
            {% for training in sorted_training %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                <div class="writing project">
                <h2><a href="{{ training.link }}">{{ training.title }}</a></h2>
                <p>{{ training.content }}</p>
                <p>Published to <strong>{{ training.audience }}</strong> on {{ training.date | date: "%B %e, %Y" }}</p>
                </div>
            </div>
            {% endfor %}
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1  text-center" id="interviews">
                <h2>Interviews</h2>
                <hr>
            </div>
            {% assign sorted_interviews = site.publications | sort: 'date' | reverse | where: 'category', 'interview' %}
            {% for interview in sorted_interviews %}
            <div class="col-sm-10 col-sm-offset-1 text-center">
                <div class="writing project">
                <h2><a href="{{ interview.link }}">{{ interview.title }}</a></h2>
                <p>{{ interview.content }}</p>
                <p>Presented to <strong>{{ interview.audience }}</strong> on {{ interview.date | date: "%B %e, %Y" }}</p>
                </div>
            </div>
            {% endfor %}
        </div>
    </div>
</section>
