<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Design 3 PHP Library - Erweiterte Demo</title>
    <?php
    require_once 'src/MD3.php';
    require_once 'src/MD3Button.php';
    require_once 'src/MD3TextField.php';
    require_once 'src/MD3Card.php';
    require_once 'src/MD3Breadcrumb.php';
    require_once 'src/MD3Dialog.php';
    require_once 'src/MD3List.php';
    require_once 'src/MD3Search.php';
    require_once 'src/MD3Chip.php';
    require_once 'src/MD3Tooltip.php';
    require_once 'src/MD3Switch.php';
    require_once 'src/MD3Checkbox.php';
    require_once 'src/MD3Radio.php';

    echo MD3::init();
    ?>
    <style>
        body {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 16px;
        }

        .demo-navigation {
            margin: 16px 0;
            padding: 16px;
            background: var(--md-sys-color-primary-container);
            border-radius: 12px;
            text-align: center;
        }

        .demo-navigation h3 {
            margin: 0 0 12px 0;
            color: var(--md-sys-color-on-primary-container);
        }

        .nav-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
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
        .demo-form-controls {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .tooltip-demo {
            position: relative;
            display: inline-block;
        }
    </style>
</head>
<body>
    <header style="padding: 24px 0; border-bottom: 1px solid var(--md-sys-color-outline-variant);">
        <h1 style="margin: 0; text-align: center; color: var(--md-sys-color-primary);">
            Material Design 3 PHP Library - Erweiterte Demo
        </h1>
        <p style="text-align: center; margin: 8px 0 0 0; color: var(--md-sys-color-on-surface-variant);">
            Alle verfügbaren Material Web Components
        </p>
    </header>

    <!-- Demo Navigation -->
    <div class="demo-navigation">
        <h3><?php echo MD3::icon('explore'); ?> Demo-Seiten Navigation</h3>
        <div class="nav-buttons">
            <?php
            echo MD3Button::outlined('🏠 Basis Demo', 'index.php');
            echo MD3Button::filled('🚀 Erweiterte Demo', 'demo-extended.php');
            echo MD3Button::elevated('⚡ Funktionale Demo', 'demo-functional.php');
            echo MD3Button::text('🧪 Test Seite', 'test.html');
            ?>
        </div>
        <p style="margin: 12px 0 0 0; font-size: 14px; color: var(--md-sys-color-on-primary-container);">
            <strong>Aktuelle Seite:</strong> Erweiterte Demo - Alle neuen Komponenten (Lists, Search, Chips, Tooltips, Forms)
        </p>
    </div>

    <!-- Lists Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('list'); ?> Listen</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Einfache Liste</h3>
                <?php
                echo MD3List::simple([
                    ['text' => 'Inbox', 'icon' => 'inbox'],
                    ['text' => 'Starred', 'icon' => 'star'],
                    ['text' => 'Sent mail', 'icon' => 'send'],
                    ['text' => 'Drafts', 'icon' => 'drafts']
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Zwei-Zeilen Liste</h3>
                <?php
                echo MD3List::twoLine([
                    [
                        'title' => 'Brunch this weekend?',
                        'subtitle' => 'Ali Connors — I\'ll be in your neighborhood...',
                        'icon' => 'person'
                    ],
                    [
                        'title' => 'Summer BBQ',
                        'subtitle' => 'to Alex, Scott, Jennifer — Wish I could come...',
                        'icon' => 'person'
                    ]
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Auswählbare Liste</h3>
                <?php
                echo MD3List::selectable([
                    ['text' => 'Option 1', 'value' => 'opt1'],
                    ['text' => 'Option 2', 'value' => 'opt2', 'checked' => true],
                    ['text' => 'Option 3', 'value' => 'opt3']
                ], 'list_options', 'radio');
                ?>
            </div>
        </div>
    </div>

    <!-- Search Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('search'); ?> Suche</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Basis Suchfeld</h3>
                <?php
                echo MD3Search::field('basic_search', 'Suche...');
                ?>
            </div>

            <div class="component-demo">
                <h3>Suche mit Vorschlägen</h3>
                <?php
                echo MD3Search::withSuggestions('suggestion_search', [
                    'Material Design',
                    'PHP Library',
                    'Web Components',
                    'User Interface'
                ], 'Suche mit Vorschlägen...');
                ?>
            </div>

            <div class="component-demo">
                <h3>Suche mit Filtern</h3>
                <?php
                echo MD3Search::withFilters('filter_search', [
                    ['label' => 'Dokumente', 'value' => 'docs'],
                    ['label' => 'Bilder', 'value' => 'images'],
                    ['label' => 'Videos', 'value' => 'videos']
                ], 'Gefilterte Suche...');
                ?>
            </div>
        </div>
    </div>

    <!-- Chips Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('label'); ?> Chips</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Assist Chips</h3>
                <?php
                $assistChips = [
                    ['label' => 'Wetter', 'icon' => 'cloud'],
                    ['label' => 'Verkehr', 'icon' => 'traffic'],
                    ['label' => 'Restaurant', 'icon' => 'restaurant']
                ];
                echo MD3Chip::assistSet($assistChips);
                ?>
            </div>

            <div class="component-demo">
                <h3>Filter Chips</h3>
                <?php
                $filterOptions = [
                    ['label' => 'Alle', 'value' => 'all', 'selected' => true],
                    ['label' => 'Ungelesen', 'value' => 'unread'],
                    ['label' => 'Wichtig', 'value' => 'important', 'icon' => 'star']
                ];
                echo MD3Chip::filterSet($filterOptions, 'email_filter');
                ?>
            </div>

            <div class="component-demo">
                <h3>Input Chips</h3>
                <?php
                echo MD3Chip::inputField('tags', 'Tag hinzufügen...', ['PHP', 'Material Design', 'Web']);
                ?>
            </div>
        </div>
    </div>

    <!-- Form Controls Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('tune'); ?> Formular-Kontrollen</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Switches</h3>
                <div class="demo-form-controls">
                    <?php
                    echo MD3Switch::withLabel('notifications', 'Benachrichtigungen aktivieren', '1', true);
                    echo MD3Switch::withLabel('dark_mode', 'Dunkles Design', '1', false);
                    echo MD3Switch::withLabel('auto_sync', 'Automatische Synchronisation', '1', false);
                    ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Checkboxes</h3>
                <div class="demo-form-controls">
                    <?php
                    echo MD3Checkbox::withLabel('terms', 'AGBs akzeptieren', '1', false);
                    echo MD3Checkbox::withLabel('newsletter', 'Newsletter abonnieren', '1', true);
                    echo MD3Checkbox::withLabel('marketing', 'Marketing E-Mails erhalten', '1', false);
                    ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Radio Buttons</h3>
                <?php
                echo MD3Radio::group('payment_method', [
                    ['label' => 'Kreditkarte', 'value' => 'credit'],
                    ['label' => 'PayPal', 'value' => 'paypal'],
                    ['label' => 'Banküberweisung', 'value' => 'transfer']
                ], 'credit');
                ?>
            </div>
        </div>
    </div>

    <!-- Tooltips Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('info'); ?> Tooltips</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Basis Tooltips</h3>
                <div class="demo-buttons">
                    <div class="tooltip-demo">
                        <?php
                        echo MD3Button::filled('Hover mich', null, ['id' => 'tooltip-button-1']);
                        echo MD3Tooltip::basic('Das ist ein einfacher Tooltip', 'tooltip-button-1');
                        ?>
                    </div>

                    <div class="tooltip-demo">
                        <?php
                        echo MD3Button::outlined('Mit Icon', null, ['id' => 'tooltip-button-2']);
                        echo MD3Tooltip::withIcon('Tooltip mit Icon', 'star', 'tooltip-button-2');
                        ?>
                    </div>
                </div>
            </div>

            <div class="component-demo">
                <h3>Hilfe-Tooltips</h3>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span>Komplexe Einstellung</span>
                    <?php
                    echo MD3Tooltip::help('Dies ist eine erweiterte Einstellung, die nur von erfahrenen Benutzern geändert werden sollte.', 'help-1');
                    ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Rich Tooltip</h3>
                <div class="tooltip-demo">
                    <?php
                    echo MD3Button::elevated('Rich Tooltip', null, ['id' => 'rich-tooltip-button']);
                    echo MD3Tooltip::rich(
                        'Material Design 3',
                        'Ein umfassendes Design-System von Google für moderne Benutzeroberflächen.',
                        'rich-tooltip-button'
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Integration Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('integration_instructions'); ?> Integration Beispiel</h2>

        <div class="component-demo">
            <h3>Komplettes Formular</h3>
            <form style="max-width: 600px;">
                <div class="demo-fields">
                    <?php
                    echo MD3TextField::filled('name', 'Name');
                    echo MD3TextField::emailOutlined('email', 'E-Mail');

                    echo '<div style="margin: 16px 0;">';
                    echo '<p style="margin-bottom: 8px; font-weight: 500;">Interessen:</p>';
                    $interests = [
                        ['label' => 'Technologie', 'value' => 'tech'],
                        ['label' => 'Design', 'value' => 'design', 'selected' => true],
                        ['label' => 'Entwicklung', 'value' => 'dev']
                    ];
                    echo MD3Chip::filterSet($interests, 'interests');
                    echo '</div>';

                    echo '<div style="margin: 16px 0;">';
                    echo MD3Switch::withLabel('subscribe', 'Newsletter abonnieren', '1', true);
                    echo '</div>';

                    echo '<div style="margin: 16px 0;">';
                    echo MD3Radio::group('contact_preference', [
                        ['label' => 'E-Mail', 'value' => 'email'],
                        ['label' => 'Telefon', 'value' => 'phone'],
                        ['label' => 'Post', 'value' => 'mail']
                    ], 'email');
                    echo '</div>';
                    ?>

                    <div class="demo-buttons" style="margin-top: 24px;">
                        <?php
                        echo MD3Button::filled('Absenden');
                        echo MD3Button::outlined('Abbrechen');
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer style="text-align: center; padding: 24px 0; color: var(--md-sys-color-on-surface-variant); border-top: 1px solid var(--md-sys-color-outline-variant); margin-top: 32px;">
        <p>Material Design 3 PHP Library Erweiterte Demo<br>
        <small>Alle neuen Komponenten: Lists, Search, Chips, Tooltips, Form Controls</small>
        </p>
    </footer>

    <?php
    // Include JavaScript for interactive components
    echo MD3Search::getSearchScript();
    echo MD3Chip::getChipScript();
    echo MD3Tooltip::getTooltipScript();
    ?>
</body>
</html>