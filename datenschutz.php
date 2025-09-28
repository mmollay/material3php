<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Material Design 3 PHP Library</title>
    <meta name="description" content="Privacy Policy for the Material Design 3 PHP Library - Information about data processing and your rights">
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
            max-width: 900px;
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

        .privacy-section {
            margin-bottom: 32px;
        }

        .privacy-content {
            line-height: 1.6;
        }

        .privacy-content h3 {
            color: var(--md-sys-color-primary);
            margin: 24px 0 12px 0;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .privacy-content p {
            color: var(--md-sys-color-on-surface-variant);
            margin: 0 0 16px 0;
        }

        .privacy-content ul {
            color: var(--md-sys-color-on-surface-variant);
            margin: 0 0 16px 0;
            padding-left: 20px;
        }

        .privacy-content li {
            margin-bottom: 8px;
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

        .important-notice {
            background: var(--md-sys-color-secondary-container);
            color: var(--md-sys-color-on-secondary-container);
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
        }

        .table-container {
            overflow-x: auto;
            margin: 16px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--md-sys-color-surface);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--md-sys-color-outline-variant);
        }

        .data-table th {
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            padding: 12px;
            text-align: left;
            font-weight: 500;
        }

        .data-table td {
            padding: 12px;
            border-top: 1px solid var(--md-sys-color-outline-variant);
            color: var(--md-sys-color-on-surface);
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

            .data-table {
                font-size: 13px;
            }

            .data-table th,
            .data-table td {
                padding: 8px;
            }
        }
    </style>

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h1 class="page-title">
                <?php echo MD3::icon('privacy_tip'); ?>
                Privacy Policy
            </h1>
            <p class="page-subtitle">Information about the processing of your personal data</p>
        </div>

        <!-- Responsible Party -->
        <div class="privacy-section">
            <?php echo MD3Card::elevated('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('person') . ' Data Controller
                </h2>
                <div class="privacy-content">
                    <p>Responsible for data processing on this website:</p>
                    <div class="contact-info">
                        <div class="contact-item">
                            <span class="material-symbols-outlined contact-icon">corporate_fare</span>
                            <span class="contact-label">Company:</span>
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
                        <div class="contact-item">
                            <span class="material-symbols-outlined contact-icon">email</span>
                            <span class="contact-label">E-Mail:</span>
                            <span class="contact-value"><a href="mailto:office@ssi.at">office@ssi.at</a></span>
                        </div>
                        <div class="contact-item">
                            <span class="material-symbols-outlined contact-icon">phone</span>
                            <span class="contact-label">Phone:</span>
                            <span class="contact-value"><a href="tel:+4365025226266">+43 650 25 26 266</a></span>
                        </div>
                    </div>
                </div>
            '); ?>
        </div>

        <!-- Data Processing Overview -->
        <div class="privacy-section">
            <?php echo MD3Card::outlined('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('data_usage') . ' Data Processing Overview
                </h2>
                <div class="privacy-content">
                    <p>This website is a demonstration site for the <strong>Material Design 3 PHP Library</strong>.
                    Only the minimally necessary data is processed to ensure the functionality of the website.</p>

                    <div class="important-notice">
                        <strong>' . MD3::icon('info') . ' Important Notice:</strong><br>
                        This website serves exclusively as a demonstration of the MD3 PHP Library.
                        No personal data is permanently stored or shared with third parties.
                    </div>

                    <h3>Automatically Collected Data</h3>
                    <p>When visiting our website, the following information is automatically collected:</p>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Data Type</th>
                                    <th>Purpose</th>
                                    <th>Legal Basis</th>
                                    <th>Storage Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>IP Address</td>
                                    <td>Technical provision</td>
                                    <td>Legitimate interest (Art. 6 Para. 1 lit. f GDPR)</td>
                                    <td>7 days (Server logs)</td>
                                </tr>
                                <tr>
                                    <td>Browser information</td>
                                    <td>Compatibility, error analysis</td>
                                    <td>Legitimate interest (Art. 6 Para. 1 lit. f GDPR)</td>
                                    <td>Session-based</td>
                                </tr>
                                <tr>
                                    <td>Access time</td>
                                    <td>Security, analysis</td>
                                    <td>Legitimate interest (Art. 6 Para. 1 lit. f GDPR)</td>
                                    <td>7 days (Server logs)</td>
                                </tr>
                                <tr>
                                    <td>Theme preferences</td>
                                    <td>User experience</td>
                                    <td>Legitimate interest (Art. 6 Para. 1 lit. f GDPR)</td>
                                    <td>Local Storage (browser-based)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            '); ?>
        </div>

        <!-- Contact Form -->
        <div class="privacy-section">
            <?php echo MD3Card::surface('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('contact_mail') . ' Contact Form
                </h2>
                <div class="privacy-content">
                    <p>When you use our contact form, we process the following data:</p>
                    <ul>
                        <li><strong>Name:</strong> For personal addressing</li>
                        <li><strong>Email address:</strong> To respond to your inquiry</li>
                        <li><strong>Company (optional):</strong> For business contexts</li>
                        <li><strong>Phone number (optional):</strong> For direct contact</li>
                        <li><strong>Message content:</strong> To process your request</li>
                    </ul>

                    <h3>Legal Basis</h3>
                    <p>Processing is based on your consent (Art. 6 Para. 1 lit. a GDPR)
                    and for the performance of pre-contractual measures (Art. 6 Para. 1 lit. b GDPR).</p>

                    <h3>Storage Duration</h3>
                    <p>Your contact data will be stored for the duration of processing your inquiry plus
                    3 years for documentation purposes, unless legal retention obligations exist.</p>
                </div>
            '); ?>
        </div>

        <!-- Your Rights -->
        <div class="privacy-section">
            <?php echo MD3Card::elevated('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('gavel') . ' Your Rights
                </h2>
                <div class="privacy-content">
                    <p>You have the following rights regarding your personal data:</p>
                    <ul>
                        <li><strong>Right to access (Art. 15 GDPR):</strong> You can request information about the personal data we process.</li>
                        <li><strong>Right to rectification (Art. 16 GDPR):</strong> You can request the correction of incorrect or completion of incomplete data.</li>
                        <li><strong>Right to erasure (Art. 17 GDPR):</strong> You can request the deletion of your personal data.</li>
                        <li><strong>Right to restriction (Art. 18 GDPR):</strong> You can request the restriction of processing.</li>
                        <li><strong>Data portability (Art. 20 GDPR):</strong> You can request the transfer of your data in a structured format.</li>
                        <li><strong>Right to object (Art. 21 GDPR):</strong> You can object to the processing of your data.</li>
                        <li><strong>Right to complain:</strong> You can file a complaint with a supervisory authority.</li>
                    </ul>

                    <div class="important-notice">
                        <strong>' . MD3::icon('contact_phone') . ' Contact for privacy inquiries:</strong><br>
                        Email: <a href="mailto:office@ssi.at">office@ssi.at</a><br>
                        Phone: <a href="tel:+4365025226266">+43 650 25 26 266</a>
                    </div>
                </div>
            '); ?>
        </div>

        <!-- Technical Information -->
        <div class="privacy-section">
            <?php echo MD3Card::outlined('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('settings') . ' Technical Information
                </h2>
                <div class="privacy-content">
                    <h3>Cookies and Local Storage</h3>
                    <p>This website uses minimal technical storage:</p>
                    <ul>
                        <li><strong>Theme settings:</strong> Your color scheme preferences are stored in browser Local Storage</li>
                        <li><strong>Session data:</strong> Temporary data for website functionality</li>
                        <li><strong>No tracking cookies:</strong> We do not use cookies for tracking or analytics</li>
                    </ul>

                    <h3>Hosting and Server</h3>
                    <p>This website is hosted in Austria. Server logs are kept for a maximum of 7 days for security purposes.</p>

                    <h3>No Third-party Services</h3>
                    <p>This demonstration site does not use external analytics tools, social media plugins, or other third-party services
                    that could process your data.</p>
                </div>
            '); ?>
        </div>

        <!-- Updates -->
        <div class="privacy-section">
            <?php echo MD3Card::surface('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('update') . ' Changes to this Privacy Policy
                </h2>
                <div class="privacy-content">
                    <p>We reserve the right to adapt this privacy policy as needed to comply with changed legal situations
                    or when changes are made to our services. The current privacy policy is
                    always available at this address.</p>

                    <p><strong>Last updated:</strong> <?php echo date('d.m.Y'); ?></p>

                    <div class="important-notice">
                        <strong>' . MD3::icon('info') . ' Open Source Project:</strong><br>
                        This Material Design 3 PHP Library is an open source project.
                        The source code is publicly available on <a href="https://github.com/mmollay/material3php" target="_blank">GitHub</a>.
                    </div>
                </div>
            '); ?>
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