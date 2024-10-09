---
title: The 10¢ ecommerce website (elbow grease not included)
date: 2018-03-30 09:00:00 -0500
image: https://footballcroptop.com/images/football-field.jpg
description: How to build an automated affiliate website with an ecommerce experience for pennies per month.
elsewhere:
    - https://coderwall.com/p/ui995q/build-a-shareasale-proxy-with-slim-php-framework
---

I love the Internet. It’s a wild and random ecosystem with very few guardrails or black-and-white rules on how to "do the Internet right." One of my favorite aspects of the Internet is just how low the barrier of entry is to jump in and play; the tools and access to technical education are improving every day. Unfortunately, there are still some hard expenses associated with getting a website out into space and that can really take the fun out of playing (and learning) on the Internet.

With that in mind, I want to tell you about a new website I launched: [FootballCropTop.com](https://footballcroptop.com).

While I think it's important that there is now a website dedicated exclusively to helping you find [crop top shirts adorned with your favorite sports team branding](https://footballcroptop.com), I think it is far more interesting to share, step by step, how I built and maintain FootballCropTop.com for, what shakes out to be, **10¢ per month**.

---

## Buying an awesome domain

In addition to being, in my opinion, a hilarious and random domain name, it is obvious what is offered on FootballCropTop.com without ever having to go to the website. If you knew that it offered [crop top shirts adorned with your favorite sports team branding](https://footballcroptop.com) straight away then I think you know that it is an amazingly high quality domain name. Not [youboob.com](http://www.youboob.com/sale/) quality, but it certainly establishes the very precise niche it represents, both from a conversational and a keyword perspective.

> **Sidebar** - From an academic perspective it is incredibly irresponsible to buy a domain name before you know that you have a market-validated use for it. I'm more transparent and messy than I am academic, so here's what really happened.
>
> I was watching some sweet college football tournament action with some friends and was delighted with just how many players were wearing crop top jerseys.  We had to know more! Most importantly, we had to know where we could buy our own! I noticed [FootballCropTop.com](https://footballcroptop.com) was available so I bought it without anything specific in mind. I just thought it was funny and it was available.

---

## Evaluating market research and validation

Usually I would perform this step before committing to purchasing a new domain name, but since I already had one in hand, it did make it a bit easier to work through the research. The goal here is to figure out if there is a reasonable path to "success" with the resources available in the marketplace. I needed to answer some key questions:

- What exactly is my content?
- Am I selling something?
- What am I selling?
- Do these products exist?
- Are there affiliate programs, with APIs, that feed these products?
- How many potential customers are there? What do they search when they want crop tops?

In the end, I discovered that crop top product listings associated with affiliate links would be the best content. So I needed to find a proper affiliate; and more importantly one that offered an API to access product updates programmatically. Though I am not selling something directly (simply linking to affiliate ecommerce sites), I did want to provide an ecommerce-esque experience. I shopped around for ecommerce sites that offered branded football apparel.

A quick Google search turned up [Fanatics.com](https://shareasale.com/r.cfm?b=31196&u=1730429&m=7124&urllink=www%2Efanatics%2Ecom%2F%3Fquery%3Dcrop%2520top&afftrack=). I searched their inventory for "crop tops" and found just shy of 200 products available. Great! That is more than enough for my goals. Then I did a bit of digging and discovered that they offered an affiliate program via two providers; one that I had worked with before, [ShareASale](https://shareasale.com/r.cfm?b=69&u=1730429&m=47&urllink=&afftrack=). The ShareASale program offered an API to access a product feed from Fanatics.com. A quick pulse check shows no major roadblocks and the path looks pretty clear from here – let's plow forward!

---

## Establishing a basic design

I frequently use [Jekyll](https://jekyllrb.com/) for personal projects - it is a static site generator built with Ruby that gives you a ton of power to build and maintain plain old HTML websites. Working with it feels like working with a CMS or other server-side application, but it doesn't need to actively run on an application server; it simply spits out HTML files which can be hosted almost anywhere dirt-cheap without much concern around scaling.

Another resource I use frequently are the HTML/CSS/JS templates available at [HTML5 UP](https://html5up.net/). They offer a great selection of modern, responsive templates for free (with attribution) that give you a great starting place for a brand new project or MVP. I don't look at these templates through the lens of "this is my site always and forever." I just want to find something appropriate for my content that allows me to begin building a site without getting hung up on style and layout issues at every turn. You can always go back through the project and replace the template with relative ease later.

Since I harvested a general plan and vision from the previous steps, it was easy to scroll through the options and zero in on a design that I wanted to start with. I fired off a `jekyll new footballcroptop.com` into my terminal and started building.

I wasn't sure about the exact format of the data I would get from ShareASale (because I hadn't applied yet), but I did have some basic ideas about the various pages and product information I wanted to offer so I started roughing in pages with dummy data. I created:

- Product List (Category) Page
- Product Detail Page

I filled these pages with a primitive set of product data:

- Title
- Image
- Price

I began to get a feel for how I wanted product data to flow through the Jekyll app by creating a `products.json` file (with dummy data) in the `_data` directory and used that to loop over products on the list and detail pages. I was satisfied enough that I wanted to start to get some real data.

I manually scraped some football team data from Wikipedia and set up a single-table database on my local machine - I wanted to use this to add some structure for my categories:

```
CREATE TABLE `teams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `abbreviation` varchar(10) DEFAULT NULL,
  `conference` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `league` varchar(255) DEFAULT NULL,
  `stop_words` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
)
```

159 records later I ran a script to convert CSV exported data from the table into JSON and added a `teams.json` file to the `_data` directory. This would serve as the foundation of my categories: `leagues`, `conferences`, `states`, `cities`, and `teams`.

I created the initial version of a `product_organizer.rb` Ruby file in the `_plugins` directory and used [Jekyll's Plugin Hooks](https://jekyllrb.com/docs/plugins/#hooks) to trigger this organizer to run `after_init` ("Just after the site initializes, but before setup & render. Good for modifying the configuration of the site.") This initial version of the organizer was tasked with looping over all the teams and creating individual data collections for each of the category types based on the distinct values of the `teams.json`. I share the final product organizer code a bit later.

I used these categories to layer in product list pages for each category, as well as some basic link lists in the footer of the site. Now, I've got a basic skeleton of a site and I am ready for real product data.

## Applying for affiliate program

The site was still only running locally on my machine and I thought I could apply for access to the affiliate program without having launched the site yet. I was wrong and my application was denied - and with a very vague reason that didn't say _"Yo! You don't have a real website!"_ I decided to rectify that and move forward with launching the site in a "staged" capacity with real product information but not active affiliate links (because I didn't have them yet).

---

## Manually scraping staging product data

I took a much closer look at the product data available on Fanatics.com and decided that I wanted to collect a small sample of product data mapped into a loose data structure:

- id
- name
- price_in_cents_retail
- price_in_cents_actual
- discount_in_cents (price_in_cents_retail - price_in_cents_actual)
- thumbnail_image_url
- product_url

I posted a job on [Upwork.com](https://www.upwork.com) asking for a freelancer to visit the search results page for "crop top" on Fanatics.com and manually extract the data for the approximately 170 products listed in the search results, returned in a CSV file. I offered $10.00 for this job and someone took it within 10 minutes of posting.

I replaced my dummy data filled `products.json` with my staging data filled `products.json`, then tweaked my product list and detail page templates to use this new structure. I ran `jekyll serve` and it looked great. Now to deploy it somewhere.

---

## Deploying

Github offers free hosting for static HTML websites via a product called [Github Pages](https://pages.github.com). Additionally, if your static site is built with Jekyll, they will use their own servers to perform the build operation and deploy the generated site files to their servers. I do this frequently with simple Jekyll sites. Unfortunately because of our `product_organizer.rb` plugin, Github will not allow my site to be built on their servers. There are workarounds for this which involve multiple branches in your project and a bit of command line gymnastics. My goal here is “simple and maintainable” so I choose not to go that route. Instead, I will build (for free) and host (for pennies) elsewhere.

---

## Deploying - take two

[Codeship](https://codeship.com) is a player in the Continuous Integration (CI) space; I've been a customer for a handful of years. They offer a free plan for projects that don’t have a lot of build activity or tax their infrastructure too heavily. This plan is more than adequate for my needs. The product offers a Just-In-Time (JIT) container based build process as well as a user interface to configure deployments to S3. I created an S3 bucket (with "static website hosting" enabled), set up the basic project build and deployment settings, then committed my code to a repo on Github; we're off to the races. Every time I commit code to the master branch, this build and deployment process will kick-off and run.

---

## Utilizing Cloudfront as a CDN

After years of building simple static HTML sites for one-off silly (or ridiculous) projects, I've learned to embrace a CDN early on. In my opinion, it's easier to layer it in early and not need it than it is to insert it later, especially if you are under load.

I set up one distribution that points to one custom origin for the URL offered by the "static website hosting" feature within S3. After this distribution was (finally) deployed and ready, it was time to point my domain to the hosted content.

---

## SSL termination and reverse proxying with Digital Ocean

A habit I've picked up is to always configure SSL for my projects. At this point in my life I will not launch a new website without adding SSL support. This used to be kind of expensive. Fortunately for us all, [LetsEncrypt](https://letsencrypt.org) is a low-cost (sort of free) solution for obtaining SSL encryption for your projects. The actual certificates are completely free. The "sort of free" part comes from a requirement by LetsEncrypt to renew the cert after a matter of weeks rather than annually. You will need to do this manually (ugh!) or find a tool that will automate the renewal and deployment of updated certificates.

For my non-static personal projects that require an application server, I use a couple of Droplets in my [Digital Ocean account](https://m.do.co/c/196f6f6823aa), mostly running PHP and MySQL. I use a tool called [Forge](https://forge.laravel.com) to provision and maintain the configuration of those Droplets. One of the awesome features of Forge is automated renewal of LetsEncrypt certificates.

I updated the DNS for FootballCropTop.com, set up an NGINX reverse proxy on Digital Ocean to the Cloudfront distribution I created earlier, and requested a LetsEncrypt certificate. Now the site is alive and well, accessible in browsers everywhere; especially by the fine folks at ShareASale.

---

## Applying for affiliate program - take two

I replied to the denial notification email from ShareASale and asked if they would mind reviewing my application again. It took a bit of doing and follow-ups but they finally re-evaluated my application and granted me access to the Fanatics.com affiliate program.

---

## ShareASale proxying with Digital Ocean

In order to access the [product feed API offered by ShareASale](http://blog.shareasale.com/2013/02/15/api-product-search/) you will need to configure some basic security and access controls. One such control is an IP whitelist feature. This requires you to explicitly define all (up to five) of the IP addresses that will be allowed to access the API using your access credentials. This means you will need to have a static IP address somewhere out in the wild.

I previously mentioned that I do some light hosting on [Digital Ocean](https://m.do.co/c/196f6f6823aa) and each of those Droplets are issued a static IP, something that I am already paying for (~$5/month) so I decide to build a small proxy app in PHP using the [Slim Framework](https://www.slimframework.com). In addition to the static IP whitelisting requirement, ShareASale also requires that each request be signed with an encrypted token which must be done on each request. I'd like to use other tools (like [Postman](https://www.getpostman.com/) locally or [AWS Lambdas](https://aws.amazon.com/lambda/) in the cloud) to access the ShareASale data through the static IP address associated with the Droplet hosting this small proxy app. I came up with a basic design that would allow me to set my secret credential information via headers and forward a request through the proxy. In turn the proxy will sign and authenticate the request, fetch the results, cleanup and format a nice response (ShareASale is _not_ the best in this area), and finally send it back to the requesting client. Here is the code from my Slim project that does this work:

<script src="https://gist.github.com/stevenmaguire/912865639ff91e7a99a5f9fb46be7f02.js"></script>

With this little piece of infrastructure in place I am free to begin consuming the product feed data from basically anywhere.

---

## Working with real data

Real-life data tells the real story and now that I have unrestricted access to the product feed data for Fanatics.com, I can start to dial in the requirements of the `product_organizer.rb` plugin to organize the product data for successful generation of the Jekyll site.

<script src="https://gist.github.com/stevenmaguire/64b28db81a3abeb552481ad1995af505.js"></script>

---

## Automating daily production builds with AWS Lambda and Cloudwatch

Amazon Web Services (AWS) offers a product called Lambda, which I've mentioned before, that is a great tool to off-load one-off processes to an isolated pool of resources where you only pay for what you use. In the case of FootballCropTop.com, I only need the service to wake up once per day, fetch the latest product feed from ShareASale, and initiate a new build of the project with the latest products. I don't want to pay a monthly fee for a server to be up and running, on my dime, when it won't be used 99.999999999% of the time.

I wrote a very simple Lambda function (in JavaScript using Node) to fetch the latest product feed data using the proxy app, format the data into the `products.json` schema, then commit those changes directly to the Jekyll repo - kicking off a new build via Codeship.

<script src="https://gist.github.com/stevenmaguire/bd033725b18ac6429724ca3049c757c2.js"></script>

Finally, I set up a CloudWatch Rule to trigger this Lambda function once per day. Voila! Automated daily refreshes of FootballCropTop.com.

---

## Wrapping up

Every web project is going to cost something. Sometimes it's a hard, monthly, out-of-pocket expense, other times it's a routine manual task that costs some of your free time. Occasionally, like this project, you can spend a little bit more time and elbow grease planning and executing up front and wind up with a project that is alive-and-well without either of those recurring expenses.

In the case of FootballCropTop.com, I have an automatically updating static HTML website with loads of affiliate links, security, scalability, and a 93% Google PageSpeed Insight score (I can't go higher because of the images hosted by Fanatics.com - boo!) that has added only pennies per month to my existing out-of-pocket expenses.

I am indeed using some paid services (like Digital Ocean, Forge, Github, AWS), but because of careful planning and resource conservation, these services are either free because of low utilization or costs are commingled with other projects.

![technical design of FootballCropTop.com](https://static.stevenmaguire.com/articles/footballcroptop-topology.jpg)
