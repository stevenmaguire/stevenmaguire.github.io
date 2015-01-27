---
layout: post
title: Fire your in-house QA team immediately
date: 2015-01-27 12:00:00
---

Now that I’ve got your attention, don’t fire your QA team. Instead consider the enclosed thoughts on how a manual testing process may be hurting the overall quality of your product and skills advancement of your engineering team.

Let’s explore two extremes on the spectrum of manual quality assurance.

### Scenario 1: Terrible at communicating requirements

If you have little to no documentation, or are admittedly bad at communicating test requirements, your testers are probably serving as product managers, with bad timing, more so than ensuring your product meets a clear standard of quality.

You may experience an overall quality lift from this scenario, but it will come at a greater cost that manifests itself in decreased project timeliness, increased friction between testers and engineers, and a lot of discussion about “scope creep” among project stakeholders.

When your testing staff is asked to test software without a clearly defined set of expectations and behaviors, they may feel compelled to engage in [exploratory testing](http://en.wikipedia.org/wiki/Exploratory_testing) in which they consider new scenarios and assert their own expectations of the software behavior. Any violations of these newly formed expectations may turn up as defect reports in your project management tracking system. When defects are reported by testers they require further research and resolution; a process that involves testers, engineers, designers, and project stakeholders.

Effort spent deciding if a defect report is related to a current feature, new feature, or not a defect at all is costly. Reduce these conversations where possible.

### Scenario 2: Terrific at communicating requirements

If you are great at communicating test requirements, and still rely exclusively on manual testing, you may be losing valuable opportunities to speed up your product development velocity with little effort.

Whether your impressive requirements documentation process begins before, during, or after engineering, it consumes a lot of energy and time. The documents are a thorough accounting of each of the scenarios your product expects, and more it doesn’t. For each of these scenarios, you’ve likely made clear indications about the inputs, actions, and expected output.

While this level of detail is thorough and yields better clarity of the quality of your product, it is still limited by the number of team members tasked with executing the scripts. Additionally, on-boarding new test runners requires valuable time from your most experienced team members.

## Start today, improve tomorrow

If you identify with Scenario 1, Scenario 2, or more likely somewhere in between, you need to consider the benefits of putting your testing on auto-pilot and still improve overall product quality; work towards a reality where you can stop manual testing altogether.

The first step in achieving this involves moving the responsibility of test creation and execution to the engineers. Quality engineers want to test their code and appreciate the value of a well-maintained automated test suite. A great test suite will communicate software requirements to new engineers, speedup defect research and resolution, and give your project stakeholders a tangible list of metrics to communicate the health of a product.

Your engineers build quality code. Encourage them to build quality tests; they can do it.

After your engineering team assumes responsibility for writing and executing tests, give them time to configure and automate a test environment. This environment will serve as an unbiased, on-demand army of testers who report defects for documented expectations or configuration issues; the types of things you don’t want your customers seeing. A testing server will be a fraction of the cost compared to a person and can perform exponentially more tests.

Configuring your first test environment won’t fit into your revenue generating project plans, but give it the room and time to evolve; it’s an operational investment worth making.

## Refine human contributions

If the engineers are testing now, its time to fire the QA team right? Don’t do it! They are valuable members of the team and their skills can be focused on assisting this new automated test culture.

Some of your testing team members are analytical, thoughtful and have proven track record of being full of valuable insights. Focus their energy on the planning phase of your product development sprint. I am sure they can help surface the edge cases and scenarios that matter to your customers; the engineers would love to have those itemized ahead of time anyway. I am sure they can even help to convert your manual test scripts into an automation friendly format, like [Gherkin](http://en.wikipedia.org/wiki/Cucumber_(software)) or other [BDD](http://en.wikipedia.org/wiki/Behavior-driven_development) test format.

![Example of BDD test script](http://stevenmaguire-com.s3.amazonaws.com/assets/bdd-test-script.png)

Others on the testing team have an affinity for the process of executing tests and reporting results to the rest of the team. Empower these team members to continue adding value in this capacity, but by managing and maintaining test environments, observing builds, and making operational improvements to your testing infrastructure.

## Rinse and repeat

Testing is an incredibly important part of the product development process and as software continues to improve so do the tools and practices built to support it. Make a few small steps in the direction of of an automated testing culture everyday; the results may just surprise you.

