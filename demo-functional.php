<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Design 3 PHP Library - Funktionale Demo</title>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once 'src/MD3.php';
    require_once 'src/MD3Button.php';
    require_once 'src/MD3TextField.php';
    require_once 'src/MD3Card.php';
    require_once 'src/MD3List.php';
    require_once 'src/MD3Search.php';
    require_once 'src/MD3Chip.php';
    require_once 'src/MD3Tooltip.php';
    require_once 'src/MD3Switch.php';
    require_once 'src/MD3Checkbox.php';
    require_once 'src/MD3Radio.php';
    require_once 'src/MD3Select.php';
    require_once 'src/MD3Dialog.php';
    require_once 'src/MD3Theme.php';
    require_once 'src/MD3Header.php';
    require_once 'src/MD3Progress.php';
    require_once 'src/MD3Slider.php';

    // Get theme from URL parameter or default
    $currentTheme = $_GET['theme'] ?? 'default';

    echo MD3::init(true, true, $currentTheme);
    ?>
    <style>
        <?php
        if (class_exists('MD3Theme')) {
            echo MD3Theme::getThemeCSS();
        }
        echo MD3::getVersionCSS();
        // Basic working components first
        echo MD3Header::getCSS();
        echo MD3List::getCSS();
        echo MD3Chip::getCSS();
        echo MD3Switch::getCSS();
        echo MD3Checkbox::getCSS();
        echo MD3Radio::getCSS();
        // TextField CSS has issues - skip for now
        ?>
    </style>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 16px;
        }

        .demo-navigation {
            margin: 24px 0;
            padding: 24px;
            background: var(--md-sys-color-primary-container);
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .demo-navigation h3 {
            margin: 0 0 20px 0;
            color: var(--md-sys-color-on-primary-container);
            font-size: 1.25rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .nav-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 16px;
        }

        .nav-buttons a {
            text-decoration: none;
        }

        .nav-buttons .md3-button {
            min-width: 140px;
            height: 48px;
            border-radius: 24px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }

        .nav-buttons .md3-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        .nav-buttons .md3-button--filled {
            background: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
        }

        .nav-buttons .md3-button--outlined {
            background: var(--md-sys-color-surface);
            border: 2px solid var(--md-sys-color-primary);
            color: var(--md-sys-color-primary);
        }

        .nav-buttons .md3-button--tonal {
            background: var(--md-sys-color-secondary-container);
            color: var(--md-sys-color-on-secondary-container);
        }

        .nav-buttons .md3-button--text {
            background: transparent;
            color: var(--md-sys-color-primary);
            box-shadow: none;
        }

        .demo-navigation p {
            margin: 16px 0 0 0;
            padding: 12px 16px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            font-size: 14px;
            color: var(--md-sys-color-on-primary-container);
            backdrop-filter: blur(4px);
        }

        .demo-section {
            margin: 24px 0;
            padding: 16px;
            border-radius: 12px;
            background: var(--md-sys-color-surface-container-lowest);
        }
        .demo-section h2 {
            margin-top: 0;
            color: var(--md-sys-color-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .demo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 16px;
            margin: 16px 0;
        }
        .component-demo {
            padding: 16px;
            background: var(--md-sys-color-surface);
            border-radius: 8px;
            border: 1px solid var(--md-sys-color-outline-variant);
        }
        .component-demo h3 {
            margin: 0 0 12px 0;
            font-size: 1rem;
            color: var(--md-sys-color-on-surface);
        }
        .demo-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 8px 0;
        }
        .demo-fields {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <?php echo MD3Header::demo('Material Design 3 PHP Library - Funktionale Demo', 'integration_instructions', $currentTheme); ?>

    <div class="content-wrapper">
        <!-- Demo Navigation -->
    <div class="demo-navigation">
        <h3><?php echo MD3::icon('explore'); ?> Demo-Seiten Navigation</h3>
        <div class="nav-buttons">
            <?php
            $themeParam = $currentTheme !== 'default' ? '?theme=' . $currentTheme : '';
            echo '<a href="index.php' . $themeParam . '" style="text-decoration: none;">' . MD3Button::outlined('🏠 Basis Demo') . '</a>';
            echo '<a href="demo-extended.php' . $themeParam . '" style="text-decoration: none;">' . MD3Button::outlined('🚀 Erweiterte Demo') . '</a>';
            echo '<a href="demo-functional.php' . $themeParam . '" style="text-decoration: none;">' . MD3Button::filled('⚡ Funktionale Demo') . '</a>';
            echo '<a href="playground.php' . $themeParam . '" style="text-decoration: none;">' . MD3Button::tonal('🎮 Interactive Playground') . '</a>';
            echo '<a href="test.html" style="text-decoration: none;">' . MD3Button::text('🧪 Test Seite') . '</a>';
            ?>
        </div>
        <p style="margin: 12px 0 0 0; font-size: 14px; color: var(--md-sys-color-on-primary-container);">
            <strong>Aktuelle Seite:</strong> Funktionale Demo - Vollständige Form-Integration mit POST-Testing
        </p>
    </div>

    <form method="POST" action="demo-functional.php<?php echo $currentTheme !== 'default' ? '?theme=' . $currentTheme : ''; ?>">

        <!-- Form Controls Demo -->
        <div class="demo-section">
            <h2><?php echo MD3::icon('tune'); ?>Funktionale Form-Kontrollen</h2>

            <div class="demo-grid">
                <div class="component-demo">
                    <h3>Switches (funktional)</h3>
                    <?php
                    echo MD3Switch::withLabel('notifications', 'Benachrichtigungen aktivieren', ['value' => '1', 'checked' => true]);
                    echo MD3Switch::withLabel('dark_mode', 'Dunkles Design verwenden', ['value' => '1', 'checked' => false]);
                    echo MD3Switch::withLabel('auto_sync', 'Automatische Synchronisation', ['value' => '1', 'checked' => false]);
                    ?>
                </div>

                <div class="component-demo">
                    <h3>Checkboxes (funktional)</h3>
                    <?php
                    echo MD3Checkbox::withLabel('terms', 'AGBs akzeptiert', ['value' => 'accepted', 'checked' => false]);
                    echo MD3Checkbox::withLabel('newsletter', 'Newsletter abonnieren', ['value' => 'yes', 'checked' => true]);
                    echo MD3Checkbox::withLabel('marketing', 'Marketing-E-Mails erhalten', ['value' => 'yes', 'checked' => false]);
                    ?>
                </div>

                <div class="component-demo">
                    <h3>Radio Buttons (funktional)</h3>
                    <?php
                    echo MD3Radio::group('contact_method', [
                        ['label' => 'E-Mail bevorzugt', 'value' => 'email'],
                        ['label' => 'Telefon bevorzugt', 'value' => 'phone'],
                        ['label' => 'Post bevorzugt', 'value' => 'post']
                    ], 'email');
                    ?>
                </div>
            </div>
        </div>

        <!-- Select Fields Demo -->
        <div class="demo-section">
            <h2><?php echo MD3::icon('arrow_drop_down'); ?>Select Felder (NEU!)</h2>

            <div class="demo-grid">
                <div class="component-demo">
                    <h3>Basis Select</h3>
                    <div class="demo-fields">
                        <?php
                        echo MD3Select::filled('country', 'Land auswählen', [
                            'DE' => 'Deutschland',
                            'AT' => 'Österreich',
                            'CH' => 'Schweiz',
                            'US' => 'USA'
                        ], 'DE');
                        ?>
                    </div>
                </div>

                <div class="component-demo">
                    <h3>Outlined Select</h3>
                    <div class="demo-fields">
                        <?php
                        echo MD3Select::outlined('priority', 'Priorität', [
                            'low' => 'Niedrig',
                            'normal' => 'Normal',
                            'high' => 'Hoch',
                            'urgent' => 'Dringend'
                        ], 'normal');
                        ?>
                    </div>
                </div>

                <div class="component-demo">
                    <h3>Länder-Select</h3>
                    <div class="demo-fields">
                        <?php
                        echo MD3Select::country('user_country', 'Ihr Land', 'DE', true);
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chip Filter Demo -->
        <div class="demo-section">
            <h2><?php echo MD3::icon('label'); ?>Filter Chips (funktional)</h2>

            <div class="component-demo">
                <h3>Kategorie Filter</h3>
                <p>Wählen Sie Ihre Interessensgebiete:</p>
                <?php
                $interestOptions = [
                    ['label' => 'Technologie', 'value' => 'tech', 'selected' => true],
                    ['label' => 'Design', 'value' => 'design', 'selected' => false],
                    ['label' => 'Entwicklung', 'value' => 'development', 'selected' => true],
                    ['label' => 'Marketing', 'value' => 'marketing', 'selected' => false],
                    ['label' => 'Business', 'value' => 'business', 'selected' => false]
                ];
                echo MD3Chip::filterSet($interestOptions, 'interests[]');
                ?>
            </div>
        </div>

        <!-- Text Fields -->
        <div class="demo-section">
            <h2><?php echo MD3::icon('text_fields'); ?>Text Felder</h2>

            <div class="demo-grid">
                <div class="component-demo">
                    <h3>Persönliche Daten</h3>
                    <div class="demo-fields">
                        <?php
                        echo MD3TextField::filled('firstname', 'Vorname');
                        echo MD3TextField::outlined('lastname', 'Nachname');
                        echo MD3TextField::email('email', 'E-Mail Adresse');
                        ?>
                    </div>
                </div>

                <div class="component-demo">
                    <h3>Weitere Felder</h3>
                    <div class="demo-fields">
                        <?php
                        echo MD3TextField::withLeadingIcon('phone', 'Telefon', 'phone');
                        echo MD3TextField::textarea('message', 'Ihre Nachricht');
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lists Demo -->
        <div class="demo-section">
            <h2><?php echo MD3::icon('list'); ?>Funktionale Listen (Form-Integration)</h2>

            <div class="demo-grid">
                <div class="component-demo">
                    <h3>Mehrfachauswahl Liste</h3>
                    <p style="margin-bottom: 12px; font-size: 14px; color: var(--md-sys-color-on-surface-variant);">Wählen Sie mehrere Services:</p>
                    <?php
                    echo MD3List::selectable([
                        ['text' => 'Cloud Storage', 'value' => 'storage', 'icon' => 'cloud', 'checked' => true],
                        ['text' => 'Database Backup', 'value' => 'backup', 'icon' => 'backup'],
                        ['text' => 'Analytics Service', 'value' => 'analytics', 'icon' => 'analytics', 'checked' => true],
                        ['text' => 'Email Service', 'value' => 'email', 'icon' => 'email']
                    ], 'services[]', 'checkbox');
                    ?>
                </div>

                <div class="component-demo">
                    <h3>Prioritäts-Auswahl</h3>
                    <p style="margin-bottom: 12px; font-size: 14px; color: var(--md-sys-color-on-surface-variant);">Wählen Sie eine Priorität:</p>
                    <?php
                    echo MD3List::selectable([
                        ['text' => 'Niedrig', 'value' => 'low', 'icon' => 'low_priority'],
                        ['text' => 'Normal', 'value' => 'normal', 'icon' => 'remove', 'checked' => true],
                        ['text' => 'Hoch', 'value' => 'high', 'icon' => 'priority_high'],
                        ['text' => 'Kritisch', 'value' => 'critical', 'icon' => 'error']
                    ], 'priority', 'radio');
                    ?>
                </div>

                <div class="component-demo">
                    <h3>Team-Mitglieder Liste</h3>
                    <p style="margin-bottom: 12px; font-size: 14px; color: var(--md-sys-color-on-surface-variant);">Projektteam zusammenstellen:</p>
                    <?php
                    echo MD3List::withAvatars([
                        ['text' => 'Max Mustermann (Entwickler)', 'avatar' => 'MM', 'meta' => 'verfügbar', 'onclick' => 'alert("Max zu Team hinzufügen?")'],
                        ['text' => 'Anna Schmidt (Designer)', 'avatar' => 'AS', 'meta' => 'besetzt', 'onclick' => 'alert("Anna ist bereits besetzt")'],
                        ['text' => 'Peter Weber (Tester)', 'avatar' => 'PW', 'meta' => 'verfügbar', 'onclick' => 'alert("Peter zu Team hinzufügen?")']
                    ]);
                    ?>
                </div>

                <div class="component-demo">
                    <h3>Benachrichtigungen</h3>
                    <?php
                    echo MD3List::twoLine([
                        [
                            'title' => 'Deployment erfolgreich',
                            'subtitle' => 'Version 2.1.0 wurde erfolgreich deployed',
                            'icon' => 'check_circle',
                            'meta' => 'vor 5 min',
                            'onclick' => 'alert("Deployment-Details anzeigen")'
                        ],
                        [
                            'title' => 'Neue Nachricht',
                            'subtitle' => 'Sie haben 3 neue Nachrichten erhalten',
                            'icon' => 'message',
                            'meta' => 'neu',
                            'badge' => '3',
                            'href' => '#messages'
                        ],
                        [
                            'title' => 'Systemfehler',
                            'subtitle' => 'Database connection timeout',
                            'icon' => 'error',
                            'meta' => 'vor 1h',
                            'onclick' => 'alert("Fehlerdetails: Connection timeout nach 30s")'
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <!-- Submit Section -->
        <div class="demo-section">
            <h2><?php echo MD3::icon('send'); ?>Formular senden</h2>

            <div class="component-demo">
                <div class="demo-buttons">
                    <?php
                    echo MD3Button::filled('Formular absenden', null, ['type' => 'submit']);
                    echo MD3Button::outlined('Zurücksetzen', null, ['type' => 'reset']);
                    echo MD3Button::text('Abbrechen', null, ['type' => 'button']);
                    ?>
                </div>

                <?php if ($_POST): ?>
                <div style="margin-top: 24px; padding: 16px; background: var(--md-sys-color-primary-container); border-radius: 8px;">
                    <h3 style="margin: 0 0 8px 0; color: var(--md-sys-color-on-primary-container);">
                        📋 Übermittelte Daten:
                    </h3>
                    <pre style="margin: 0; font-family: monospace; font-size: 12px; white-space: pre-wrap; color: var(--md-sys-color-on-primary-container);">
<?php echo htmlspecialchars(print_r($_POST, true)); ?>
                    </pre>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </form>

    <!-- Tooltips Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('info'); ?>Tooltips</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Interaktive Tooltips</h3>
                <div class="demo-buttons">
                    <div style="position: relative; display: inline-block;">
                        <?php
                        echo MD3Button::outlined('Tooltip Test', null, ['id' => 'tooltip-btn-1']);
                        echo MD3Tooltip::basic('Das ist ein funktionierender Tooltip!', 'tooltip-btn-1');
                        ?>
                    </div>

                    <?php
                    echo MD3Tooltip::help('Dies ist ein Hilfe-Tooltip mit detaillierten Informationen über diese Funktion.', 'help-tooltip-demo');
                    ?>
                </div>
            </div>
        </div>
    </div>

        <footer style="text-align: center; padding: 24px 0; color: var(--md-sys-color-on-surface-variant); border-top: 1px solid var(--md-sys-color-outline-variant); margin-top: 32px;">
            <p><strong>Material Design 3 PHP Library - Funktionale Demo</strong><br>
            <small>Alle Komponenten sind vollständig funktionsfähig und form-kompatibel</small>
            </p>
        </footer>
    </div>

    <script>
    <?php
    // All JavaScript like in playground.php
    echo MD3Switch::getJS();
    echo MD3Checkbox::getJS();
    echo MD3Radio::getJS();
    echo MD3Chip::getJS();
    echo MD3List::getJS();
    echo MD3Tooltip::getJS();
    ?>
    console.log('Material Design 3 Demo loaded');
    </script>

    <?php
    // Script includes like playground.php
    echo MD3Search::getSearchScript();
    echo MD3Tooltip::getTooltipScript();
    echo MD3Select::getSelectScript();
    echo MD3Theme::getThemeScript();
    ?>

    <script>
        // Demo-specific functionality
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Material Design 3 Demo loaded');

            // Form change listeners for debugging
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('change', function(e) {
                    console.log('Form field changed:', e.target.name, '=', e.target.value);
                });
            }
        });
    </script>
</body>
</html>