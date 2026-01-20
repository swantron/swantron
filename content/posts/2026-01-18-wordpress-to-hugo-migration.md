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

![Deleting WordPress site - final step](/uploads/2026/01/delete-wordpress-site.png)

## The Evolution: From Shared Hosting to Code-First

Over two decades, swantron.com moved through every hosting trend imaginable. Each step was an attempt to make things "easier," but usually just added a different flavor of maintenance:

* **Phase 1: The Basics** – Traditional shared hosting (`Siteground`). Cheap and easy, but you're at the mercy of the host.
* **Phase 2: Cloud Ops** – Managing VMs and RDS databases (`AWS EC2` / `GCP Cloud SQL`). Total control, but now you're a part-time SysAdmin.
* **Phase 3: Infrastructure** – Modernized deployments via `DigitalOcean` and `Docker`. "Infrastructure as Code" was the goal, but the core was still a heavy CMS.
* **Phase 4: The End State** – **Static delivery via `Hugo` + `GitHub Actions`.** Each previous phase was just a different way of babysitting a server. This migration is different. It's a fundamental change in philosophy: moving from a "managed system" that lives on a remote server to a **code-first delivery** that lives on my machine and deploys to the edge.

## The Database Horror (Why I Left)

I had a shower thought how gross a WordPress database might end up. After **20 years** of content (2005-2025), I finally checked. My final database dump: **34MB and 555,947 lines of text.**

![SQL file size - 555,947 lines](/uploads/2026/01/sql-file-size.png)

* **122,307 references** to `bouncerblog.com`—a domain that died over a decade ago.
* **Serialized PHP arrays** stored as strings. Want to change a simple rewrite rule? Good luck parsing a 2,000-character string in `wp_options`.
* **Zombie Data:** Thousands of `_transient` entries and orphaned plugin settings that WordPress autoloads on every single page request, long after the plugins are deleted.

The database had become a black box. Transitioning to Markdown files feels like exhaling after holding your breath for years. No more regex-searching a SQL dump just to find a setting.

## The Migration: Managing 1,040 Post-Slugs

Moving **1,040 posts** while maintaining permalink integrity is a rite of passage. My goal was to strip away the ugly legacy `/index.php/` prefix from my URLs without breaking 20 years of external links and search indexing.

I wrote a script to automate the `alias` field in Hugo's front matter, mapping the old legacy paths to the new clean ones.

**The result in each Markdown file:**

```yaml
title: "My Old Post"
slug: "my-old-post"
aliases:
  - /index.php/2005/10/10/my-old-post/

```

![Alias example in frontmatter](/uploads/2026/01/alias-example.png)

Now, Hugo automatically generates redirect HTML pages at the old paths. This preserves every bookmark, social share, and search result while allowing the site to live at a modern URL.

**Result: 1,041/1,041 posts migrated with 100% link integrity.**

## The New Stack

**Hugo 0.154.5** for static generation, **GitHub Pages + Actions** for hosting and CI/CD. No themes—just custom CSS and layout code that I control entirely.

### The Tipping Point

| Feature | WordPress (Old) | Hugo (New) |
| --- | --- | --- |
| **Speed** | 2s - 4s Load | **< 500ms** |
| **Security** | Constant Patches | **Zero Attack Surface** |
| **Cost** | Monthly Fees | **$0 (GitHub Pages)** |
| **URL Structure** | `/index.php/slug` | **Clean & Pretty** |
| **Content** | MySQL | **Markdown in Git** |

## Why This Matters

The friction is gone. I don't have to log into a clunky admin panel, clear a cache, or run a plugin update before I type. I write Markdown, I `git push`, and it's live.

It feels like the OG blogging days again. We had CMS shit back then, but blogging was largely just writing and publishing. Simple. Direct. SEO made things weird for a bit—I did the paid post thing—and we tried to bolt PHP junk onto everything for no particular reason. The CMS never really got better, and blogs sort of died under the weight of their own tech debt.

In a way, I'm jumping back in with the terminal Gs who never bothered with this path in the first place. They've been over there in their minimal setups, posting random shit about obsolete tech this entire time, while the rest of us were fighting database corruption.

<img src="/uploads/2026/01/cowbot.png" alt="Cowbot - The migration mascot" class="cowbot-image" />

Here's to another decade, though.. this time it is static, versioned, and finally **cattle, not pets.**
