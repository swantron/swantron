# blog
swan tron dot com 

## Hugo Static Site

This repository contains a Hugo-based static site generated from the original WordPress blog export.

### Quick Start

The Hugo site is located in the `hugo-site/` directory. See `hugo-site/README.md` for detailed instructions.

### Structure

- `hugo-site/` - Hugo static site (ready for deployment)
- `wp-export/` - Original WordPress/Jekyll export (can be removed after verification)
- `convert_posts.py` - Script used to convert posts (kept for reference)

### Deployment

The site is configured to automatically build and deploy via GitHub Actions when you push to `main`.

**To enable GitHub Pages:**
1. Go to Repository Settings → Pages
2. Source: GitHub Actions
3. Your site will be available at: `https://swantron.github.io/swantron/`

The `baseURL` in `hugo-site/config.toml` is already configured for this URL.

### Local Development

```bash
cd hugo-site
hugo server
```

Visit http://localhost:1313

### Cleanup

After verifying the site works correctly, you can optionally remove:
- `wp-export/` directory (original export, ~2.9GB)
- `convert_posts.py` (conversion script, no longer needed)

These are kept for reference but can be deleted to reduce repository size.
