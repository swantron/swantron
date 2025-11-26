#!/usr/bin/env python3
"""
Remove all HTML wrapper tags and WordPress shortcodes that prevent markdown images from rendering.
Handles: <div>, <span>, <p>, <figure>, <a> tags wrapping markdown images
Also handles WordPress [caption] shortcodes (with escaped brackets \[caption\])
"""

import re
from pathlib import Path

def fix_html_wrappers(content):
    """Remove HTML wrapper tags and WordPress shortcodes around markdown images."""
    original = content
    
    # Pattern 1: WordPress caption format \[caption...\]...\[/caption\] (escaped brackets)
    # Use non-greedy match to get content between caption tags
    pattern_caption = r'\\\[caption.*?\\\](.*?)\\\[/caption\\\]'
    def replace_caption(match):
        inner = match.group(1).strip()
        # Extract markdown image if present
        # Could be: ![alt](img) or [![alt](img)](link)
        # First try to find linked image pattern [![alt](img)](link)
        linked_img_match = re.search(r'\[(!\[.*?\]\([^)]+\))\]\([^)]+\)', inner)
        if linked_img_match:
            return linked_img_match.group(1)  # Return just the image part
        # Otherwise find standalone image
        img_match = re.search(r'!\[.*?\]\([^)]+\)', inner)
        if img_match:
            return img_match.group(0)
        return inner
    content = re.sub(pattern_caption, replace_caption, content, flags=re.DOTALL | re.IGNORECASE)
    
    # Pattern 2: WordPress caption format [caption...]...[/caption] (unescaped)
    pattern_caption2 = r'\[caption.*?\](.*?)\[/caption\]'
    content = re.sub(pattern_caption2, replace_caption, content, flags=re.DOTALL | re.IGNORECASE)
    
    # Pattern 3: <div...>![](image)</div> or <div...><a>![](image)</a></div>
    pattern_div = r'<div[^>]*>\s*(?:<a[^>]*>)?\s*(\s*!\[.*?\]\(.*?\))\s*(?:</a>)?\s*</div>'
    content = re.sub(pattern_div, r'\1', content, flags=re.DOTALL | re.IGNORECASE)
    
    # Pattern 4: <span...>![](image)</span> or <span...><a>![](image)</a></span>
    pattern_span = r'<span[^>]*>\s*(?:<a[^>]*>)?\s*(\s*!\[.*?\]\(.*?\))\s*(?:</a>)?\s*</span>'
    content = re.sub(pattern_span, r'\1', content, flags=re.DOTALL | re.IGNORECASE)
    
    # Pattern 5: <p...>![](image)</p> (only if paragraph ONLY contains the image)
    pattern_p = r'<p[^>]*>\s*(\s*!\[.*?\]\(.*?\))\s*</p>'
    content = re.sub(pattern_p, r'\1', content, flags=re.DOTALL | re.IGNORECASE)
    
    # Pattern 6: <a...>![](image)</a> (link wrapping ONLY a markdown image)
    pattern_a = r'<a[^>]*href="[^"]*">\s*(\s*!\[.*?\]\([^)]+\))\s*</a>'
    content = re.sub(pattern_a, r'\1', content, flags=re.DOTALL | re.IGNORECASE)
    
    # Pattern 7: <figure...>![](image)</figure>
    pattern_figure = r'<figure[^>]*>\s*(\s*!\[.*?\]\(.*?\))\s*</figure>'
    content = re.sub(pattern_figure, r'\1', content, flags=re.DOTALL | re.IGNORECASE)
    
    return content

def fix_post_file(post_path):
    """Fix HTML wrappers in a post file."""
    try:
        with open(post_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        original_content = content
        content = fix_html_wrappers(content)
        
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
    
    print(f"Checking {total} posts for HTML wrapper tags and WordPress shortcodes around images...")
    
    for i, post_path in enumerate(posts, 1):
        if i % 100 == 0:
            print(f"Processed {i}/{total} posts...")
        
        if fix_post_file(post_path):
            fixed += 1
    
    print(f"Fixed {fixed}/{total} posts with HTML wrapper tags/shortcodes")

if __name__ == '__main__':
    main()
