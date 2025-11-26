#!/usr/bin/env python3
"""
Fix featured_image fields that have extra quotes/text from markdown alt text
"""

import re
from pathlib import Path

def fix_featured_image(content):
    """Fix featured_image fields with extra quotes."""
    # Pattern: featured_image: '/path/to/image.jpg "alt text"'
    # Match featured_image line and extract just the image path
    pattern = r"(featured_image:\s*['\"])([^'\"]+\.(jpg|jpeg|png|gif|webp))([^'\"]*)(['\"])"
    
    def replace(match):
        quote_start = match.group(1)
        image_path = match.group(2)
        extra_text = match.group(4)
        quote_end = match.group(5)
        
        # If there's extra text (like alt text), remove it
        if extra_text and (' "' in extra_text or ' "' in image_path):
            # Split on space-quote to get just the path
            if ' "' in image_path:
                image_path = image_path.split(' "')[0]
        
        # Use single quotes consistently
        return f"featured_image: '{image_path}'"
    
    return re.sub(pattern, replace, content, flags=re.MULTILINE)

def fix_post_file(post_path):
    """Fix featured_image in a post file."""
    try:
        with open(post_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        original_content = content
        content = fix_featured_image(content)
        
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
    
    print(f"Checking {total} posts for featured_image with extra quotes...")
    
    for i, post_path in enumerate(posts, 1):
        if i % 100 == 0:
            print(f"Processed {i}/{total} posts...")
        
        if fix_post_file(post_path):
            fixed += 1
    
    print(f"Fixed {fixed}/{total} posts with featured_image quote issues")

if __name__ == '__main__':
    main()
