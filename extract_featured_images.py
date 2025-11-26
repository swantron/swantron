#!/usr/bin/env python3
"""
Extract first image from each post and add it as featured_image in frontmatter
"""

import re
from pathlib import Path

def extract_first_image(content):
    """Extract the first image URL from markdown content."""
    # Pattern for markdown images: ![alt](url)
    pattern = r'!\[.*?\]\(([^)]+)\)'
    match = re.search(pattern, content)
    if match:
        return match.group(1)
    return None

def add_featured_image_to_post(post_path):
    """Add featured_image to post frontmatter if it doesn't exist."""
    try:
        with open(post_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        # Check if already has featured_image
        if 'featured_image:' in content or 'featuredImage:' in content:
            return False
        
        # Split frontmatter and content
        if not content.startswith('---'):
            return False
        
        parts = content.split('---', 2)
        if len(parts) < 3:
            return False
        
        frontmatter = parts[1]
        body = parts[2]
        
        # Extract first image from body
        image_url = extract_first_image(body)
        if not image_url:
            return False
        
        # Add featured_image to frontmatter (before the closing ---)
        # Find the last line of frontmatter
        frontmatter_lines = frontmatter.strip().split('\n')
        
        # Add featured_image before the last line (or at the end)
        featured_line = f"featured_image: '{image_url}'"
        
        # Check if slug exists, add after slug
        new_frontmatter_lines = []
        added = False
        for i, line in enumerate(frontmatter_lines):
            new_frontmatter_lines.append(line)
            if line.strip().startswith('slug:') and not added:
                new_frontmatter_lines.append(featured_line)
                added = True
        
        if not added:
            new_frontmatter_lines.append(featured_line)
        
        new_frontmatter = '\n'.join(new_frontmatter_lines)
        new_content = f"---\n{new_frontmatter}\n---{body}"
        
        with open(post_path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        return True
    except Exception as e:
        print(f"Error processing {post_path}: {e}")
    return False

def main():
    posts_dir = Path('/Users/swantron/code/swantron/hugo-site/content/posts')
    posts = list(posts_dir.glob('*.md'))
    total = len(posts)
    fixed = 0
    
    print(f"Extracting featured images from {total} posts...")
    
    for i, post_path in enumerate(posts, 1):
        if i % 100 == 0:
            print(f"Processed {i}/{total} posts...")
        
        if add_featured_image_to_post(post_path):
            fixed += 1
    
    print(f"Added featured images to {fixed}/{total} posts")

if __name__ == '__main__':
    main()
