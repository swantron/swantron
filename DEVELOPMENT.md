# swantron.com — development

The static site at [swantron.com](https://swantron.com), built with Hugo and deployed to GitHub Pages via GitHub Actions.

## Quick Start

```bash
# Serve locally
hugo server

# Build for production
hugo --baseURL https://swantron.com/
```

## Directory Structure

- `content/posts/` — All blog posts (1,022). Each post has a stable `id` in front matter. Id 1 is the oldest post (11 Jul 2005). A new post needs the next unused id (one higher than the current maximum, currently 1023). The list feed at `/api/posts/index.json` is metadata only. A post's HTML is at that post's `index.json`.
- `content/` — Standalone pages (about.md, contact.md, etc.)
- `static/uploads/` — All images and media files from WordPress
- `themes/paper/` — Paper theme
- `layouts/` — Custom theme overrides
- `config.toml` — Hugo configuration

## Configuration

- **Theme**: Paper
- **Base URL**: `https://swantron.com/`
- **Permalinks**: `/:year/:month/:day/:slug/`
- **Pagination**: 10 posts per page

Build output is deployed to GitHub Pages via GitHub Actions on push to `main`.
