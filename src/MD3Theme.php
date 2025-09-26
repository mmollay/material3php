<?php

require_once 'MD3.php';

/**
 * MD3Theme - Material Design 3 Theme System
 * Provides different color themes for Material Design 3
 */
class MD3Theme
{
    /**
     * Available themes
     */
    public static function getAvailableThemes(): array
    {
        return [
            'default' => ['name' => 'Standard Purple', 'icon' => 'palette'],
            'ocean' => ['name' => 'Ocean Blue', 'icon' => 'water'],
            'forest' => ['name' => 'Forest Green', 'icon' => 'park'],
            'sunset' => ['name' => 'Sunset Orange', 'icon' => 'wb_twilight'],
            'minimal' => ['name' => 'Minimal Gray', 'icon' => 'contrast']
        ];
    }

    /**
     * Get theme colors for a specific theme
     *
     * @param string $theme Theme name
     * @return array Theme colors for light and dark modes
     */
    public static function getThemeColors(string $theme = 'default'): array
    {
        $themes = [
            'default' => [
                'light' => [
                    'primary' => '#6750A4',
                    'on-primary' => '#FFFFFF',
                    'primary-container' => '#EADDFF',
                    'on-primary-container' => '#21005D',
                    'secondary' => '#625B71',
                    'on-secondary' => '#FFFFFF',
                    'secondary-container' => '#E8DEF8',
                    'on-secondary-container' => '#1D192B',
                    'tertiary' => '#7D5260',
                    'on-tertiary' => '#FFFFFF',
                    'surface' => '#FEF7FF',
                    'on-surface' => '#1D1B20',
                    'surface-variant' => '#E7E0EC',
                    'on-surface-variant' => '#49454F',
                    'background' => '#FEF7FF',
                    'on-background' => '#1D1B20',
                    'surface-container-lowest' => '#FFFFFF',
                    'surface-container' => '#F3EDF7',
                    'surface-container-high' => '#ECE6F0',
                    'outline' => '#79747E',
                    'outline-variant' => '#CAC4D0',
                    'error' => '#BA1A1A',
                    'on-error' => '#FFFFFF'
                ],
                'dark' => [
                    'primary' => '#D0BCFF',
                    'on-primary' => '#371E73',
                    'primary-container' => '#4F378B',
                    'on-primary-container' => '#EADDFF',
                    'secondary' => '#CCC2DC',
                    'on-secondary' => '#332D41',
                    'secondary-container' => '#4A4458',
                    'on-secondary-container' => '#E8DEF8',
                    'tertiary' => '#EFB8C8',
                    'on-tertiary' => '#492532',
                    'surface' => '#141218',
                    'on-surface' => '#E6E0E9',
                    'surface-variant' => '#49454F',
                    'on-surface-variant' => '#CAC4D0',
                    'background' => '#141218',
                    'on-background' => '#E6E0E9',
                    'surface-container-lowest' => '#0F0D13',
                    'surface-container' => '#211F26',
                    'surface-container-high' => '#2B2930',
                    'outline' => '#938F99',
                    'outline-variant' => '#49454F',
                    'error' => '#FFB4AB',
                    'on-error' => '#690005'
                ]
            ],
            'ocean' => [
                'light' => [
                    'primary' => '#0061A4',
                    'on-primary' => '#FFFFFF',
                    'primary-container' => '#D1E4FF',
                    'on-primary-container' => '#001D36',
                    'secondary' => '#535F70',
                    'on-secondary' => '#FFFFFF',
                    'secondary-container' => '#D7E3F7',
                    'on-secondary-container' => '#101C2B',
                    'tertiary' => '#6B5778',
                    'on-tertiary' => '#FFFFFF',
                    'surface' => '#F8F9FF',
                    'on-surface' => '#191C20',
                    'surface-variant' => '#DFE2EB',
                    'on-surface-variant' => '#43474E',
                    'background' => '#F8F9FF',
                    'on-background' => '#191C20',
                    'surface-container-lowest' => '#FFFFFF',
                    'surface-container' => '#ECEEF6',
                    'surface-container-high' => '#E6E8F0',
                    'outline' => '#73777F',
                    'outline-variant' => '#C3C7CF',
                    'error' => '#BA1A1A',
                    'on-error' => '#FFFFFF'
                ],
                'dark' => [
                    'primary' => '#9ECAFF',
                    'on-primary' => '#003258',
                    'primary-container' => '#00497D',
                    'on-primary-container' => '#D1E4FF',
                    'secondary' => '#BBC7DB',
                    'on-secondary' => '#253140',
                    'secondary-container' => '#3B4858',
                    'on-secondary-container' => '#D7E3F7',
                    'tertiary' => '#D0BCC0',
                    'on-tertiary' => '#352B3E',
                    'surface' => '#101418',
                    'on-surface' => '#E2E2E9',
                    'surface-variant' => '#43474E',
                    'on-surface-variant' => '#C3C7CF',
                    'background' => '#101418',
                    'on-background' => '#E2E2E9',
                    'surface-container-lowest' => '#0B0E13',
                    'surface-container' => '#1D2024',
                    'surface-container-high' => '#272A2F',
                    'outline' => '#8D9199',
                    'outline-variant' => '#43474E',
                    'error' => '#FFB4AB',
                    'on-error' => '#690005'
                ]
            ],
            'forest' => [
                'light' => [
                    'primary' => '#256A00',
                    'on-primary' => '#FFFFFF',
                    'primary-container' => '#A8F685',
                    'on-primary-container' => '#042100',
                    'secondary' => '#55624C',
                    'on-secondary' => '#FFFFFF',
                    'secondary-container' => '#D9E7CB',
                    'on-secondary-container' => '#131F0D',
                    'tertiary' => '#386667',
                    'on-tertiary' => '#FFFFFF',
                    'surface' => '#F8FAF0',
                    'on-surface' => '#191D16',
                    'surface-variant' => '#E0E4D6',
                    'on-surface-variant' => '#44483E',
                    'background' => '#F8FAF0',
                    'on-background' => '#191D16',
                    'surface-container-lowest' => '#FFFFFF',
                    'surface-container' => '#ECEEE4',
                    'surface-container-high' => '#E6E8DE',
                    'outline' => '#74796D',
                    'outline-variant' => '#C4C8BA',
                    'error' => '#BA1A1A',
                    'on-error' => '#FFFFFF'
                ],
                'dark' => [
                    'primary' => '#8DD96A',
                    'on-primary' => '#0A3900',
                    'primary-container' => '#165200',
                    'on-primary-container' => '#A8F685',
                    'secondary' => '#BDCBB0',
                    'on-secondary' => '#283420',
                    'secondary-container' => '#3E4B35',
                    'on-secondary-container' => '#D9E7CB',
                    'tertiary' => '#A0CCCD',
                    'on-tertiary' => '#1F3536',
                    'surface' => '#11140E',
                    'on-surface' => '#E2E3DC',
                    'surface-variant' => '#44483E',
                    'on-surface-variant' => '#C4C8BA',
                    'background' => '#11140E',
                    'on-background' => '#E2E3DC',
                    'surface-container-lowest' => '#0C0F09',
                    'surface-container' => '#1D201A',
                    'surface-container-high' => '#272B24',
                    'outline' => '#8E9387',
                    'outline-variant' => '#44483E',
                    'error' => '#FFB4AB',
                    'on-error' => '#690005'
                ]
            ],
            'sunset' => [
                'light' => [
                    'primary' => '#B3261E',
                    'on-primary' => '#FFFFFF',
                    'primary-container' => '#FFDAD6',
                    'on-primary-container' => '#410002',
                    'secondary' => '#775652',
                    'on-secondary' => '#FFFFFF',
                    'secondary-container' => '#FFDAD6',
                    'on-secondary-container' => '#2C1512',
                    'tertiary' => '#715B2E',
                    'on-tertiary' => '#FFFFFF',
                    'surface' => '#FFFBF8',
                    'on-surface' => '#1C1B1F',
                    'surface-variant' => '#F5DDDA',
                    'on-surface-variant' => '#534341',
                    'background' => '#FFFBF8',
                    'on-background' => '#1C1B1F',
                    'surface-container-lowest' => '#FFFFFF',
                    'surface-container' => '#FBF1EE',
                    'surface-container-high' => '#F0E6E1',
                    'outline' => '#85736F',
                    'outline-variant' => '#D8C2BE',
                    'error' => '#BA1A1A',
                    'on-error' => '#FFFFFF'
                ],
                'dark' => [
                    'primary' => '#FFB4AB',
                    'on-primary' => '#690005',
                    'primary-container' => '#93000A',
                    'on-primary-container' => '#FFDAD6',
                    'secondary' => '#E7BDB6',
                    'on-secondary' => '#442925',
                    'secondary-container' => '#5D3F3B',
                    'on-secondary-container' => '#FFDAD6',
                    'tertiary' => '#D3C4A0',
                    'on-tertiary' => '#3A2F05',
                    'surface' => '#141213',
                    'on-surface' => '#EDE0DD',
                    'surface-variant' => '#534341',
                    'on-surface-variant' => '#D8C2BE',
                    'background' => '#141213',
                    'on-background' => '#EDE0DD',
                    'surface-container-lowest' => '#0F0D0E',
                    'surface-container' => '#201A19',
                    'surface-container-high' => '#2B2523',
                    'outline' => '#A08C89',
                    'outline-variant' => '#534341',
                    'error' => '#FFB4AB',
                    'on-error' => '#690005'
                ]
            ],
            'minimal' => [
                'light' => [
                    'primary' => '#5F5F5F',
                    'on-primary' => '#FFFFFF',
                    'primary-container' => '#E4E4E4',
                    'on-primary-container' => '#1C1C1C',
                    'secondary' => '#606060',
                    'on-secondary' => '#FFFFFF',
                    'secondary-container' => '#E5E5E5',
                    'on-secondary-container' => '#1D1D1D',
                    'tertiary' => '#7A7A7A',
                    'on-tertiary' => '#FFFFFF',
                    'surface' => '#FFFFFF',
                    'on-surface' => '#1C1C1C',
                    'surface-variant' => '#F4F4F4',
                    'on-surface-variant' => '#47474A',
                    'background' => '#FFFFFF',
                    'on-background' => '#1C1C1C',
                    'surface-container-lowest' => '#FFFFFF',
                    'surface-container' => '#F9F9F9',
                    'surface-container-high' => '#F3F3F3',
                    'outline' => '#777777',
                    'outline-variant' => '#C7C7C7',
                    'error' => '#BA1A1A',
                    'on-error' => '#FFFFFF'
                ],
                'dark' => [
                    'primary' => '#C7C7C7',
                    'on-primary' => '#2E2E2E',
                    'primary-container' => '#454545',
                    'on-primary-container' => '#E4E4E4',
                    'secondary' => '#C8C8C8',
                    'on-secondary' => '#2F2F2F',
                    'secondary-container' => '#464646',
                    'on-secondary-container' => '#E5E5E5',
                    'tertiary' => '#C3C3C3',
                    'on-tertiary' => '#424242',
                    'surface' => '#141414',
                    'on-surface' => '#E3E3E3',
                    'surface-variant' => '#47474A',
                    'on-surface-variant' => '#C7C7C7',
                    'background' => '#141414',
                    'on-background' => '#E3E3E3',
                    'surface-container-lowest' => '#0F0F0F',
                    'surface-container' => '#1F1F1F',
                    'surface-container-high' => '#2A2A2A',
                    'outline' => '#919191',
                    'outline-variant' => '#47474A',
                    'error' => '#FFB4AB',
                    'on-error' => '#690005'
                ]
            ]
        ];

        return $themes[$theme] ?? $themes['default'];
    }

    /**
     * Generate theme selector UI
     *
     * @param string $currentTheme Current active theme
     * @param array $attributes Additional HTML attributes
     * @return string HTML for theme selector
     */
    public static function selector(string $currentTheme = 'default', array $attributes = []): string
    {
        $themes = self::getAvailableThemes();

        $html = '<div class="theme-selector"' . MD3::escapeAttributes($attributes) . '>';
        $html .= '<label for="theme-select">Theme auswählen:</label>';
        $html .= '<select id="theme-select" onchange="changeTheme(this.value)">';

        foreach ($themes as $key => $theme) {
            $selected = ($key === $currentTheme) ? ' selected' : '';
            $html .= "<option value=\"{$key}\"{$selected}>";
            $html .= MD3::icon($theme['icon']) . ' ' . htmlspecialchars($theme['name']);
            $html .= '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Generate theme toggle chips
     *
     * @param string $currentTheme Current active theme
     * @return string HTML for theme toggle chips
     */
    public static function toggleChips(string $currentTheme = 'default'): string
    {
        $themes = self::getAvailableThemes();
        $html = '<div class="theme-toggle-chips">';

        foreach ($themes as $key => $theme) {
            $isActive = ($key === $currentTheme);
            $chipClass = $isActive ? 'md-filter-chip selected' : 'md-filter-chip';

            $html .= "<div class=\"{$chipClass}\" onclick=\"changeTheme('{$key}')\" data-theme=\"{$key}\">";
            $html .= '<span class="chip-icon">' . MD3::icon($theme['icon']) . '</span>';
            $html .= htmlspecialchars($theme['name']);
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Generate combined theme selector with dark/light mode toggle
     *
     * @param string $currentTheme Current active theme
     * @param array $attributes Additional HTML attributes
     * @return string HTML for combined theme and mode controls
     */
    public static function selectorWithModeToggle(string $currentTheme = 'default', array $attributes = []): string
    {
        require_once 'MD3Select.php';

        $themes = self::getAvailableThemes();
        $options = [];
        foreach ($themes as $key => $theme) {
            $options[$key] = $theme['name'];
        }

        $html = '<div class="theme-mode-controls"' . MD3::escapeAttributes($attributes) . '>';

        // Theme Selector using MD3Select
        $html .= '<div class="theme-selector-wrapper">';
        $html .= MD3Select::filled('theme-select', 'Theme auswählen', $options, $currentTheme, [
            'onchange' => 'changeTheme(this.value)',
            'style' => 'min-width: 200px;'
        ]);
        $html .= '</div>';

        // Dark/Light Mode Toggle
        $html .= '<div class="mode-toggle-wrapper">';
        $html .= '<button class="md3-mode-toggle" onclick="toggleMode()" id="mode-toggle-btn" title="Dark/Light Mode wechseln">';
        $html .= '<span class="material-symbols-outlined">dark_mode</span>';
        $html .= '</button>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Generate JavaScript for theme switching
     *
     * @return string JavaScript code for theme functionality
     */
    public static function getThemeScript(): string
    {
        return '<script>
            // Theme management
            function changeTheme(themeName) {
                // Store theme preference
                localStorage.setItem("md3-theme", themeName);

                // Apply theme immediately by reloading with theme parameter
                const url = new URL(window.location);
                url.searchParams.set("theme", themeName);
                window.location.href = url.toString();
            }

            // Note: toggleMode and initializeColorScheme are now handled by MD3Header::getScript()

            // Make functions globally available immediately
            window.changeTheme = changeTheme;
            // Note: toggleMode is now defined in MD3Header::getScript()

            // Load saved theme on page load
            document.addEventListener("DOMContentLoaded", function() {
                // Note: Color scheme initialization is handled by MD3Header::getScript()

                const savedTheme = localStorage.getItem("md3-theme") || "default";
                const urlParams = new URLSearchParams(window.location.search);
                const urlTheme = urlParams.get("theme");

                if (urlTheme && urlTheme !== savedTheme) {
                    localStorage.setItem("md3-theme", urlTheme);
                } else if (!urlTheme && savedTheme !== "default") {
                    changeTheme(savedTheme);
                }

                // Update theme selector if present
                const themeSelect = document.getElementById("theme-select");
                if (themeSelect) {
                    themeSelect.value = urlTheme || savedTheme;
                }

                // Update chip selector if present
                const activeTheme = urlTheme || savedTheme;
                document.querySelectorAll(".theme-toggle-chips .md-filter-chip").forEach(chip => {
                    if (chip.getAttribute("data-theme") === activeTheme) {
                        chip.classList.add("selected");
                    } else {
                        chip.classList.remove("selected");
                    }
                });
            });
        </script>';
    }

    /**
     * Generate CSS variables for light and dark modes
     *
     * @param string $theme Theme name
     * @return string CSS with both light and dark mode variables
     */
    public static function generateThemeModeCSS(string $theme = 'default'): string
    {
        $themeColors = self::getThemeColors($theme);

        if (!isset($themeColors['light']) || !isset($themeColors['dark'])) {
            return '/* Theme not found */';
        }

        $css = ":root, [data-theme=\"light\"] {\n  color-scheme: light;\n";

        // Light mode colors
        foreach ($themeColors['light'] as $token => $color) {
            $css .= "  --md-sys-color-{$token}: {$color};\n";
        }

        $css .= "}\n\n[data-theme=\"dark\"], @media (prefers-color-scheme: dark) {\n  :root:not([data-theme=\"light\"]) {\n";

        // Dark mode colors
        foreach ($themeColors['dark'] as $token => $color) {
            $css .= "    --md-sys-color-{$token}: {$color};\n";
        }

        $css .= "  }\n}";

        return $css;
    }

    /**
     * Generate CSS for theme selector styling
     *
     * @return string CSS for theme components
     */
    public static function getThemeCSS(): string
    {
        return '<style>
            .theme-selector {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px;
                background: var(--md-sys-color-surface-container);
                border-radius: 8px;
                margin: 16px 0;
            }

            .theme-selector label {
                font-weight: 500;
                color: var(--md-sys-color-on-surface);
            }

            .theme-selector select {
                padding: 8px 12px;
                border: 1px solid var(--md-sys-color-outline);
                border-radius: 4px;
                background: var(--md-sys-color-surface);
                color: var(--md-sys-color-on-surface);
                font-family: inherit;
                min-width: 180px;
            }

            .theme-mode-controls {
                display: flex;
                align-items: center;
                gap: 16px;
                padding: 16px;
                background: var(--md-sys-color-surface-container);
                border-radius: 12px;
                margin: 16px 0;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .theme-selector-wrapper {
                flex: 1;
                min-width: 200px;
            }

            .mode-toggle-wrapper {
                display: flex;
                align-items: center;
            }

            .md3-mode-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                border: none;
                border-radius: 24px;
                background: var(--md-sys-color-primary);
                color: var(--md-sys-color-on-primary);
                cursor: pointer;
                transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
                box-shadow: var(--md-sys-elevation-1);
                font-size: 24px;
            }

            .md3-mode-toggle:hover {
                background: var(--md-sys-color-primary);
                box-shadow: var(--md-sys-elevation-2);
                transform: scale(1.05);
            }

            .md3-mode-toggle:active {
                transform: scale(0.95);
                box-shadow: var(--md-sys-elevation-1);
            }

            .md3-mode-toggle .material-symbols-outlined {
                font-size: 20px;
                transition: transform 0.2s;
            }

            @media (max-width: 480px) {
                .theme-mode-controls {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 12px;
                }

                .theme-selector-wrapper {
                    min-width: auto;
                }

                .mode-toggle-wrapper {
                    justify-content: center;
                }
            }

            .theme-toggle-chips {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 16px;
                background: var(--md-sys-color-surface-container-lowest);
                border-radius: 12px;
                margin: 16px 0;
            }

            .theme-toggle-chips .md-filter-chip {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 16px;
                border: 1px solid var(--md-sys-color-outline);
                border-radius: 20px;
                background: var(--md-sys-color-surface);
                color: var(--md-sys-color-on-surface);
                cursor: pointer;
                transition: all 0.2s ease;
                text-decoration: none;
            }

            .theme-toggle-chips .md-filter-chip:hover {
                background: var(--md-sys-color-surface-container-high);
                border-color: var(--md-sys-color-outline-variant);
            }

            .theme-toggle-chips .md-filter-chip.selected {
                background: var(--md-sys-color-primary-container);
                color: var(--md-sys-color-on-primary-container);
                border-color: var(--md-sys-color-primary);
            }

            .theme-toggle-chips .chip-icon {
                font-size: 18px;
            }
        </style>';
    }
}