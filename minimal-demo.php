<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Material3PHP - Minimal Demo</title>

    <!-- Just 2 lines needed! -->
    <?php require_once 'autoload.php'; ?>
    <?php
    $currentTheme = $_GET['theme'] ?? 'default';
    echo MD3::init(true, true, $currentTheme);
    ?>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div style="max-width: 800px; margin: 0 auto; padding: 24px;">
        <h1><?php echo MD3::icon('celebration'); ?> It works!</h1>

    <p>This page only needs 2 lines of PHP to get beautiful Material Design 3 components:</p>

    <div style="margin: 24px 0;">
        <?php echo MD3Button::filled('Amazing!'); ?>
        <?php echo MD3Button::outlined('So Simple'); ?>
        <?php echo MD3Button::text('No Setup'); ?>
    </div>

    <?php echo MD3Card::create([
        'title' => MD3::icon('rocket_launch') . ' Ready to go!',
        'content' => 'Material3PHP gives you production-ready Material Design 3 components with zero configuration. Just include and start building!'
    ]); ?>

    <div style="margin: 24px 0;">
        <?php echo MD3TextField::filled('demo', 'Try typing here...'); ?>
    </div>

        <div style="margin-top: 32px; padding: 16px; background: var(--md-sys-color-primary-container); border-radius: 8px; color: var(--md-sys-color-on-primary-container);">
            <strong>That's it!</strong> No CSS files, no CDN links, no complex setup. Pure PHP power! 🚀
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>