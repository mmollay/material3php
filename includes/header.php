<?php
/**
 * Central Header Include
 * Based on the playground header design with navigation menu
 */

// Determine current page
$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
$currentTheme = $_GET['theme'] ?? 'default';
$currentComponent = $_GET['component'] ?? '';

// Page configurations
$pageConfigs = [
    'index.php' => [
        'title' => 'Material Design 3 PHP Library',
        'icon' => 'home'
    ],
    'demo-extended.php' => [
        'title' => 'Component Gallery',
        'icon' => 'dashboard'
    ],
    'playground.php' => [
        'title' => 'MD3 Playground',
        'icon' => 'science'
    ],
    'contact.php' => [
        'title' => 'Kontakt',
        'icon' => 'contact_phone'
    ],
    'impressum.php' => [
        'title' => 'Impressum',
        'icon' => 'info'
    ],
    'datenschutz.php' => [
        'title' => 'Datenschutz',
        'icon' => 'privacy_tip'
    ],
];

$currentPage = $pageConfigs[$currentScript] ?? [
    'title' => 'Material Design 3 PHP Library',
    'icon' => 'home'
];

// Navigation menu items
$navMenuItems = [
    [
        'href' => 'index.php',
        'icon' => 'home',
        'label' => 'Home',
        'active' => $currentScript === 'index.php'
    ],
    [
        'href' => 'demo-extended.php',
        'icon' => 'dashboard',
        'label' => 'Gallery',
        'active' => $currentScript === 'demo-extended.php'
    ],
    [
        'href' => 'playground.php',
        'icon' => 'science',
        'label' => 'Playground',
        'active' => $currentScript === 'playground.php'
    ],
    [
        'type' => 'divider'
    ],
    [
        'href' => 'contact.php',
        'icon' => 'contact_phone',
        'label' => 'Kontakt',
        'active' => $currentScript === 'contact.php'
    ],
    [
        'href' => 'impressum.php',
        'icon' => 'info',
        'label' => 'Impressum',
        'active' => $currentScript === 'impressum.php'
    ],
];
?>

<header class="central-header">
    <div class="header-main">
        <div class="header-left">
            <!-- Navigation Menu -->
            <div class="nav-menu-container">
                <button class="nav-menu-toggle" onclick="toggleNavMenu()" id="nav-menu-toggle">
                    <?php echo MD3::icon('menu'); ?>
                    <span class="nav-menu-label">Menu</span>
                    <?php echo MD3::icon('expand_more'); ?>
                </button>
                <div class="nav-menu-dropdown" id="nav-menu-dropdown">
                    <?php foreach ($navMenuItems as $item): ?>
                        <?php if (isset($item['type']) && $item['type'] === 'divider'): ?>
                            <div class="nav-menu-divider"></div>
                        <?php else: ?>
                            <?php
                            $href = $item['href'];
                            if ($currentTheme !== 'default') {
                                $separator = strpos($href, '?') !== false ? '&' : '?';
                                $href .= $separator . 'theme=' . $currentTheme;
                            }
                            if ($currentScript === 'playground.php' && $currentComponent) {
                                if (strpos($href, 'playground.php') !== false) {
                                    $separator = strpos($href, '?') !== false ? '&' : '?';
                                    $href .= $separator . 'component=' . $currentComponent;
                                }
                            }
                            ?>
                            <a href="<?php echo $href; ?>" class="nav-menu-item<?php echo $item['active'] ? ' active' : ''; ?>">
                                <span class="nav-menu-icon"><?php echo MD3::icon($item['icon']); ?></span>
                                <span class="nav-menu-text"><?php echo htmlspecialchars($item['label']); ?></span>
                                <?php if ($item['active']): ?>
                                    <span class="nav-menu-check"><?php echo MD3::icon('check'); ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <h1>
                <?php echo MD3::icon($currentPage['icon']); ?> <?php echo htmlspecialchars($currentPage['title']); ?>
            </h1>
        </div>

        <div class="header-actions">
            <!-- Light/Dark Mode Toggle -->
            <button class="mode-toggle" onclick="toggleMode()" id="mode-toggle">
                <?php echo MD3::icon('light_mode'); ?>
            </button>

            <!-- Theme Selector -->
            <div class="theme-selector-compact">
                <button class="theme-toggle" onclick="toggleThemeSelector()">
                    <?php echo MD3::icon('palette'); ?>
                    <span class="theme-current"><?php
                        if (class_exists('MD3Theme')) {
                            $themes = MD3Theme::getAvailableThemes();
                            echo $themes[$currentTheme]['name'] ?? ucfirst($currentTheme);
                        } else {
                            echo ucfirst($currentTheme);
                        }
                    ?></span>
                    <?php echo MD3::icon('expand_more'); ?>
                </button>
                <div class="theme-dropdown" id="theme-dropdown">
                    <?php
                    try {
                        if (class_exists('MD3Theme')) {
                            $themes = MD3Theme::getAvailableThemes();
                            foreach ($themes as $key => $theme) {
                                $isActive = $key === $currentTheme;

                                // Build URL with current page context
                                $url = $currentScript;
                                $params = [];
                                if ($key !== 'default') {
                                    $params['theme'] = $key;
                                }
                                if ($currentComponent && $currentScript === 'playground.php') {
                                    $params['component'] = $currentComponent;
                                }
                                if (!empty($params)) {
                                    $url .= '?' . http_build_query($params);
                                }

                                echo '<a href="' . $url . '" class="theme-option' . ($isActive ? ' active' : '') . '">';
                                echo '<span class="theme-icon">' . MD3::icon($theme['icon']) . '</span>';
                                echo '<span class="theme-name">' . $theme['name'] . '</span>';
                                if ($isActive) echo '<span class="theme-check">' . MD3::icon('check') . '</span>';
                                echo '</a>';
                            }
                        }
                    } catch (Exception $e) {
                        echo '<!-- Theme error: ' . htmlspecialchars($e->getMessage()) . ' -->';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
/* Central Header Styles */
.central-header {
    background: var(--md-sys-color-surface);
    border-bottom: 1px solid var(--md-sys-color-outline-variant);
    padding: 12px 24px;
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    max-width: 1200px;
    margin: 0 auto;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.header-left h1 {
    font-size: 18px;
    font-weight: 500;
    color: var(--md-sys-color-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Navigation Menu */
.nav-menu-container {
    position: relative;
}

.nav-menu-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: var(--md-sys-color-surface-container);
    color: var(--md-sys-color-on-surface);
    border: 1px solid var(--md-sys-color-outline);
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    font-size: 14px;
    font-family: inherit;
}

.nav-menu-toggle:hover {
    background: var(--md-sys-color-surface-container-high);
    border-color: var(--md-sys-color-primary);
    color: var(--md-sys-color-primary);
}

.nav-menu-label {
    font-weight: 500;
}

.nav-menu-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    background: var(--md-sys-color-surface-container);
    border: 1px solid var(--md-sys-color-outline);
    border-radius: 12px;
    box-shadow: var(--md-sys-elevation-2);
    min-width: 200px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
}

.nav-menu-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.nav-menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: var(--md-sys-color-on-surface);
    text-decoration: none;
    transition: background-color 0.2s;
    position: relative;
}

.nav-menu-item:hover {
    background: var(--md-sys-color-surface-container-high);
}

.nav-menu-item.active {
    background: var(--md-sys-color-primary-container);
    color: var(--md-sys-color-on-primary-container);
}

.nav-menu-icon {
    font-size: 18px;
    width: 18px;
    flex-shrink: 0;
}

.nav-menu-text {
    flex: 1;
    font-weight: 500;
    font-size: 14px;
}

.nav-menu-check {
    font-size: 16px;
    color: var(--md-sys-color-primary);
}

.nav-menu-divider {
    height: 1px;
    background: var(--md-sys-color-outline-variant);
    margin: 8px 16px;
}

/* Mode Toggle */
.mode-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: none;
    border: 1px solid var(--md-sys-color-outline);
    border-radius: 20px;
    color: var(--md-sys-color-on-surface);
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    font-size: 18px;
}

.mode-toggle:hover {
    background: var(--md-sys-color-surface-container-high);
    border-color: var(--md-sys-color-primary);
    color: var(--md-sys-color-primary);
}

/* Theme Selector */
.theme-selector-compact {
    position: relative;
}

.theme-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: var(--md-sys-color-surface-container);
    color: var(--md-sys-color-on-surface);
    border: 1px solid var(--md-sys-color-outline);
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    font-size: 14px;
    min-width: 120px;
    font-family: inherit;
}

.theme-toggle:hover {
    background: var(--md-sys-color-surface-container-high);
    border-color: var(--md-sys-color-primary);
    color: var(--md-sys-color-primary);
}

.theme-current {
    flex: 1;
    text-align: left;
    font-weight: 500;
}

.theme-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: var(--md-sys-color-surface-container);
    border: 1px solid var(--md-sys-color-outline);
    border-radius: 12px;
    box-shadow: var(--md-sys-elevation-2);
    min-width: 200px;
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
}

.theme-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.theme-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: var(--md-sys-color-on-surface);
    text-decoration: none;
    transition: background-color 0.2s;
    position: relative;
}

.theme-option:hover {
    background: var(--md-sys-color-surface-container-high);
}

.theme-option.active {
    background: var(--md-sys-color-primary-container);
    color: var(--md-sys-color-on-primary-container);
}

.theme-icon {
    font-size: 18px;
    width: 18px;
    flex-shrink: 0;
}

.theme-name {
    flex: 1;
    font-weight: 500;
    font-size: 14px;
}

.theme-check {
    font-size: 16px;
    color: var(--md-sys-color-primary);
}

/* Responsive Design */
@media (max-width: 768px) {
    .central-header {
        padding: 8px 16px;
    }

    .header-left h1 {
        font-size: 16px;
    }

    .header-actions {
        gap: 8px;
    }

    .theme-toggle {
        min-width: 100px;
        padding: 6px 10px;
    }

    .theme-current {
        display: none;
    }

    .nav-menu-label {
        display: none;
    }

    .mode-toggle {
        width: 36px;
        height: 36px;
    }
}

@media (max-width: 480px) {
    .header-main {
        gap: 8px;
    }

    .theme-toggle, .nav-menu-toggle {
        min-width: 40px;
    }

    .theme-dropdown, .nav-menu-dropdown {
        right: -50px;
        min-width: 180px;
    }
}
</style>

<script>
// Navigation Menu Toggle
window.toggleNavMenu = function() {
    const dropdown = document.getElementById('nav-menu-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('show');
    }
};

// Theme Selector Toggle
window.toggleThemeSelector = function() {
    const dropdown = document.getElementById('theme-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('show');
    }
};

// Dark/Light Mode Toggle
window.toggleMode = function() {
    const currentMode = document.documentElement.getAttribute('data-theme') || 'light';
    const newMode = currentMode === 'light' ? 'dark' : 'light';

    console.log('Toggling from', currentMode, 'to', newMode);

    // Update data attribute for CSS
    document.documentElement.setAttribute('data-theme', newMode);

    // Save preference
    localStorage.setItem('md3-color-scheme', newMode);

    // Update button icon - show opposite of current mode
    const button = document.getElementById('mode-toggle');
    if (button) {
        const icon = newMode === 'dark' ? 'light_mode' : 'dark_mode';
        button.querySelector('.material-symbols-outlined').textContent = icon;
    }

    console.log('Applied theme:', document.documentElement.getAttribute('data-theme'));
};

document.addEventListener('DOMContentLoaded', function() {
    // Initialize color scheme on page load
    const savedMode = localStorage.getItem('md3-color-scheme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const initialMode = savedMode || (systemPrefersDark ? 'dark' : 'light');

    console.log('Initializing color scheme:', initialMode);
    document.documentElement.setAttribute('data-theme', initialMode);

    const modeButton = document.getElementById('mode-toggle');
    if (modeButton) {
        // Show opposite icon of current mode
        const icon = initialMode === 'dark' ? 'light_mode' : 'dark_mode';
        console.log('Set initial icon to:', icon);
        modeButton.querySelector('.material-symbols-outlined').textContent = icon;
    }

    console.log('HTML data-theme attribute:', document.documentElement.getAttribute('data-theme'));

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        const navMenuContainer = document.querySelector('.nav-menu-container');
        const navDropdown = document.getElementById('nav-menu-dropdown');
        const themeContainer = document.querySelector('.theme-selector-compact');
        const themeDropdown = document.getElementById('theme-dropdown');

        if (navMenuContainer && navDropdown && !navMenuContainer.contains(e.target)) {
            navDropdown.classList.remove('show');
        }

        if (themeContainer && themeDropdown && !themeContainer.contains(e.target)) {
            themeDropdown.classList.remove('show');
        }
    });

    // Close dropdowns on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const navDropdown = document.getElementById('nav-menu-dropdown');
            const themeDropdown = document.getElementById('theme-dropdown');
            if (navDropdown) navDropdown.classList.remove('show');
            if (themeDropdown) themeDropdown.classList.remove('show');
        }
    });
});
</script>