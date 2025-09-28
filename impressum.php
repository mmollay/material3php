<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legal Notice - Material Design 3 PHP Library</title>
    <meta name="description" content="Legal notice and information about the Material Design 3 PHP Library by SSI - Martin Mollay">
    <meta name="robots" content="noindex, nofollow">

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
    ?>
        body {
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .content-wrapper {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 24px 48px;
        }

        .page-header {
            padding: 32px 0;
            text-align: center;
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
            margin-bottom: 32px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 400;
            color: var(--md-sys-color-primary);
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .demo-section {
            margin-bottom: 24px;
        }

        .contact-info {
            display: grid;
            gap: 16px;
            margin-top: 24px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 8px 0;
        }

        .contact-icon {
            color: var(--md-sys-color-primary);
            font-size: 20px;
            margin-top: 2px;
        }

        .contact-label {
            font-weight: 500;
            color: var(--md-sys-color-on-surface);
            min-width: 120px;
        }

        .contact-value {
            color: var(--md-sys-color-on-surface-variant);
        }

        .contact-value a {
            color: var(--md-sys-color-primary);
            text-decoration: none;
        }

        .contact-value a:hover {
            text-decoration: underline;
        }

        .business-hours {
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h1 class="page-title">Legal Notice</h1>
            <p>Legal information according to Austrian law</p>
        </div>

        <!-- Company Information -->
        <div class="demo-section">
            <div class="md-card md-card--elevated" style="padding: 24px; margin: 16px 0; border-radius: 12px; background: var(--md-sys-color-surface-container-low); box-shadow: 0 1px 3px rgba(0,0,0,0.12);">
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    <?php echo MD3::icon('business'); ?> Company Information
                </h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('corporate_fare'); ?></span>
                        <span class="contact-label">Company Name:</span>
                        <span class="contact-value"><strong>SSI - Service Support Internet</strong></span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('person'); ?></span>
                        <span class="contact-label">CEO:</span>
                        <span class="contact-value">Martin Mollay</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('location_on'); ?></span>
                        <span class="contact-label">Address:</span>
                        <span class="contact-value">
                            Saubersdorfergasse 14<br>
                            2700 Wiener Neustadt<br>
                            Austria
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="demo-section">
            <div class="md-card md-card--elevated" style="padding: 24px; margin: 16px 0; border-radius: 12px; background: var(--md-sys-color-surface-container-low); box-shadow: 0 1px 3px rgba(0,0,0,0.12);">
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    <?php echo MD3::icon('contact_phone'); ?> Contact Information
                </h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('phone'); ?></span>
                        <span class="contact-label">Phone:</span>
                        <span class="contact-value"><a href="tel:+4365025226266">+43 650 25 26 266</a></span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('email'); ?></span>
                        <span class="contact-label">E-Mail:</span>
                        <span class="contact-value"><a href="mailto:office@ssi.at">office@ssi.at</a></span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('language'); ?></span>
                        <span class="contact-label">Website:</span>
                        <span class="contact-value"><a href="https://www.ssi.at" target="_blank">www.ssi.at</a></span>
                    </div>
                    <div class="business-hours">
                        <strong><?php echo MD3::icon('schedule'); ?> Business Hours:</strong><br>
                        Monday - Saturday: 08:00 - 18:00 (CET)
                    </div>
                </div>
            </div>
        </div>

        <!-- Legal Information -->
        <div class="demo-section">
            <div class="md-card md-card--elevated" style="padding: 24px; margin: 16px 0; border-radius: 12px; background: var(--md-sys-color-surface-container-low); box-shadow: 0 1px 3px rgba(0,0,0,0.12);">
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    <?php echo MD3::icon('gavel'); ?> Legal Information
                </h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('receipt_long'); ?></span>
                        <span class="contact-label">VAT Number:</span>
                        <span class="contact-value">ATU 41596803</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('account_balance'); ?></span>
                        <span class="contact-label">Tax Number:</span>
                        <span class="contact-value">425 / 4315 (Tax Office Wiener Neustadt)</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('business_center'); ?></span>
                        <span class="contact-label">Member of:</span>
                        <span class="contact-value">Austrian Chamber of Commerce</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon"><?php echo MD3::icon('policy'); ?></span>
                        <span class="contact-label">Applicable Law:</span>
                        <span class="contact-value">Austrian Law</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Back -->
        <div style="margin-top: 32px; text-align: center;">
            <?php
            $themeParam = $currentTheme !== 'default' ? '?theme=' . $currentTheme : '';
            echo '<a href="index.php' . $themeParam . '" style="padding: 12px 24px; border: 1px solid var(--md-sys-color-primary); background: transparent; color: var(--md-sys-color-primary); border-radius: 20px; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">';
            echo MD3::icon('arrow_back') . ' Back to Homepage';
            echo '</a>';
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>