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

## The Migration: Managing 1,040 Post-Slugs

Moving **1,040 posts** while maintaining permalink integrity is a rite of passage. My goal was to strip away the ugly legacy `/index.php/` prefix from my URLs, but I couldn't afford to break 20 years of external links and search indexing.

To solve this, I wrote a Python script to automate the 'alias' field in Hugo's front matter.

```python
# If no date in frontmatter, extract from filename
if not date_str:
    filename_match = re.match(r'(\d{4})-(\d{2})-(\d{2})', filepath.stem)
    if filename_match:
        year, month, day = filename_match.groups()
        date_str = f'{year}-{month}-{day}T00:00:00+00:00'
```

The script successfully mapped every single post to its legacy counterpart. Now, Hugo automatically generates redirect HTML pages at the old paths (e.g., `/index.php/2005/10/10/post-slug/`) that point to the new, clean URLs.

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

It feels like the OG blogging days again. Before 'CMS' became a corporate buzzword, blogging was just writing and publishing. Simple. Direct. Maybe if the web had stayed this simple—if we hadn't traded performance for bloated admin panels—personal blogs wouldn't have declined in the first place.

Here's to another decade—static, versioned, and finally **cattle, not pets.**
