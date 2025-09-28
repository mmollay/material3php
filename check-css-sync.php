<?php
/**
 * Material3PHP CSS Sync Checker
 *
 * Checks if the global CSS is up-to-date with component changes
 * Run: php check-css-sync.php
 */

require_once 'autoload.php';

echo "🔍 Checking Material3PHP CSS sync status...\n";

// Get modification times
$srcDir = __DIR__ . '/src';
$cssFile = __DIR__ . '/dist/material3php.css';

if (!file_exists($cssFile)) {
    echo "❌ Global CSS file not found: dist/material3php.css\n";
    echo "💡 Run: php build-css.php\n";
    exit(1);
}

$cssModTime = filemtime($cssFile);
$newestSrcTime = 0;
$changedFiles = [];

// Check all MD3 component files
$files = glob($srcDir . '/MD3*.php');
foreach ($files as $file) {
    $modTime = filemtime($file);
    if ($modTime > $newestSrcTime) {
        $newestSrcTime = $modTime;
    }
    if ($modTime > $cssModTime) {
        $changedFiles[] = basename($file);
    }
}

// Check build script itself
if (filemtime(__DIR__ . '/build-css.php') > $cssModTime) {
    $changedFiles[] = 'build-css.php';
}

// Results
if (empty($changedFiles)) {
    echo "✅ CSS is up-to-date!\n";
    echo "📊 CSS built: " . date('Y-m-d H:i:s', $cssModTime) . "\n";
    echo "📊 Latest source: " . date('Y-m-d H:i:s', $newestSrcTime) . "\n";

    // Show build info
    $buildInfoFile = __DIR__ . '/dist/build-info.json';
    if (file_exists($buildInfoFile)) {
        $buildInfo = json_decode(file_get_contents($buildInfoFile), true);
        echo "📦 Version: {$buildInfo['version']}\n";
        echo "📦 Components: {$buildInfo['components_included']}\n";
        echo "📦 Size: " . number_format($buildInfo['original_size']) . " bytes (minified: " . number_format($buildInfo['minified_size']) . " bytes)\n";
    }
} else {
    echo "⚠️  CSS is OUT OF DATE!\n";
    echo "📝 Changed files since last build:\n";
    foreach ($changedFiles as $file) {
        echo "   - $file\n";
    }
    echo "\n💡 Run one of these commands to update:\n";
    echo "   php build-css.php\n";
    echo "   ./build.sh\n";
    echo "   VS Code: Ctrl+Shift+P → 'Tasks: Run Task' → 'Material3PHP: Rebuild CSS'\n";
    exit(1);
}
?>