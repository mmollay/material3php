<!DOCTYPE html>
<html lang="de" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Design 3 PHP Library</title>
    <?php
    require_once 'src/MD3.php';
    require_once 'src/MD3Button.php';
    require_once 'src/MD3TextField.php';
    require_once 'src/MD3Card.php';
    require_once 'src/MD3Theme.php';
    require_once 'src/MD3Header.php';
    require_once 'src/MD3NavigationBar.php';
    require_once 'src/MD3Breadcrumb.php';

    // Get theme from URL parameter or default
    $currentTheme = $_GET['theme'] ?? 'default';

    echo MD3::init(true, true, $currentTheme);
    ?>
    <style>
    <?php
    echo MD3Theme::getThemeCSS();
    echo MD3Header::getCSS();
    echo MD3NavigationBar::getCSS();
    echo MD3::getVersionCSS();
    ?>
        body {
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-section {
            padding: 32px 0;
            text-align: center;
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
        }

        .subtitle {
            margin: 0 0 16px 0;
            font-size: 1.1rem;
            color: var(--md-sys-color-on-surface-variant);
        }

        .version-badge {
            display: inline-block;
            padding: 6px 16px;
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            border-radius: 16px;
            font-size: 12px;
            font-weight: 500;
            box-shadow: var(--md-sys-elevation-1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin: 32px 0;
        }

        .stat-card {
            padding: 16px;
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            border-radius: 12px;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 500;
            margin: 0;
        }

        .stat-label {
            font-size: 12px;
            margin: 4px 0 0 0;
            opacity: 0.8;
        }

        .quick-nav {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
            margin: 24px 0;
        }

        .nav-card {
            padding: 20px;
            background: var(--md-sys-color-surface-container-low);
            border-radius: 12px;
            text-align: center;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            border: 1px solid var(--md-sys-color-outline-variant);
        }

        .nav-card:hover {
            background: var(--md-sys-color-surface-container);
            transform: translateY(-2px);
            box-shadow: var(--md-sys-elevation-2);
        }

        .nav-card .icon {
            font-size: 32px;
            margin-bottom: 8px;
            display: block;
        }

        .nav-card h3 {
            margin: 0 0 8px 0;
            font-size: 1.1rem;
            color: var(--md-sys-color-primary);
        }

        .nav-card p {
            margin: 0;
            font-size: 13px;
            color: var(--md-sys-color-on-surface-variant);
            line-height: 1.4;
        }

        .demo-section {
            margin: 32px 0;
            padding: 24px;
            background: var(--md-sys-color-surface-container-lowest);
            border-radius: 16px;
        }

        .demo-section h2 {
            margin: 0 0 16px 0;
            font-size: 1.3rem;
            color: var(--md-sys-color-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .component-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .component-demo {
            padding: 16px;
            background: var(--md-sys-color-surface);
            border-radius: 12px;
            border: 1px solid var(--md-sys-color-outline-variant);
        }

        .component-demo h3 {
            margin: 0 0 12px 0;
            font-size: 14px;
            font-weight: 500;
            color: var(--md-sys-color-on-surface);
        }

        .demo-items {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .footer {
            text-align: center;
            padding: 24px 0;
            color: var(--md-sys-color-on-surface-variant);
            border-top: 1px solid var(--md-sys-color-outline-variant);
            margin-top: 32px;
            font-size: 13px;
        }

        .footer a {
            color: var(--md-sys-color-primary);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="content-wrapper">
        <div class="hero-section">
            <p class="subtitle">Pure PHP Implementation • <?php echo MD3::getComponentCount(); ?> Components • MD3 Compliant</p>
            <span class="version-badge">v<?php echo file_get_contents('VERSION'); ?></span>
        </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo MD3::getComponentCount(); ?></div>
            <div class="stat-label">Komponenten</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">52%</div>
            <div class="stat-label">MD3 Vollständig</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">6</div>
            <div class="stat-label">Kategorien</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">5</div>
            <div class="stat-label">Themes</div>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="quick-nav">
        <a href="playground.php<?php echo $currentTheme !== 'default' ? '?theme=' . $currentTheme : ''; ?>" class="nav-card">
            <span class="material-symbols-outlined icon">science</span>
            <h3>Interactive Playground</h3>
            <p>Live component editor mit allen Konfigurationsoptionen</p>
        </a>
        <a href="demo-extended.php<?php echo $currentTheme !== 'default' ? '?theme=' . $currentTheme : ''; ?>" class="nav-card">
            <span class="material-symbols-outlined icon">dashboard</span>
            <h3>Component Gallery</h3>
            <p>Alle implementierten Komponenten in einer Übersicht</p>
        </a>
    </div>

    <!-- Component Showcase -->
    <div class="demo-section">
        <h2><span class="material-symbols-outlined">widgets</span> Component Examples</h2>

        <div class="component-grid">
            <div class="component-demo">
                <h3>Buttons</h3>
                <div class="demo-items">
                    <?php
                    echo MD3Button::filled('Filled');
                    echo MD3Button::outlined('Outlined');
                    echo MD3Button::tonal('Tonal');
                    ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Text Fields</h3>
                <div class="demo-items">
                    <?php echo MD3TextField::filled('demo', 'Demo Field', ['style' => 'max-width: 200px']); ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Cards</h3>
                <div class="demo-items">
                    <?php echo MD3Card::elevated('Card content example with Material Design 3 styling.'); ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Navigation Components</h3>
                <div class="demo-items" style="font-size: 13px; color: var(--md-sys-color-on-surface-variant);">
                    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 8px;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">bottom_navigation</span> Navigation Bar
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 8px;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">menu_open</span> Navigation Drawer
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">dock_to_left</span> Navigation Rail
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Material Design 3 PHP Library •
        <a href="https://m3.material.io" target="_blank">Material Design 3</a> •
        <a href="playground.php" target="_blank">Interactive Playground</a> •
        Made with ❤️ for pure PHP implementations
        </p>
    </div>
    </div>

    <?php
    echo MD3Header::getScript();
    echo MD3Theme::getThemeScript();
    ?>

</body>
</html>