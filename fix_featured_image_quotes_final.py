#!/usr/bin/env python3
"""
Fix featured_image fields that have malformed quotes
"""

import re
from pathlib import Path

def fix_featured_image(content):
    """Fix featured_image fields with malformed quotes."""
    # Find all featured_image lines
    lines = content.split('\n')
    fixed_lines = []
    
    for line in lines:
        if 'featured_image:' in line:
            # Extract the image path - look for .jpg, .jpeg, .png, .gif, .webp
            # Pattern: featured_image: '...' or featured_image: "..."
            match = re.search(r"featured_image:\s*['\"]([^'\"]*\.(jpg|jpeg|png|gif|webp))[^'\"]*['\"]", line)
            if match:
                image_path = match.group(1)
                # Clean up - remove any alt text after the image extension
                if ' "' in image_path:
                    image_path = image_path.split(' "')[0]
                # Remove any trailing quotes or text
                image_path = image_path.split("'")[0].split('"')[0]
                fixed_lines.append(f"featured_image: '{image_path}'")
            else:
                # Try to extract just the path manually
                # Remove everything after the file extension
                if '.jpg' in line:
                    path_end = line.find('.jpg') + 4
                elif '.jpeg' in line:
                    path_end = line.find('.jpeg') + 5
                elif '.png' in line:
                    path_end = line.find('.png') + 4
                elif '.gif' in line:
                    path_end = line.find('.gif') + 4
                elif '.webp' in line:
                    path_end = line.find('.webp') + 5
                else:
                    fixed_lines.append(line)
                    continue
                
                # Extract from start of featured_image to end of extension
                start = line.find("featured_image:")
                if start != -1:
                    # Find the opening quote
                    quote_start = line.find("'", start)
                    if quote_start == -1:
                        quote_start = line.find('"', start)
                    if quote_start != -1:
                        image_path = line[quote_start+1:path_end]
                        fixed_lines.append(f"featured_image: '{image_path}'")
                    else:
                        fixed_lines.append(line)
                else:
                    fixed_lines.append(line)
        else:
            fixed_lines.append(line)
    
    return '\n'.join(fixed_lines)

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
    
    print(f"Checking {total} posts for malformed featured_image quotes...")
    
    for i, post_path in enumerate(posts, 1):
        if i % 100 == 0:
            print(f"Processed {i}/{total} posts...")
        
        if fix_post_file(post_path):
            fixed += 1
    
    print(f"Fixed {fixed}/{total} posts with featured_image quote issues")

if __name__ == '__main__':
    main()
