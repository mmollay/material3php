<!DOCTYPE html>
<html lang="de" data-theme="light">
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
    require_once 'src/MD3Progress.php';
    require_once 'src/MD3Slider.php';
    require_once 'src/MD3Tooltip.php';
    require_once 'src/MD3Switch.php';
    require_once 'src/MD3Checkbox.php';
    require_once 'src/MD3Radio.php';
    require_once 'src/MD3Tabs.php';
    require_once 'src/MD3Theme.php';
    require_once 'src/MD3Select.php';
    require_once 'src/MD3Header.php';
    require_once 'src/MD3Badge.php';
    require_once 'src/MD3Snackbar.php';
    require_once 'src/MD3BottomSheet.php';
    require_once 'src/MD3DateTimePicker.php';
    require_once 'src/MD3Menu.php';
    require_once 'src/MD3Toolbar.php';
    require_once 'src/MD3FloatingActionButton.php';
    require_once 'src/MD3NavigationBar.php';
    require_once 'src/MD3NavigationDrawer.php';
    require_once 'src/MD3Divider.php';
    require_once 'src/MD3Carousel.php';

    // Get theme from URL parameter or default
    $currentTheme = $_GET['theme'] ?? 'default';

    echo MD3::init(true, true, $currentTheme);
    ?>
    <style>
    <?php
    echo MD3Theme::getThemeCSS();
    echo MD3Header::getCSS();
    echo MD3List::getCSS();
    echo MD3Card::getCSS();
    echo MD3Search::getCSS();
    echo MD3Chip::getCSS();
    echo MD3Progress::getCSS();
    echo MD3Slider::getCSS();
    echo MD3Switch::getCSS();
    echo MD3Checkbox::getCSS();
    echo MD3Radio::getCSS();
    echo MD3Tabs::getCSS();
    echo MD3Tooltip::getCSS();
    echo MD3Badge::getCSS();
    echo MD3Snackbar::getCSS();
    echo MD3BottomSheet::getCSS();
    echo MD3DateTimePicker::getCSS();
    echo MD3Menu::getCSS();
    echo MD3Toolbar::getCSS();
    echo MD3FloatingActionButton::getCSS();
    echo MD3NavigationBar::getCSS();
    echo MD3NavigationDrawer::getCSS();
    echo MD3Divider::getCSS();
    echo MD3Carousel::getCSS();
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
    <?php echo MD3Header::demo('Material Design 3 PHP Library - Erweiterte Demo', 'dashboard', $currentTheme); ?>

    <div class="content-wrapper">
        <!-- Demo Navigation -->
    <div class="demo-navigation">
        <h3><?php echo MD3::icon('explore'); ?> Demo-Seiten Navigation</h3>
        <div class="nav-buttons">
            <?php
            $themeParam = $currentTheme !== 'default' ? '?theme=' . $currentTheme : '';
            echo '<a href="index.php' . $themeParam . '" style="text-decoration: none;">' . MD3Button::outlined('🏠 Basis Demo') . '</a>';
            echo '<a href="demo-extended.php' . $themeParam . '" style="text-decoration: none;">' . MD3Button::filled('🚀 Erweiterte Demo') . '</a>';
            echo '<a href="demo-functional.php' . $themeParam . '" style="text-decoration: none;">' . MD3Button::elevated('⚡ Funktionale Demo') . '</a>';
            echo '<a href="playground.php' . $themeParam . '" style="text-decoration: none;">' . MD3Button::tonal('🎮 Interactive Playground') . '</a>';
            echo '<a href="test.html" style="text-decoration: none;">' . MD3Button::text('🧪 Test Seite') . '</a>';
            ?>
        </div>
        <p style="margin: 12px 0 0 0; font-size: 14px; color: var(--md-sys-color-on-primary-container);">
            <strong>Aktuelle Seite:</strong> Erweiterte Demo - Alle neuen Komponenten (Lists, Search, Chips, Tooltips, Forms)
        </p>
    </div>

    <!-- Lists Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('list'); ?> Listen (Funktional)</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Navigationsliste</h3>
                <?php
                echo MD3List::navigation([
                    ['text' => 'Dashboard', 'icon' => 'dashboard', 'href' => '#dashboard', 'badge' => '3'],
                    ['text' => 'Projekte', 'icon' => 'work', 'href' => '#projects'],
                    ['text' => 'Einstellungen', 'icon' => 'settings', 'href' => '#settings'],
                    ['text' => 'Hilfe', 'icon' => 'help', 'href' => '#help']
                ], '#dashboard');
                ?>
            </div>

            <div class="component-demo">
                <h3>Klickbare Liste mit Badges</h3>
                <?php
                echo MD3List::simple([
                    ['text' => 'Inbox', 'icon' => 'inbox', 'badge' => '12', 'href' => '#inbox'],
                    ['text' => 'Starred', 'icon' => 'star', 'badge' => '2', 'onclick' => 'alert("Starred angeklickt!")'],
                    ['text' => 'Sent mail', 'icon' => 'send', 'meta' => 'vor 2h', 'href' => '#sent'],
                    ['text' => 'Drafts', 'icon' => 'drafts', 'meta' => '5 Entwürfe', 'href' => '#drafts']
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Liste mit Avatars</h3>
                <?php
                echo MD3List::withAvatars([
                    ['text' => 'Max Mustermann', 'avatar' => 'MM', 'meta' => 'online'],
                    ['text' => 'Anna Schmidt', 'avatar' => 'AS', 'meta' => 'vor 5 min'],
                    ['text' => 'Peter Weber', 'avatar' => 'PW', 'meta' => 'offline']
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Zwei-Zeilen Liste mit Meta</h3>
                <?php
                echo MD3List::twoLine([
                    [
                        'title' => 'Brunch this weekend?',
                        'subtitle' => 'Ali Connors — I\'ll be in your neighborhood...',
                        'icon' => 'person',
                        'meta' => '2 Min',
                        'href' => '#message1'
                    ],
                    [
                        'title' => 'Summer BBQ',
                        'subtitle' => 'to Alex, Scott, Jennifer — Wish I could come...',
                        'icon' => 'person',
                        'meta' => '1 Std',
                        'onclick' => 'alert("BBQ Message geöffnet!")'
                    ],
                    [
                        'title' => 'Meeting Reminder',
                        'subtitle' => 'Daily standup meeting at 9:00 AM tomorrow',
                        'icon' => 'event',
                        'meta' => 'heute',
                        'href' => '#meeting'
                    ]
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Drei-Zeilen Liste</h3>
                <?php
                echo MD3List::threeLine([
                    [
                        'title' => 'Projektupdate',
                        'subtitle' => 'Fortschritt beim neuen Feature',
                        'description' => 'Das neue Dashboard-Feature ist zu 85% abgeschlossen und wird nächste Woche deployed.',
                        'icon' => 'update',
                        'onclick' => 'alert("Projektdetails öffnen!")'
                    ],
                    [
                        'title' => 'Systemwartung',
                        'subtitle' => 'Geplante Wartung am Wochenende',
                        'description' => 'Server werden am Samstag zwischen 2-4 Uhr gewartet. Kurze Ausfallzeiten möglich.',
                        'icon' => 'build',
                        'href' => '#maintenance'
                    ]
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Auswählbare Liste (funktional)</h3>
                <form style="background: var(--md-sys-color-surface-container-lowest); padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                    <?php
                    echo MD3List::selectable([
                        ['text' => 'E-Mail Benachrichtigungen', 'value' => 'email', 'icon' => 'email', 'checked' => true],
                        ['text' => 'Push Benachrichtigungen', 'value' => 'push', 'icon' => 'notifications'],
                        ['text' => 'SMS Benachrichtigungen', 'value' => 'sms', 'icon' => 'sms']
                    ], 'notifications[]', 'checkbox');
                    ?>
                    <div style="margin-top: 12px;">
                        <button type="submit" style="padding: 8px 16px; background: var(--md-sys-color-primary); color: var(--md-sys-color-on-primary); border: none; border-radius: 4px; cursor: pointer;">Einstellungen speichern</button>
                    </div>
                </form>
            </div>

            <div class="component-demo">
                <h3>Action Liste</h3>
                <?php
                echo MD3List::actions([
                    ['text' => 'Bearbeiten', 'icon' => 'edit', 'action' => 'alert("Bearbeiten gewählt!")'],
                    ['text' => 'Teilen', 'icon' => 'share', 'action' => 'alert("Teilen gewählt!")'],
                    ['text' => 'Kopieren', 'icon' => 'content_copy', 'action' => 'alert("Kopiert!")'],
                    ['text' => 'Löschen', 'icon' => 'delete', 'action' => 'confirm("Wirklich löschen?") && alert("Gelöscht!")', 'destructive' => true]
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Liste mit Trennlinien</h3>
                <?php
                echo MD3List::withDividers([
                    ['text' => 'Wichtige Nachrichten', 'icon' => 'priority_high', 'badge' => '!'],
                    ['text' => 'Normale Nachrichten', 'icon' => 'inbox', 'meta' => '42'],
                    ['text' => 'Archivierte Nachrichten', 'icon' => 'archive', 'meta' => '128'],
                    ['text' => 'Papierkorb', 'icon' => 'delete', 'meta' => '5']
                ]);
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
                    MD3Chip::assist('Wetter', ['icon' => 'cloud']),
                    MD3Chip::assist('Verkehr', ['icon' => 'traffic']),
                    MD3Chip::assist('Restaurant', ['icon' => 'restaurant'])
                ];
                echo MD3Chip::set($assistChips, ['variant' => 'assist']);
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
                echo MD3Chip::inputField('tags', [
                    'placeholder' => 'Tag hinzufügen...',
                    'chips' => ['PHP', 'Material Design', 'Web']
                ]);
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
                    echo MD3Switch::withLabel('notifications', 'Benachrichtigungen aktivieren', ['value' => '1', 'checked' => true]);
                    echo MD3Switch::withLabel('dark_mode', 'Dunkles Design', ['value' => '1', 'checked' => false]);
                    echo MD3Switch::withLabel('auto_sync', 'Automatische Synchronisation', ['value' => '1', 'checked' => false]);
                    ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Checkboxes</h3>
                <div class="demo-form-controls">
                    <?php
                    echo MD3Checkbox::withLabel('terms', 'AGBs akzeptieren', ['value' => '1', 'checked' => false]);
                    echo MD3Checkbox::withLabel('newsletter', 'Newsletter abonnieren', ['value' => '1', 'checked' => true]);
                    echo MD3Checkbox::withLabel('marketing', 'Marketing E-Mails erhalten', ['value' => '1', 'checked' => false]);
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
                    echo MD3Switch::withLabel('subscribe', 'Newsletter abonnieren', ['value' => '1', 'checked' => true]);
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
    </div>

    <?php
    // Include JavaScript for interactive components
    echo MD3Header::getScript();
    echo MD3Search::getSearchScript();
    ?>
    <script>
    <?php
    echo MD3Chip::getJS();
    echo MD3Progress::getJS();
    echo MD3Slider::getJS();
    echo MD3Switch::getJS();
    echo MD3Checkbox::getJS();
    echo MD3Radio::getJS();
    echo MD3Tabs::getJS();
    echo MD3Tooltip::getJS();
    echo MD3List::getJS();
    echo MD3Snackbar::getJS();
    echo MD3Badge::getScript();
    ?>
    </script>
    <?php
    echo MD3Theme::getThemeScript();
    echo MD3Menu::getScript();
    echo MD3BottomSheet::getScript();
    echo MD3DateTimePicker::getScript();
    echo MD3FloatingActionButton::getScript();
    echo MD3NavigationBar::getScript();
    echo MD3NavigationDrawer::getScript();
    ?>
</body>
</html>