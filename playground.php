<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Design 3 PHP Library - Interactive Playground</title>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once 'autoload.php';

    try {

        // Get theme from URL parameter or default
        $currentTheme = $_GET['theme'] ?? 'default';

        echo MD3::init(true, true, $currentTheme);
    } catch (Exception $e) {
        echo "<!-- Error: " . htmlspecialchars($e->getMessage()) . " -->";
    }
    ?>
    <style>
        <?php
        if (class_exists('MD3Theme')) {
            echo MD3Theme::getThemeCSS();
        }
        echo MD3::getVersionCSS();
        // Additional component CSS inside style tag
        echo MD3NavigationBar::getCSS();
        echo MD3NavigationDrawer::getCSS();
        echo MD3Search::getCSS();
        echo MD3Select::getCSS();
        echo MD3List::getCSS();
        echo MD3Card::getCSS();
        echo MD3Button::getCSS();
        echo MD3Chip::getCSS();
        echo MD3Progress::getCSS();
        echo MD3Slider::getCSS();
        echo MD3Switch::getCSS();
        echo MD3Checkbox::getCSS();
        echo MD3Radio::getCSS();
        echo MD3Tabs::getCSS();
        echo MD3Tooltip::getCSS();
        echo MD3Breadcrumb::getCSS();
        echo MD3Toolbar::getCSS();
        echo MD3NavigationRail::getCSS();
        echo MD3Menu::getCSS();
        echo MD3Dialog::getCSS();
        echo MD3FloatingActionButton::getCSS();
        echo MD3IconButton::getCSS();
        echo MD3Progress::getCSS();
        echo MD3Slider::getCSS();
        echo MD3Badge::getCSS();
        echo MD3BottomSheet::getCSS();
        echo MD3DateTimePicker::getCSS();
        echo MD3Header::getCSS();
        echo MD3Snackbar::getCSS();
        ?>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Google Sans', 'Roboto', system-ui, sans-serif;
            background: var(--md-sys-color-background);
            color: var(--md-sys-color-on-background);
            overflow-x: hidden;
        }

        /* Layout */
        .playground-container {
            display: grid;
            grid-template-areas:
                "sidebar content";
            grid-template-columns: 280px 1fr;
            height: calc(100vh - 65px); /* Account for fixed header height */
        }

        .playground-header {
            grid-area: header;
            background: var(--md-sys-color-surface);
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
            padding: 12px 24px;
        }

        .header-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .header-main h1 {
            font-size: 18px;
            font-weight: 500;
            color: var(--md-sys-color-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Mode Toggle */
        .mode-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: none;
            border: 1px solid var(--md-sys-color-outline);
            border-radius: 20px;
            color: var(--md-sys-color-on-surface);
            cursor: pointer;
            transition: all 0.2s;
            margin-right: 8px;
        }

        .mode-toggle:hover {
            background: var(--md-sys-color-surface-container-high);
            border-color: var(--md-sys-color-primary);
        }

        /* Compact Theme Selector */
        .theme-selector-compact {
            position: relative;
        }

        .theme-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: var(--md-sys-color-surface-container);
            color: var(--md-sys-color-on-surface);
            border: 1px solid var(--md-sys-color-outline);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            min-width: 120px;
        }

        .theme-toggle:hover {
            background: var(--md-sys-color-surface-container-high);
            border-color: var(--md-sys-color-primary);
        }

        .theme-current {
            flex: 1;
            text-align: left;
        }

        .theme-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--md-sys-color-surface-container);
            border-radius: 8px;
            box-shadow: var(--md-sys-elevation-2);
            padding: 8px 0;
            min-width: 200px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
        }

        .theme-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .theme-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--md-sys-color-on-surface);
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .theme-option:hover {
            background: var(--md-sys-color-surface-container-high);
        }

        .theme-option.active {
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
        }

        .theme-icon {
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-name {
            flex: 1;
        }

        .theme-check {
            width: 20px;
            color: var(--md-sys-color-primary);
        }

        .back-link {
            text-decoration: none;
        }

        .playground-sidebar {
            grid-area: sidebar;
            background: var(--md-sys-color-surface);
            border-right: 1px solid var(--md-sys-color-outline-variant);
            overflow-y: auto;
            padding: 8px;
        }

        .playground-content {
            grid-area: content;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 0;
            min-height: calc(100vh - 64px);
        }

        .component-preview {
            padding: 24px;
            background: var(--md-sys-color-background);
            overflow-y: auto;
        }

        .component-controls {
            background: var(--md-sys-color-surface-container-lowest);
            border-left: 1px solid var(--md-sys-color-outline-variant);
            padding: 24px;
            overflow-y: auto;
        }

        /* Navigation */
        .nav-section {
            margin-bottom: 10px;
        }

        .nav-section h3 {
            font-size: 11px;
            font-weight: 600;
            color: var(--md-sys-color-primary);
            margin-bottom: 4px;
            padding: 0 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 8px;
            border-radius: 16px;
            text-decoration: none;
            color: var(--md-sys-color-on-surface);
            font-size: 12px;
            margin-bottom: 1px;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-item .material-symbols-outlined {
            font-size: 16px;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: var(--md-sys-color-surface-container-high);
        }

        .nav-item.active {
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            font-weight: 500;
        }

        /* Preview Area */
        .preview-area {
            background: var(--md-sys-color-surface);
            border-radius: 12px;
            padding: 32px;
            margin-bottom: 24px;
            border: 1px solid var(--md-sys-color-outline-variant);
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        /* Code Display */
        .code-section {
            background: var(--md-sys-color-surface-container);
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
            font-family: 'Roboto Mono', monospace;
            font-size: 13px;
            line-height: 1.4;
            overflow-x: auto;
        }

        .code-section h4 {
            margin-bottom: 12px;
            color: var(--md-sys-color-on-surface);
            font-family: inherit;
        }

        .code-section pre {
            background: var(--md-sys-color-surface-variant);
            padding: 12px;
            border-radius: 4px;
            color: var(--md-sys-color-on-surface-variant);
            white-space: pre-wrap;
            position: relative;
        }

        /* Controls */
        .control-group {
            margin-bottom: 20px;
        }

        .control-group h4 {
            font-size: 15px;
            margin-bottom: 10px;
            color: var(--md-sys-color-on-surface);
        }

        /* Enhanced input styling */
        .control-group label {
            display: block;
            font-weight: 500;
            color: var(--md-sys-color-on-surface);
            margin-bottom: 6px;
            font-size: 13px;
        }

        .control-group select,
        .control-group input[type="text"],
        .control-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--md-sys-color-outline);
            border-radius: 8px;
            background: var(--md-sys-color-surface);
            color: var(--md-sys-color-on-surface);
            font-family: inherit;
            font-size: 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }

        .control-group select:focus,
        .control-group input[type="text"]:focus,
        .control-group textarea:focus {
            outline: none;
            border-color: var(--md-sys-color-primary);
            box-shadow: 0 0 0 2px rgba(66, 165, 245, 0.12);
        }

        .control-group select:hover,
        .control-group input[type="text"]:hover,
        .control-group textarea:hover {
            border-color: var(--md-sys-color-outline-variant);
        }

        /* Enhanced select styling */
        .control-group select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
            appearance: none;
            cursor: pointer;
        }

        /* Enhanced checkbox styling - MD3 Style */
        .control-group input[type="checkbox"] {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid var(--md-sys-color-outline);
            border-radius: 2px;
            background-color: transparent;
            cursor: pointer;
            position: relative;
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
            margin-right: 8px;
            flex-shrink: 0;
        }

        .control-group input[type="checkbox"]:checked {
            background-color: var(--md-sys-color-primary);
            border-color: var(--md-sys-color-primary);
        }

        .control-group input[type="checkbox"]:checked::before {
            content: "✓";
            position: absolute;
            color: var(--md-sys-color-on-primary);
            font-size: 10px;
            font-weight: bold;
            top: -2px;
            left: 1px;
        }

        .control-group input[type="checkbox"]:hover {
            border-color: var(--md-sys-color-primary);
        }

        /* Special styling for checkbox containers */
        .control-group:has(input[type="checkbox"]) {
            padding: 8px 12px;
            border: 1px solid var(--md-sys-color-outline-variant);
            border-radius: 8px;
            background: var(--md-sys-color-surface-container-lowest);
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 12px;
        }

        .control-group:has(input[type="checkbox"]):hover {
            background: var(--md-sys-color-surface-container);
            border-color: var(--md-sys-color-primary);
        }

        .control-group:has(input[type="checkbox"]) label {
            margin: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 400;
            font-size: 14px;
        }

        .control-item {
            margin-bottom: 16px;
        }

        /* Group Styling - Optimized Layout */
        .control-group-container {
            margin-bottom: 24px;
            border: 1px solid var(--md-sys-color-outline-variant);
            border-radius: 12px;
            padding: 16px;
            background: var(--md-sys-color-surface-container-lowest);
            width: 100%;
        }

        .control-group-label {
            margin: 0 0 16px 0;
            font-size: 14px;
            font-weight: 600;
            color: var(--md-sys-color-primary);
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
            padding-bottom: 8px;
        }

        .control-group-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            width: 100%;
        }

        /* Force grid items to use full available space */
        .control-group-content .control-group {
            margin-bottom: 0;
            box-sizing: border-box;
            width: 100%;
            min-width: 0; /* Allow flex items to shrink */
        }

        /* Special handling for checkbox groups - better grid layout */
        .control-group-content:has(.control-group input[type="checkbox"]) {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }

        /* Ensure textarea and text inputs use full available width */
        .control-group-content .control-group textarea,
        .control-group-content .control-group input[type="text"],
        .control-group-content .control-group input[type="number"],
        .control-group-content .control-group select {
            width: 100%;
            box-sizing: border-box;
        }

        /* Override width settings for full utilization */
        .control-group-content .control-group[style*="width: 50%"] {
            grid-column: span 1;
            width: 100% !important;
        }

        .control-group-content .control-group[style*="width: 33%"] {
            grid-column: span 1;
            width: 100% !important;
        }

        .control-group-content .control-group[style*="width: 70%"] {
            grid-column: span 2;
            width: 100% !important;
        }

        .control-group-content .control-group[style*="width: 30%"] {
            grid-column: span 1;
            width: 100% !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .control-group-content {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .control-group-content .control-group[style*="width: 70%"],
            .control-group-content .control-group[style*="width: 30%"] {
                grid-column: span 1;
            }
        }

        .control-group-content .control-group:has(input[type="checkbox"]) {
            padding: 6px 10px;
            margin-bottom: 6px;
            background: var(--md-sys-color-surface);
            border: 1px solid var(--md-sys-color-outline-variant);
        }

        .control-group-content .control-group:has(input[type="checkbox"]):hover {
            background: var(--md-sys-color-surface-container-high);
        }

        /* Textarea styling in groups */
        .control-group-content textarea {
            min-height: 80px;
            resize: vertical;
        }

        .control-group-content input[type="number"] {
            text-align: center;
        }

        .control-item label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--md-sys-color-on-surface-variant);
            margin-bottom: 8px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .playground-content {
                grid-template-columns: 1fr;
                grid-template-rows: 1fr auto;
            }

            .component-controls {
                border-left: none;
                border-top: 1px solid var(--md-sys-color-outline-variant);
            }
        }

        @media (max-width: 768px) {
            .playground-container {
                grid-template-areas:
                    "header"
                    "content";
                grid-template-columns: 1fr;
            }

            .playground-sidebar {
                display: none;
            }
        }

        /* Custom styling for form elements */
        .control-item select,
        .control-item input[type="text"],
        .control-item input[type="number"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--md-sys-color-outline);
            border-radius: 4px;
            background: var(--md-sys-color-surface);
            color: var(--md-sys-color-on-surface);
            font-size: 14px;
        }

        .theme-selector-playground {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 16px;
        }

        .theme-chip {
            padding: 6px 12px;
            border: 1px solid var(--md-sys-color-outline);
            border-radius: 16px;
            background: var(--md-sys-color-surface);
            color: var(--md-sys-color-on-surface);
            text-decoration: none;
            font-size: 12px;
            transition: all 0.2s ease;
        }

        .theme-chip.active {
            background: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
            border-color: var(--md-sys-color-primary);
        }

        .copy-button {
            position: absolute;
            top: 8px;
            right: 8px;
            background: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="playground-container">

        <!-- Sidebar Navigation -->
        <nav class="playground-sidebar">

            <div class="nav-section">
                <h3>Basic Components</h3>
                <a href="?component=button&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? 'button') === 'button' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('smart_button'); ?> Button
                </a>
                <a href="?component=iconbutton&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'iconbutton' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('radio_button_unchecked'); ?> Icon Button
                </a>
                <a href="?component=textfield&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'textfield' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('text_fields'); ?> TextField
                </a>
                <a href="?component=search&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'search' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('search'); ?> Search Bar
                </a>
                <a href="?component=card&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'card' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('web_stories'); ?> Card
                </a>
            </div>

            <div class="nav-section">
                <h3>Navigation</h3>
                <a href="?component=navigation&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'navigation' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('bottom_navigation'); ?> Nav Bar
                </a>
                <a href="?component=navigationdrawer&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'navigationdrawer' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('menu_open'); ?> Nav Drawer
                </a>
                <a href="?component=navigationrail&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'navigationrail' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('dock_to_left'); ?> Nav Rail
                </a>
                <a href="?component=breadcrumb&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'breadcrumb' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('chevron_right'); ?> Breadcrumb
                </a>
                <a href="?component=toolbar&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'toolbar' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('view_headline'); ?> Toolbar
                </a>
                <a href="?component=menu&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'menu' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('more_vert'); ?> Menu
                </a>
                <a href="?component=tabs&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'tabs' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('tab'); ?> Tabs
                </a>
            </div>

            <div class="nav-section">
                <h3>Overlays</h3>
                <a href="?component=dialog&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'dialog' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('open_in_new'); ?> Dialog
                </a>
                <a href="?component=tooltip&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'tooltip' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('help'); ?> Tooltip
                </a>
                <a href="?component=bottomsheet&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'bottomsheet' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('vertical_align_bottom'); ?> Bottom Sheet
                </a>
                <a href="?component=snackbar&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'snackbar' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('notifications'); ?> Snackbar
                </a>
            </div>

            <div class="nav-section">
                <h3>Form Controls</h3>
                <a href="?component=select&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'select' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('arrow_drop_down'); ?> Select
                </a>
                <a href="?component=switch&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'switch' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('toggle_on'); ?> Switch
                </a>
                <a href="?component=checkbox&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'checkbox' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('check_box'); ?> Checkbox
                </a>
                <a href="?component=radio&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'radio' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('radio_button_checked'); ?> Radio
                </a>
                <a href="?component=slider&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'slider' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('tune'); ?> Slider
                </a>
                <a href="?component=progress&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'progress' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('progress_activity'); ?> Progress
                </a>
                <a href="?component=datetimepicker&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'datetimepicker' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('calendar_today'); ?> Date/Time Picker
                </a>
            </div>

            <div class="nav-section">
                <h3>Collections</h3>
                <a href="?component=list&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'list' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('list'); ?> List
                </a>
                <a href="?component=chip&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'chip' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('label'); ?> Chip
                </a>
                <a href="?component=badge&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'badge' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('circle'); ?> Badge
                </a>
                <a href="?component=header&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'header' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('title'); ?> Header
                </a>
            </div>

            <div class="nav-section">
                <h3>Info</h3>
                <div style="padding: 8px; font-size: 10px; color: var(--md-sys-color-on-surface-variant); line-height: 1.3;">
                    <div><strong>v<?php echo MD3::getVersion(); ?></strong></div>
                    <div id="component-count">0 Components</div>
                    <div><?php echo ucfirst($currentTheme); ?> Theme</div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="playground-content">
            <div class="component-preview">
                <div id="preview-area" class="preview-area">
                    <!-- Component will be rendered here -->
                </div>

                <div class="code-section">
                    <h4><?php echo MD3::icon('code'); ?> PHP Code</h4>
                    <pre id="php-code">
                        <button class="copy-button" onclick="copyCode('php', this)">Copy</button>
<code id="php-code-content">// PHP code will appear here</code>
                    </pre>
                </div>

                <div class="code-section">
                    <h4><?php echo MD3::icon('html'); ?> Generated HTML</h4>
                    <pre id="html-code">
                        <button class="copy-button" onclick="copyCode('html', this)">Copy</button>
<code id="html-code-content"><!-- HTML output will appear here --></code>
                    </pre>
                </div>
            </div>

            <div class="component-controls">
                <h3 style="margin-bottom: 20px; color: var(--md-sys-color-primary);">
                    <?php echo MD3::icon('tune'); ?> Component Controls
                </h3>

                <div id="component-controls">
                    <!-- Controls will be dynamically generated -->
                </div>

                <?php echo MD3::getVersionDisplay(); ?>
            </div>
        </main>
    </div>

    <script><?php echo MD3List::getJS(); ?></script>
    <script><?php echo MD3Tooltip::getJS(); ?></script>
    <script><?php echo MD3Snackbar::getJS(); ?></script>
    <script>
        // Theme system initialization
        document.addEventListener('DOMContentLoaded', function() {
            const html = document.documentElement;
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                html.setAttribute('data-theme', 'dark');
            }
        });
    </script>

    <script>
        // Component configurations
        const componentConfigs = {
            button: {
                name: 'Button',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Button Type',
                        options: {
                            'filled': 'Filled',
                            'outlined': 'Outlined',
                            'text': 'Text',
                            'elevated': 'Elevated',
                            'tonal': 'Tonal'
                        },
                        default: 'filled'
                    },
                    text: {
                        type: 'text',
                        label: 'Button Text',
                        default: 'Click me'
                    },
                    icon: {
                        type: 'text',
                        label: 'Icon (optional)',
                        default: '',
                        placeholder: 'e.g. favorite, add, delete'
                    },
                    disabled: {
                        type: 'checkbox',
                        label: 'Disabled',
                        default: false
                    }
                }
            },
            textfield: {
                name: 'TextField',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Field Type',
                        options: {
                            'filled': 'Filled',
                            'outlined': 'Outlined'
                        },
                        default: 'filled'
                    },
                    label: {
                        type: 'text',
                        label: 'Label Text',
                        default: 'Enter text'
                    },
                    placeholder: {
                        type: 'text',
                        label: 'Placeholder',
                        default: ''
                    },
                    leadingIcon: {
                        type: 'text',
                        label: 'Leading Icon',
                        default: '',
                        placeholder: 'e.g. person, search'
                    },
                    trailingIcon: {
                        type: 'text',
                        label: 'Trailing Icon',
                        default: '',
                        placeholder: 'e.g. visibility, clear'
                    }
                }
            },
            search: {
                name: 'Search Bar',
                controls: {
                    basic_group: {
                        type: 'group',
                        label: 'Basic Settings',
                        controls: {
                            placeholder: {
                                type: 'text',
                                label: 'Placeholder Text',
                                default: 'Search...'
                            },
                            value: {
                                type: 'text',
                                label: 'Initial Value',
                                default: ''
                            }
                        }
                    },
                    features_group: {
                        type: 'group',
                        label: 'Features',
                        controls: {
                            with_suggestions: {
                                type: 'checkbox',
                                label: 'With Suggestions',
                                default: false
                            },
                            with_filters: {
                                type: 'checkbox',
                                label: 'With Filter Chips',
                                default: false
                            },
                            disabled: {
                                type: 'checkbox',
                                label: 'Disabled',
                                default: false
                            }
                        }
                    },
                    content_group: {
                        type: 'group',
                        label: 'Content Configuration',
                        controls: {
                            suggestions: {
                                type: 'textarea',
                                label: 'Suggestions (one per line)',
                                default: 'Material Design\nSearch Bar\nComponents\nThemes'
                            },
                            filters: {
                                type: 'textarea',
                                label: 'Filter Options (label:value per line)',
                                default: 'Documents:docs\nImages:images\nVideos:videos'
                            }
                        }
                    }
                }
            },
            card: {
                name: 'Card',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Card Type',
                        options: {
                            'elevated': 'Elevated',
                            'filled': 'Filled',
                            'outlined': 'Outlined'
                        },
                        default: 'elevated'
                    },
                    title: {
                        type: 'text',
                        label: 'Title',
                        default: 'Card Title'
                    },
                    content: {
                        type: 'textarea',
                        label: 'Content',
                        default: 'This is the card content area where you can add descriptive text.'
                    },
                    icon: {
                        type: 'text',
                        label: 'Icon (optional)',
                        default: '',
                        placeholder: 'e.g. info, warning'
                    }
                }
            },
            switch: {
                name: 'Switch',
                controls: {
                    settings_group: {
                        type: 'group',
                        label: 'Settings',
                        controls: {
                            label: {
                                type: 'text',
                                label: 'Label Text',
                                default: 'Enable notifications',
                                width: '70%'
                            },
                            checked: {
                                type: 'checkbox',
                                label: 'Initially Checked',
                                default: false,
                                width: '30%'
                            }
                        }
                    }
                }
            },
            checkbox: {
                name: 'Checkbox',
                controls: {
                    label: {
                        type: 'text',
                        label: 'Label Text',
                        default: 'I agree to the terms'
                    },
                    checked: {
                        type: 'checkbox',
                        label: 'Initially Checked',
                        default: false
                    }
                }
            },
            radio: {
                name: 'Radio',
                controls: {
                    options_group: {
                        type: 'group',
                        label: 'Configuration',
                        controls: {
                            options: {
                                type: 'textarea',
                                label: 'Options (one per line)',
                                default: 'Option A\nOption B\nOption C',
                                width: '70%'
                            },
                            selected: {
                                type: 'number',
                                label: 'Selected Option (0-based)',
                                default: 0,
                                width: '30%'
                            }
                        }
                    }
                }
            },
            list: {
                name: 'Lists',
                controls: {
                    type: {
                        type: 'select',
                        label: 'List Type',
                        options: {
                            'simple': 'Simple List',
                            'twoLine': 'Two Line',
                            'withAvatars': 'With Avatars'
                        },
                        default: 'simple'
                    },
                    items: {
                        type: 'textarea',
                        label: 'Items (one per line)',
                        default: 'Inbox\nStarred\nSent mail\nDrafts'
                    }
                }
            },
            chip: {
                name: 'Chip',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Chip Type',
                        options: {
                            'assist': 'Assist Chip',
                            'filter': 'Filter Chip',
                            'input': 'Input Chip'
                        },
                        default: 'assist'
                    },
                    labels: {
                        type: 'textarea',
                        label: 'Chip Labels (one per line)',
                        default: 'Design\nDevelopment\nTesting'
                    }
                }
            },
            navigation: {
                name: 'Navigation Bar',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Navigation Type',
                        options: {
                            'fixed': 'Fixed Bottom',
                            'floating': 'Floating',
                            'icons-only': 'Icons Only'
                        },
                        default: 'fixed'
                    },
                    items: {
                        type: 'textarea',
                        label: 'Items (format: icon|label|href)',
                        default: 'home|Home|/\nsearch|Search|/search\nfavorite|Favorites|/favorites\nnotifications|Alerts|/alerts'
                    },
                    activeIndex: {
                        type: 'number',
                        label: 'Active Item (0-based)',
                        default: 0
                    }
                }
            },
            navigationdrawer: {
                name: 'Navigation Drawer',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Drawer Type',
                        options: {
                            'modal': 'Modal (with overlay)',
                            'standard': 'Standard (always visible)'
                        },
                        default: 'modal'
                    },
                    title: {
                        type: 'text',
                        label: 'Title',
                        default: 'Navigation'
                    },
                    subtitle: {
                        type: 'text',
                        label: 'Subtitle',
                        default: 'Main navigation menu'
                    },
                    items: {
                        type: 'textarea',
                        label: 'Items (format: icon|text|href)',
                        default: 'home|Home|/\ninbox|Inbox|/inbox\nfavorites|Favorites|/favorites\n---\nsettings|Settings|/settings'
                    },
                    open: {
                        type: 'checkbox',
                        label: 'Initially Open',
                        default: true
                    }
                }
            },
            navigationrail: {
                name: 'Navigation Rail',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Rail Type',
                        options: {
                            'standard': 'Standard',
                            'with-header': 'With Header/FAB',
                            'compact': 'Compact (icons only)'
                        },
                        default: 'standard'
                    },
                    items: {
                        type: 'textarea',
                        label: 'Items (format: icon|label|href)',
                        default: 'home|Home|/\ninbox|Inbox|/inbox\nfavorites|Favorites|/favorites\nsettings|Settings|/settings'
                    },
                    fab_icon: {
                        type: 'text',
                        label: 'FAB Icon (for with-header)',
                        default: 'add'
                    }
                }
            },
            menu: {
                name: 'Menu',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Menu Type',
                        options: {
                            'dropdown': 'Dropdown Menu',
                            'context': 'Context Menu'
                        },
                        default: 'dropdown'
                    },
                    trigger: {
                        type: 'text',
                        label: 'Trigger Text',
                        default: 'More Options'
                    },
                    items: {
                        type: 'textarea',
                        label: 'Menu Items (format: text|icon|action)',
                        default: 'Settings|settings|settings\nProfile|person|profile\n---\nLogout|logout|logout'
                    },
                    position: {
                        type: 'select',
                        label: 'Position',
                        options: {
                            'bottom-start': 'Bottom Start',
                            'bottom-end': 'Bottom End',
                            'top-start': 'Top Start',
                            'top-end': 'Top End'
                        },
                        default: 'bottom-start'
                    }
                }
            },
            iconbutton: {
                name: 'Icon Button',
                controls: {
                    basic_group: {
                        type: 'group',
                        label: 'Basic Settings',
                        controls: {
                            type: {
                                type: 'select',
                                label: 'Type',
                                options: {
                                    'standard': 'Standard',
                                    'filled': 'Filled',
                                    'outlined': 'Outlined',
                                    'tonal': 'Tonal'
                                },
                                default: 'standard',
                                width: '50%'
                            },
                            icon: {
                                type: 'text',
                                label: 'Icon',
                                default: 'star',
                                width: '50%'
                            }
                        }
                    },
                    toggle_group: {
                        type: 'group',
                        label: 'Toggle Settings',
                        controls: {
                            toggle: {
                                type: 'checkbox',
                                label: 'Toggle Button',
                                default: false,
                                width: '33%'
                            },
                            selected: {
                                type: 'checkbox',
                                label: 'Selected',
                                default: false,
                                width: '33%'
                            },
                            disabled: {
                                type: 'checkbox',
                                label: 'Disabled',
                                default: false,
                                width: '33%'
                            }
                        }
                    },
                    advanced_group: {
                        type: 'group',
                        label: 'Advanced',
                        controls: {
                            selected_icon: {
                                type: 'text',
                                label: 'Selected Icon',
                                default: 'star',
                                width: '50%'
                            },
                            aria_label: {
                                type: 'text',
                                label: 'ARIA Label',
                                default: 'Icon Button',
                                width: '50%'
                            }
                        }
                    }
                }
            },
            fab: {
                name: 'FAB',
                controls: {
                    type: {
                        type: 'select',
                        label: 'FAB Type',
                        options: {
                            'standard': 'Standard',
                            'small': 'Small',
                            'large': 'Large',
                            'extended': 'Extended'
                        },
                        default: 'standard'
                    },
                    icon: {
                        type: 'text',
                        label: 'Icon',
                        default: 'add'
                    },
                    text: {
                        type: 'text',
                        label: 'Text (Extended only)',
                        default: 'Create'
                    },
                    disabled: {
                        type: 'checkbox',
                        label: 'Disabled',
                        default: false
                    }
                }
            },
            dialog: {
                name: 'Dialog',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Dialog Type',
                        options: {
                            'basic': 'Basic Dialog',
                            'alert': 'Alert Dialog',
                            'confirm': 'Confirmation',
                            'fullscreen': 'Fullscreen',
                            'form': 'Form Dialog'
                        },
                        default: 'basic'
                    },
                    title: {
                        type: 'text',
                        label: 'Title',
                        default: 'Dialog Title'
                    },
                    content: {
                        type: 'textarea',
                        label: 'Content',
                        default: 'This is the dialog content. You can add any text or HTML here.'
                    },
                    confirmText: {
                        type: 'text',
                        label: 'Confirm Button',
                        default: 'OK'
                    },
                    cancelText: {
                        type: 'text',
                        label: 'Cancel Button (if applicable)',
                        default: 'Cancel'
                    }
                }
            },
            select: {
                name: 'Select',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Select Type',
                        options: {
                            'filled': 'Filled',
                            'outlined': 'Outlined',
                            'large': 'Large',
                            'dense': 'Dense'
                        },
                        default: 'filled'
                    },
                    label: {
                        type: 'text',
                        label: 'Label',
                        default: 'Choose option'
                    },
                    options: {
                        type: 'textarea',
                        label: 'Options (one per line)',
                        default: 'Option 1\\nOption 2\\nOption 3\\nOption 4'
                    },
                    disabled: {
                        type: 'checkbox',
                        label: 'Disabled',
                        default: false
                    }
                }
            },
            toolbar: {
                name: 'Toolbar',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Toolbar Type',
                        options: {
                            'top': 'Top App Bar',
                            'bottom': 'Bottom App Bar',
                            'navigation': 'Navigation'
                        },
                        default: 'top'
                    },
                    title: {
                        type: 'text',
                        label: 'Title',
                        default: 'Toolbar Title'
                    },
                    leading_icon: {
                        type: 'text',
                        label: 'Leading Icon',
                        default: 'menu'
                    },
                    actions: {
                        type: 'textarea',
                        label: 'Actions (icon:label per line)',
                        default: 'search:Search\\nmore_vert:More'
                    }
                }
            },
            tooltip: {
                name: 'Tooltip',
                controls: {
                    text: {
                        type: 'text',
                        label: 'Tooltip Text',
                        default: 'This is a tooltip'
                    },
                    trigger: {
                        type: 'text',
                        label: 'Trigger Text',
                        default: 'Hover me'
                    },
                    position: {
                        type: 'select',
                        label: 'Position',
                        options: {
                            'top': 'Top',
                            'bottom': 'Bottom',
                            'left': 'Left',
                            'right': 'Right'
                        },
                        default: 'top'
                    }
                }
            },
            breadcrumb: {
                name: 'Breadcrumb',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Breadcrumb Type',
                        options: {
                            'simple': 'Simple',
                            'icons': 'With Icons',
                            'separator': 'Custom Separator'
                        },
                        default: 'simple'
                    },
                    items: {
                        type: 'textarea',
                        label: 'Items (one per line)',
                        default: 'Home\\nProducts\\nCurrent Page'
                    }
                }
            },
            progress: {
                name: 'Progress',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Progress Type',
                        options: {
                            'linear': 'Linear',
                            'circular': 'Circular'
                        },
                        default: 'linear'
                    },
                    value: {
                        type: 'text',
                        label: 'Progress Value (0-100)',
                        default: '65'
                    },
                    indeterminate: {
                        type: 'checkbox',
                        label: 'Indeterminate',
                        default: false
                    }
                }
            },
            slider: {
                name: 'Slider',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Slider Type',
                        options: {
                            'continuous': 'Continuous',
                            'discrete': 'Discrete'
                        },
                        default: 'continuous'
                    },
                    min: {
                        type: 'text',
                        label: 'Min Value',
                        default: '0'
                    },
                    max: {
                        type: 'text',
                        label: 'Max Value',
                        default: '100'
                    },
                    value: {
                        type: 'text',
                        label: 'Current Value',
                        default: '50'
                    }
                }
            },
            tabs: {
                name: 'Tabs',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Tab Type',
                        options: {
                            'primary': 'Primary',
                            'secondary': 'Secondary'
                        },
                        default: 'primary'
                    },
                    tabs: {
                        type: 'textarea',
                        label: 'Tab Items (one per line)',
                        default: 'Home\\nProducts\\nServices\\nContact'
                    },
                    activeIndex: {
                        type: 'text',
                        label: 'Active Tab (0-based)',
                        default: '0'
                    }
                }
            },
            badge: {
                name: 'Badge',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Badge Type',
                        options: {
                            'small': 'Small',
                            'large': 'Large'
                        },
                        default: 'small'
                    },
                    content: {
                        type: 'text',
                        label: 'Badge Content',
                        default: '5'
                    },
                    color: {
                        type: 'select',
                        label: 'Badge Color',
                        options: {
                            'error': 'Error',
                            'primary': 'Primary',
                            'secondary': 'Secondary'
                        },
                        default: 'error'
                    }
                }
            },
            bottomsheet: {
                name: 'Bottom Sheet',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Sheet Type',
                        options: {
                            'modal': 'Modal',
                            'standard': 'Standard'
                        },
                        default: 'modal'
                    },
                    title: {
                        type: 'text',
                        label: 'Sheet Title',
                        default: 'Bottom Sheet Title'
                    },
                    content: {
                        type: 'textarea',
                        label: 'Sheet Content',
                        default: 'This is the content of the bottom sheet. You can put any content here.'
                    }
                }
            },
            datetimepicker: {
                name: 'Date/Time Picker',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Picker Type',
                        options: {
                            'date': 'Date Picker',
                            'time': 'Time Picker',
                            'datetime': 'Date & Time'
                        },
                        default: 'date'
                    },
                    label: {
                        type: 'text',
                        label: 'Field Label',
                        default: 'Select Date'
                    },
                    value: {
                        type: 'text',
                        label: 'Default Value',
                        default: ''
                    }
                }
            },
            header: {
                name: 'Header',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Header Type',
                        options: {
                            'large': 'Large',
                            'medium': 'Medium',
                            'small': 'Small'
                        },
                        default: 'large'
                    },
                    title: {
                        type: 'text',
                        label: 'Header Title',
                        default: 'Page Title'
                    },
                    subtitle: {
                        type: 'text',
                        label: 'Subtitle (optional)',
                        default: 'Optional subtitle text'
                    }
                }
            },
            snackbar: {
                name: 'Snackbar',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Snackbar Type',
                        options: {
                            'info': 'Info',
                            'success': 'Success',
                            'warning': 'Warning',
                            'error': 'Error'
                        },
                        default: 'info'
                    },
                    message: {
                        type: 'text',
                        label: 'Message Text',
                        default: 'This is a snackbar message'
                    },
                    action: {
                        type: 'text',
                        label: 'Action Text (optional)',
                        default: 'UNDO'
                    }
                }
            }
        };

        // Current state
        let currentComponent = '<?php echo $_GET['component'] ?? 'button'; ?>';
        let currentValues = {};

        // Initialize playground
        document.addEventListener('DOMContentLoaded', function() {
            // Update component count dynamically
            const componentCount = Object.keys(componentConfigs).length;
            document.getElementById('component-count').textContent = componentCount + ' Components';

            loadComponent(currentComponent);
        });

        function loadComponent(componentName) {
            currentComponent = componentName;
            const config = componentConfigs[componentName];

            if (!config) {
                console.error('Component not found:', componentName);
                return;
            }

            // Generate controls
            generateControls(config.controls);

            // Initial render
            updatePreview();
        }

        function generateControls(controls) {
            const container = document.getElementById('component-controls');
            container.innerHTML = '';

            Object.keys(controls).forEach(key => {
                const control = controls[key];

                if (control.type === 'group') {
                    // Create group container
                    const groupContainer = document.createElement('div');
                    groupContainer.className = 'control-group-container';

                    const groupLabel = document.createElement('h4');
                    groupLabel.textContent = control.label;
                    groupLabel.className = 'control-group-label';
                    groupContainer.appendChild(groupLabel);

                    const groupContent = document.createElement('div');
                    groupContent.className = 'control-group-content';

                    // Process controls within group
                    Object.keys(control.controls).forEach(groupKey => {
                        const groupControl = control.controls[groupKey];
                        currentValues[groupKey] = groupControl.default;

                        const controlGroup = document.createElement('div');
                        controlGroup.className = 'control-group';
                        if (groupControl.width) {
                            controlGroup.style.width = groupControl.width;
                            controlGroup.style.display = 'inline-block';
                            controlGroup.style.marginRight = '8px';
                        }

                        const label = document.createElement('label');
                        label.textContent = groupControl.label;
                        controlGroup.appendChild(label);

                        let input = createInput(groupControl, groupKey);
                        controlGroup.appendChild(input);
                        groupContent.appendChild(controlGroup);
                    });

                    groupContainer.appendChild(groupContent);
                    container.appendChild(groupContainer);
                } else {
                    currentValues[key] = control.default;
                    const controlGroup = document.createElement('div');
                    controlGroup.className = 'control-group';

                    const label = document.createElement('label');
                    label.textContent = control.label;
                    controlGroup.appendChild(label);

                    let input = createInput(control, key);
                    controlGroup.appendChild(input);
                    container.appendChild(controlGroup);
                }
            });
        }

        function createInput(control, key) {
            let input;

            switch (control.type) {
                case 'select':
                    input = document.createElement('select');
                    Object.keys(control.options).forEach(optionKey => {
                        const option = document.createElement('option');
                        option.value = optionKey;
                        option.textContent = control.options[optionKey];
                        if (optionKey === control.default) option.selected = true;
                        input.appendChild(option);
                    });
                    break;

                case 'textarea':
                    input = document.createElement('textarea');
                    input.value = control.default;
                    input.rows = 4;
                    break;

                case 'checkbox':
                    input = document.createElement('input');
                    input.type = 'checkbox';
                    input.checked = control.default;
                    break;

                case 'number':
                    input = document.createElement('input');
                    input.type = 'number';
                    input.value = control.default;
                    input.min = 0;
                    break;

                default:
                    input = document.createElement('input');
                    input.type = 'text';
                    input.value = control.default;
                    if (control.placeholder) {
                        input.placeholder = control.placeholder;
                    }
            }

            input.addEventListener('change', function() {
                currentValues[key] = input.type === 'checkbox' ? input.checked : input.value;
                updatePreview();
            });

            return input;
        }

        function updatePreview() {
            // Generate component based on current values
            const data = {
                component: currentComponent,
                values: currentValues
            };

            // Make AJAX request to generate component
            fetch('playground-api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('preview-area').innerHTML = data.html;
                document.getElementById('php-code-content').textContent = data.php;
                document.getElementById('html-code-content').textContent = data.html;

                // Re-initialize interactive components after loading
                if (window.initializeMenus) window.initializeMenus();

                // Re-initialize tooltips
                document.querySelectorAll(".md3-tooltip").forEach(function(tooltip) {
                    if (typeof window.initTooltip === 'function') {
                        window.initTooltip(tooltip);
                    }
                });

                // Re-initialize tooltip triggers by data attribute
                document.querySelectorAll("[data-tooltip]").forEach(function(element) {
                    if (typeof window.initTooltip === 'function') {
                        window.initTooltip(element);
                    }
                });

                // Alternative tooltip initialization by class
                document.querySelectorAll(".md3-tooltip-trigger").forEach(function(element) {
                    if (typeof window.initTooltip === 'function') {
                        window.initTooltip(element);
                    }
                });

                // Execute any inline scripts for snackbars
                const scripts = document.getElementById('preview-area').querySelectorAll('script');
                scripts.forEach(script => {
                    try {
                        eval(script.textContent);
                    } catch (e) {
                        console.warn('Script execution error:', e);
                    }
                });
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('preview-area').innerHTML = '<div style="color: var(--md-sys-color-error);">Error generating component</div>';
            });
        }

        function copyCode(type, button) {
            const codeElement = document.getElementById(type + '-code-content');
            const text = codeElement.textContent;

            navigator.clipboard.writeText(text).then(function() {
                // Show success feedback
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.style.background = 'var(--md-sys-color-primary)';

                setTimeout(() => {
                    button.textContent = originalText;
                    button.style.background = 'var(--md-sys-color-primary)';
                }, 2000);
            });
        }

        // Load component from URL
        const urlParams = new URLSearchParams(window.location.search);
        const componentParam = urlParams.get('component');
        if (componentParam && componentConfigs[componentParam]) {
            currentComponent = componentParam;
        }

        // Light/Dark Mode Toggle
        function toggleMode() {
            const button = document.getElementById('mode-toggle');
            const currentMode = document.documentElement.getAttribute('data-theme') || 'light';
            const newMode = currentMode === 'light' ? 'dark' : 'light';

            console.log('Toggling from', currentMode, 'to', newMode);

            // Update data attribute for CSS
            document.documentElement.setAttribute('data-theme', newMode);

            // Save preference
            localStorage.setItem('md3-color-scheme', newMode);

            // Update button icon - show opposite of current mode
            const icon = newMode === 'dark' ? 'light_mode' : 'dark_mode';
            button.innerHTML = '<span class="material-symbols-outlined">' + icon + '</span>';

            // Add a class to body to ensure CSS recalculation
            document.body.classList.toggle('theme-switching');

            console.log('Applied theme:', document.documentElement.getAttribute('data-theme'));

            // Debug: Test if CSS variables are changing
            setTimeout(() => {
                const computedStyle = getComputedStyle(document.documentElement);
                const bgColor = computedStyle.getPropertyValue('--md-sys-color-background').trim();
                const primaryColor = computedStyle.getPropertyValue('--md-sys-color-primary').trim();
                console.log('Background color:', bgColor);
                console.log('Primary color:', primaryColor);
            }, 100);
        }

        // Initialize mode from localStorage or system preference
        function initializeColorScheme() {
            const savedMode = localStorage.getItem('md3-color-scheme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initialMode = savedMode || (systemPrefersDark ? 'dark' : 'light');

            console.log('Initializing color scheme:', initialMode);

            document.documentElement.setAttribute('data-theme', initialMode);

            const modeButton = document.getElementById('mode-toggle');
            if (modeButton) {
                // Show opposite icon of current mode
                const icon = initialMode === 'dark' ? 'light_mode' : 'dark_mode';
                modeButton.innerHTML = '<span class="material-symbols-outlined">' + icon + '</span>';
                console.log('Set initial icon to:', icon);
            }

            console.log('HTML data-theme attribute:', document.documentElement.getAttribute('data-theme'));
        }

        // Initialize on page load
        initializeColorScheme();

        <?php echo MD3IconButton::getJS(); ?>
        <?php echo MD3NavigationDrawer::getJS(); ?>
        <?php echo MD3NavigationRail::getJS(); ?>

        // Theme selector functionality
        function toggleThemeSelector() {
            const dropdown = document.getElementById('theme-dropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const selector = document.querySelector('.theme-selector-compact');
            const dropdown = document.getElementById('theme-dropdown');

            if (!selector.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>

    <!-- Snackbar Container -->
    <?php echo MD3Snackbar::container(); ?>

    <?php include 'includes/footer.php'; ?>

</body>
</html>