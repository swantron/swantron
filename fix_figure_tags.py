#!/usr/bin/env python3
"""
Fix WordPress figure tags that wrap markdown images.
Converts <figure>![](image)</figure> to just ![](image)
"""

import re
from pathlib import Path

def fix_figure_tags(content):
    """Remove figure tags wrapping markdown images."""
    # Pattern: <figure...>![](image)</figure>
    pattern = r'<figure[^>]*>(\s*!\[.*?\]\(.*?\))\s*</figure>'
    
    def replace_figure(match):
        # Extract just the markdown image syntax
        markdown_image = match.group(1).strip()
        return markdown_image
    
    content = re.sub(pattern, replace_figure, content, flags=re.DOTALL)
    
    # Also handle figure tags with figcaption
    pattern2 = r'<figure[^>]*>(\s*!\[.*?\]\(.*?\))\s*<figcaption[^>]*>.*?</figcaption>\s*</figure>'
    content = re.sub(pattern2, replace_figure, content, flags=re.DOTALL)
    
    return content

def fix_post_file(post_path):
    """Fix figure tags in a post file."""
    try:
        with open(post_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        original_content = content
        content = fix_figure_tags(content)
        
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
    
    print(f"Checking {total} posts for figure tags...")
    
    for i, post_path in enumerate(posts, 1):
        if i % 100 == 0:
            print(f"Processed {i}/{total} posts...")
        
        if fix_post_file(post_path):
            fixed += 1
    
    print(f"Fixed {fixed}/{total} posts with figure tags")

if __name__ == '__main__':
    main()
