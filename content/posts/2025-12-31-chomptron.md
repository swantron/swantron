---
title: 'Chomptron: AI Recipe Generator'
date: 2025-12-31T04:00:00+00:00
slug: 'chomptron'
description: 'Turn random ingredients into real recipes with Google Gemini AI'
featured_image: '/uploads/2025/12/chomptron-screenshot.png'
aliases:
  - '/index.php/2025/12/31/chomptron/'
---

Do you hate cooking blogs? Sure, we all do..

Inane story, some ads, ingredient somewhere, more adds, quatities somewhere else, another ad.  Like and subscribe..

It is embarrassing to say that I bought the domain name with that sort of thing in mind. I have some of our go-tos in texts from Katie and others that I have emailed to myself (from texts from Katie). I parked some stuff on WordPress and promptly remembered that I hate WordPress about as much as I hate cooking blogs. We know what we have and what we like.. it wasn't a very practical idea. No reason to host that sort of thing.

So instead, I sort of built an anti-food-blog: **[Chomptron](https://chomptron.com)**. It's an AI-powered engine that turns whatever's in your fridge into actual recipes. No fluff, no life stories, just dinner.

![Chomptron in action](/uploads/2025/12/chomptron-screenshot.png)

<video width="100%" controls>
  <source src="/uploads/2025/12/chomptron-demo.mp4" type="video/mp4">
  Your browser doesn't support video.
</video>

## The Problem

You've got chicken, some tomatoes, garlic, and half an onion. Or maybe just sriracha and some leftovers. You don't want to read an article; you just want to know how to combine those things into something edible without making a grocery run.

## The Solution

Type the ingredients, hit generate, and get a recipe with scaled measurements and instructions. It uses **Google Gemini** under the hood to handle the logic.

**Features that actually matter:**

* **Scaling that works** – Most sites make you do the math. Chomptron scales from 0.25x to 4x automatically
* **Privacy by default** – It saves up to 100 recipes in your browser's `localStorage`. I don't want your email, I don't want your data, and I don't want to manage a user database
* **Dietary logic** – Filters for everything from Vegan to Shellfish-free
* **Dark mode** – Wreck your eyes!

## The Stack

I wanted this to be fast and 'tidy.' No framework bloat, no heavy lifting on the client side:

* **Backend:** Node.js 20 + Express
* **AI:** Google Gemini (`gemini-2.5-flash-lite`)
* **Frontend:** Vanilla HTML/CSS/JavaScript
* **Platform:** Google Cloud Run (Serverless)  

## Why Serverless?

Chomptron runs on **Google Cloud Run**, serverless enough that I never think about the box it's on:

* **Scales to zero:** If nobody is using the site, I pay $0. It costs me effectively nothing to keep this live.
* **Auto-scales:** If it suddenly gets traffic, GCP spins up containers to handle it.
* **Zero maintenance:** No OS to patch, no server to reboot.

I built in some smart caching (24-hour TTL) and rate-limiting to keep the Gemini API costs under control, but otherwise, it's a hands-off deployment.

## CI/CD Workflow

The deployment cycle is refreshing. `Push to main` triggers a Cloud Build which handles the Dockerization and pushes to Cloud Run. It's a gang of tests and a few seconds of waiting before it's live.

It's got the regular dev junk:

* Health checks (`/health`, `/ready`)
* Proper SEO/Open Graph tags
* PWA support so you can pin it to your home screen

## Find It

Live: [https://chomptron.com](https://chomptron.com)

Source: [https://github.com/swantron/chomptron](https://github.com/swantron/chomptron)

It's free to use and nearly free to run (plz don't spam it). It was a fun excuse to get back into GCP and keep a JS project clean. No bloat, no stories.. just the recipes.
