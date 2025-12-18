# Swantron Hugo JSON API

This Hugo site exposes a JSON API for consuming blog posts programmatically. The API is generated as static JSON files during the Hugo build process.

## API Endpoints

### Get All Posts
**URL:** `/api/posts/index.json`

Returns a JSON object containing all blog posts:

```json
{
  "posts": [
    {
      "id": 8482,
      "slug": "tron-swan-dot-com-update",
      "title": "tronswan update",
      "excerpt": "I've been busy with...",
      "content": "<p>Full HTML content...</p>",
      "date": "2025-08-22T03:05:51Z",
      "permalink": "/index.php/2025/08/22/tron-swan-dot-com-update/",
      "link": "/index.php/2025/08/22/tron-swan-dot-com-update/",
      "featuredImage": "/uploads/2025/08/robospin.gif",
      "categories": [],
      "tags": []
    }
  ],
  "total": 1039
}
```

### Get Post by ID
**URL:** `/api/posts/by-id.json`

Returns a JSON object with posts keyed by ID:

```json
{
  "8482": {
    "id": 8482,
    "slug": "tron-swan-dot-com-update",
    "title": "tronswan update",
    ...
  },
  "1818": {
    "id": 1818,
    "slug": "green-robots-everywhere",
    ...
  }
}
```

## Usage in tronswan

The tronswan React app consumes this API by:

1. Setting the `VITE_SWANTRON_API_URL` environment variable to the Hugo site's base URL (e.g., `https://swantron.gitlab.io/swantron`)
2. Fetching `/api/posts/index.json` for the posts list
3. Fetching `/api/posts/by-id.json` for individual post lookups
4. Handling pagination and search client-side

## Building the API

The API endpoints are automatically generated when you build the Hugo site:

```bash
hugo --baseURL https://swantron.gitlab.io/swantron/
```

The JSON files will be generated in the `public/api/posts/` directory.

## File Structure

```
swantron/
├── content/
│   └── api/
│       └── posts/
│           ├── _index.md          # Posts list endpoint
│           └── by-id.md            # Posts by ID endpoint
├── layouts/
│   └── api/
│       └── posts/
│           ├── list.json           # Template for posts list
│           └── by-id.json         # Template for posts by ID
└── config.toml                     # Hugo configuration
```

## Notes

- All endpoints return JSON
- Posts are sorted by date (newest first) in the client application
- Search is handled client-side by filtering the posts array
- Pagination is handled client-side by slicing the posts array
- Featured images are extracted from post frontmatter or content
- The API is cached client-side for 5 minutes to reduce requests
