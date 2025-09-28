<?php
/**
 * Material3PHP CSS Builder
 *
 * Automatically generates dist/material3php.css from all component CSS
 * Run: php build-css.php
 */

require_once 'autoload.php';

echo "🔨 Building Material3PHP global CSS...\n";

// Get current version
$version = trim(file_get_contents('VERSION'));
$buildDate = date('Y-m-d H:i:s');

// Start building the complete CSS
$css = [];

// Header
$css[] = '/*!';
$css[] = ' * Material3PHP - Complete CSS Framework';
$css[] = " * Version: {$version}";
$css[] = ' * Built: ' . $buildDate;
$css[] = ' * Like Fomantic-UI but for Material Design 3';
$css[] = ' *';
$css[] = ' * Usage: <link rel="stylesheet" href="dist/material3php.css">';
$css[] = ' */';
$css[] = '';

// Get base MD3 system from MD3::init()
echo "📦 Extracting base MD3 system...\n";
$baseInit = MD3::init(false, true, 'default'); // No icons, yes CSS, default theme
if (preg_match('/<style>(.*?)<\/style>/s', $baseInit, $matches)) {
    $css[] = '/* ==========================================================================';
    $css[] = '   Material Design 3 Base System (from MD3::init())';
    $css[] = '   ========================================================================== */';
    $css[] = '';
    $css[] = trim($matches[1]);
    $css[] = '';
}

// Collect all component CSS
$components = [
    'MD3Button' => 'Buttons',
    'MD3List' => 'Lists',
    'MD3Card' => 'Cards',
    'MD3TextField' => 'Text Fields',
    'MD3Select' => 'Select Fields',
    'MD3Chip' => 'Chips',
    'MD3Progress' => 'Progress Indicators',
    'MD3Switch' => 'Switches',
    'MD3Checkbox' => 'Checkboxes',
    'MD3Radio' => 'Radio Buttons',
    'MD3Slider' => 'Sliders',
    'MD3Badge' => 'Badges',
    'MD3Tabs' => 'Tabs',
    'MD3Menu' => 'Menus',
    'MD3Dialog' => 'Dialogs',
    'MD3Snackbar' => 'Snackbars',
    'MD3Tooltip' => 'Tooltips',
    'MD3DateTimePicker' => 'Date Time Pickers',
    'MD3Search' => 'Search Fields',
    'MD3NavigationBar' => 'Navigation Bar',
    'MD3NavigationDrawer' => 'Navigation Drawer',
    'MD3NavigationRail' => 'Navigation Rail',
    'MD3FloatingActionButton' => 'Floating Action Buttons',
    'MD3IconButton' => 'Icon Buttons',
    'MD3Divider' => 'Dividers',
    'MD3Breadcrumb' => 'Breadcrumbs',
    'MD3BottomSheet' => 'Bottom Sheets',
    'MD3Carousel' => 'Carousels',
    'MD3Toolbar' => 'Toolbars'
];

foreach ($components as $className => $displayName) {
    if (class_exists($className) && method_exists($className, 'getCSS')) {
        echo "📝 Adding {$displayName} CSS...\n";

        $css[] = '/* ==========================================================================';
        $css[] = "   {$displayName}";
        $css[] = '   ========================================================================== */';
        $css[] = '';

        $componentCSS = $className::getCSS();
        $css[] = trim($componentCSS);
        $css[] = '';
    }
}

// Add responsive design and utilities
$css[] = '/* ==========================================================================';
$css[] = '   Responsive Design & Utilities';
$css[] = '   ========================================================================== */';
$css[] = '';
$css[] = '@media (max-width: 768px) {';
$css[] = '  body { padding: 8px; }';
$css[] = '  md-filled-button, md-outlined-button, md-text-button, md-elevated-button, md-filled-tonal-button {';
$css[] = '    height: 36px; padding: 0 16px; font-size: 13px;';
$css[] = '  }';
$css[] = '  .md3-list-item { padding: 8px 12px; }';
$css[] = '}';
$css[] = '';

// Add Material Icons helper
$css[] = '/* Material Icons */';
$css[] = '.material-symbols-outlined {';
$css[] = '  font-variation-settings: \'FILL\' 0, \'wght\' 400, \'GRAD\' 0, \'opsz\' 24;';
$css[] = '}';
$css[] = '';

// Footer
$css[] = '/* ==========================================================================';
$css[] = '   End of Material3PHP CSS Framework';
$css[] = " * Version: {$version} | Built: {$buildDate}";
$css[] = '   ========================================================================== */';

// Write the CSS file
$finalCSS = implode("\n", $css);
$distDir = __DIR__ . '/dist';
if (!is_dir($distDir)) {
    mkdir($distDir, 0755, true);
}

file_put_contents($distDir . '/material3php.css', $finalCSS);

// Create minified version (basic minification)
$minified = preg_replace('/\/\*.*?\*\//s', '', $finalCSS); // Remove comments
$minified = preg_replace('/\s+/', ' ', $minified); // Compress whitespace
$minified = str_replace([' {', '{ ', ' }', '} ', '; ', ' ;', ': ', ' :'], ['{', '{', '}', '}', ';', ';', ':', ':'], $minified);
file_put_contents($distDir . '/material3php.min.css', trim($minified));

// Generate file sizes
$originalSize = filesize($distDir . '/material3php.css');
$minifiedSize = filesize($distDir . '/material3php.min.css');

echo "✅ Build complete!\n";
echo "📁 Files created:\n";
echo "   - dist/material3php.css ({$originalSize} bytes)\n";
echo "   - dist/material3php.min.css ({$minifiedSize} bytes)\n";
echo "💾 Size reduction: " . round((1 - $minifiedSize/$originalSize) * 100, 1) . "%\n";

// Update build info
$buildInfo = [
    'version' => $version,
    'build_date' => $buildDate,
    'original_size' => $originalSize,
    'minified_size' => $minifiedSize,
    'components_included' => count($components),
    'compression_ratio' => round((1 - $minifiedSize/$originalSize) * 100, 1)
];

file_put_contents($distDir . '/build-info.json', json_encode($buildInfo, JSON_PRETTY_PRINT));

echo "📊 Build info saved to dist/build-info.json\n";
echo "🚀 Ready to use: <link rel=\"stylesheet\" href=\"dist/material3php.css\">\n";
?>