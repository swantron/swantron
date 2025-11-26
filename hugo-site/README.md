# Hugo Site - swan tron dot com

This directory contains the Hugo static site generator configuration and content.

## Quick Start

```bash
# Serve locally
hugo server

# Build for production
hugo --baseURL https://swantron.github.io/swantron/
```

## Directory Structure

- `content/posts/` - All blog posts (1,039 posts)
- `content/` - Standalone pages (about.md, contact.md, etc.)
- `static/uploads/` - All images and media files from WordPress
- `themes/paper/` - Paper theme (git submodule)
- `layouts/` - Custom theme overrides
- `config.toml` - Hugo configuration

## Configuration

### Main Settings

- **Theme**: Paper
- **Base URL**: `https://swantron.github.io/swantron/`
- **Permalinks**: `/index.php/:year/:month/:day/:slug/` (WordPress-compatible)
- **Pagination**: 10 posts per page

### Theme Customization

- **Banner Image**: Set `banner_image` in `config.toml` under `[params]`
- **Color Scheme**: Set `color` in `config.toml` (options: linen, wheat, gray, light)
- **Custom Layouts**: Override theme templates in `layouts/`

## Custom Layouts

- `layouts/_default/list.html` - Post list with banner and featured images
- `layouts/_default/single.html` - Single post with featured image
- `layouts/_default/index.json` - JSON API output for tronswan app
- `layouts/partials/head.html` - Custom head partial

## Adding Content

### New Post

Create `content/posts/YYYY-MM-DD-post-title.md`:

```yaml
---
title: "Post Title"
date: 2024-01-01T12:00:00+00:00
featured_image: '/uploads/path/to/image.jpg'  # Optional
tags: ['tag1', 'tag2']  # Optional
---
```

### Featured Images

Featured images are automatically extracted from the first image in each post. You can also manually set `featured_image` in frontmatter.

## Build Output

- `public/` - Generated static HTML files (gitignored)
- Build output is deployed to GitHub Pages via GitHub Actions

## Theme

The site uses the [Paper theme](https://github.com/nanxiaobei/hugo-paper) as a git submodule. Customizations are made via layout overrides in `layouts/` rather than modifying the theme directly.
