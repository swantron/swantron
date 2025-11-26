# swan tron dot com

A static site generated from the original WordPress blog, hosted on GitHub Pages.

**Live site:** https://swantron.github.io/swantron/

## History

This blog was originally hosted at:
- **bouncerblog.com** (early years)
- **swantron.com** (WordPress installation)
- Now migrated to a **Hugo static site** on GitHub Pages

## Structure

```
swantron/
├── hugo-site/          # Hugo static site generator
│   ├── content/        # Blog posts and pages
│   ├── static/         # Images and assets
│   ├── themes/         # Paper theme (git submodule)
│   └── layouts/        # Custom theme overrides
├── wp-export/          # Original WordPress export (not committed)
└── .github/workflows/  # GitHub Actions for deployment
```

## Content

- **1,039 blog posts** converted from WordPress/Jekyll format
- **Featured images** extracted from post content (889 posts)
- **WordPress-compatible permalinks**: `/index.php/YYYY/MM/DD/post-slug/`
- **Images**: All WordPress uploads preserved in `static/uploads/`

## Technology

- **Hugo** - Static site generator
- **Paper Theme** - Clean, minimal Hugo theme
- **GitHub Pages** - Free hosting
- **GitHub Actions** - Automated build and deployment

## Local Development

To work with this site locally:

1. **Install Hugo** (extended version):
   ```bash
   brew install hugo  # macOS
   ```

2. **Clone with submodules**:
   ```bash
   git clone --recurse-submodules https://github.com/swantron/swantron.git
   ```

3. **Serve locally**:
   ```bash
   cd hugo-site
   hugo server
   ```
   Visit http://localhost:1313

## Adding New Posts

1. Create a new markdown file in `hugo-site/content/posts/`:
   - Format: `YYYY-MM-DD-post-title.md`

2. Add frontmatter:
   ```yaml
   ---
   title: "Your Post Title"
   date: 2024-01-01T12:00:00+00:00
   featured_image: '/uploads/path/to/image.jpg'  # Optional
   ---
   ```

3. Write content in Markdown

4. Commit and push - GitHub Actions will build and deploy automatically

## Deployment

The site is automatically built and deployed via GitHub Actions when you push to the `main` branch.

- **Build**: Runs Hugo to generate static HTML
- **Deploy**: Pushes to `gh-pages` branch
- **Hosting**: GitHub Pages serves from `gh-pages` branch

## Configuration

- `hugo-site/config.toml` - Main Hugo configuration
- `hugo-site/layouts/` - Custom theme overrides
- Banner image: Set `banner_image` in `config.toml` under `[params]`

## Features

- ✅ WordPress-compatible permalinks
- ✅ Featured images for posts
- ✅ Homepage banner image
- ✅ RSS feed (`/index.xml`)
- ✅ JSON API output (`/index.json`) for tronswan app
- ✅ Pagination (10 posts per page)
- ✅ Dark mode support
- ✅ Responsive design

## Notes

- All image paths use relative URLs (`/uploads/...`)
- Posts were converted from Jekyll format to Hugo format
- HTML entities in titles were decoded (e.g., `&#8217;` → `'`)
- WordPress caption shortcodes and HTML wrappers were removed from posts
- The Paper theme is included as a git submodule
