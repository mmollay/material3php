<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Design 3 PHP Library - Demo</title>
    <?php
    require_once 'src/MD3.php';
    require_once 'src/MD3Button.php';
    require_once 'src/MD3TextField.php';
    require_once 'src/MD3Card.php';
    require_once 'src/MD3Breadcrumb.php';
    require_once 'src/MD3Dialog.php';

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
    </style>
</head>
<body>
    <header style="padding: 24px 0; border-bottom: 1px solid var(--md-sys-color-outline-variant);">
        <h1 style="margin: 0; text-align: center; color: var(--md-sys-color-primary);">
            Material Design 3 PHP Library
        </h1>
        <p style="text-align: center; margin: 8px 0 0 0; color: var(--md-sys-color-on-surface-variant);">
            Demonstriert die verschiedenen Material Web Components
        </p>
    </header>

    <!-- Demo Navigation -->
    <div class="demo-navigation">
        <h3><?php echo MD3::icon('explore'); ?> Weitere Demo-Seiten erkunden</h3>
        <div class="nav-buttons">
            <?php
            echo '<a href="index.php" style="text-decoration: none;">' . MD3Button::filled('🏠 Basis Demo') . '</a>';
            echo '<a href="demo-extended.php" style="text-decoration: none;">' . MD3Button::outlined('🚀 Erweiterte Demo') . '</a>';
            echo '<a href="demo-functional.php" style="text-decoration: none;">' . MD3Button::elevated('⚡ Funktionale Demo') . '</a>';
            echo '<a href="test.html" style="text-decoration: none;">' . MD3Button::text('🧪 Test Seite') . '</a>';
            ?>
        </div>
        <p style="margin: 12px 0 0 0; font-size: 14px; color: var(--md-sys-color-on-primary-container);">
            <strong>Basis Demo:</strong> Grundlegende Komponenten |
            <strong>Erweiterte Demo:</strong> Alle neuen Komponenten |
            <strong>Funktionale Demo:</strong> Vollständige Form-Integration
        </p>
    </div>

    <!-- Breadcrumb Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('navigation'); ?> Breadcrumb Navigation</h2>

        <?php
        echo MD3Breadcrumb::fromArray([
            ['label' => 'Start', 'href' => '/'],
            ['label' => 'Produkte', 'href' => '/products'],
            ['label' => 'Smartphones', 'href' => '/products/smartphones'],
            ['label' => 'iPhone 15']
        ]);
        ?>
    </div>

    <!-- Button Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('smart_button'); ?> Buttons</h2>

        <div class="component-demo">
            <h3>Standard Buttons</h3>
            <div class="demo-buttons">
                <?php
                echo MD3Button::filled('Filled Button');
                echo MD3Button::outlined('Outlined Button');
                echo MD3Button::text('Text Button');
                echo MD3Button::elevated('Elevated Button');
                echo MD3Button::tonal('Tonal Button');
                ?>
            </div>
        </div>

        <div class="component-demo">
            <h3>Icon Buttons</h3>
            <div class="demo-buttons">
                <?php
                echo MD3Button::icon('favorite');
                echo MD3Button::iconFilled('favorite');
                echo MD3Button::iconTonal('favorite');
                echo MD3Button::iconOutlined('favorite');
                ?>
            </div>
        </div>

        <div class="component-demo">
            <h3>FAB</h3>
            <div class="demo-buttons">
                <?php
                echo MD3Button::fab('add');
                echo MD3Button::fab('edit', 'Bearbeiten');
                ?>
            </div>
        </div>
    </div>

    <!-- TextField Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('text_fields'); ?> Text Fields</h2>

        <div class="demo-grid">
            <div class="component-demo">
                <h3>Filled Fields</h3>
                <div class="demo-fields">
                    <?php
                    echo MD3TextField::filled('name', 'Name');
                    echo MD3TextField::email('email', 'E-Mail');
                    echo MD3TextField::password('password', 'Passwort');
                    echo MD3TextField::textarea('message', 'Nachricht');
                    ?>
                </div>
            </div>

            <div class="component-demo">
                <h3>Outlined Fields</h3>
                <div class="demo-fields">
                    <?php
                    echo MD3TextField::outlined('name_outlined', 'Name');
                    echo MD3TextField::emailOutlined('email_outlined', 'E-Mail');
                    echo MD3TextField::passwordOutlined('password_outlined', 'Passwort');
                    echo MD3TextField::textareaOutlined('message_outlined', 'Nachricht');
                    ?>
                </div>
            </div>
        </div>

        <div class="component-demo">
            <h3>Fields mit Icons</h3>
            <div class="demo-fields">
                <?php
                echo MD3TextField::withLeadingIcon('search', 'Suche', 'search');
                echo MD3TextField::withTrailingIcon('phone', 'Telefon', 'phone', true);
                ?>
            </div>
        </div>
    </div>

    <!-- Card Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('web_stories'); ?> Cards</h2>

        <div class="demo-grid">
            <?php
            echo MD3Card::simple(
                'Elevated Card',
                'Dies ist eine einfache elevated Card mit Titel und Inhalt.',
                'elevated'
            );

            echo MD3Card::withIcon(
                'settings',
                'Einstellungen',
                'Verwalte deine App-Einstellungen und Präferenzen.',
                'outlined'
            );

            $actions = [
                MD3Button::text('Abbrechen'),
                MD3Button::filled('Speichern')
            ];
            echo MD3Card::withActions(
                'Formular',
                'Diese Card enthält Action-Buttons am unteren Rand.',
                $actions,
                'filled'
            );
            ?>
        </div>
    </div>

    <!-- Dialog Demo -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('open_in_new'); ?> Dialogs</h2>

        <div class="demo-buttons">
            <?php
            echo MD3Dialog::trigger('demo-alert', 'Alert Dialog', 'outlined');
            echo MD3Dialog::trigger('demo-confirm', 'Confirm Dialog', 'outlined');
            echo MD3Dialog::trigger('demo-form', 'Form Dialog', 'outlined');
            ?>
        </div>

        <!-- Alert Dialog -->
        <?php
        echo MD3Dialog::alert('demo-alert', 'Information', 'Dies ist ein einfacher Alert Dialog.');
        ?>

        <!-- Confirm Dialog -->
        <?php
        echo MD3Dialog::confirm('demo-confirm', 'Bestätigung', 'Möchtest du diese Aktion wirklich ausführen?', 'Ja, fortfahren', 'Abbrechen');
        ?>

        <!-- Form Dialog -->
        <?php
        $formContent = MD3TextField::filled('dialog_name', 'Name') .
                      MD3TextField::emailOutlined('dialog_email', 'E-Mail');
        echo MD3Dialog::form('demo-form', 'Kontakt hinzufügen', $formContent);
        ?>
    </div>

    <!-- Component Overview -->
    <div class="demo-section">
        <h2><?php echo MD3::icon('info'); ?> Über die Library</h2>

        <?php
        $libraryInfo = MD3Card::simple(
            'Material Design 3 PHP Library',
            'Diese Library bietet eine einfache PHP-Schnittstelle zu den Material Web Components. ' .
            'Alle Komponenten generieren standardkonformes HTML mit Material Design 3 Styling. ' .
            'Die Library ist erweiterbar und produktionsbereit.',
            'elevated'
        );
        echo $libraryInfo;
        ?>

        <div style="margin-top: 16px; padding: 16px; background: var(--md-sys-color-primary-container); border-radius: 8px;">
            <h3 style="margin: 0 0 8px 0; color: var(--md-sys-color-on-primary-container);">
                <?php echo MD3::icon('code'); ?> Version: <?php echo MD3::getVersion(); ?>
            </h3>
            <p style="margin: 0; color: var(--md-sys-color-on-primary-container-variant);">
                Verfügbare Komponenten: Button, TextField, Card, Breadcrumb, Dialog und weitere.
            </p>
        </div>
    </div>

    <footer style="text-align: center; padding: 24px 0; color: var(--md-sys-color-on-surface-variant); border-top: 1px solid var(--md-sys-color-outline-variant); margin-top: 32px;">
        <p>Material Design 3 PHP Library Demo |
        <a href="https://m3.material.io" style="color: var(--md-sys-color-primary);">Material Design 3</a> |
        <a href="https://github.com/material-components/material-web" style="color: var(--md-sys-color-primary);">Material Web Components</a>
        </p>
    </footer>

    <script>
        // Dialog functionality
        function confirmAction() {
            alert('Aktion bestätigt!');
        }
    </script>
</body>
</html>