# swan tron dot com

<!-- Build trigger -->

- ([swantron/swantron](https://swantron.github.io/swantron/)) is the og blog, in static format 

- ([swantron/tronswan](https://tronswan.com/)) is the landing spot for several newer projects

- ([swantron/chomptron](https://chomptron.com/)) is great if you are hungry, and cook

- ([swantron/* repos](https://github.com/swantron)) has several useful tools.. look around

## Quick Start

```bash
# Serve locally
hugo server

# Build for production
hugo --baseURL https://swantron.github.io/swantron/
```

## Directory Structure

- `content/posts/` - All blog posts (1,040 posts)
- `content/` - Standalone pages (about.md, contact.md, etc.)
- `static/uploads/` - All images and media files from WordPress
- `themes/paper/` - Paper theme
- `layouts/` - Custom theme overrides
- `config.toml` - Hugo configuration

## Configuration

- **Theme**: Paper
- **Base URL**: `https://swantron.github.io/swantron/`
- **Permalinks**: `/index.php/:year/:month/:day/:slug/` (WordPress-compatible)
- **Pagination**: 10 posts per page

Build output is deployed to GitHub Pages via GitHub Actions.
