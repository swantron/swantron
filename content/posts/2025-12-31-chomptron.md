---
title: 'Chomptron: AI Recipe Generator'
date: 2025-12-31T04:00:00+00:00
slug: 'chomptron'
description: 'Turn random ingredients into real recipes with Google Gemini AI'
featured_image: '/uploads/2025/12/chomptron-screenshot.png'
---

Do you hate cooking blogs?  Sure, we all do..

I built [Chomptron](https://chomptron.com) - an AI-powered recipe generator that turns whatever's in your fridge into actual recipes.  Bam.

![Chomptron in action](/uploads/2025/12/chomptron-screenshot.png)

<video width="100%" controls>
  <source src="/uploads/2025/12/chomptron-demo.mp4" type="video/mp4">
  Your browser doesn't support video.
</video>

## Problem

You've got chicken, some tomatoes, garlic, and half an onion. What do you make? Scroll through recipe sites loaded with ads and life stories? Nope.

## Solution

Type your ingredients into Chomptron, hit generate, get a complete recipe with measurements, instructions, and cooking times. It is GCP under the hood.

**Features:**

- **AI-generated recipes** - Creative, practical recipes from Google Gemini
- **Recipe scaling** - Adjust servings from 0.25x to 4x with auto-scaled measurements
- **Dietary filters** - Vegan, vegetarian, gluten-free, dairy-free, nut-free, shellfish-free, egg-free, soy-free
- **Recipe history** - Saves up to 100 recipes in browser localStorage
- **Favorites & ratings** - Star your best recipes, rate them 1-5 stars
- **Personal notes** - Add your own cooking notes to saved recipes
- **Dark mode** - Because obviously
- **Share & print** - Export recipes or generate shareable links

## Stack

**Backend:** Node.js 20 + Express  
**AI:** Google Gemini (gemini-2.5-flash-lite)  
**Frontend:** Vanilla HTML/CSS/JavaScript (no framework bloat)  
**Platform:** Google Cloud Run (serverless)  
**Storage:** Browser localStorage  

## Serverless?

Chomptron runs on **Google Cloud Run** which means:

- **Scales to zero** - $0 cost when idle (vs $5-50/month for always-on hosting)
- **Auto-scales** - Handles burst traffic automatically
- **Zero maintenance** - No servers to manage, patch, or configure
- **Perfect for AI workloads** - CPU-intensive recipe generation just works

The app includes smart caching (24-hour TTL, max 100 recipes per instance), rate limiting, and retry logic with exponential backoff for quota errors.

## CI/CD

Push to main → Cloud Build → Docker → Cloud Run. Automatic.

The repo includes:
- Health checks (`/health`, `/ready`)
- Usage tracking (`/api/usage`)
- Gang of tests
- SEO stuff (meta tags, Open Graph, structured data)
- PWA stuff

## Check it out

Live: [https://chomptron.com](https://chomptron.com)

Source: [https://github.com/swantron/chomptron](https://github.com/swantron/chomptron)

It's free to use, nearly free to run (plz don't spam it), and actually useful.  

This was a fun one.. I haven't done a project on GCP in a minute, so I sort of came up with the idea after designing the stack.  Refreshing to keep a js project tidy.. super fast deploy cycle etc.
