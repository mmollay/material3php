<?php
/**
 * Central Footer Include
 * Unified footer for all pages with version, links and credits
 */

// Get current version
$currentVersion = file_exists('VERSION') ? trim(file_get_contents('VERSION')) : '0.2.42';

// Get component count
$componentCount = 'unknown';
if (class_exists('MD3')) {
    try {
        $componentCount = MD3::getComponentCount();
    } catch (Exception $e) {
        $componentCount = 31; // fallback
    }
}

// Build theme parameter for links
$currentTheme = $_GET['theme'] ?? 'default';
$themeParam = $currentTheme !== 'default' ? '?theme=' . $currentTheme : '';
?>

<footer class="central-footer">
    <div class="footer-content">
        <div class="footer-main">
            <div class="footer-section">
                <h3>Material Design 3 PHP Library</h3>
                <p>Pure PHP implementation of Google's Material Design 3 system</p>
                <div class="footer-stats">
                    <span class="stat-item">
                        <?php echo MD3::icon('widgets'); ?>
                        <strong><?php echo $componentCount; ?></strong> Components
                    </span>
                    <span class="stat-item">
                        <?php echo MD3::icon('code'); ?>
                        <strong>Pure PHP</strong>
                    </span>
                    <span class="stat-item">
                        <?php echo MD3::icon('check_circle'); ?>
                        <strong>MD3 Compliant</strong>
                    </span>
                </div>
            </div>

            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="index.php<?php echo $themeParam; ?>"><?php echo MD3::icon('home'); ?> Home</a></li>
                    <li><a href="demo-extended.php<?php echo $themeParam; ?>"><?php echo MD3::icon('dashboard'); ?> Component Gallery</a></li>
                    <li><a href="playground.php<?php echo $themeParam; ?>"><?php echo MD3::icon('science'); ?> Interactive Playground</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Resources</h4>
                <ul class="footer-links">
                    <li><a href="CHANGELOG.md" target="_blank"><?php echo MD3::icon('history'); ?> Changelog</a></li>
                    <li><a href="https://github.com/mmollay/material3php" target="_blank"><?php echo MD3::icon('code'); ?> GitHub Repository</a></li>
                    <li><a href="https://m3.material.io" target="_blank"><?php echo MD3::icon('design_services'); ?> Material Design 3</a></li>
                    <li><a href="https://claude.ai/code" target="_blank"><?php echo MD3::icon('smart_toy'); ?> Built with Claude Code</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Legal</h4>
                <ul class="footer-links">
                    <li><a href="impressum.php<?php echo $themeParam; ?>"><?php echo MD3::icon('info'); ?> Legal Notice</a></li>
                    <li><a href="datenschutz.php<?php echo $themeParam; ?>"><?php echo MD3::icon('privacy_tip'); ?> Privacy Policy</a></li>
                    <li><a href="contact.php<?php echo $themeParam; ?>"><?php echo MD3::icon('contact_phone'); ?> Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Version Info</h4>
                <div class="version-info">
                    <div class="version-badge">
                        <?php echo MD3::icon('new_releases'); ?>
                        <span>v<?php echo htmlspecialchars($currentVersion); ?></span>
                    </div>
                    <p class="version-date">Updated: <?php echo date('Y-m-d'); ?></p>
                    <div class="build-info">
                        <small>
                            PHP <?php echo PHP_VERSION; ?> •
                            <?php echo $componentCount; ?> Components •
                            CSS-only Implementation
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-credits">
                <p>
                    © <?php echo date('Y'); ?> Material Design 3 PHP Library •
                    Made with <?php echo MD3::icon('favorite'); ?> for pure PHP implementations
                </p>
                <p class="claude-credit">
                    🤖 Developed with <a href="https://claude.ai/code" target="_blank">Claude Code</a> •
                    Design System by <a href="https://m3.material.io" target="_blank">Google Material Design</a>
                </p>
            </div>

            <div class="footer-actions">
                <a href="#top" class="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
                    <?php echo MD3::icon('keyboard_arrow_up'); ?>
                    <span>Back to Top</span>
                </a>
            </div>
        </div>
    </div>
</footer>

<style>
/* Central Footer Styles */
.central-footer {
    background: var(--md-sys-color-surface-container-lowest);
    border-top: 1px solid var(--md-sys-color-outline-variant);
    margin-top: 48px;
    padding: 48px 0 24px;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}

.footer-main {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
    gap: 48px;
    margin-bottom: 32px;
}

.footer-section h3 {
    color: var(--md-sys-color-primary);
    font-size: 20px;
    font-weight: 500;
    margin: 0 0 12px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.footer-section h4 {
    color: var(--md-sys-color-on-surface);
    font-size: 16px;
    font-weight: 500;
    margin: 0 0 16px 0;
}

.footer-section p {
    color: var(--md-sys-color-on-surface-variant);
    font-size: 14px;
    line-height: 1.5;
    margin: 0 0 16px 0;
}

.footer-stats {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: var(--md-sys-color-on-surface-variant);
}

.stat-item .material-symbols-outlined {
    font-size: 18px;
    color: var(--md-sys-color-primary);
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 8px;
}

.footer-links a {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--md-sys-color-on-surface-variant);
    text-decoration: none;
    font-size: 14px;
    padding: 4px 0;
    transition: color 0.2s;
}

.footer-links a:hover {
    color: var(--md-sys-color-primary);
}

.footer-links a .material-symbols-outlined {
    font-size: 16px;
}

.version-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.version-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    background: var(--md-sys-color-primary-container);
    color: var(--md-sys-color-on-primary-container);
    border-radius: 16px;
    font-size: 14px;
    font-weight: 500;
    width: fit-content;
}

.version-badge .material-symbols-outlined {
    font-size: 16px;
}

.version-date {
    font-size: 13px;
    color: var(--md-sys-color-on-surface-variant);
    margin: 0;
}

.build-info {
    padding: 8px 12px;
    background: var(--md-sys-color-surface-container);
    border-radius: 8px;
    border: 1px solid var(--md-sys-color-outline-variant);
}

.build-info small {
    color: var(--md-sys-color-on-surface-variant);
    font-size: 12px;
}

.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 24px;
    border-top: 1px solid var(--md-sys-color-outline-variant);
}

.footer-credits p {
    margin: 0 0 4px 0;
    font-size: 13px;
    color: var(--md-sys-color-on-surface-variant);
}

.footer-credits .material-symbols-outlined {
    font-size: 14px;
    color: var(--md-sys-color-error);
    vertical-align: middle;
}

.claude-credit {
    font-size: 12px !important;
}

.claude-credit a {
    color: var(--md-sys-color-primary);
    text-decoration: none;
}

.claude-credit a:hover {
    text-decoration: underline;
}

.back-to-top {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 8px 16px;
    background: var(--md-sys-color-surface-container);
    color: var(--md-sys-color-on-surface);
    text-decoration: none;
    border-radius: 20px;
    border: 1px solid var(--md-sys-color-outline);
    font-size: 14px;
    transition: all 0.2s;
}

.back-to-top:hover {
    background: var(--md-sys-color-surface-container-high);
    border-color: var(--md-sys-color-primary);
    color: var(--md-sys-color-primary);
}

.back-to-top .material-symbols-outlined {
    font-size: 16px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .footer-main {
        grid-template-columns: 1fr 1fr 1fr;
        gap: 32px;
    }
}

@media (max-width: 900px) {
    .footer-main {
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }
}

@media (max-width: 768px) {
    .central-footer {
        padding: 32px 0 16px;
    }

    .footer-content {
        padding: 0 16px;
    }

    .footer-main {
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    .footer-bottom {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }

    .footer-stats {
        flex-direction: row;
        flex-wrap: wrap;
    }
}

@media (max-width: 480px) {
    .footer-stats {
        flex-direction: column;
    }

    .footer-credits {
        text-align: center;
    }
}
</style>