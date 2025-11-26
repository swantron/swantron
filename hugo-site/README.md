# swan tron dot com - Hugo Static Site

This is a Hugo-based static site generated from the original WordPress blog.

## Structure

- `content/posts/` - All blog posts (1039 posts converted from Jekyll format)
- `content/` - Standalone pages (contact.md, disclaimer.md)
- `static/uploads/` - All images and media files from WordPress
- `themes/PaperMod/` - Hugo theme (git submodule)
- `config.toml` - Hugo configuration

## Local Development

To work with this site locally:

1. Install Hugo (extended version):
   ```bash
   brew install hugo  # macOS
   ```

2. Serve the site locally:
   ```bash
   cd hugo-site
   hugo server
   ```

3. Visit http://localhost:1313

## Adding New Posts

1. Create a new markdown file in `content/posts/` with the format: `YYYY-MM-DD-post-title.md`
2. Add frontmatter:
   ```yaml
   ---
   title: "Your Post Title"
   date: 2024-01-01T12:00:00+00:00
   ---
   ```
3. Write your content in Markdown
4. Commit and push - GitHub Actions will build and deploy automatically

## Configuration

- Update `baseURL` in `config.toml` to match your GitHub Pages URL
- Theme settings can be adjusted in `config.toml` under `[params]`
- Menu items are configured in `[menu]` section

## Deployment

The site is automatically built and deployed via GitHub Actions when you push to the `main` branch.

To enable GitHub Pages:
1. Go to Repository Settings → Pages
2. Source: GitHub Actions
3. The site will be available at: `https://swantron.github.io/swantron/`

## Notes

- All image paths have been converted from absolute URLs to relative paths (`/uploads/...`)
- Posts were converted from Jekyll format to Hugo format
- The PaperMod theme is included as a git submodule
