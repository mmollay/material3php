<!DOCTYPE html>
<html lang="en" data-theme="light" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Design 3 PHP Library - Component Gallery</title>
    <?php
    require_once 'autoload.php';

    // Get theme from URL parameter or default
    $currentTheme = $_GET['theme'] ?? 'default';

    echo MD3::init(true, true, $currentTheme);
    ?>
    <style>
    <?php
    echo MD3Theme::getThemeCSS();
    echo MD3Card::getCSS();

    // Add safe demo gallery CSS
    echo "/* Demo Gallery CSS - Safe Implementation */";
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
    <?php include 'includes/header.php'; ?>

    <div class="content-wrapper">

    <!-- Lists Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('list'); ?> Lists (Functional)</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Navigation List</h3>
                <?php
                echo MD3List::navigation([
                    ['text' => 'Dashboard', 'icon' => 'dashboard', 'href' => '#dashboard', 'badge' => '3'],
                    ['text' => 'Projekte', 'icon' => 'work', 'href' => '#projects'],
                    ['text' => 'Settings', 'icon' => 'settings', 'href' => '#settings'],
                    ['text' => 'Hilfe', 'icon' => 'help', 'href' => '#help']
                ], '#dashboard');
                ?>
            </div>

            <div class="component-demo">
                <h3>Clickable List with Badges</h3>
                <?php
                echo MD3List::simple([
                    ['text' => 'Inbox', 'icon' => 'inbox', 'badge' => '12', 'href' => '#inbox'],
                    ['text' => 'Starred', 'icon' => 'star', 'badge' => '2', 'onclick' => 'alert("Starred angeklickt!")'],
                    ['text' => 'Sent mail', 'icon' => 'send', 'meta' => '2h ago', 'href' => '#sent'],
                    ['text' => 'Drafts', 'icon' => 'drafts', 'meta' => '5 Drafts', 'href' => '#drafts']
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>List with Avatars</h3>
                <?php
                echo MD3List::withAvatars([
                    ['text' => 'Max Mustermann', 'avatar' => 'MM', 'meta' => 'online'],
                    ['text' => 'Anna Schmidt', 'avatar' => 'AS', 'meta' => '5 min ago'],
                    ['text' => 'Peter Weber', 'avatar' => 'PW', 'meta' => 'offline']
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Two-Line List with Meta</h3>
                <?php
                echo MD3List::twoLine([
                    [
                        'title' => 'Brunch this weekend?',
                        'subtitle' => 'Ali Connors — I\'ll be in your neighborhood...',
                        'icon' => 'person',
                        'meta' => '2 min',
                        'href' => '#message1'
                    ],
                    [
                        'title' => 'Summer BBQ',
                        'subtitle' => 'to Alex, Scott, Jennifer — Wish I could come...',
                        'icon' => 'person',
                        'meta' => '1 hour',
                        'onclick' => 'alert("BBQ Message geöffnet!")'
                    ],
                    [
                        'title' => 'Meeting Reminder',
                        'subtitle' => 'Daily standup meeting at 9:00 AM tomorrow',
                        'icon' => 'event',
                        'meta' => 'today',
                        'href' => '#meeting'
                    ]
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Three-Line List</h3>
                <?php
                echo MD3List::threeLine([
                    [
                        'title' => 'Project Update',
                        'subtitle' => 'Fortschritt beim neuen Feature',
                        'description' => 'Das neue Dashboard-Feature ist zu 85% abgeschlossen und wird nächste Woche deployed.',
                        'icon' => 'update',
                        'onclick' => 'alert("Projektdetails öffnen!")'
                    ],
                    [
                        'title' => 'System Maintenance',
                        'subtitle' => 'Scheduled Weekend Maintenance',
                        'description' => 'Servers will be maintained on Saturday between 2-4 AM. Brief outages possible.',
                        'icon' => 'build',
                        'href' => '#maintenance'
                    ]
                ]);
                ?>
            </div>

            <div class="component-demo">
                <h3>Selectable List (Functional)</h3>
                <form style="background: var(--md-sys-color-surface-container-lowest); padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                    <?php
                    echo MD3List::selectable([
                        ['text' => 'E-Mail Benachrichtigungen', 'value' => 'email', 'icon' => 'email', 'checked' => true],
                        ['text' => 'Push Benachrichtigungen', 'value' => 'push', 'icon' => 'notifications'],
                        ['text' => 'SMS Benachrichtigungen', 'value' => 'sms', 'icon' => 'sms']
                    ], 'notifications[]', 'checkbox');
                    ?>
                    <div style="margin-top: 12px;">
                        <button type="submit" style="padding: 8px 16px; background: var(--md-sys-color-primary); color: var(--md-sys-color-on-primary); border: none; border-radius: 4px; cursor: pointer;">Save Settings</button>
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
                ], 'Search with suggestions...');
                ?>
            </div>

            <div class="component-demo">
                <h3>Search with Filters</h3>
                <?php
                echo MD3Search::withFilters('filter_search', [
                    ['label' => 'Documents', 'value' => 'docs'],
                    ['label' => 'Images', 'value' => 'images'],
                    ['label' => 'Videos', 'value' => 'videos']
                ], 'Filtered search...');
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
                    MD3Chip::assist('Weather', ['icon' => 'cloud']),
                    MD3Chip::assist('Traffic', ['icon' => 'traffic']),
                    MD3Chip::assist('Restaurant', ['icon' => 'restaurant'])
                ];
                echo MD3Chip::set($assistChips, ['variant' => 'assist']);
                ?>
            </div>

            <div class="component-demo">
                <h3>Filter Chips</h3>
                <?php
                $filterOptions = [
                    ['label' => 'All', 'value' => 'all', 'selected' => true],
                    ['label' => 'Unread', 'value' => 'unread'],
                    ['label' => 'Important', 'value' => 'important', 'icon' => 'star']
                ];
                echo MD3Chip::filterSet($filterOptions, 'email_filter');
                ?>
            </div>

            <div class="component-demo">
                <h3>Input Chips</h3>
                <?php
                echo MD3Chip::inputField('tags', [
                    'placeholder' => 'Add tag...',
                    'chips' => ['PHP', 'Material Design', 'Web']
                ]);
                ?>
            </div>
        </div>
    </div>

    <!-- Form Controls Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('tune'); ?> Form Controls</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Switches</h3>
                <div class="demo-form-controls">
                    <?php
                    echo MD3Switch::withLabel('notifications', 'Enable notifications', ['value' => '1', 'checked' => true]);
                    echo MD3Switch::withLabel('dark_mode', 'Dark mode', ['value' => '1', 'checked' => false]);
                    echo MD3Switch::withLabel('auto_sync', 'Automatic synchronization', ['value' => '1', 'checked' => false]);
                    ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Checkboxes</h3>
                <div class="demo-form-controls">
                    <?php
                    echo MD3Checkbox::withLabel('terms', 'Accept terms', ['value' => '1', 'checked' => false]);
                    echo MD3Checkbox::withLabel('newsletter', 'Subscribe to newsletter', ['value' => '1', 'checked' => true]);
                    echo MD3Checkbox::withLabel('marketing', 'Receive marketing emails', ['value' => '1', 'checked' => false]);
                    ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Radio Buttons</h3>
                <?php
                echo MD3Radio::group('payment_method', [
                    ['label' => 'Credit Card', 'value' => 'credit'],
                    ['label' => 'PayPal', 'value' => 'paypal'],
                    ['label' => 'Bank Transfer', 'value' => 'transfer']
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
                <h3>Basic Tooltips</h3>
                <div class="demo-buttons">
                    <div class="tooltip-demo">
                        <?php
                        echo MD3Button::filled('Hover me', null, ['id' => 'tooltip-button-1']);
                        echo MD3Tooltip::basic('This is a simple tooltip', 'tooltip-button-1');
                        ?>
                    </div>

                    <div class="tooltip-demo">
                        <?php
                        echo MD3Button::outlined('With Icon', null, ['id' => 'tooltip-button-2']);
                        echo MD3Tooltip::withIcon('Tooltip with icon', 'star', 'tooltip-button-2');
                        ?>
                    </div>
                </div>
            </div>

            <div class="component-demo">
                <h3>Help Tooltips</h3>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span>Complex Setting</span>
                    <?php
                    echo MD3Tooltip::help('This is an advanced setting that should only be changed by experienced users.', 'help-1');
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
                        'A comprehensive design system by Google for modern user interfaces.',
                        'rich-tooltip-button'
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Integration Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('integration_instructions'); ?> Integration Example</h2>

        <div class="component-demo">
            <h3>Complete Form</h3>
            <form style="max-width: 600px;">
                <div class="demo-fields">
                    <?php
                    echo MD3TextField::filled('name', 'Name');
                    echo MD3TextField::emailOutlined('email', 'E-Mail');

                    echo '<div style="margin: 16px 0;">';
                    echo '<p style="margin-bottom: 8px; font-weight: 500;">Interests:</p>';
                    $interests = [
                        ['label' => 'Technology', 'value' => 'tech'],
                        ['label' => 'Design', 'value' => 'design', 'selected' => true],
                        ['label' => 'Development', 'value' => 'dev']
                    ];
                    echo MD3Chip::filterSet($interests, 'interests');
                    echo '</div>';

                    echo '<div style="margin: 16px 0;">';
                    echo MD3Switch::withLabel('subscribe', 'Subscribe to newsletter', ['value' => '1', 'checked' => true]);
                    echo '</div>';

                    echo '<div style="margin: 16px 0;">';
                    echo MD3Radio::group('contact_preference', [
                        ['label' => 'Email', 'value' => 'email'],
                        ['label' => 'Phone', 'value' => 'phone'],
                        ['label' => 'Mail', 'value' => 'mail']
                    ], 'email');
                    echo '</div>';
                    ?>

                    <div class="demo-buttons" style="margin-top: 24px;">
                        <?php
                        echo MD3Button::filled('Submit');
                        echo MD3Button::outlined('Cancel');
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        // Material Design 3 Theme Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const html = document.documentElement;

            // Auto dark mode detection
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                html.setAttribute('data-theme', 'dark');
            }

            // Listen for theme preference changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                html.setAttribute('data-theme', e.matches ? 'dark' : 'light');
            });
        });
    </script>
</body>
</html>