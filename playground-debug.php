<?php
// Debug version to identify the 500 error
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Playground Debug</h1>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";

// Test each require individually
$files = [
    'src/MD3.php',
    'src/MD3Button.php',
    'src/MD3TextField.php',
    'src/MD3Card.php',
    'src/MD3List.php',
    'src/MD3Switch.php',
    'src/MD3Checkbox.php',
    'src/MD3Radio.php',
    'src/MD3Select.php',
    'src/MD3Chip.php',
    'src/MD3Theme.php'
];

foreach ($files as $file) {
    echo "<p>Testing {$file}...</p>";
    if (file_exists($file)) {
        try {
            require_once $file;
            echo "<p style='color: green;'>✅ {$file} loaded successfully</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ {$file} failed: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ {$file} not found</p>";
    }
}

// Test theme parameter
$currentTheme = $_GET['theme'] ?? 'default';
echo "<p>Current theme: {$currentTheme}</p>";

// Test MD3 initialization
try {
    echo "<p>Testing MD3::init()...</p>";
    $initResult = MD3::init(true, true, $currentTheme);
    echo "<p style='color: green;'>✅ MD3::init() successful</p>";

    echo "<p>Testing MD3Theme::getThemeCSS()...</p>";
    $themeCSS = MD3Theme::getThemeCSS();
    echo "<p style='color: green;'>✅ MD3Theme::getThemeCSS() successful</p>";

    echo "<p>Testing MD3List::getListCSS()...</p>";
    $listCSS = MD3List::getListCSS();
    echo "<p style='color: green;'>✅ MD3List::getListCSS() successful</p>";

    echo "<p>Testing MD3::getVersionCSS()...</p>";
    $versionCSS = MD3::getVersionCSS();
    echo "<p style='color: green;'>✅ MD3::getVersionCSS() successful</p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p style='color: red;'>Stack trace: " . $e->getTraceAsString() . "</p>";
}

echo "<h2>Available Classes:</h2>";
$classes = get_declared_classes();
$md3Classes = array_filter($classes, function($class) {
    return strpos($class, 'MD3') === 0;
});

foreach ($md3Classes as $class) {
    echo "<p>✅ {$class}</p>";
}

echo "<h2>Available Functions:</h2>";
if (class_exists('MD3Theme')) {
    try {
        $themes = MD3Theme::getAvailableThemes();
        echo "<p>✅ MD3Theme::getAvailableThemes() returned " . count($themes) . " themes</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ MD3Theme::getAvailableThemes() failed: " . $e->getMessage() . "</p>";
    }
}

?>