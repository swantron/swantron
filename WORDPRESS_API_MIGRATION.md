# WordPress API Migration Guide

This document outlines how to migrate the tronswan app from the WordPress REST API to work with the Hugo static site.

## Current WordPress API Usage

The `tronswan` repo uses these WordPress REST API endpoints:

1. **Get Posts** (paginated): `GET /wp-json/wp/v2/posts?_embed&page=1&per_page=10`
   - Returns: Array of posts with pagination headers
   - Headers: `X-WP-TotalPages`

2. **Get Post by ID**: `GET /wp-json/wp/v2/posts/{id}?_embed`
   - Returns: Single post object

3. **Search Posts**: `GET /wp-json/wp/v2/posts?search={query}&_embed&page=1&per_page=10`
   - Returns: Array of matching posts

### Required Post Fields

The tronswan app expects posts with:
- `id` (number)
- `title.rendered` (string)
- `excerpt.rendered` (string)
- `content.rendered` (string)
- `date` (ISO string)
- `link` (URL string)
- `_embedded.wp:featuredmedia[0].source_url` (featured image)
- `_embedded.wp:term[0]` (categories)
- `_embedded.wp:term[1]` (tags)

## Migration Options

### Option 1: Hugo JSON Output + API Wrapper (Recommended)

Hugo can generate JSON files for all posts. Create a simple API wrapper that serves this data in WordPress-compatible format.

**Pros:**
- No separate API server needed
- Can be hosted on GitHub Pages with a serverless function
- Fast (static JSON files)
- Easy to maintain

**Cons:**
- Search requires client-side filtering or external service
- Pagination handled in wrapper

**Implementation:**

1. **Enable JSON output in Hugo** (already configured):
   ```toml
   [outputs]
     home = ['HTML', 'RSS', 'JSON']
   ```

2. **Create API wrapper** (e.g., Cloudflare Workers, Vercel Functions, or Netlify Functions):

   ```javascript
   // Example: Vercel API route at /api/wp/v2/posts
   import postsData from '../../hugo-site/public/index.json';
   
   export default function handler(req, res) {
     const { page = 1, per_page = 10, search } = req.query;
     
     let posts = postsData.posts || [];
     
     // Search filtering
     if (search) {
       const query = search.toLowerCase();
       posts = posts.filter(post => 
         post.title.toLowerCase().includes(query) ||
         post.content.toLowerCase().includes(query)
       );
     }
     
     // Pagination
     const start = (page - 1) * per_page;
     const end = start + parseInt(per_page);
     const paginatedPosts = posts.slice(start, end);
     const totalPages = Math.ceil(posts.length / per_page);
     
     // Transform to WordPress format
     const wpPosts = paginatedPosts.map(post => ({
       id: post.id || post.slug,
       title: { rendered: post.title },
       excerpt: { rendered: post.excerpt || post.description || '' },
       content: { rendered: post.content },
       date: post.date,
       link: post.permalink || post.url,
       _embedded: {
         'wp:featuredmedia': post.featured_image ? [{
           source_url: post.featured_image
         }] : [],
         'wp:term': [
           post.categories || [],
           post.tags || []
         ]
       }
     }));
     
     res.setHeader('X-WP-Total', posts.length);
     res.setHeader('X-WP-TotalPages', totalPages);
     res.json(wpPosts);
   }
   ```

### Option 2: Separate API Service

Create a Node.js/Express API that reads Hugo's JSON output and serves WordPress-compatible responses.

**Pros:**
- Full control over API behavior
- Can add caching, rate limiting, etc.
- Easy to add features like full-text search

**Cons:**
- Requires separate hosting
- More maintenance overhead

### Option 3: Keep WordPress Running (Temporary)

Keep WordPress site running at a subdomain (e.g., `api.swantron.com` or `old.swantron.com`) and point tronswan there temporarily.

**Pros:**
- Zero code changes needed immediately
- Can migrate gradually

**Cons:**
- Still need to maintain WordPress
- Temporary solution

## Recommended Migration Path

### Phase 1: Prepare Hugo JSON Output

1. **Enhance Hugo JSON output** to include all needed fields:
   - Add post IDs (can use slug hash or sequential number)
   - Ensure featured images are included
   - Include categories and tags

2. **Create mapping script** to convert Hugo JSON to WordPress format:
   ```bash
   # Generate WordPress-compatible JSON
   node scripts/convert-hugo-to-wp-api.js
   ```

### Phase 2: Create API Wrapper

1. **Deploy API wrapper** (Cloudflare Workers recommended for GitHub Pages):
   - Reads Hugo's `index.json`
   - Transforms to WordPress format
   - Handles pagination and search

2. **Update tronswan service** to use new API endpoint:
   ```typescript
   // Option A: Point to new API
   const SWANTRON_API_URL = 'https://api.swantron.com/wp-json/wp/v2';
   
   // Option B: Use environment variable for gradual migration
   const SWANTRON_API_URL = process.env.SWANTRON_API_URL || 'https://swantron.com/wp-json/wp/v2';
   ```

### Phase 3: Test & Switch

1. **Test new API** with tronswan locally
2. **Deploy to staging** and verify
3. **Switch production** when ready
4. **Keep WordPress API** as fallback for a period

## Hugo JSON Output Enhancement

To make Hugo output WordPress-compatible JSON, create a custom output format:

**`hugo-site/layouts/_default/index.json`**:
```json
{{- $posts := where .Site.RegularPages "Type" "posts" -}}
{
  "posts": [
    {{- range $index, $post := $posts -}}
    {{- if $index }},{{- end }}
    {
      "id": {{ $post.Params.id | default (printf "%d" (add $index 1)) }},
      "slug": "{{ $post.Slug }}",
      "title": {{ $post.Title | jsonify }},
      "excerpt": {{ $post.Description | jsonify }},
      "content": {{ $post.Content | jsonify }},
      "date": "{{ $post.Date.Format "2006-01-02T15:04:05Z07:00" }}",
      "permalink": "{{ $post.Permalink }}",
      "featured_image": {{ $post.Params.featured_image | jsonify }},
      "categories": {{ $post.Params.categories | jsonify }},
      "tags": {{ $post.Params.tags | jsonify }}
    }
    {{- end -}}
  ]
}
```

## Testing Checklist

- [ ] API returns posts in WordPress format
- [ ] Pagination works (`X-WP-TotalPages` header)
- [ ] Search functionality works
- [ ] Featured images are included
- [ ] Categories and tags are included
- [ ] Post IDs are consistent
- [ ] Links point to correct URLs
- [ ] tronswan app works with new API

## Timeline Recommendation

1. **Week 1**: Set up Hugo JSON output and API wrapper
2. **Week 2**: Test with tronswan locally
3. **Week 3**: Deploy API wrapper, test in staging
4. **Week 4**: Switch tronswan to new API, monitor
5. **Week 5**: Decommission WordPress API (if desired)

## Notes

- The WordPress API can stay running during migration for safety
- Consider keeping WordPress at `old.swantron.com` for archive access
- All post URLs will remain the same (`/index.php/YYYY/MM/DD/slug/`)
- Images are already converted to relative paths, so they'll work on any domain
