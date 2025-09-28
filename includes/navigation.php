<?php
/**
 * Unified Navigation Include
 *
 * Provides consistent navigation across all pages
 * Determines active page automatically and builds appropriate navigation
 */

// Determine current page
$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
$currentTheme = $_GET['theme'] ?? 'default';
$themeParam = $currentTheme !== 'default' ? '?theme=' . $currentTheme : '';

// Build navigation items with active states
$navItems = [
    [
        'icon' => 'home',
        'label' => 'Home',
        'href' => 'index.php' . $themeParam,
        'active' => $currentScript === 'index.php'
    ],
    [
        'icon' => 'dashboard',
        'label' => 'Gallery',
        'href' => 'demo-extended.php' . $themeParam,
        'active' => $currentScript === 'demo-extended.php'
    ],
    [
        'icon' => 'science',
        'label' => 'Playground',
        'href' => 'playground.php' . $themeParam,
        'active' => $currentScript === 'playground.php'
    ],
];

// Build breadcrumbs based on current page
$breadcrumbs = [];
switch($currentScript) {
    case 'index.php':
        $breadcrumbs = [
            ['label' => 'Home', 'href' => 'index.php' . $themeParam]
        ];
        break;
    case 'demo-extended.php':
        $breadcrumbs = [
            ['label' => 'Home', 'href' => 'index.php' . $themeParam],
            ['label' => 'Component Gallery', 'href' => 'demo-extended.php' . $themeParam]
        ];
        break;
    case 'playground.php':
        $breadcrumbs = [
            ['label' => 'Home', 'href' => 'index.php' . $themeParam],
            ['label' => 'Interactive Playground', 'href' => 'playground.php' . $themeParam]
        ];
        break;
    default:
        $breadcrumbs = [
            ['label' => 'Home', 'href' => 'index.php' . $themeParam],
            ['label' => ucfirst(str_replace(['.php', '-'], ['', ' '], $currentScript))]
        ];
}

// Page titles and icons
$pageConfig = [
    'index.php' => ['title' => 'Material Design 3 PHP Library', 'icon' => 'home'],
    'demo-extended.php' => ['title' => 'Component Gallery', 'icon' => 'dashboard'],
    'playground.php' => ['title' => 'Interactive Playground', 'icon' => 'science'],
];

$pageInfo = $pageConfig[$currentScript] ?? ['title' => 'Material Design 3 PHP Library', 'icon' => 'home'];

// Output the navigation header
echo MD3Header::withNavigation(
    $pageInfo['title'],
    $pageInfo['icon'],
    $currentTheme,
    $breadcrumbs,
    $navItems
);
?>