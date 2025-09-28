<?php

/**
 * Material Design 3 Header Component
 *
 * Wiederverwendbarer Header mit Theme-Auswahl und Dark/Light Mode Toggle
 * Basiert auf dem Playground-Header Design
 *
 * @package MD3Header
 * @version 0.1.0
 * @since 0.2.7
 */

class MD3Header
{
    /**
     * Generate standard page header with theme and mode controls
     *
     * @param string $title Page title
     * @param string $icon Page icon (Material Symbols name)
     * @param string $currentTheme Current active theme
     * @param string $currentPage Current page name for navigation
     * @param array $options Additional options
     * @return string HTML for header
     */
    public static function create(string $title, string $icon = 'home', string $currentTheme = 'default', string $currentPage = '', array $options = []): string
    {
        require_once 'MD3Theme.php';

        $id = $options['id'] ?? 'md3-header-' . uniqid();
        $classes = ['md3-header'];

        if (!empty($options['class'])) {
            $classes[] = $options['class'];
        }

        // Build header content
        $iconHtml = MD3::icon($icon);
        $titleHtml = sprintf('<h1>%s %s</h1>', $iconHtml, htmlspecialchars($title));

        // Build theme selector and mode toggle
        $actionsHtml = self::renderHeaderActions($currentTheme, $currentPage);

        $html = sprintf(
            '<header class="%s" id="%s">
                <div class="md3-header-main">
                    %s
                    <div class="md3-header-actions">
                        %s
                    </div>
                </div>
            </header>',
            implode(' ', $classes),
            $id,
            $titleHtml,
            $actionsHtml
        );

        return $html;
    }

    /**
     * Generate playground-style header
     */
    public static function playground(string $currentTheme = 'default', string $currentComponent = 'button'): string
    {
        $options = ['class' => 'playground-header'];
        return self::create('MD3 Playground', 'play_arrow', $currentTheme, 'playground', $options);
    }

    /**
     * Generate demo page header
     */
    public static function demo(string $pageTitle, string $icon = 'dashboard', string $currentTheme = 'default'): string
    {
        return self::create($pageTitle, $icon, $currentTheme, 'demo');
    }

    /**
     * Generate unified navigation header with breadcrumbs and main navigation
     */
    public static function withNavigation(string $pageTitle, string $icon = 'dashboard', string $currentTheme = 'default', array $breadcrumbs = [], array $navItems = []): string
    {
        require_once 'MD3Breadcrumb.php';
        require_once 'MD3NavigationBar.php';

        $id = 'md3-header-nav-' . uniqid();

        // Build main header
        $iconHtml = MD3::icon($icon);
        $titleHtml = sprintf('<h1>%s %s</h1>', $iconHtml, htmlspecialchars($pageTitle));

        // Build header actions
        $actionsHtml = self::renderHeaderActions($currentTheme, 'demo');

        // Build breadcrumb navigation if provided
        $breadcrumbHtml = '';
        if (!empty($breadcrumbs)) {
            $breadcrumbHtml = '<div class="md3-header-breadcrumb">' .
                MD3Breadcrumb::fromArray($breadcrumbs) .
                '</div>';
        }

        // Build main navigation if provided
        $mainNavHtml = '';
        if (!empty($navItems)) {
            $mainNavHtml = '<div class="md3-header-navigation">' .
                MD3NavigationBar::create($navItems, ['class' => 'horizontal']) .
                '</div>';
        }

        $html = sprintf(
            '<header class="md3-header md3-header-with-nav" id="%s">
                <div class="md3-header-main">
                    %s
                    <div class="md3-header-actions">
                        %s
                    </div>
                </div>
                %s
                %s
            </header>',
            $id,
            $titleHtml,
            $actionsHtml,
            $breadcrumbHtml,
            $mainNavHtml
        );

        return $html;
    }

    /**
     * Render header actions (theme selector + mode toggle)
     */
    private static function renderHeaderActions(string $currentTheme, string $currentPage): string
    {
        // Mode toggle button
        $modeToggle = '
        <button class="md3-mode-toggle" onclick="toggleMode()" id="mode-toggle-btn" title="Dark/Light Mode wechseln">
            ' . MD3::icon('dark_mode') . '
        </button>';

        // Theme selector dropdown
        $themeSelector = self::renderThemeSelector($currentTheme, $currentPage);

        // Back link for playground
        $backLink = '';
        if ($currentPage === 'playground') {
            $themeParam = $currentTheme !== 'default' ? '?theme=' . $currentTheme : '';
            $backLink = sprintf(
                '<a href="index.php%s" class="md3-back-link">%s← Home</a>',
                $themeParam,
                MD3::icon('arrow_back')
            );
        }

        return $modeToggle . $themeSelector . $backLink;
    }

    /**
     * Render compact theme selector dropdown
     */
    private static function renderThemeSelector(string $currentTheme, string $currentPage): string
    {
        $themes = MD3Theme::getAvailableThemes();
        $currentThemeName = $themes[$currentTheme]['name'] ?? ucfirst($currentTheme);

        // Theme toggle button
        $html = '
        <div class="md3-theme-selector-compact">
            <button class="md3-theme-toggle" onclick="toggleThemeSelector()" id="theme-toggle">
                ' . MD3::icon('palette') . '
                <span class="md3-theme-current">' . htmlspecialchars($currentThemeName) . '</span>
                ' . MD3::icon('expand_more') . '
            </button>
            <div class="md3-theme-dropdown" id="theme-dropdown">';

        // Theme options
        foreach ($themes as $key => $theme) {
            $isActive = $key === $currentTheme;
            $activeClass = $isActive ? ' active' : '';

            // Build URL based on current page
            $href = self::buildThemeUrl($currentPage, $key);

            $checkIcon = $isActive ? '<span class="md3-theme-check">' . MD3::icon('check') . '</span>' : '';

            $html .= sprintf(
                '<a href="%s" class="md3-theme-option%s">
                    <span class="md3-theme-icon">%s</span>
                    <span class="md3-theme-name">%s</span>
                    %s
                </a>',
                $href,
                $activeClass,
                MD3::icon($theme['icon']),
                htmlspecialchars($theme['name']),
                $checkIcon
            );
        }

        $html .= '
            </div>
        </div>';

        return $html;
    }

    /**
     * Build theme URL for current page
     */
    private static function buildThemeUrl(string $currentPage, string $theme): string
    {
        // Get current script name
        $currentScript = $_SERVER['SCRIPT_NAME'] ?? '';
        $currentScript = basename($currentScript);

        // Build URL parameters
        $params = [];

        // Add theme parameter
        if ($theme !== 'default') {
            $params['theme'] = $theme;
        }

        // For playground, preserve component parameter
        if ($currentPage === 'playground' && isset($_GET['component'])) {
            $params['component'] = $_GET['component'];
        }

        // Build query string
        $queryString = !empty($params) ? '?' . http_build_query($params) : '';

        // Return current page with new theme
        return $currentScript . $queryString;
    }

    /**
     * Generate CSS for Header Component
     */
    public static function getCSS(): string
    {
        return '
        /* Material Design 3 Header Component */
        .md3-header {
            background: var(--md-sys-color-surface);
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
            padding: 12px 24px;
            position: relative;
            z-index: 10;
        }

        .md3-header-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .md3-header h1 {
            font-size: 18px;
            font-weight: 500;
            color: var(--md-sys-color-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .md3-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Mode Toggle */
        .md3-mode-toggle {
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

        .md3-mode-toggle:hover {
            background: var(--md-sys-color-surface-container-high);
            border-color: var(--md-sys-color-primary);
            color: var(--md-sys-color-primary);
        }

        .md3-mode-toggle:active {
            transform: scale(0.95);
        }

        /* Compact Theme Selector */
        .md3-theme-selector-compact {
            position: relative;
        }

        .md3-theme-toggle {
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

        .md3-theme-toggle:hover {
            background: var(--md-sys-color-surface-container-high);
            border-color: var(--md-sys-color-primary);
            color: var(--md-sys-color-primary);
        }

        .md3-theme-current {
            flex: 1;
            text-align: left;
            font-weight: 500;
        }

        .md3-theme-dropdown {
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

        .md3-theme-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .md3-theme-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--md-sys-color-on-surface);
            text-decoration: none;
            transition: background-color 0.2s;
            position: relative;
        }

        .md3-theme-option:hover {
            background: var(--md-sys-color-surface-container-high);
        }

        .md3-theme-option.active {
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
        }

        .md3-theme-icon {
            font-size: 18px;
            width: 18px;
            flex-shrink: 0;
        }

        .md3-theme-name {
            flex: 1;
            font-weight: 500;
            font-size: 14px;
        }

        .md3-theme-check {
            font-size: 16px;
            color: var(--md-sys-color-primary);
        }

        /* Back Link */
        .md3-back-link {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 8px 12px;
            color: var(--md-sys-color-primary);
            text-decoration: none;
            border-radius: 20px;
            transition: background-color 0.2s;
            font-size: 14px;
            font-weight: 500;
        }

        .md3-back-link:hover {
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
        }

        /* Playground Header Specific Styles */
        .playground-header {
            grid-area: header;
        }

        /* Header with Navigation */
        .md3-header-with-nav {
            border-bottom: none;
        }

        .md3-header-breadcrumb {
            padding: 8px 24px 0;
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
        }

        .md3-header-navigation {
            background: var(--md-sys-color-surface-container-lowest);
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
        }

        .md3-header-navigation .md3-navigation-bar.horizontal {
            justify-content: center;
            padding: 0 24px;
        }

        .md3-header-navigation .md3-navigation-bar.horizontal .md3-nav-item {
            min-width: 120px;
            padding: 12px 16px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .md3-header {
                padding: 8px 16px;
            }

            .md3-header h1 {
                font-size: 16px;
            }

            .md3-header-actions {
                gap: 8px;
            }

            .md3-theme-toggle {
                min-width: 100px;
                padding: 6px 10px;
            }

            .md3-theme-current {
                display: none;
            }

            .md3-mode-toggle {
                width: 36px;
                height: 36px;
            }

            .md3-back-link span {
                display: none;
            }

            .md3-header-breadcrumb {
                padding: 8px 16px 0;
            }

            .md3-header-navigation .md3-navigation-bar.horizontal {
                padding: 0 16px;
            }

            .md3-header-navigation .md3-navigation-bar.horizontal .md3-nav-item {
                min-width: 80px;
                padding: 10px 12px;
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .md3-header-main {
                gap: 8px;
            }

            .md3-theme-toggle {
                min-width: 40px;
            }

            .md3-theme-dropdown {
                right: -50px;
                min-width: 180px;
            }

            .md3-header-navigation .md3-navigation-bar.horizontal {
                overflow-x: auto;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .md3-header-navigation .md3-navigation-bar.horizontal::-webkit-scrollbar {
                display: none;
            }
        }
        ';
    }

    /**
     * Generate JavaScript for Header interactions
     */
    public static function getScript(): string
    {
        return "
        <script>
        // Dark/Light Mode Toggle - defined immediately for onclick access
        window.toggleMode = function() {
            const currentMode = document.documentElement.getAttribute('data-theme') || 'light';
            const newMode = currentMode === 'light' ? 'dark' : 'light';

            console.log('Toggling from', currentMode, 'to', newMode);

            // Update data attribute for CSS
            document.documentElement.setAttribute('data-theme', newMode);

            // Save preference
            localStorage.setItem('md3-color-scheme', newMode);

            // Update button icon - show opposite of current mode
            const button = document.getElementById('mode-toggle-btn');
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

            document.documentElement.setAttribute('data-theme', initialMode);

            const modeButton = document.getElementById('mode-toggle-btn');
            if (modeButton) {
                // Show opposite icon of current mode
                const icon = initialMode === 'dark' ? 'light_mode' : 'dark_mode';
                modeButton.querySelector('.material-symbols-outlined').textContent = icon;
            }

            // Theme selector functionality
            window.toggleThemeSelector = function() {
                const dropdown = document.getElementById('theme-dropdown');
                if (dropdown) {
                    dropdown.classList.toggle('show');
                }
            };

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const themeSelector = document.querySelector('.md3-theme-selector-compact');
                const dropdown = document.getElementById('theme-dropdown');

                if (themeSelector && dropdown && !themeSelector.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });

            // Close dropdown on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const dropdown = document.getElementById('theme-dropdown');
                    if (dropdown) {
                        dropdown.classList.remove('show');
                    }
                }
            });
        });
        </script>
        ";
    }
}

?>