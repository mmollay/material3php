<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Material3PHP - Quick Demo</title>

    <!-- Just 2 lines needed! -->
    <?php require_once 'autoload.php'; ?>
    <?php
    $currentTheme = $_GET['theme'] ?? 'default';
    echo MD3::init(true, true, $currentTheme);
    ?>

    <style>
        .demo-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 24px;
        }

        .hero {
            text-align: center;
            padding: 32px 24px;
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            border-radius: 12px;
            margin-bottom: 32px;
        }

        .setup-code {
            background: var(--md-sys-color-surface-container);
            padding: 16px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 14px;
            margin: 16px 0;
            border-left: 4px solid var(--md-sys-color-primary);
        }

        .demo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin: 32px 0;
        }

        .demo-section {
            background: var(--md-sys-color-surface-container-low);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--md-sys-color-outline-variant);
        }

        .demo-section h3 {
            margin: 0 0 16px 0;
            color: var(--md-sys-color-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .button-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin: 12px 0;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="demo-container">
        <!-- Hero Section -->
        <div class="hero">
            <h1><?php echo MD3::icon('rocket_launch'); ?> Material3PHP Quick Demo</h1>
            <p>See what you get with just 2 lines of PHP setup!</p>

            <div class="setup-code">
                &lt;?php require_once 'autoload.php'; ?&gt;<br>
                &lt;?php echo MD3::init(); ?&gt;
            </div>
        </div>

        <!-- Component Showcase -->
        <div class="demo-grid">

            <!-- Buttons -->
            <div class="demo-section">
                <h3><?php echo MD3::icon('smart_button'); ?> Buttons</h3>
                <div class="button-row">
                    <?php echo MD3Button::filled('Filled'); ?>
                    <?php echo MD3Button::outlined('Outlined'); ?>
                    <?php echo MD3Button::text('Text'); ?>
                </div>
                <div class="button-row">
                    <?php echo MD3Button::elevated('Elevated'); ?>
                    <?php echo MD3Button::tonal('Tonal'); ?>
                </div>
                <div class="button-row">
                    <?php echo MD3Button::filled('With Icon', null, ['data-icon' => 'favorite']); ?>
                    <?php echo MD3Button::outlined('Download', null, ['data-icon' => 'download']); ?>
                </div>
            </div>

            <!-- Text Fields -->
            <div class="demo-section">
                <h3><?php echo MD3::icon('edit'); ?> Text Fields</h3>
                <div style="margin: 12px 0;">
                    <?php echo MD3TextField::filled('name', 'Your Name'); ?>
                </div>
                <div style="margin: 12px 0;">
                    <?php echo MD3TextField::outlined('email', 'Email Address'); ?>
                </div>
                <div style="margin: 12px 0;">
                    <?php echo MD3TextField::filled('message', 'Message', ['type' => 'textarea', 'rows' => 3]); ?>
                </div>
            </div>

            <!-- Lists -->
            <div class="demo-section">
                <h3><?php echo MD3::icon('list'); ?> Lists</h3>
                <?php echo MD3List::simple([
                    ['text' => 'Dashboard', 'icon' => 'dashboard', 'badge' => '5'],
                    ['text' => 'Messages', 'icon' => 'mail', 'badge' => 'new'],
                    ['text' => 'Settings', 'icon' => 'settings'],
                    ['text' => 'Profile', 'icon' => 'person']
                ]); ?>
            </div>

            <!-- Selects -->
            <div class="demo-section">
                <h3><?php echo MD3::icon('arrow_drop_down'); ?> Select Fields</h3>
                <div style="margin: 12px 0;">
                    <?php echo MD3Select::filled('country', 'Choose Country', [
                        'DE' => 'Germany',
                        'AT' => 'Austria',
                        'CH' => 'Switzerland',
                        'US' => 'United States'
                    ]); ?>
                </div>
                <div style="margin: 12px 0;">
                    <?php echo MD3Select::outlined('language', 'Language', [
                        'en' => 'English',
                        'de' => 'Deutsch',
                        'fr' => 'Français'
                    ]); ?>
                </div>
            </div>

            <!-- Cards -->
            <div class="demo-section">
                <h3><?php echo MD3::icon('credit_card'); ?> Cards</h3>
                <div style="background: var(--md-sys-color-surface-container-low); padding: 16px; border-radius: 8px; margin: 12px 0; border: 1px solid var(--md-sys-color-outline-variant);">
                    <h4 style="margin: 0 0 8px 0; display: flex; align-items: center; gap: 8px;">
                        <?php echo MD3::icon('celebration'); ?> Welcome Card
                    </h4>
                    <p style="margin: 0; color: var(--md-sys-color-on-surface-variant);">
                        This card demonstrates Material Design 3 styling with proper color tokens and spacing.
                    </p>
                </div>
            </div>

            <!-- Form Example -->
            <div class="demo-section">
                <h3><?php echo MD3::icon('assignment'); ?> Complete Form</h3>
                <form style="display: flex; flex-direction: column; gap: 16px;">
                    <?php echo MD3TextField::filled('fullname', 'Full Name'); ?>
                    <?php echo MD3Select::outlined('role', 'Role', [
                        'user' => 'User',
                        'admin' => 'Administrator',
                        'moderator' => 'Moderator'
                    ]); ?>

                    <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 8px;">
                        <?php echo MD3Button::text('Cancel'); ?>
                        <?php echo MD3Button::filled('Submit'); ?>
                    </div>
                </form>
            </div>

        </div>

        <!-- Statistics -->
        <div style="background: var(--md-sys-color-tertiary-container); color: var(--md-sys-color-on-tertiary-container); padding: 24px; border-radius: 12px; margin: 32px 0;">
            <h2 style="margin: 0 0 16px 0; text-align: center;">
                <?php echo MD3::icon('auto_awesome'); ?> What You Get
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; text-align: center;">
                <div>
                    <div style="font-size: 2rem; font-weight: bold;">25+</div>
                    <div style="font-size: 14px; opacity: 0.8;">Components</div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: bold;">2</div>
                    <div style="font-size: 14px; opacity: 0.8;">Lines Setup</div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: bold;">0</div>
                    <div style="font-size: 14px; opacity: 0.8;">Dependencies</div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: bold;">5</div>
                    <div style="font-size: 14px; opacity: 0.8;">Themes</div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div style="text-align: center; background: var(--md-sys-color-primary-container); color: var(--md-sys-color-on-primary-container); padding: 24px; border-radius: 12px;">
            <h2 style="margin: 0 0 16px 0;">Ready to Start?</h2>
            <p style="margin: 0 0 20px 0;">Get started with Material3PHP in seconds!</p>

            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <a href="how-to-use.php?theme=<?php echo $currentTheme; ?>" style="text-decoration: none;">
                    <?php echo MD3Button::filled('Full Documentation'); ?>
                </a>
                <a href="demo-extended.php?theme=<?php echo $currentTheme; ?>" style="text-decoration: none;">
                    <?php echo MD3Button::outlined('Component Gallery'); ?>
                </a>
                <a href="playground.php?theme=<?php echo $currentTheme; ?>" style="text-decoration: none;">
                    <?php echo MD3Button::tonal('Interactive Playground'); ?>
                </a>
            </div>
        </div>

        <!-- Footer Note -->
        <div style="text-align: center; margin-top: 32px; padding: 16px; border-top: 1px solid var(--md-sys-color-outline-variant);">
            <p style="margin: 0; color: var(--md-sys-color-on-surface-variant); font-size: 14px;">
                <?php echo MD3::icon('info'); ?>
                <strong>This entire page uses only the 2-line setup shown above!</strong><br>
                No additional CSS files, no CDN dependencies, no complex configuration.
            </p>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>