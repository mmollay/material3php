<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How to Use Material3PHP - Simple 2-Line Integration</title>

    <!-- STEP 1: Include Autoloader -->
    <?php require_once 'autoload.php'; ?>

    <!-- STEP 2: Initialize Material3PHP -->
    <?php
    $currentTheme = $_GET['theme'] ?? 'default';
    echo MD3::init(true, true, $currentTheme);
    ?>

    <style>
        body { max-width: 1200px; margin: 0 auto; padding: 24px; }
        .hero { text-align: center; padding: 48px 0; background: var(--md-sys-color-primary-container); border-radius: 12px; margin: 32px 0 32px 0; }
        .hero h1 { color: var(--md-sys-color-on-primary-container); margin: 0 0 16px 0; }
        .hero p { color: var(--md-sys-color-on-primary-container); font-size: 18px; opacity: 0.8; margin: 0; }
        .section { margin: 32px 0; }
        .code-example { background: var(--md-sys-color-surface-container); padding: 16px; border-radius: 8px; margin: 16px 0; font-family: monospace; }
        .demo-area { background: var(--md-sys-color-surface); padding: 24px; border-radius: 12px; border: 1px solid var(--md-sys-color-outline-variant); margin: 16px 0; }
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin: 32px 0; }
        .feature-card { background: var(--md-sys-color-surface-container-low); padding: 24px; border-radius: 12px; border: 1px solid var(--md-sys-color-outline-variant); }
        .step { background: var(--md-sys-color-secondary-container); color: var(--md-sys-color-on-secondary-container); padding: 4px 12px; border-radius: 16px; font-size: 14px; font-weight: 500; margin-right: 8px; }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <div class="hero">
        <h1><?php echo MD3::icon('rocket_launch'); ?> Material3PHP</h1>
        <p>Pure PHP Material Design 3 Components - Just 2 Lines to Get Started!</p>
    </div>

    <!-- Quick Start -->
    <div class="section">
        <h2><?php echo MD3::icon('flash_on'); ?> Quick Start - Only 2 Lines!</h2>
        <p>Get Material Design 3 components running in seconds:</p>

        <div class="code-example">
&lt;?php require_once 'autoload.php'; ?&gt;<br>
&lt;?php echo MD3::init(); ?&gt;
        </div>

        <p>That's it! Now you can use all Material3PHP components. No CSS files, no CDN dependencies!</p>
    </div>

    <!-- Examples -->
    <div class="section">
        <h2><?php echo MD3::icon('code'); ?> Usage Examples</h2>

        <!-- Buttons -->
        <h3><span class="step">1</span>Buttons</h3>
        <div class="demo-area">
            <div style="display: flex; gap: 16px; margin: 16px 0; flex-wrap: wrap;">
                <?php echo MD3Button::filled('Filled Button'); ?>
                <?php echo MD3Button::outlined('Outlined Button'); ?>
                <?php echo MD3Button::text('Text Button'); ?>
                <?php echo MD3Button::elevated('Elevated Button'); ?>
            </div>
            <div style="display: flex; gap: 16px; margin: 16px 0; flex-wrap: wrap;">
                <?php echo MD3Button::filled('With Icon', null, ['data-icon' => 'star']); ?>
                <?php echo MD3Button::outlined('Download', null, ['data-icon' => 'download']); ?>
                <?php echo MD3Button::text('Settings', null, ['data-icon' => 'settings']); ?>
            </div>
            <div style="display: flex; gap: 16px; margin: 16px 0; flex-wrap: wrap;">
                <?php echo MD3Button::filled('Disabled', null, ['disabled' => 'true']); ?>
                <?php echo MD3Button::outlined('Link Button', 'https://example.com'); ?>
                <?php echo MD3Button::text('Click Me', null, ['onclick' => 'alert("Hello!")']); ?>
            </div>
        </div>
        <div class="code-example">
<strong>Basic Buttons:</strong><br>
&lt;?php echo MD3Button::filled('Filled Button'); ?&gt;<br>
&lt;?php echo MD3Button::outlined('Outlined Button'); ?&gt;<br>
&lt;?php echo MD3Button::text('Text Button'); ?&gt;<br>
&lt;?php echo MD3Button::elevated('Elevated Button'); ?&gt;<br><br>
<strong>With Icons:</strong><br>
&lt;?php echo MD3Button::filled('With Icon', null, ['data-icon' => 'star']); ?&gt;<br>
&lt;?php echo MD3Button::outlined('Download', null, ['data-icon' => 'download']); ?&gt;<br><br>
<strong>Special Cases:</strong><br>
&lt;?php echo MD3Button::filled('Disabled', null, ['disabled' => 'true']); ?&gt;<br>
&lt;?php echo MD3Button::outlined('Link Button', 'https://example.com'); ?&gt;<br>
&lt;?php echo MD3Button::text('Click Me', null, ['onclick' => 'alert(\"Hello!\")']); ?&gt;
        </div>

        <!-- Cards -->
        <h3><span class="step">2</span>Cards</h3>
        <div class="demo-area">
            <div style="max-width: 400px;">
                <div style="background: var(--md-sys-color-surface-container-low); padding: 24px; border-radius: 12px; border: 1px solid var(--md-sys-color-outline-variant);">
                    <h3 style="margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                        <?php echo MD3::icon('stars'); ?> Welcome Card
                    </h3>
                    <p style="margin: 0; color: var(--md-sys-color-on-surface-variant);">
                        This beautiful card was created with just one line of PHP code using Material3PHP!
                    </p>
                </div>
            </div>
        </div>
        <div class="code-example">
&lt;div style="background: var(--md-sys-color-surface-container-low); padding: 24px; border-radius: 12px;"&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&lt;h3&gt;&lt;?php echo MD3::icon('stars'); ?&gt; Welcome Card&lt;/h3&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;&lt;p&gt;Beautiful card content!&lt;/p&gt;<br>
&lt;/div&gt;
        </div>

        <!-- Text Fields -->
        <h3><span class="step">3</span>Text Fields</h3>
        <div class="demo-area">
            <div style="max-width: 400px;">
                <div style="margin: 16px 0;">
                    <?php echo MD3TextField::filled('name', 'Your Name'); ?>
                </div>
                <div style="margin: 16px 0;">
                    <?php echo MD3TextField::outlined('email', 'Your Email'); ?>
                </div>
            </div>
        </div>
        <div class="code-example">
&lt;?php echo MD3TextField::filled('name', 'Your Name'); ?&gt;<br>
&lt;?php echo MD3TextField::outlined('email', 'Your Email'); ?&gt;
        </div>

        <!-- Lists -->
        <h3><span class="step">4</span>Lists</h3>
        <div class="demo-area">
            <div style="max-width: 400px;">
                <?php echo MD3List::create([
                    ['title' => 'Dashboard', 'subtitle' => 'Overview and analytics', 'icon' => 'dashboard'],
                    ['title' => 'Settings', 'subtitle' => 'Configure your preferences', 'icon' => 'settings'],
                    ['title' => 'Profile', 'subtitle' => 'Manage your account', 'icon' => 'person']
                ]); ?>
            </div>
        </div>
        <div class="code-example">
&lt;?php echo MD3List::create([<br>
&nbsp;&nbsp;&nbsp;&nbsp;['title' => 'Dashboard', 'subtitle' => 'Overview', 'icon' => 'dashboard'],<br>
&nbsp;&nbsp;&nbsp;&nbsp;['title' => 'Settings', 'subtitle' => 'Configure', 'icon' => 'settings']<br>
]); ?&gt;
        </div>
    </div>

    <!-- Features -->
    <div class="section">
        <h2><?php echo MD3::icon('auto_awesome'); ?> Why Material3PHP?</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <h3><?php echo MD3::icon('speed'); ?> 2-Line Setup</h3>
                <p>Just include autoloader and initialize. No complex configuration needed!</p>
            </div>
            <div class="feature-card">
                <h3><?php echo MD3::icon('palette'); ?> Pure Material Design 3</h3>
                <p>Official Google Material Design 3 specifications, implemented in pure PHP & CSS.</p>
            </div>
            <div class="feature-card">
                <h3><?php echo MD3::icon('cloud_off'); ?> Zero Dependencies</h3>
                <p>No CDN, no external CSS files. Everything is bundled and optimized.</p>
            </div>
            <div class="feature-card">
                <h3><?php echo MD3::icon('devices'); ?> Responsive</h3>
                <p>Works perfectly on desktop, tablet, and mobile devices out of the box.</p>
            </div>
            <div class="feature-card">
                <h3><?php echo MD3::icon('dark_mode'); ?> Theme Support</h3>
                <p>Multiple themes included: default, ocean, forest, sunset, minimal.</p>
            </div>
            <div class="feature-card">
                <h3><?php echo MD3::icon('accessibility'); ?> Accessible</h3>
                <p>WCAG 2.1 AA compliant with proper ARIA labels and keyboard navigation.</p>
            </div>
        </div>
    </div>

    <!-- Getting Started -->
    <div class="section">
        <h2><?php echo MD3::icon('download'); ?> Get Started</h2>
        <div style="background: var(--md-sys-color-tertiary-container); color: var(--md-sys-color-on-tertiary-container); padding: 24px; border-radius: 12px;">
            <h3 style="margin-top: 0;">Download Material3PHP</h3>
            <ol>
                <li><strong>Download:</strong> Get the latest version from <a href="https://github.com/mmollay/material3php" style="color: var(--md-sys-color-primary);">GitHub</a></li>
                <li><strong>Include:</strong> Add the 2 lines shown above to your PHP file</li>
                <li><strong>Start Building:</strong> Use any Material3PHP component immediately!</li>
            </ol>
            <div style="margin-top: 16px;">
                <?php echo MD3Button::filled('View Full Documentation'); ?>
                <?php echo MD3Button::outlined('See Component Gallery'); ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="text-align: center; margin-top: 48px; padding-top: 24px; border-top: 1px solid var(--md-sys-color-outline-variant);">
        <p style="color: var(--md-sys-color-on-surface-variant);">
            <?php echo MD3::icon('favorite'); ?> Made with Material3PHP •
            <a href="https://m3.material.io" target="_blank" style="color: var(--md-sys-color-primary);">Material Design 3</a> •
            <a href="https://github.com/mmollay/material3php" target="_blank" style="color: var(--md-sys-color-primary);">GitHub</a>
        </p>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>