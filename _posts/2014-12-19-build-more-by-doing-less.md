---
layout: markdown
title: Build more by doing less
date: 2014-12-19 14:34:25
---

Recently I gave [a presentation](http://bitly.com/laravel-ci-deck) to the Laravel Chicago Meetup group focused on implementing continuous integration for Laravel projects. While a bit technical at times, the presentation’s core message is a cross-cutting piece of advice that can improve performance across an entire organization, including yours.

>Increase the frequency of delivering value by decreasing the size of the deliverable

To truly understand how this advice applies to an entire organization, let’s first take a look at how it manifests itself from the engineering perspective, then work backwards toward the birth of a project idea.

Build a daily deployment culture
----------

These days it is very difficult to attend a conference, skim through your news feed, or talk to your technical friends and miss the value proposition of "agile", "lean", and "continuous integration". Instead of adding to the mountain of persuasive communication about the issue, I want to highlight the observable benefits from adopting such practices.

**Automate production releases** - After you prioritize a project to configure and automate a build server, all code, existing and future alike, can be automatically deployed to one or thousands of production servers in minutes and without the risk of human error.

**Automate testing before production releases** - When the build server is in the strategic position to be capable of automatically deploying code to production, it offers you an always-on, scalable opportunity to test the code before deployment; the last line of quality assurance.

**Write better tests** - If you have an automated process to execute system tests that ensure quality before deployment, you have a reliable test suite to execute. In order to have a reliable test suite, testing must become an integral part of the active product development process. Build the features and the tests that validate them at the same time.

**Clearly define product features** - Better tests are a resulting benefit of feature clarity across the entire product development team.

**Define smaller features** - Product development team clarity increases as complexity decreases. The less time the team spends reaching consensus on the inner workings and value proposition of the feature, the sooner development and testing can begin.

![On the left a typical, loosely defined product; on the right a small sample of the features that compose the product](https://stevenmaguire-com.s3.amazonaws.com/assets/value-complexity-matrix.png)

I would wager that your product development team is not only capable of doing so, but is also eager to implement these practices. Even if several of these processes are in place, it still requires input of small, manageable goals that add value to the business.

The $64,000 question
----------

You have big plans and a vision for the future of your product; how do you achieve “big things” by working on smaller goals?

There is a lot of literature on the topic and much of it is aimed at changing the way you think about big problems. Whether you choose CANI ([Kaizen](http://en.wikipedia.org/wiki/Kaizen)), [PDCA](http://en.wikipedia.org/wiki/PDCA), the [5 Whys](http://en.wikipedia.org/wiki/5_Whys), [Lean](http://en.wikipedia.org/wiki/Lean_manufacturing), or some flavor of [Agile](http://en.wikipedia.org/wiki/Agile_software_development), the goal is the same; establish a path that leads towards a picture of success, then start moving with the intention of learning and adjusting along the way.

Focus on getting started; refine and improve along the way
----------

This is where the aforementioned presentation picks up the thread again. I recommend that you spend some time performing a needs analysis of your team’s skills and development process.

![Example of continuous delivery needs analysis](https://stevenmaguire-com.s3.amazonaws.com/assets/continous-delivery-needs.png)

The goal is to ensure you find a solution that improves the overall speed and quality of delivering value to your customers through incremental improvements of your product.

Once you decide your initial implementation strategy, include its status, health and effectiveness in your regularly occurring retrospectives.

Imagine the change your product & company will see after delivering hundreds of small, measurable improvements this year.
