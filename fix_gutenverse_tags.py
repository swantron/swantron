#!/usr/bin/env python3
"""
Remove WordPress Gutenverse HTML wrapper tags that prevent markdown images from rendering.
Converts <div class="wp-block-gutenverse-image..."><a>![](image)</a></div> to ![](image)
"""

import re
from pathlib import Path

def fix_gutenverse_tags(content):
    """Remove Gutenverse wrapper tags around markdown images."""
    # Pattern: <div class="wp-block-gutenverse-image..."><a...>![](image)</a></div>
    pattern = r'<div[^>]*class="[^"]*wp-block-gutenverse[^"]*"[^>]*>\s*<a[^>]*>(\s*!\[.*?\]\(.*?\))\s*</a>\s*</div>'
    
    def replace_gutenverse(match):
        # Extract just the markdown image syntax
        markdown_image = match.group(1).strip()
        return markdown_image
    
    content = re.sub(pattern, replace_gutenverse, content, flags=re.DOTALL | re.IGNORECASE)
    
    # Also handle cases without <a> tag
    pattern2 = r'<div[^>]*class="[^"]*wp-block-gutenverse[^"]*"[^>]*>(\s*!\[.*?\]\(.*?\))\s*</div>'
    content = re.sub(pattern2, replace_gutenverse, content, flags=re.DOTALL | re.IGNORECASE)
    
    # Handle guten-element and guten-image classes
    pattern3 = r'<div[^>]*class="[^"]*guten-[^"]*"[^>]*>\s*<a[^>]*>(\s*!\[.*?\]\(.*?\))\s*</a>\s*</div>'
    content = re.sub(pattern3, replace_gutenverse, content, flags=re.DOTALL | re.IGNORECASE)
    
    pattern4 = r'<div[^>]*class="[^"]*guten-[^"]*"[^>]*>(\s*!\[.*?\]\(.*?\))\s*</div>'
    content = re.sub(pattern4, replace_gutenverse, content, flags=re.DOTALL | re.IGNORECASE)
    
    return content

def fix_post_file(post_path):
    """Fix Gutenverse tags in a post file."""
    try:
        with open(post_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        original_content = content
        content = fix_gutenverse_tags(content)
        
        if content != original_content:
            with open(post_path, 'w', encoding='utf-8') as f:
                f.write(content)
            return True
    except Exception as e:
        print(f"Error fixing {post_path}: {e}")
    return False

def main():
    posts_dir = Path('/Users/swantron/code/swantron/hugo-site/content/posts')
    posts = list(posts_dir.glob('*.md'))
    total = len(posts)
    fixed = 0
    
    print(f"Checking {total} posts for Gutenverse wrapper tags...")
    
    for i, post_path in enumerate(posts, 1):
        if i % 100 == 0:
            print(f"Processed {i}/{total} posts...")
        
        if fix_post_file(post_path):
            fixed += 1
    
    print(f"Fixed {fixed}/{total} posts with Gutenverse wrapper tags")

if __name__ == '__main__':
    main()
