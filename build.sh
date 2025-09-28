#!/bin/bash

# Material3PHP Build Script
# Automatically rebuilds the global CSS file

echo "🔨 Material3PHP Build Process"
echo "=============================="

# Check if PHP is available
if ! command -v php &> /dev/null; then
    echo "❌ PHP is required but not found"
    echo "💡 Try: /Applications/XAMPP/bin/php build-css.php"
    exit 1
fi

# Run the CSS builder
echo "📦 Building CSS framework..."
if command -v /Applications/XAMPP/bin/php &> /dev/null; then
    /Applications/XAMPP/bin/php build-css.php
else
    php build-css.php
fi

# Check if build was successful
if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Build successful!"
    echo ""
    echo "📋 Next steps:"
    echo "   1. Test with: open global-demo.php"
    echo "   2. Commit changes: git add dist/ && git commit -m 'Update CSS build'"
    echo "   3. Deploy: Copy dist/material3php.css to your CDN"
    echo ""
    echo "💡 Usage:"
    echo "   <link rel=\"stylesheet\" href=\"dist/material3php.css\">"
else
    echo "❌ Build failed!"
    exit 1
fi