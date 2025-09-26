<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Design 3 PHP Library - Funktionale Demo</title>
    <?php
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

    echo MD3::init();
    ?>
    <style>
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
    <header style="padding: 24px 0; border-bottom: 1px solid var(--md-sys-color-outline-variant);">
        <h1 style="margin: 0; text-align: center; color: var(--md-sys-color-primary);">
            Material Design 3 PHP Library - Funktionale Demo
        </h1>
        <p style="text-align: center; margin: 8px 0 0 0; color: var(--md-sys-color-on-surface-variant);">
            Vollständig funktionsfähige Komponenten mit korrekten Form-Elementen
        </p>
    </header>

    <form method="POST" action="demo-functional.php">

        <!-- Form Controls Demo -->
        <div class="demo-section">
            <h2><?php echo MD3::icon('tune'); ?>Funktionale Form-Kontrollen</h2>

            <div class="demo-grid">
                <div class="component-demo">
                    <h3>Switches (funktional)</h3>
                    <?php
                    echo MD3Switch::withLabel('notifications', 'Benachrichtigungen aktivieren', '1', true);
                    echo MD3Switch::withLabel('dark_mode', 'Dunkles Design verwenden', '1', false);
                    echo MD3Switch::withLabel('auto_sync', 'Automatische Synchronisation', '1', false);
                    ?>
                </div>

                <div class="component-demo">
                    <h3>Checkboxes (funktional)</h3>
                    <?php
                    echo MD3Checkbox::withLabel('terms', 'AGBs akzeptiert', 'accepted', false);
                    echo MD3Checkbox::withLabel('newsletter', 'Newsletter abonnieren', 'yes', true);
                    echo MD3Checkbox::withLabel('marketing', 'Marketing-E-Mails erhalten', 'yes', false);
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
            <h2><?php echo MD3::icon('list'); ?>Funktionale Listen</h2>

            <div class="demo-grid">
                <div class="component-demo">
                    <h3>Navigation Liste</h3>
                    <?php
                    echo MD3List::simple([
                        ['text' => 'Dashboard', 'icon' => 'dashboard', 'href' => '#dashboard'],
                        ['text' => 'Projekte', 'icon' => 'work', 'href' => '#projects'],
                        ['text' => 'Einstellungen', 'icon' => 'settings', 'href' => '#settings'],
                        ['text' => 'Hilfe', 'icon' => 'help', 'href' => '#help']
                    ]);
                    ?>
                </div>

                <div class="component-demo">
                    <h3>Auswählbare Liste</h3>
                    <?php
                    echo MD3List::selectable([
                        ['text' => 'Option A', 'value' => 'a'],
                        ['text' => 'Option B', 'value' => 'b', 'checked' => true],
                        ['text' => 'Option C', 'value' => 'c']
                    ], 'list_selection', 'radio');
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

    <?php
    // Include JavaScript for interactive components
    echo MD3Search::getSearchScript();
    echo MD3Chip::getChipScript();
    echo MD3Tooltip::getTooltipScript();
    echo MD3Select::getSelectScript();
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