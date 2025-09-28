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

        .page-subtitle {
            color: var(--md-sys-color-on-surface-variant);
            font-size: 1rem;
            margin: 0;
        }

        .legal-section {
            margin-bottom: 32px;
        }

        .contact-info {
            display: grid;
            gap: 16px;
            margin-top: 24px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
        }

        .contact-icon {
            color: var(--md-sys-color-primary);
            font-size: 20px;
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

        .disclaimer {
            background: var(--md-sys-color-surface-container-lowest);
            border: 1px solid var(--md-sys-color-outline-variant);
            border-radius: 12px;
            padding: 20px;
            margin-top: 32px;
        }

        .disclaimer h3 {
            color: var(--md-sys-color-on-surface);
            margin: 0 0 12px 0;
        }

        .disclaimer p {
            color: var(--md-sys-color-on-surface-variant);
            font-size: 13px;
            line-height: 1.5;
            margin: 0;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 0 16px 48px;
            }

            .page-title {
                font-size: 1.5rem;
                flex-direction: column;
                gap: 8px;
            }

            .contact-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .contact-label {
                min-width: unset;
                font-size: 14px;
            }
        }
    </style>

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h1 class="page-title">
                <?php echo MD3::icon('info'); ?>
                Legal Notice
            </h1>
            <p class="page-subtitle">Legal information according to Austrian law</p>
        </div>

        <!-- Company Information -->
        <div class="legal-section">
            <?php echo MD3Card::elevated('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('business') . ' Company Information
                </h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">corporate_fare</span>
                        <span class="contact-label">Company Name:</span>
                        <span class="contact-value"><strong>SSI - Service Support Internet</strong></span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">person</span>
                        <span class="contact-label">CEO:</span>
                        <span class="contact-value">Martin Mollay</span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">location_on</span>
                        <span class="contact-label">Address:</span>
                        <span class="contact-value">
                            Saubersdorfergasse 14<br>
                            2700 Wiener Neustadt<br>
                            Austria
                        </span>
                    </div>
                </div>
            '); ?>
        </div>

        <!-- Contact Information -->
        <div class="legal-section">
            <?php echo MD3Card::elevated('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('contact_phone') . ' Contact Information
                </h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">phone</span>
                        <span class="contact-label">Phone:</span>
                        <span class="contact-value"><a href="tel:+4365025226266">+43 650 25 26 266</a></span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">email</span>
                        <span class="contact-label">E-Mail:</span>
                        <span class="contact-value"><a href="mailto:office@ssi.at">office@ssi.at</a></span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">language</span>
                        <span class="contact-label">Website:</span>
                        <span class="contact-value"><a href="https://www.ssi.at" target="_blank">www.ssi.at</a></span>
                    </div>
                </div>
                <div class="business-hours">
                    <strong>' . MD3::icon('schedule') . ' Business Hours:</strong><br>
                    Monday - Saturday: 08:00 - 18:00 (CET)
                </div>
            '); ?>
        </div>

        <!-- Legal Information -->
        <div class="legal-section">
            <?php echo MD3Card::elevated('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('gavel') . ' Legal Information
                </h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">receipt_long</span>
                        <span class="contact-label">VAT Number:</span>
                        <span class="contact-value">ATU 41596803</span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">account_balance</span>
                        <span class="contact-label">Tax Number:</span>
                        <span class="contact-value">425 / 4315 (Tax Office Wiener Neustadt)</span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">business_center</span>
                        <span class="contact-label">Member of:</span>
                        <span class="contact-value">Austrian Chamber of Commerce</span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">policy</span>
                        <span class="contact-label">Applicable Law:</span>
                        <span class="contact-value">Austrian Law</span>
                    </div>
                </div>
            '); ?>
        </div>

        <!-- Banking Information -->
        <div class="legal-section">
            <?php echo MD3Card::outlined('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('account_balance') . ' Banking Information
                </h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">credit_card</span>
                        <span class="contact-label">IBAN:</span>
                        <span class="contact-value">AT53 3293 7000 0060 8745</span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">location_city</span>
                        <span class="contact-label">BIC:</span>
                        <span class="contact-value">RLNWATWWWRN KAD</span>
                    </div>
                </div>
            '); ?>
        </div>

        <!-- Project Information -->
        <div class="legal-section">
            <?php echo MD3Card::surface('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('code') . ' About this Project
                </h2>
                <p style="color: var(--md-sys-color-on-surface-variant); margin: 0 0 16px 0;">
                    The <strong>Material Design 3 PHP Library</strong> is an open source implementation of Google's Material Design 3 system in pure PHP.
                </p>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">code</span>
                        <span class="contact-label">Repository:</span>
                        <span class="contact-value"><a href="https://github.com/mmollay/material3php" target="_blank">github.com/mmollay/material3php</a></span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">new_releases</span>
                        <span class="contact-label">Version:</span>
                        <span class="contact-value">v' . (file_exists('VERSION') ? trim(file_get_contents('VERSION')) : '0.2.42') . '</span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">smart_toy</span>
                        <span class="contact-label">Developed with:</span>
                        <span class="contact-value"><a href="https://claude.ai/code" target="_blank">Claude Code</a></span>
                    </div>
                </div>
            '); ?>
        </div>

        <!-- Disclaimer -->
        <div class="disclaimer">
            <h3><?php echo MD3::icon('warning'); ?> Disclaimer</h3>
            <p>
                The contents of this website have been created with the greatest care. However, we cannot guarantee the accuracy, completeness and timeliness of the content. As service providers, we are responsible for our own content on these pages according to general laws pursuant to Section 7, Paragraph 1 of the German Telemedia Act (TMG).
            </p>
        </div>

        <!-- Navigation Back -->
        <div style="margin-top: 32px; text-align: center;">
            <?php
            $themeParam = $currentTheme !== 'default' ? '?theme=' . $currentTheme : '';
            echo '<a href="index.php' . $themeParam . '" style="text-decoration: none;">';
            echo MD3Button::outlined('← Back to Homepage');
            echo '</a>';
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <?php
    echo MD3Theme::getThemeScript();
    ?>

</body>
</html>