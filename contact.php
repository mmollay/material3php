<!DOCTYPE html>
<html lang="de" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt - Material Design 3 PHP Library</title>
    <meta name="description" content="Kontaktieren Sie SSI - Martin Mollay für Fragen zur Material Design 3 PHP Library und professionelle Webentwicklung">
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

        .contact-section {
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

        .contact-form {
            display: grid;
            gap: 20px;
            margin-top: 24px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .business-hours {
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
        }

        .response-times {
            background: var(--md-sys-color-secondary-container);
            color: var(--md-sys-color-on-secondary-container);
            padding: 16px;
            border-radius: 12px;
            margin: 16px 0;
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

            .form-row {
                grid-template-columns: 1fr;
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

            .form-actions {
                justify-content: stretch;
            }

            .form-actions button {
                flex: 1;
            }
        }
    </style>

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h1 class="page-title">
                <?php echo MD3::icon('contact_phone'); ?>
                Kontakt
            </h1>
            <p class="page-subtitle">Nehmen Sie Kontakt mit uns auf - wir helfen gerne weiter</p>
        </div>

        <!-- Contact Information -->
        <div class="contact-section">
            <?php echo MD3Card::elevated('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('person') . ' Direkter Kontakt
                </h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">person</span>
                        <span class="contact-label">Ansprechpartner:</span>
                        <span class="contact-value"><strong>Martin Mollay</strong><br>Geschäftsführer</span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">phone</span>
                        <span class="contact-label">Telefon:</span>
                        <span class="contact-value"><a href="tel:+4365025226266">+43 650 25 26 266</a></span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">email</span>
                        <span class="contact-label">E-Mail:</span>
                        <span class="contact-value"><a href="mailto:office@ssi.at">office@ssi.at</a></span>
                    </div>
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">location_on</span>
                        <span class="contact-label">Adresse:</span>
                        <span class="contact-value">
                            SSI - Service Support Internet<br>
                            Saubersdorfergasse 14<br>
                            2700 Wiener Neustadt<br>
                            Österreich
                        </span>
                    </div>
                </div>
                <div class="business-hours">
                    <strong>' . MD3::icon('schedule') . ' Geschäftszeiten:</strong><br>
                    Montag - Samstag: 08:00 - 18:00 Uhr
                </div>
                <div class="response-times">
                    <strong>' . MD3::icon('schedule_send') . ' Antwortzeiten:</strong><br>
                    E-Mail: Innerhalb von 24 Stunden<br>
                    Telefon: Sofort während der Geschäftszeiten
                </div>
            '); ?>
        </div>

        <!-- Contact Form -->
        <div class="contact-section">
            <?php echo MD3Card::outlined('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('mail') . ' Nachricht senden
                </h2>
                <p style="color: var(--md-sys-color-on-surface-variant); margin: 0 0 24px 0;">
                    Haben Sie Fragen zur Material Design 3 PHP Library oder benötigen Sie Unterstützung bei Ihrem Projekt? Kontaktieren Sie uns gerne!
                </p>
                <form class="contact-form" action="#" method="POST" onsubmit="return submitContactForm(event)">
                    <div class="form-row">
                        <div class="form-field">
                            ' . MD3TextField::filled('name', 'Ihr Name', ['required' => true]) . '
                        </div>
                        <div class="form-field">
                            ' . MD3TextField::filled('email', 'E-Mail Adresse', ['required' => true, 'type' => 'email']) . '
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-field">
                            ' . MD3TextField::filled('company', 'Unternehmen (optional)') . '
                        </div>
                        <div class="form-field">
                            ' . MD3TextField::filled('phone', 'Telefon (optional)', ['type' => 'tel']) . '
                        </div>
                    </div>
                    <div class="form-field">
                        ' . MD3TextField::filled('subject', 'Betreff', ['required' => true]) . '
                    </div>
                    <div class="form-field">
                        ' . MD3TextField::filled('message', 'Ihre Nachricht', ['required' => true, 'rows' => 6, 'multiline' => true]) . '
                    </div>
                    <div class="form-actions">
                        ' . MD3Button::text('Zurücksetzen', ['type' => 'reset', 'onclick' => 'resetContactForm()']) . '
                        ' . MD3Button::filled('Nachricht senden', ['type' => 'submit']) . '
                    </div>
                </form>
            '); ?>
        </div>

        <!-- Project Support -->
        <div class="contact-section">
            <?php echo MD3Card::surface('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('support') . ' Material Design 3 PHP Support
                </h2>
                <p style="color: var(--md-sys-color-on-surface-variant); margin: 0 0 16px 0;">
                    Die Material Design 3 PHP Library ist ein Open-Source-Projekt. Für Support und Beiträge:
                </p>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="material-symbols-outlined contact-icon">bug_report</span>
                        <span class="contact-label">Issues & Bugs:</span>
                        <span class="contact-value"><a href="https://github.com/mmollay/material3php/issues" target="_blank">GitHub Issues</a></span>
                    </div>
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
                </div>
            '); ?>
        </div>

        <!-- Navigation Back -->
        <div style="margin-top: 32px; text-align: center;">
            <?php
            $themeParam = $currentTheme !== 'default' ? '?theme=' . $currentTheme : '';
            echo '<a href="index.php' . $themeParam . '" style="text-decoration: none;">';
            echo MD3Button::outlined('← Zurück zur Startseite');
            echo '</a>';
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
    function submitContactForm(event) {
        event.preventDefault();

        // Get form data
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());

        // Basic validation
        if (!data.name || !data.email || !data.subject || !data.message) {
            showSnackbar('Bitte füllen Sie alle Pflichtfelder aus.', 'error');
            return false;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(data.email)) {
            showSnackbar('Bitte geben Sie eine gültige E-Mail-Adresse ein.', 'error');
            return false;
        }

        // Simulate form submission
        showSnackbar('Nachricht wird gesendet...', 'info');

        setTimeout(() => {
            showSnackbar('Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet. Wir melden uns bald bei Ihnen.', 'success');
            event.target.reset();
        }, 1500);

        return false;
    }

    function resetContactForm() {
        showSnackbar('Formular wurde zurückgesetzt.', 'info');
    }

    function showSnackbar(message, type = 'info') {
        // Create snackbar using MD3 components
        const snackbar = document.createElement('div');
        snackbar.className = 'md3-snackbar ' + (type === 'error' ? 'error' : type === 'success' ? 'success' : 'info');
        snackbar.innerHTML = message;
        snackbar.style.cssText = `
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--md-sys-color-inverse-surface);
            color: var(--md-sys-color-inverse-on-surface);
            padding: 12px 16px;
            border-radius: 8px;
            box-shadow: var(--md-sys-elevation-3);
            z-index: 1000;
            max-width: 400px;
            text-align: center;
            animation: slideUp 0.3s ease;
        `;

        document.body.appendChild(snackbar);

        setTimeout(() => {
            snackbar.style.animation = 'slideDown 0.3s ease';
            setTimeout(() => document.body.removeChild(snackbar), 300);
        }, 3000);
    }
    </script>

    <style>
    @keyframes slideUp {
        from { transform: translateX(-50%) translateY(100%); opacity: 0; }
        to { transform: translateX(-50%) translateY(0); opacity: 1; }
    }

    @keyframes slideDown {
        from { transform: translateX(-50%) translateY(0); opacity: 1; }
        to { transform: translateX(-50%) translateY(100%); opacity: 0; }
    }

    .md3-snackbar.success {
        background: var(--md-sys-color-primary-container) !important;
        color: var(--md-sys-color-on-primary-container) !important;
    }

    .md3-snackbar.error {
        background: var(--md-sys-color-error-container) !important;
        color: var(--md-sys-color-on-error-container) !important;
    }
    </style>

    <?php
    echo MD3Header::getScript();
    echo MD3Theme::getThemeScript();
    ?>

</body>
</html>