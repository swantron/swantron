#!/usr/bin/env python3
"""
Extract permalinks from original posts and add them to Hugo frontmatter.
This preserves the old WordPress URL structure.
"""

import re
from pathlib import Path
from datetime import datetime

def extract_permalink_from_original(post_path):
    """Read the original post and extract permalink."""
    try:
        with open(post_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        # Extract permalink from frontmatter
        match = re.search(r'permalink:\s*(.+?)(?:\n|$)', content)
        if match:
            permalink = match.group(1).strip().strip("'\"")
            # Remove domain and leading slash if present
            permalink = re.sub(r'^https?://[^/]+', '', permalink)
            permalink = permalink.lstrip('/')
            return permalink
    except Exception as e:
        print(f"Error reading {post_path}: {e}")
    return None

def add_permalink_to_hugo_post(hugo_post_path, permalink):
    """Add permalink slug to Hugo post frontmatter."""
    try:
        with open(hugo_post_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        # Extract slug from permalink (last part after last slash, remove trailing slash)
        slug = permalink.rstrip('/').split('/')[-1]
        
        # Check if slug already exists and matches
        if 'slug:' in content:
            match = re.search(r"slug:\s*['\"](.+?)['\"]", content)
            if match and match.group(1) == slug:
                return False  # Already correct
        
        # Add slug to frontmatter (Hugo will use it with the permalink pattern)
        # Find the frontmatter section
        if content.startswith('---'):
            parts = content.split('---', 2)
            if len(parts) >= 3:
                frontmatter = parts[1]
                body = parts[2]
                
                # Remove existing slug line if present
                frontmatter = re.sub(r"slug:\s*['\"]?[^'\"]*['\"]?\s*\n", '', frontmatter)
                
                # Add slug after date
                if 'date:' in frontmatter and slug:
                    # Insert slug after date line
                    lines = frontmatter.split('\n')
                    new_lines = []
                    for line in lines:
                        new_lines.append(line)
                        if line.strip().startswith('date:'):
                            new_lines.append(f"slug: '{slug}'")
                    frontmatter = '\n'.join(new_lines)
                elif slug:
                    # Add at the end of frontmatter
                    frontmatter = frontmatter.rstrip() + f"\nslug: '{slug}'"
                
                content = f"---{frontmatter}---{body}"
                
                with open(hugo_post_path, 'w', encoding='utf-8') as f:
                    f.write(content)
                return True
    except Exception as e:
        print(f"Error updating {hugo_post_path}: {e}")
    return False

def main():
    source_dir = Path('/Users/swantron/code/blog/wp-export/_posts')
    dest_dir = Path('/Users/swantron/code/blog/hugo-site/content/posts')
    
    posts = list(source_dir.glob('*.md'))
    total = len(posts)
    updated = 0
    
    print(f"Processing {total} posts to preserve permalinks...")
    
    for i, source_post in enumerate(posts, 1):
        if i % 100 == 0:
            print(f"Processed {i}/{total} posts...")
        
        permalink = extract_permalink_from_original(source_post)
        if permalink:
            hugo_post = dest_dir / source_post.name
            if hugo_post.exists():
                if add_permalink_to_hugo_post(hugo_post, permalink):
                    updated += 1
    
    print(f"Updated {updated}/{total} posts with permalink slugs")

if __name__ == '__main__':
    main()
