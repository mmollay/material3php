<!DOCTYPE html>
<html lang="de" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datenschutz - Material Design 3 PHP Library</title>
    <meta name="description" content="Datenschutzerklärung für die Material Design 3 PHP Library - Informationen über Datenverarbeitung und Ihre Rechte">
    <meta name="robots" content="noindex, nofollow">

    <?php
    require_once 'src/MD3.php';
    require_once 'src/MD3Button.php';
    require_once 'src/MD3Card.php';
    require_once 'src/MD3Theme.php';
    require_once 'src/MD3Header.php';
    require_once 'src/MD3NavigationBar.php';
    require_once 'src/MD3Breadcrumb.php';
    require_once 'src/MD3List.php';
    require_once 'src/MD3Divider.php';

    // Get theme from URL parameter or default
    $currentTheme = $_GET['theme'] ?? 'default';

    echo MD3::init(true, true, $currentTheme);
    ?>
    <style>
    <?php
    echo MD3Theme::getThemeCSS();
    echo MD3Header::getCSS();
    echo MD3NavigationBar::getCSS();
    echo MD3Card::getCSS();
    echo MD3List::getCSS();
    echo MD3::getVersionCSS();
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
                Datenschutzerklärung
            </h1>
            <p class="page-subtitle">Informationen über die Verarbeitung Ihrer personenbezogenen Daten</p>
        </div>

        <!-- Responsible Party -->
        <div class="privacy-section">
            <?php echo MD3Card::elevated('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('person') . ' Verantwortlicher
                </h2>
                <div class="privacy-content">
                    <p>Verantwortlich für die Datenverarbeitung auf dieser Website ist:</p>
                    <div class="contact-info">
                        <div class="contact-item">
                            <span class="material-symbols-outlined contact-icon">corporate_fare</span>
                            <span class="contact-label">Unternehmen:</span>
                            <span class="contact-value"><strong>SSI - Service Support Internet</strong></span>
                        </div>
                        <div class="contact-item">
                            <span class="material-symbols-outlined contact-icon">person</span>
                            <span class="contact-label">Geschäftsführer:</span>
                            <span class="contact-value">Martin Mollay</span>
                        </div>
                        <div class="contact-item">
                            <span class="material-symbols-outlined contact-icon">location_on</span>
                            <span class="contact-label">Adresse:</span>
                            <span class="contact-value">
                                Saubersdorfergasse 14<br>
                                2700 Wiener Neustadt<br>
                                Österreich
                            </span>
                        </div>
                        <div class="contact-item">
                            <span class="material-symbols-outlined contact-icon">email</span>
                            <span class="contact-label">E-Mail:</span>
                            <span class="contact-value"><a href="mailto:office@ssi.at">office@ssi.at</a></span>
                        </div>
                        <div class="contact-item">
                            <span class="material-symbols-outlined contact-icon">phone</span>
                            <span class="contact-label">Telefon:</span>
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
                    ' . MD3::icon('data_usage') . ' Überblick der Datenverarbeitung
                </h2>
                <div class="privacy-content">
                    <p>Diese Website ist eine Demonstrationsseite für die <strong>Material Design 3 PHP Library</strong>.
                    Es werden nur die minimal notwendigen Daten verarbeitet, um die Funktionalität der Website zu gewährleisten.</p>

                    <div class="important-notice">
                        <strong>' . MD3::icon('info') . ' Wichtiger Hinweis:</strong><br>
                        Diese Website dient ausschließlich der Demonstration der MD3 PHP Library.
                        Es werden keine persönlichen Daten dauerhaft gespeichert oder an Dritte weitergegeben.
                    </div>

                    <h3>Automatisch erhobene Daten</h3>
                    <p>Beim Besuch unserer Website werden automatisch folgende Informationen erfasst:</p>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Datenart</th>
                                    <th>Zweck</th>
                                    <th>Rechtsgrundlage</th>
                                    <th>Speicherdauer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>IP-Adresse</td>
                                    <td>Technische Bereitstellung</td>
                                    <td>Berechtigtes Interesse (Art. 6 Abs. 1 lit. f DSGVO)</td>
                                    <td>7 Tage (Server-Logs)</td>
                                </tr>
                                <tr>
                                    <td>Browser-Informationen</td>
                                    <td>Kompatibilität, Fehleranalyse</td>
                                    <td>Berechtigtes Interesse (Art. 6 Abs. 1 lit. f DSGVO)</td>
                                    <td>Sessionbasiert</td>
                                </tr>
                                <tr>
                                    <td>Zugriffszeitpunkt</td>
                                    <td>Sicherheit, Analyse</td>
                                    <td>Berechtigtes Interesse (Art. 6 Abs. 1 lit. f DSGVO)</td>
                                    <td>7 Tage (Server-Logs)</td>
                                </tr>
                                <tr>
                                    <td>Theme-Präferenzen</td>
                                    <td>Benutzerfreundlichkeit</td>
                                    <td>Berechtigtes Interesse (Art. 6 Abs. 1 lit. f DSGVO)</td>
                                    <td>Local Storage (browserbasiert)</td>
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
                    ' . MD3::icon('contact_mail') . ' Kontaktformular
                </h2>
                <div class="privacy-content">
                    <p>Wenn Sie unser Kontaktformular nutzen, verarbeiten wir folgende Daten:</p>
                    <ul>
                        <li><strong>Name:</strong> Zur persönlichen Ansprache</li>
                        <li><strong>E-Mail-Adresse:</strong> Zur Beantwortung Ihrer Anfrage</li>
                        <li><strong>Unternehmen (optional):</strong> Für geschäftliche Kontexte</li>
                        <li><strong>Telefonnummer (optional):</strong> Für direkten Kontakt</li>
                        <li><strong>Nachrichteninhalt:</strong> Zur Bearbeitung Ihres Anliegens</li>
                    </ul>

                    <h3>Rechtsgrundlage</h3>
                    <p>Die Verarbeitung erfolgt auf Basis Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO)
                    und zur Erfüllung vorvertraglicher Maßnahmen (Art. 6 Abs. 1 lit. b DSGVO).</p>

                    <h3>Speicherdauer</h3>
                    <p>Ihre Kontaktdaten werden für die Dauer der Bearbeitung Ihrer Anfrage plus
                    3 Jahre zur Dokumentation gespeichert, sofern keine gesetzlichen Aufbewahrungspflichten bestehen.</p>
                </div>
            '); ?>
        </div>

        <!-- Your Rights -->
        <div class="privacy-section">
            <?php echo MD3Card::elevated('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('gavel') . ' Ihre Rechte
                </h2>
                <div class="privacy-content">
                    <p>Sie haben folgende Rechte bezüglich Ihrer personenbezogenen Daten:</p>
                    <ul>
                        <li><strong>Auskunftsrecht (Art. 15 DSGVO):</strong> Sie können Auskunft über die von uns verarbeiteten personenbezogenen Daten verlangen.</li>
                        <li><strong>Berichtigungsrecht (Art. 16 DSGVO):</strong> Sie können die Berichtigung unrichtiger oder die Vervollständigung unvollständiger Daten verlangen.</li>
                        <li><strong>Löschungsrecht (Art. 17 DSGVO):</strong> Sie können die Löschung Ihrer personenbezogenen Daten verlangen.</li>
                        <li><strong>Einschränkungsrecht (Art. 18 DSGVO):</strong> Sie können die Einschränkung der Verarbeitung verlangen.</li>
                        <li><strong>Datenübertragbarkeit (Art. 20 DSGVO):</strong> Sie können die Übertragung Ihrer Daten in einem strukturierten Format verlangen.</li>
                        <li><strong>Widerspruchsrecht (Art. 21 DSGVO):</strong> Sie können der Verarbeitung Ihrer Daten widersprechen.</li>
                        <li><strong>Beschwerderecht:</strong> Sie können sich bei einer Aufsichtsbehörde beschweren.</li>
                    </ul>

                    <div class="important-notice">
                        <strong>' . MD3::icon('contact_phone') . ' Kontakt für Datenschutzanfragen:</strong><br>
                        E-Mail: <a href="mailto:office@ssi.at">office@ssi.at</a><br>
                        Telefon: <a href="tel:+4365025226266">+43 650 25 26 266</a>
                    </div>
                </div>
            '); ?>
        </div>

        <!-- Technical Information -->
        <div class="privacy-section">
            <?php echo MD3Card::outlined('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('settings') . ' Technische Informationen
                </h2>
                <div class="privacy-content">
                    <h3>Cookies und Local Storage</h3>
                    <p>Diese Website verwendet minimale technische Speicherung:</p>
                    <ul>
                        <li><strong>Theme-Einstellungen:</strong> Ihre Farbschema-Präferenzen werden im Browser Local Storage gespeichert</li>
                        <li><strong>Session-Daten:</strong> Temporäre Daten für die Funktionalität der Website</li>
                        <li><strong>Keine Tracking-Cookies:</strong> Wir verwenden keine Cookies für Tracking oder Analyse</li>
                    </ul>

                    <h3>Hosting und Server</h3>
                    <p>Diese Website wird in Österreich gehostet. Server-Logs werden für maximal 7 Tage zu Sicherheitszwecken aufbewahrt.</p>

                    <h3>Keine Drittanbieter-Services</h3>
                    <p>Diese Demonstrationsseite nutzt keine externen Analyse-Tools, Social Media Plugins oder andere Drittanbieter-Services,
                    die Ihre Daten verarbeiten könnten.</p>
                </div>
            '); ?>
        </div>

        <!-- Updates -->
        <div class="privacy-section">
            <?php echo MD3Card::surface('
                <h2 style="color: var(--md-sys-color-primary); margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    ' . MD3::icon('update') . ' Änderungen dieser Datenschutzerklärung
                </h2>
                <div class="privacy-content">
                    <p>Wir behalten uns vor, diese Datenschutzerklärung bei Bedarf anzupassen, um sie an geänderte Rechtslagen
                    oder bei Änderungen unserer Dienste anzupassen. Die jeweils aktuelle Datenschutzerklärung ist
                    stets unter dieser Adresse abrufbar.</p>

                    <p><strong>Stand dieser Datenschutzerklärung:</strong> <?php echo date('d.m.Y'); ?></p>

                    <div class="important-notice">
                        <strong>' . MD3::icon('info') . ' Open Source Projekt:</strong><br>
                        Diese Material Design 3 PHP Library ist ein Open Source Projekt.
                        Der Quellcode ist öffentlich auf <a href="https://github.com/mmollay/material3php" target="_blank">GitHub</a> verfügbar.
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

    <?php
    echo MD3Header::getScript();
    echo MD3Theme::getThemeScript();
    ?>

</body>
</html>