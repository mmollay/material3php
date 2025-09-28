# Material3PHP Build System

## Overview

Material3PHP offers two usage approaches:

1. **PHP Approach**: Dynamic server-side rendering with component methods
2. **Global CSS Approach**: Static CSS framework like Fomantic-UI

## Building the Global CSS

### Automatic Build

```bash
# Run the build script
./build.sh

# Or manually with PHP
php build-css.php
```

### What Gets Built

- `dist/material3php.css` - Complete framework (~146KB)
- `dist/material3php.min.css` - Minified version (~107KB, 28% smaller)
- `dist/build-info.json` - Build metadata

### Build Process

The build system automatically:

1. Extracts base MD3 system from `MD3::init()`
2. Collects CSS from all component classes (`MD3Button::getCSS()`, etc.)
3. Adds responsive design utilities
4. Creates minified version
5. Generates build metadata

### Included Components

✅ **All Material Design 3 Components:**

- Buttons (Filled, Outlined, Text, Elevated, Tonal)
- Icon Buttons & FAB
- Text Fields (Filled, Outlined)
- Select Fields
- Lists (Navigation, Simple, Avatar, Two-line, Three-line)
- Cards (Elevated, Filled, Outlined)
- Chips (Assist, Filter, Input, Suggestion)
- Progress Indicators
- Switches, Checkboxes, Radio Buttons
- Sliders, Badges, Tabs
- Menus, Dialogs, Snackbars, Tooltips
- Date/Time Pickers, Search Fields
- Navigation (Bar, Drawer, Rail)
- Dividers, Breadcrumbs, Bottom Sheets
- Carousels, Toolbars

### Usage After Build

#### Global CSS Approach (Like Fomantic-UI)
```html
<!-- Single CSS file - no PHP required -->
<link rel="stylesheet" href="dist/material3php.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

<!-- Use Material Design 3 elements directly -->
<md-filled-button>Hello World</md-filled-button>
<md-outlined-select label="Choose option">
  <md-select-option value="1">Option 1</md-select-option>
</md-outlined-select>
```

#### PHP Approach (Dynamic)
```php
<?php require_once 'autoload.php'; ?>
<?php echo MD3::init(); ?>

<?php echo MD3Button::filled('Hello World'); ?>
<?php echo MD3Select::outlined('demo', 'Choose option', ['1' => 'Option 1']); ?>
```

## When to Rebuild

Rebuild the CSS when:

- ✅ Adding new components
- ✅ Modifying existing component CSS
- ✅ Updating design tokens/themes
- ✅ Changing responsive breakpoints
- ✅ Releasing new versions

## Automation

### Pre-commit Hook (Optional)

```bash
# Add to .git/hooks/pre-commit
#!/bin/bash
if [ -f "build-css.php" ]; then
    echo "Rebuilding CSS..."
    php build-css.php
    git add dist/
fi
```

### CI/CD Integration

```yaml
# GitHub Actions example
- name: Build CSS
  run: |
    php build-css.php
    git add dist/
    git commit -m "Update CSS build" || exit 0
```

## CDN Deployment

After building, deploy `dist/material3php.css` to your CDN:

```html
<!-- CDN Usage -->
<link rel="stylesheet" href="https://cdn.yoursite.com/material3php/0.3.5/material3php.min.css">
```

## File Sizes

- **Uncompressed**: ~146KB
- **Minified**: ~107KB (28% reduction)
- **Gzipped**: ~15-20KB (estimated)

## Comparison

| Approach | Pros | Cons |
|----------|------|------|
| **Global CSS** | ✅ No PHP required<br>✅ CDN-ready<br>✅ Static hosting<br>✅ Fast loading | ❌ Static themes<br>❌ Larger file size |
| **PHP Dynamic** | ✅ Dynamic themes<br>✅ Server-side rendering<br>✅ Component methods<br>✅ Smaller output | ❌ Requires PHP<br>❌ Server dependency |

## Examples

- **Global CSS Demo**: [global-demo.php](global-demo.php)
- **PHP Demo**: [minimal-demo.php](minimal-demo.php)
- **Complete Gallery**: [demo-extended.php](demo-extended.php)

---

**Made with Material3PHP** • [GitHub](https://github.com/mmollay/material3php)