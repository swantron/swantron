---
id: 1005
title: 'Chomptron'
date: 2025-12-31T04:00:00+00:00
slug: 'chomptron'
description: 'I bought the domain for a recipe blog, then remembered I hate recipe blogs.'
featured_image: '/uploads/2025/12/chomptron-screenshot.png'
aliases:
  - '/index.php/2025/12/31/chomptron/'
---

Do you hate cooking blogs? Sure, we all do..

Inane story, some ads, ingredient somewhere, more adds, quatities somewhere else, another ad.  Like and subscribe..

It is embarrassing to say that I bought the domain name with that sort of thing in mind. I have some of our go-tos in texts from Katie and others that I have emailed to myself (from texts from Katie). I parked some stuff on WordPress and promptly remembered that I hate WordPress about as much as I hate cooking blogs. We know what we have and what we like.. it wasn't a very practical idea. No reason to host that sort of thing.

So instead, I sort of built an anti-food-blog: **[Chomptron](https://chomptron.com)**. Type in whatever's in the fridge and Gemini hands back a recipe. No story.

![Chomptron in action](/uploads/2025/12/chomptron-screenshot.png)

<video width="100%" controls>
  <source src="/uploads/2025/12/chomptron-demo.mp4" type="video/mp4">
  Your browser doesn't support video.
</video>

Chicken, some tomatoes, garlic, half an onion.. or just sriracha and some leftovers. Hit generate, get measurements and steps. It scales from 0.25x to 4x so nobody has to do the math, and there are filters for vegan through shellfish-free. It keeps up to 100 recipes in your browser's `localStorage`.. I don't want your email, and I don't want to manage a user database. Dark mode, to wreck your eyes.

## The Stack

Node 20 + Express, vanilla HTML/CSS/JS, and `gemini-2.5-flash-lite`, on Cloud Run. It scales to zero, so if nobody's using it I pay nothing. A 24-hour cache and some rate limiting keep the Gemini bill sane. Push to main, Cloud Build builds the container, a gang of tests run, and it's live a few seconds later. Health checks, Open Graph tags, and you can pin it to your home screen.. the regular dev junk.

Live: [https://chomptron.com](https://chomptron.com)

Source: [https://github.com/swantron/chomptron](https://github.com/swantron/chomptron)

It's free to use and nearly free to run (plz don't spam it). It was a fun excuse to get back into GCP and keep a JS project clean.
