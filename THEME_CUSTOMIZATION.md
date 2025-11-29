# Theme Customization Guide

## Theme Setup

The theme is included directly in `themes/paper/` - no submodules or modules needed!

## How Hugo Template Overrides Work

Hugo uses a **lookup order** for templates:
1. `layouts/` in your site (highest priority - YOUR customizations)
2. `themes/paper/layouts/` (theme defaults)

**Any file you put in `layouts/` overrides the theme version!**

## Customizing for Images

### Option 1: Override Post Template (Recommended)

Create `hugo-site/layouts/_default/single.html` to customize how posts display:

```html
{{- define "main" }}
<article class="post-single">
  <header class="post-header">
    <h1>{{ .Title }}</h1>
    {{- if .Params.featured_image }}
    <img src="{{ .Params.featured_image }}" alt="{{ .Title }}" class="featured-image">
    {{- end }}
  </header>
  
  <div class="post-content">
    {{ .Content }}
  </div>
  
  <!-- Add custom image gallery, etc. -->
</article>
{{- end }}
```

### Option 2: Use Hugo Shortcodes

Create custom shortcodes in `hugo-site/layouts/shortcodes/`:

**`hugo-site/layouts/shortcodes/image-gallery.html`**:
```html
<div class="image-gallery">
  {{ range .Params }}
    <img src="{{ . }}" alt="Gallery image">
  {{ end }}
</div>
```

Then use in posts:
```markdown
{{< image-gallery "image1.jpg" "image2.jpg" >}}
```

### Option 3: Add Custom CSS

Create `hugo-site/static/css/custom.css`:
```css
.featured-image {
  width: 100%;
  max-width: 800px;
  margin: 2rem auto;
  display: block;
}

.image-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
}
```

Reference in `config.toml`:
```toml
[params]
  customCSS = ["css/custom.css"]
```

Or add to `hugo-site/layouts/partials/head-custom.html`:
```html
<link rel="stylesheet" href="{{ "css/custom.css" | relURL }}">
```

## Example: Adding Image Support to Posts

### 1. Create Custom Post Layout

**`hugo-site/layouts/_default/single.html`**:
```html
{{- define "main" }}
<article class="post-single">
  <header class="post-header">
    <h1>{{ .Title }}</h1>
    <time>{{ .Date.Format "January 2, 2006" }}</time>
    
    {{- if .Params.featured_image }}
    <div class="featured-image-container">
      <img src="{{ .Params.featured_image | relURL }}" 
           alt="{{ .Title }}" 
           class="featured-image">
    </div>
    {{- end }}
  </header>
  
  <div class="post-content">
    {{ .Content }}
  </div>
  
  {{- if .Params.images }}
  <div class="post-images">
    <h2>More Images</h2>
    <div class="image-grid">
      {{- range .Params.images }}
      <img src="{{ . | relURL }}" alt="Post image">
      {{- end }}
    </div>
  </div>
  {{- end }}
</article>
{{- end }}
```

### 2. Add Custom Styles

**`hugo-site/static/css/custom.css`**:
```css
.featured-image-container {
  margin: 2rem 0;
  text-align: center;
}

.featured-image {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.image-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1rem;
  margin: 2rem 0;
}

.image-grid img {
  width: 100%;
  height: auto;
  border-radius: 4px;
  transition: transform 0.2s;
}

.image-grid img:hover {
  transform: scale(1.05);
}
```

### 3. Include CSS in Theme

**`hugo-site/layouts/partials/head-custom.html`**:
```html
<link rel="stylesheet" href="{{ "css/custom.css" | relURL }}">
```

### 4. Use in Posts

**Example post frontmatter**:
```yaml
---
title: "My Post with Images"
date: 2024-01-01
featured_image: "/uploads/2024/01/main-image.jpg"
images:
  - "/uploads/2024/01/image1.jpg"
  - "/uploads/2024/01/image2.jpg"
---
```

## Updating the Theme

Since the theme is included directly, you can:
1. Edit files directly in `themes/paper/` if needed
2. Or download a new version from https://github.com/nanxiaobei/hugo-paper and replace it

Your customizations in `layouts/` override the theme automatically!

## Best Practices

1. **Override in `layouts/`** - Your customizations (recommended)
2. **Add custom CSS/JS in `static/`** - Your assets
3. **Use shortcodes** - Reusable components
4. **Edit `themes/paper/` directly** - If you need to modify the theme itself

## Current Setup

Your site already has:
- ✅ Theme included directly (`hugo-site/themes/paper/`)
- ✅ Custom layouts directory (`hugo-site/layouts/`)
- ✅ Custom JSON output (`hugo-site/layouts/_default/index.json`)
- ✅ Static files directory (`hugo-site/static/`)

You're all set to customize! Just add files to `layouts/` and `static/` as needed.
