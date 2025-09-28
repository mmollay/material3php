<?php

/**
 * Material Design 3 Navigation Bar Component
 *
 * Implementiert die MD3 Navigation Bar (Bottom Navigation) mit Icons und Labels
 * Unterstützt aktive States, Badges und verschiedene Konfigurationen
 *
 * @package MD3NavigationBar
 * @version 0.1.0
 * @since 0.1.0
 */

class MD3NavigationBar
{
    /**
     * Generate Navigation Bar HTML
     *
     * @param array $items Navigation items with structure:
     *   [
     *     ['icon' => 'home', 'label' => 'Home', 'href' => '/', 'active' => true, 'badge' => 3],
     *     ['icon' => 'search', 'label' => 'Search', 'href' => '/search'],
     *     // ...
     *   ]
     * @param array $options Additional options
     * @return string HTML
     */
    public static function create(array $items, array $options = []): string
    {
        $id = $options['id'] ?? 'md3-nav-bar-' . uniqid();
        $classes = ['md3-navigation-bar'];

        if (!empty($options['class'])) {
            $classes[] = $options['class'];
        }

        // Build navigation items
        $itemsHtml = '';
        foreach ($items as $item) {
            $itemsHtml .= self::renderNavigationItem($item);
        }

        $html = sprintf(
            '<nav class="%s" id="%s" role="navigation" aria-label="Primary navigation">%s</nav>',
            implode(' ', $classes),
            $id,
            $itemsHtml
        );

        return $html;
    }

    /**
     * Render a single navigation item
     */
    private static function renderNavigationItem(array $item): string
    {
        $icon = $item['icon'] ?? '';
        $label = $item['label'] ?? '';
        $href = $item['href'] ?? '#';
        $active = $item['active'] ?? false;
        $badge = $item['badge'] ?? null;

        $classes = ['md3-nav-item'];
        if ($active) {
            $classes[] = 'active';
        }

        $badgeHtml = '';
        if ($badge !== null) {
            require_once 'MD3Badge.php';
            $badgeHtml = MD3Badge::create((string)$badge, ['size' => 'small']);
        }

        $iconHtml = '';
        if ($icon) {
            require_once 'MD3.php';
            $iconHtml = MD3::icon($icon);
        }

        $html = sprintf(
            '<a href="%s" class="%s">
                <div class="md3-nav-item-content">
                    <div class="md3-nav-item-icon">%s%s</div>
                    <div class="md3-nav-item-label">%s</div>
                </div>
            </a>',
            htmlspecialchars($href),
            implode(' ', $classes),
            $iconHtml,
            $badgeHtml,
            htmlspecialchars($label)
        );

        return $html;
    }

    /**
     * Generate CSS for Navigation Bar Component
     */
    public static function getCSS(): string
    {
        return '
        /* Material Design 3 Navigation Bar */
        .md3-navigation-bar {
            display: flex;
            align-items: center;
            background: var(--md-sys-color-surface-container);
            border-radius: 16px;
            padding: 8px;
            gap: 4px;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .md3-navigation-bar::-webkit-scrollbar {
            display: none;
        }

        .md3-navigation-bar.horizontal {
            flex-direction: row;
        }

        .md3-nav-item {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 64px;
            padding: 8px 12px;
            border-radius: 16px;
            text-decoration: none;
            color: var(--md-sys-color-on-surface-variant);
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
            position: relative;
            flex: 1;
            min-width: 64px;
        }

        .md3-nav-item:hover {
            background: var(--md-sys-color-surface-container-high);
        }

        .md3-nav-item.active {
            background: var(--md-sys-color-secondary-container);
            color: var(--md-sys-color-on-secondary-container);
        }

        .md3-nav-item-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .md3-nav-item-icon {
            position: relative;
            font-size: 24px;
            line-height: 1;
        }

        .md3-nav-item-label {
            font-size: 12px;
            font-weight: 500;
            line-height: 1.2;
            text-align: center;
        }

        /* Horizontal layout adjustments */
        .md3-navigation-bar.horizontal .md3-nav-item {
            min-height: 48px;
            flex: 0 0 auto;
        }

        .md3-navigation-bar.horizontal .md3-nav-item-content {
            flex-direction: row;
            gap: 8px;
        }

        .md3-navigation-bar.horizontal .md3-nav-item-icon {
            font-size: 20px;
        }

        .md3-navigation-bar.horizontal .md3-nav-item-label {
            font-size: 14px;
        }

        /* Badge positioning */
        .md3-nav-item-icon .md3-badge {
            position: absolute;
            top: -6px;
            right: -6px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .md3-nav-item {
                min-width: 56px;
                padding: 6px 8px;
            }

            .md3-nav-item-label {
                font-size: 11px;
            }

            .md3-navigation-bar.horizontal .md3-nav-item-label {
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .md3-navigation-bar {
                padding: 4px;
            }

            .md3-nav-item {
                min-width: 48px;
                padding: 4px 6px;
            }

            .md3-nav-item-icon {
                font-size: 20px;
            }

            .md3-navigation-bar.horizontal .md3-nav-item-icon {
                font-size: 18px;
            }
        }
        ';
    }
}

?>