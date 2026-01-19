---
title: 'WordPress to Hugo Migration'
date: 2026-01-18T05:00:00+00:00
slug: 'wordpress-to-hugo-migration'
description: 'After decades of WordPress pets, swantron.com is now static on Hugo - a fundamental shift to code-first'
featured_image: '/uploads/2026/01/cowbot.png'
---

This is the first time in decades I haven't had a WordPress instance live.

![Cowbot - The migration mascot](/uploads/2026/01/cowbot.png)

## The Breaking Point

The breaking point wasn't dramatic. No database crash. No catastrophic hack. Just the slow death of a thousand cuts. The WordPress admin panel getting slower. Plugin updates breaking things. Security patches every week. Database backups that might or might not work. The constant maintenance overhead.

After **20 years** of content (2005-2025), the thought of losing it all to database corruption or bit-rot was real. WordPress felt fragile. The content deserved better.

This is a pita. Moving **1,040 posts** while maintaining permalink integrity is no small feat—especially shifting from a 'pet' WordPress setup to a 'cattle' Hugo workflow. It's a rite of passage for any dev who values performance and long-term ownership.

## The Journey

I started on Siteground with Griff for **bouncerblog.com**.. ran that for years. The bar literally blew up, and eventually it morphed into **swantron.com**.

Over the past few decades, the site evolved through different hosting and deployment approaches:

**Phase 1: Hosting Plan**
- **Siteground** (original) - Traditional shared hosting plan. Cheap, easy, managed. Just upload WordPress and go.

**Phase 2: Cloud Resources**
- **Google App Engine (GAE)** - Moved to running cloud resources the same way. Managed platform, but still managing WordPress instances.
- **AWS** - EC2 instances, RDS databases. Running cloud infrastructure, managing servers, databases, backups.
- **Google Cloud Platform (GCP)** - Compute Engine, Cloud SQL. Different cloud, same approach - managing resources.

**Phase 3: Canned Images**
- **DigitalOcean (DO)** - Droplets, managed databases. Started using canned images, containers, standardized deployments. Still WordPress, but more infrastructure-as-code.

**Phase 4: Back to Traditional**
- Back to **Siteground** - Full circle. Cheap and easy. Traditional hosting thing because it was simple and worked.

**Phase 5: Proper Content Delivery**
- **GitHub Pages + Hugo** - Something that feels more akin to actual content delivery via a proper build and resource levels. Static site generation, CDN delivery, git-based workflow.

Each phase was a learning opportunity. How do you move a WordPress database? How do you handle file uploads? How do you configure DNS? How do you set up SSL? How do you handle backups? Each approach had its own way of doing things.

> The issues were really straight forward.. I had ssl issues after juggling the wordpress install across several (4?) cloud platforms over the past several (4?) years, and a directory issue that took some time to resolve. There are still some broken photo links from the early-early posts, but I can say with certainty that nobody needs to revisit. Assume we all had fun and move on.

But through all of it, they were essentially **pets** under the hood. WordPress instances that needed care, feeding, and attention. Database backups. Plugin updates. Security patches. Server maintenance. Monitoring. Whether it was a shared hosting plan, cloud resources, or canned images - each instance was unique, fragile, and required ongoing maintenance.

## The Fundamental Shift

This migration is different. This isn't just moving WordPress to another provider. This is a fundamental change from using WordPress as a content management system to a **code-first approach**.

**Before:** WordPress content system
- Content stored in MySQL database
- Admin panel for editing
- Themes for presentation
- Plugins for functionality
- Updates, patches, security concerns
- Database backups, file backups
- Server management, monitoring

**Now:** Code-first approach
- Content is markdown files in git
- Code controls everything
- No themes - just code
- No plugins - just code
- No database - just files
- No server - just static files
- Version control is the backup

## The Migration

**1,040 posts** migrated from WordPress to Hugo. **20 years** of content (2005-2025). All URLs preserved exactly - `/index.php/YYYY/MM/DD/post-slug/` matches WordPress permalinks perfectly. Every old link still works.

All images migrated to `/static/uploads/` - thousands of photos from 2005-2025, organized by year.

The migration process involved exporting WordPress content, converting to markdown, preserving slugs, and ensuring permalink structure matched exactly. Custom scripts handled the conversion, maintaining all metadata, dates, and image references.

The content is preserved. The URLs are preserved. But the infrastructure is completely different. More importantly, the content is now **secured** against bit-rot and database corruption. It's in git. It's version controlled. It's reproducible.

## The Database Dump Horror

The final WordPress database dump is **34MB** and **555,947 lines**. It's a perfect example of how WordPress databases become unmaintainable over time for no real reason.

**Examples of the bloat:**

- **122,307 references** to `bouncerblog.com` - a domain that hasn't been used in over a decade. URLs, image paths, serialized data - all still pointing to a domain that died when the bar blew up.

- **Serialized PHP arrays** stored as strings in the database. Want to see your cron jobs? Here's a 2,000-character serialized array stored in `wp_options`. Want to change a rewrite rule? Good luck parsing that serialized data.

- **Transient data** that should be temporary but gets stored permanently. `_transient_wp_styles_for_blocks`, `_site_transient_update_core`, `_transient_health-check-site-status-result` - all marked as 'yes' for autoload, meaning WordPress loads them on every page request.

- **wp_postmeta** with thousands of entries. Every post edit creates new meta entries. Every plugin adds metadata. Every theme customization gets stored. After 20 years, you have 596 INSERT statements just for post metadata.

- **wp_options** storing everything as serialized PHP. Plugin settings, theme options, widget configurations - all serialized and stored in a single table. Want to find a specific setting? Hope you like regex.

- **Old plugin data** that never gets cleaned up. Deleted plugins leave their options behind. Changed themes? Old theme options still in the database. Uninstalled a plugin 5 years ago? Its data is still there.

The database becomes a **black box** of serialized PHP data, orphaned references, and stale configuration. You can't easily query it. You can't easily migrate it. You can't easily understand what's actually being used vs what's just cruft accumulated over years.

This is why the migration to markdown files feels so clean. No serialized data. No orphaned references. No stale configuration. Just files. Readable, searchable, version-controlled files.

## The New Stack

- **Hugo 0.154.5** - Static site generator, builds from markdown to HTML
- **No themes** - Custom layouts, just code
- **GitHub Pages** - Free hosting, CDN included
- **GitHub Actions** - CI/CD pipeline, automatic builds
- **Git-based workflow** - Content in version control
- **Search functionality** - Custom client-side JSON API with scoring algorithm (title/tag/content weighting), no server needed
- **RSS feed** - `index.xml` generated automatically by Hugo for long-time RSS subscribers
- **Dark mode** - Because obviously

### Quick Comparison

| Feature | Old (WordPress) | New (Hugo) |
| --- | --- | --- |
| **Speed** | 2s - 4s Load | < 500ms (Static) |
| **Security** | Constant Patches | Zero Attack Surface |
| **Hosting** | Shared/VPS ($) | GitHub Pages ($0) |
| **Storage** | MySQL Database | Markdown Files |
| **Updates** | Plugin Hell | Git Push |
| **Backups** | Database Dumps | Git History |
| **Deployment** | FTP/SSH | Git Push |
| **Content** | Database Queries | Static HTML |
| **Data Longevity** | Risky (DB Rot) | Permanent (Git) |

## Pets vs Cattle

The old WordPress instances were **pets**. Each one unique, requiring individual care:
- Database backups specific to that instance
- Plugin configurations that might break on update
- Server configurations that needed monitoring
- Security patches that needed to be applied
- Performance tuning for that specific server

The new Hugo site is **cattle**. Disposable, replaceable, reproducible:
- Content is in git - can be rebuilt anywhere
- No database - just files
- No server - just static files
- Build process is automated - GitHub Actions handles it
- If something breaks, rebuild from git

## Code-First, Not Theme-First

This isn't about finding the right WordPress theme. This is about writing code.

Custom layouts override the theme. Custom CSS styles the site. Custom JavaScript adds functionality. Everything is code, version controlled, and reproducible.

No more theme updates breaking customizations. No more plugin conflicts. No more 'this worked yesterday, why doesn't it work today?'

Just code. Write it, commit it, push it. It works.

## What This Means

The barrier to posting is gone. No WordPress admin panel. No plugin updates. No security patches. Just write markdown and push.

The site is **crazy fast** - static files served from a CDN. No database queries. No PHP execution. No server-side processing. Just HTML, CSS, and JavaScript delivered at the edge. Pages load instantly.

The site is **crazy secure** - nothing to get into. No database to exploit. No PHP to hack. No WordPress admin panel to brute force. No plugins with vulnerabilities. Just static files. There's literally nothing to attack.

The site is simpler - no server to manage, no database to backup, no plugins to update.

The site is more maintainable - everything is in git. Want to see what changed? `git log`. Want to rollback? `git revert`. Want to see the history? `git blame`.

## The Future

Still blogging? Maybe. But now it's actually enjoyable. The infrastructure doesn't get in the way. The content system doesn't fight you. The deployment process is trivial.

Writing blog content in a markdown file and pushing it to a repository feels oddly more like the OG blog days. Before WordPress became a content management system. Before plugins and themes and admin panels. When blogging was just writing and publishing. Simple. Direct.

Nobody ever liked working with PHP and janky remote databases. The friction was real. The admin panel was clunky. The updates broke things. The plugins conflicted. The security patches were constant. The database backups were stressful. It was never fun.

This type of setup - static site generators, git-based workflows, markdown content - might have kept blogs alive. Blogs were a lot of fun when they were simple. When the barrier to posting was low. When you could just write and publish without fighting with infrastructure.

Maybe if this approach had been more common earlier, blogging wouldn't have declined. Maybe more people would still be blogging if it wasn't such a pain to maintain a WordPress site.

The robot background image is still there. The posts are all there. The URLs all work. But now it's modern, fast, maintainable, and actually fun to work with.

Here's to another decade.. but this time, static. Code-first. No pets, just cattle. Back to the roots, but with modern tooling. Maybe this is how blogging should have been all along.
