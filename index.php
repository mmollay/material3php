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

    // Get theme from URL parameter or default
    $currentTheme = $_GET['theme'] ?? 'default';

    echo MD3::init(true, true, $currentTheme);
    echo MD3Theme::getThemeCSS();
    echo MD3::getVersionCSS();
    ?>
    <style>
        body {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            font-size: 14px;
        }

        .header {
            padding: 32px 0;
            text-align: center;
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
            position: relative;
        }

        .header h1 {
            margin: 0 0 8px 0;
            font-size: 2.5rem;
            font-weight: 400;
            color: var(--md-sys-color-primary);
        }

        .header .subtitle {
            margin: 0;
            font-size: 1.1rem;
            color: var(--md-sys-color-on-surface-variant);
        }

        .version-badge {
            display: inline-block;
            margin-top: 12px;
            padding: 4px 12px;
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .mode-toggle {
            position: absolute;
            top: 20px;
            right: 0;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--md-sys-color-on-surface-variant);
            padding: 8px;
            border-radius: 20px;
            transition: all 0.2s;
        }

        .mode-toggle:hover {
            background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 12%, transparent);
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

    <script>
        // Define functions immediately to avoid reference errors
        function toggleMode() {
            const currentMode = document.documentElement.getAttribute('data-theme') || 'light';
            const newMode = currentMode === 'light' ? 'dark' : 'light';

            console.log('Toggling from', currentMode, 'to', newMode);

            // Update data attribute for CSS
            document.documentElement.setAttribute('data-theme', newMode);

            // Save preference
            localStorage.setItem('md3-color-scheme', newMode);

            // Update button icon - show opposite of current mode
            const button = document.getElementById('mode-toggle');
            if (button) {
                const icon = newMode === 'dark' ? 'light_mode' : 'dark_mode';
                button.querySelector('.material-symbols-outlined').textContent = icon;
            }

            console.log('Applied theme:', document.documentElement.getAttribute('data-theme'));
        }

        function changeTheme(themeName) {
            const currentUrl = new URL(window.location);

            // Update URL parameter
            if (themeName === 'default') {
                currentUrl.searchParams.delete('theme');
            } else {
                currentUrl.searchParams.set('theme', themeName);
            }

            // Navigate to new URL
            window.location.href = currentUrl.toString();
        }

        // Make functions globally available
        window.toggleMode = toggleMode;
        window.changeTheme = changeTheme;
    </script>
</head>
<body>
    <header class="header">
        <button class="mode-toggle" onclick="toggleMode()" id="mode-toggle">
            <span class="material-symbols-outlined">dark_mode</span>
        </button>
        <h1>Material Design 3 PHP Library</h1>
        <p class="subtitle">Pure PHP Implementation • 17 Components • MD3 Compliant</p>
        <span class="version-badge">v<?php echo file_get_contents('VERSION'); ?></span>
    </header>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">17</div>
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
        <a href="demo-functional.php<?php echo $currentTheme !== 'default' ? '?theme=' . $currentTheme : ''; ?>" class="nav-card">
            <span class="material-symbols-outlined icon">integration_instructions</span>
            <h3>Form Integration</h3>
            <p>Funktionale Demos mit echten Form-Elementen</p>
        </a>
    </div>

    <!-- Theme Selection -->
    <div class="demo-section">
        <h2><span class="material-symbols-outlined">palette</span> Theme Selection</h2>
        <?php echo MD3Theme::toggleChips($currentTheme); ?>
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
                    <?php echo MD3TextField::filled('demo', 'Demo Field', '', ['style' => 'max-width: 200px']); ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Cards</h3>
                <div class="demo-items">
                    <?php echo MD3Card::simple('Card Title', 'Card content example with Material Design 3 styling.'); ?>
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

    <script>
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
                modeButton.querySelector('.material-symbols-outlined').textContent = icon;
                console.log('Set initial icon to:', icon);
            }

            console.log('HTML data-theme attribute:', document.documentElement.getAttribute('data-theme'));
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeColorScheme();
        });
    </script>
</body>
</html>