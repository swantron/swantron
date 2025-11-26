# Deployment Todo List

## ✅ Pre-Deployment Checklist

### 1. Review What Will Be Committed
```bash
cd /Users/swantron/code/blog
git status
```

**Expected files to commit:**
- `.gitmodules` (submodule config)
- `.gitignore` (excludes wp-export, sensitive files)
- `.github/workflows/deploy.yml` (GitHub Actions)
- `hugo-site/` (entire Hugo site)
- `README.md` (updated)
- Documentation files (CUSTOM_DOMAIN_SETUP.md, etc.)

**Should NOT commit:**
- `wp-export/` (excluded by .gitignore - contains sensitive data)
- `convert_posts.py` (optional, can exclude)
- `fix_permalinks.py` (optional, can exclude)

### 2. Verify Submodule is Set Up
```bash
git submodule status
```
Should show: `hugo-site/themes/PaperMod`

### 3. Test Hugo Build Locally (Optional but Recommended)
```bash
cd hugo-site
hugo server --baseURL http://localhost:1313/
```
Visit http://localhost:1313/ and verify:
- [ ] Homepage loads
- [ ] Posts display correctly
- [ ] Images load
- [ ] Navigation works
- [ ] No errors in console

---

## 🚀 Deployment Steps

### Step 1: Stage All Files
```bash
cd /Users/swantron/code/blog

# Add all Hugo site files
git add hugo-site/

# Add configuration files
git add .gitmodules
git add .gitignore
git add .github/

# Add documentation
git add README.md
git add *.md

# Review what will be committed
git status
```

### Step 2: Commit Everything
```bash
git commit -m "Add Hugo static site from WordPress export

- Converted 1,039 posts from Jekyll to Hugo format
- Preserved WordPress permalink structure (/index.php/YYYY/MM/DD/slug/)
- Added WordPress post IDs for API compatibility
- Configured PaperMod theme as submodule
- Set up GitHub Actions for automatic deployment
- Updated baseURL for swantron/swantron repository
- Excluded sensitive files (wp-export, config files)"
```

### Step 3: Push to GitHub
```bash
git push origin main
```

**Note:** If you get an error about the submodule, you may need to:
```bash
git push origin main --recurse-submodules=on-demand
```

### Step 4: Enable GitHub Pages

1. Go to: `https://github.com/swantron/swantron/settings/pages`

2. Under **"Source"**, select:
   - **"GitHub Actions"** (not "Deploy from a branch")

3. Click **"Save"**

4. GitHub will automatically:
   - Run the workflow from `.github/workflows/deploy.yml`
   - Build your Hugo site
   - Deploy to GitHub Pages

### Step 5: Monitor Deployment

1. Go to: `https://github.com/swantron/swantron/actions`

2. Watch the workflow run:
   - Should see "Hugo Build & Deploy" workflow
   - Wait for it to complete (usually 2-5 minutes)

3. Check for errors:
   - Green checkmark = success ✅
   - Red X = failure ❌ (check logs)

### Step 6: Verify Site is Live

Once deployment completes:

1. Visit: `https://swantron.github.io/swantron/`
   - Should see your blog homepage

2. Test a post URL:
   - `https://swantron.github.io/swantron/index.php/2010/03/14/green-robots-everywhere/`
   - Should load the post

3. Verify images:
   - Check that images load from `/uploads/...` paths

4. Test navigation:
   - About page
   - Contact page
   - Post pagination

---

## 🔧 Troubleshooting

### If GitHub Actions Fails:

**Error: "Hugo not found"**
- Check workflow file uses correct Hugo version
- Verify `extended: true` is set

**Error: "Submodule not found"**
- Run: `git submodule update --init --recursive`
- Commit the submodule reference

**Error: "Build failed"**
- Check Hugo build locally: `cd hugo-site && hugo`
- Look for template errors
- Check `config.toml` syntax

**Error: "Pages deployment failed"**
- Verify repository is public (required for free GitHub Pages)
- Check Pages settings → Source is "GitHub Actions"

### If Site Doesn't Load:

1. **Check GitHub Pages status:**
   - Settings → Pages → Should show "Published"

2. **Verify baseURL in config.toml:**
   - Should be: `https://swantron.github.io/swantron/`

3. **Check workflow logs:**
   - Actions → Latest workflow → Check build logs

4. **Wait a few minutes:**
   - DNS/CDN propagation can take 5-10 minutes

---

## 📋 Post-Deployment Checklist

After site is live:

- [ ] Homepage loads correctly
- [ ] Sample posts display correctly
- [ ] Images load from `/uploads/` paths
- [ ] Navigation menu works
- [ ] About/Contact pages work
- [ ] Permalink structure matches old WordPress URLs
- [ ] No 404 errors on old URLs
- [ ] Mobile responsive (check on phone)
- [ ] RSS feed works (if configured)

---

## 🌐 Custom Domain Setup (Later)

When ready to use `swantron.com`:

1. See `CUSTOM_DOMAIN_SETUP.md` for detailed instructions
2. Add DNS records at your domain registrar
3. Update `baseURL` in `config.toml` to `https://swantron.com/`
4. Commit and push

**Note:** Don't set up custom domain yet if WordPress is still running!

---

## 📝 Quick Reference Commands

```bash
# Test locally
cd hugo-site
hugo server --baseURL http://localhost:1313/

# Build locally (test build)
cd hugo-site
hugo

# Check what will be committed
git status

# Add everything
git add .

# Commit
git commit -m "Your message"

# Push
git push origin main

# Update theme later
cd hugo-site/themes/PaperMod
git pull origin master
cd ../..
git add hugo-site/themes/PaperMod
git commit -m "Update theme"
git push
```

---

## ⏱️ Estimated Time

- **Review & Test Locally:** 10-15 minutes
- **Commit & Push:** 2-3 minutes
- **GitHub Actions Build:** 2-5 minutes
- **DNS Propagation:** 0-10 minutes (usually instant for GitHub Pages)
- **Total:** ~20-30 minutes

---

## 🎯 Current Status

- ✅ Hugo site created
- ✅ Posts converted (1,039 posts)
- ✅ Images moved to static/uploads
- ✅ Permalinks preserved
- ✅ WordPress IDs added
- ✅ Theme configured
- ✅ GitHub Actions workflow created
- ✅ baseURL configured
- ⏳ Ready to commit and deploy

---

**Next Step:** Run `git status` to review, then follow Step 1 above!
