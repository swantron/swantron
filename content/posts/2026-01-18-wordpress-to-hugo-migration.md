---
title: 'WordPress to Hugo Migration'
date: 2026-01-18T05:00:00+00:00
slug: 'wordpress-to-hugo-migration'
description: 'After decades of WordPress pets, swantron.com is now static on Hugo - a fundamental shift to code-first'
featured_image: '/uploads/2026/01/cowbot.png'
aliases:
  - '/index.php/2026/01/18/wordpress-to-hugo-migration/'
---

This is the first time in decades I haven't had a WordPress instance live.

<img src="/uploads/2026/01/cowbot.png" alt="Cowbot - The migration mascot" class="cowbot-image" />

## The Breaking Point

The breaking point wasn't a catastrophic hack; it was the slow death of a thousand cuts. After **20 years** of content (2005-2025), WordPress felt fragile. The site had become a 'pet' that required constant feeding: security patches, plugin conflicts, and the looming fear of database bit-rot.

![Deleting WordPress site - final step](/uploads/2026/01/delete-wordpress-site.png)

## The Evolution: From Shared Hosting to Code-First

Over two decades, swantron.com moved through every hosting trend imaginable:

1. **The Early Days:** Traditional shared hosting on Siteground.
2. **The Cloud Era:** Managing VMs and RDS databases on AWS and GCP.
3. **The Infrastructure Era:** DigitalOcean Droplets and 'Infrastructure as Code' containers.
4. **The Final Form:** **Hugo + GitHub Pages.** A shift from a 'managed system' to a **code-first delivery.**

Each previous phase was just a different way of babysitting a server. This migration is different. It's not a new host; it's a fundamental change in philosophy.

## The Database Horror (Why I Left)

If you want to know why WordPress scales poorly for a solo dev, look at my final database dump: **34MB and 555,947 lines of text.**

- **122,307 references** to `bouncerblog.com`—a domain that died over a decade ago.
- **Serialized PHP arrays** stored as strings. Want to change a rewrite rule? Good luck parsing a 2,000-character string in `wp_options`.
- **Zombie Data:** Thousands of `_transient` entries and orphaned plugin settings that WordPress autoloads on every single page request, long after the plugins are deleted.

The database became a black box. Transitioning to Markdown files feels like exhaling after holding your breath for years. No more regex-searching a SQL dump just to find a setting.

## The Migration & New Stack

Moving **1,040 posts** while maintaining permalink integrity is a rite of passage. To keep 20 years of SEO and links alive, I used custom scripts to map the legacy WordPress export to Hugo's directory structure.

* **The Permalinks:** Initially preserved the WordPress `/index.php/YYYY/MM/DD/slug` structure for compatibility, then cleaned it up to `/:year/:month/:day/:slug/` using Hugo aliases to redirect old URLs seamlessly.
* **The Media:** Thousands of images moved to `/static/uploads/`, with a bulk regex to update the paths in the Markdown files.
* **The Engine:** Hugo 0.154.5, GitHub Actions for CI/CD, and a custom CSS build. **No themes, just code.**

### The Tipping Point

| Feature | WordPress (Old) | Hugo (New) |
| --- | --- | --- |
| **Speed** | 2s - 4s Load | **< 500ms** |
| **Security** | Constant Patches | **Zero Attack Surface** |
| **Cost** | Monthly Fees | **$0 (GitHub Pages)** |
| **Content** | MySQL | **Markdown in Git** |

## Why This Matters

The friction is gone. I don't have to log into a clunky admin panel, clear a cache, or run a plugin update before I type. I write Markdown, I `git push`, and it's live.

It feels like the OG blogging days again. Before 'CMS' became a corporate buzzword, blogging was just writing and publishing. Simple. Direct. Maybe if the web had stayed this simple—if we hadn't traded performance for bloated admin panels—personal blogs wouldn't have declined in the first place.

Here's to another decade—static, versioned, and finally **cattle, not pets.**
