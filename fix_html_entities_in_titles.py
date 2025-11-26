#!/usr/bin/env python3
"""
Fix HTML entities in post titles (e.g., &#8217; -> ')
"""

import re
import html
from pathlib import Path

def fix_html_entities_in_title(content):
    """Decode HTML entities in YAML frontmatter title field."""
    # Pattern to match title field in frontmatter
    # Matches: title: '...' or title: "..."
    pattern = r"(title:\s*['\"])(.*?)(['\"])"
    
    def replace_title(match):
        quote_start = match.group(1)  # title: ' or title: "
        title_content = match.group(2)  # The actual title text
        quote_end = match.group(3)  # ' or "
        
        # Decode HTML entities
        decoded_title = html.unescape(title_content)
        
        # Use double quotes if title contains single quotes, otherwise keep original
        if "'" in decoded_title and quote_start.endswith("'"):
            return f'title: "{decoded_title}"'
        elif '"' in decoded_title and quote_start.endswith('"'):
            return f"title: '{decoded_title}'"
        else:
            return f"{quote_start}{decoded_title}{quote_end}"
    
    return re.sub(pattern, replace_title, content, flags=re.MULTILINE | re.DOTALL)

def fix_post_file(post_path):
    """Fix HTML entities in a post file."""
    try:
        with open(post_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        original_content = content
        content = fix_html_entities_in_title(content)
        
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
    
    print(f"Checking {total} posts for HTML entities in titles...")
    
    for i, post_path in enumerate(posts, 1):
        if i % 100 == 0:
            print(f"Processed {i}/{total} posts...")
        
        if fix_post_file(post_path):
            fixed += 1
    
    print(f"Fixed {fixed}/{total} posts with HTML entities in titles")

if __name__ == '__main__':
    main()
