<!DOCTYPE html>
<html lang="de" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material3PHP - Clean Usage Example</title>

    <?php
    // NEW WAY: Just one include - everything is auto-loaded!
    require_once 'autoload.php';

    // Get theme from URL parameter or default
    $currentTheme = $_GET['theme'] ?? 'default';

    // Initialize MD3 with autoloader
    echo MD3Autoloader::init(true, true, $currentTheme);
    ?>
    <style>
    <?php
    // All classes are auto-loaded - no manual requires needed!
    echo MD3Theme::getThemeCSS();
    echo MD3Header::getCSS();
    echo MD3NavigationBar::getCSS();
    echo MD3Card::getCSS();
    echo MD3TextField::getCSS();
    echo MD3::getVersionCSS();
    ?>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background: var(--md-sys-color-background);
            color: var(--md-sys-color-on-background);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .demo-section {
            margin-bottom: 32px;
        }

        .component-grid {
            display: grid;
            gap: 16px;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo MD3::icon('auto_awesome'); ?> Clean Material3PHP Usage</h1>

        <p>Diese Seite demonstriert die <strong>neue, saubere</strong> Art Material3PHP zu verwenden:</p>

        <div class="demo-section">
            <?php echo MD3Card::elevated('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0;">
                    ✨ Vorher vs. Nachher
                </h2>
                <h3>❌ Alt (manuell):</h3>
                <pre style="background: var(--md-sys-color-surface-container); padding: 12px; border-radius: 8px; font-size: 12px; overflow-x: auto;">
require_once \'src/MD3.php\';
require_once \'src/MD3Button.php\';
require_once \'src/MD3TextField.php\';
require_once \'src/MD3Card.php\';
require_once \'src/MD3Theme.php\';
// ... 20+ weitere Zeilen ...</pre>

                <h3>✅ Neu (autoload):</h3>
                <pre style="background: var(--md-sys-color-primary-container); color: var(--md-sys-color-on-primary-container); padding: 12px; border-radius: 8px; font-size: 12px;">
require_once \'autoload.php\';
// Das wars! Alle Klassen werden automatisch geladen.</pre>
            '); ?>
        </div>

        <div class="demo-section">
            <?php echo MD3Card::outlined('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0;">
                    🚀 Komponenten funktionieren sofort
                </h2>
                <div class="component-grid">
                    <div>
                        <h4>Buttons:</h4>
                        ' . MD3Button::filled('Filled Button') . '
                        ' . MD3Button::outlined('Outlined Button') . '
                        ' . MD3Button::text('Text Button') . '
                    </div>
                    <div>
                        <h4>Text Field:</h4>
                        ' . MD3TextField::filled('demo', 'Auto-loaded TextField') . '
                    </div>
                    <div>
                        <h4>Navigation:</h4>
                        <p style="font-size: 14px; color: var(--md-sys-color-on-surface-variant);">
                            Header, NavigationBar, Breadcrumb - alles verfügbar ohne manuelle Includes!
                        </p>
                    </div>
                </div>
            '); ?>
        </div>

        <div class="demo-section">
            <?php echo MD3Card::surface('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0;">
                    📊 System Information
                </h2>
                <ul style="margin: 0; padding-left: 20px; color: var(--md-sys-color-on-surface-variant);">
                    <li><strong>Available Components:</strong> ' . MD3Autoloader::getComponentCount() . '</li>
                    <li><strong>Current Theme:</strong> ' . ucfirst($currentTheme) . '</li>
                    <li><strong>Auto-loader:</strong> ✅ Active</li>
                    <li><strong>Composer Ready:</strong> ✅ Yes</li>
                </ul>

                <h3>Available Classes:</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px; margin-top: 12px; font-size: 12px;">
                    ' . implode('', array_map(function($class) {
                        return '<span style="background: var(--md-sys-color-surface-container); padding: 4px 8px; border-radius: 4px;">' . $class . '</span>';
                    }, MD3Autoloader::getAvailableClasses())) . '
                </div>
            '); ?>
        </div>

        <div style="text-align: center; margin-top: 32px;">
            <a href="index.php<?php echo $currentTheme !== 'default' ? '?theme=' . $currentTheme : ''; ?>" style="text-decoration: none;">
                <?php echo MD3Button::outlined('← Zurück zur Hauptseite'); ?>
            </a>
        </div>
    </div>

    <?php
    echo MD3Header::getScript();
    echo MD3Theme::getThemeScript();
    ?>
</body>
</html>