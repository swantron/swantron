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

- `content/posts/` — All blog posts (1,040+ posts)
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
