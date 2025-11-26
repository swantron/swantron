# Custom Domain Setup for swantron.com

This guide explains how to point your domain `swantron.com` to the GitHub Pages site while preserving all old URLs.

## ✅ URL Structure Preserved

The Hugo site is configured to match your old WordPress permalink structure:
- Old: `https://swantron.com/index.php/2010/03/14/green-robots-everywhere/`
- New: `https://swantron.com/index.php/2010/03/14/green-robots-everywhere/` ✅

All 1,039 posts have been configured with their original slugs, so links will work exactly as before.

## Step 1: Configure GitHub Pages Custom Domain

1. Go to your repository: `https://github.com/swantron/swantron/settings/pages`
2. Under "Custom domain", enter: `swantron.com`
3. Check "Enforce HTTPS" (recommended)
4. Click "Save"

GitHub will automatically create a `CNAME` file in your repository (already included in `hugo-site/static/CNAME`).

## Step 2: Configure DNS Records

You need to add DNS records at your domain registrar (where you bought swantron.com). Add these records:

### Option A: Apex Domain (swantron.com) - Recommended

Add **4 A records** pointing to GitHub Pages IPs:
```
Type: A
Name: @ (or swantron.com)
Value: 185.199.108.153
TTL: 3600

Type: A
Name: @ (or swantron.com)
Value: 185.199.109.153
TTL: 3600

Type: A
Name: @ (or swantron.com)
Value: 185.199.110.153
TTL: 3600

Type: A
Name: @ (or swantron.com)
Value: 185.199.111.153
TTL: 3600
```

### Option B: CNAME (www.swantron.com)

Add a CNAME record for the www subdomain:
```
Type: CNAME
Name: www
Value: swantron.github.io
TTL: 3600
```

**Note:** GitHub Pages IPs can change. Check the latest IPs at: https://docs.github.com/en/pages/configuring-a-custom-domain-for-your-github-pages-site/managing-a-custom-domain-for-your-github-pages-site#configuring-an-apex-domain

## Step 3: Wait for DNS Propagation

DNS changes can take 24-48 hours to propagate, though often much faster (minutes to hours).

Check propagation:
```bash
dig swantron.com +short
# Should return the GitHub Pages IPs
```

## Step 4: Verify SSL Certificate

After DNS propagates, GitHub will automatically provision an SSL certificate for your domain. This usually takes a few minutes to an hour.

Check certificate status:
- Visit `https://swantron.com` - should show a valid certificate
- GitHub will show "DNS check successful" in repository settings

## Step 5: Update baseURL (After Domain is Live)

Once your domain is working, update `hugo-site/config.toml`:

```toml
baseURL = 'https://swantron.com/'
```

Then commit and push:
```bash
git add hugo-site/config.toml
git commit -m "Update baseURL for custom domain"
git push origin main
```

## Testing

After setup, test these URLs to ensure they work:
- `https://swantron.com/` (homepage)
- `https://swantron.com/index.php/2010/03/14/green-robots-everywhere/` (sample post)
- `https://swantron.com/about/`
- `https://swantron.com/contact/`

## Troubleshooting

### DNS not resolving
- Wait longer (can take up to 48 hours)
- Check DNS records are correct
- Verify at https://dnschecker.org/

### SSL certificate not issued
- Ensure DNS is fully propagated
- Make sure "Enforce HTTPS" is enabled in GitHub Pages settings
- Wait a bit longer (can take up to 24 hours)

### 404 errors on old URLs
- Verify permalink structure in `config.toml` matches old structure
- Check that posts have `slug:` in frontmatter
- Rebuild the site: `hugo -s hugo-site`

## Important Notes

1. **All old URLs are preserved** - The permalink structure `/index.php/YYYY/MM/DD/post-slug/` matches your old WordPress site exactly.

2. **Images work** - All image paths have been converted to relative paths (`/uploads/...`), so they'll work on any domain.

3. **No redirects needed** - Since URLs match exactly, no redirects are necessary.

4. **HTTPS enforced** - GitHub Pages automatically provides SSL certificates.

## Current Configuration

- **GitHub Pages URL**: `https://swantron.github.io/swantron/`
- **Custom Domain**: `swantron.com` (after DNS setup)
- **Permalink Pattern**: `/index.php/:year/:month/:day/:slug/`
- **Posts**: 1,039 posts with preserved slugs
