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
     * Generate Floating Navigation Bar (elevated)
     */
    public static function floating(array $items, array $options = []): string
    {
        $options['class'] = ($options['class'] ?? '') . ' md3-navigation-bar--floating';
        return self::create($items, $options);
    }

    /**
     * Generate Navigation Bar with only icons (no labels)
     */
    public static function iconsOnly(array $items, array $options = []): string
    {
        $options['class'] = ($options['class'] ?? '') . ' md3-navigation-bar--icons-only';
        return self::create($items, $options);
    }

    /**
     * Render individual navigation item
     */
    private static function renderNavigationItem(array $item): string
    {
        $icon = $item['icon'] ?? 'circle';
        $label = $item['label'] ?? '';
        $href = $item['href'] ?? '#';
        $active = $item['active'] ?? false;
        $badge = $item['badge'] ?? null;
        $disabled = $item['disabled'] ?? false;

        $classes = ['md3-navigation-bar__item'];
        if ($active) $classes[] = 'md3-navigation-bar__item--active';
        if ($disabled) $classes[] = 'md3-navigation-bar__item--disabled';

        $attributes = [
            'class' => implode(' ', $classes),
            'href' => $href,
            'role' => 'tab',
            'aria-selected' => $active ? 'true' : 'false'
        ];

        if ($disabled) {
            $attributes['aria-disabled'] = 'true';
            $attributes['tabindex'] = '-1';
        }

        if ($label) {
            $attributes['aria-label'] = $label;
        }

        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        // Build badge HTML if present
        $badgeHtml = '';
        if ($badge !== null && $badge > 0) {
            $badgeText = $badge > 99 ? '99+' : (string)$badge;
            $badgeHtml = sprintf(
                '<span class="md3-navigation-bar__badge" aria-label="%d new notifications">%s</span>',
                $badge,
                $badgeText
            );
        }

        // Build item content
        $iconHtml = sprintf(
            '<span class="md3-navigation-bar__icon"><span class="material-symbols-outlined">%s</span>%s</span>',
            $icon,
            $badgeHtml
        );

        $labelHtml = $label ? sprintf(
            '<span class="md3-navigation-bar__label">%s</span>',
            htmlspecialchars($label)
        ) : '';

        return sprintf(
            '<a%s>%s%s<span class="md3-navigation-bar__indicator"></span></a>',
            $attributesStr,
            $iconHtml,
            $labelHtml
        );
    }

    /**
     * Generate CSS for Navigation Bar
     */
    public static function getCSS(): string
    {
        return '
        /* Material Design 3 Navigation Bar */
        .md3-navigation-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: var(--md-sys-color-surface);
            border-top: 1px solid var(--md-sys-color-outline-variant);
            display: flex;
            align-items: stretch;
            justify-content: space-around;
            padding: 0;
            box-sizing: border-box;
            z-index: 100;
        }

        .md3-navigation-bar--floating {
            position: fixed;
            bottom: 16px;
            left: 16px;
            right: 16px;
            height: 64px;
            border-radius: 16px;
            border: none;
            background: var(--md-sys-color-surface-container);
            box-shadow: var(--md-sys-elevation-3);
        }

        .md3-navigation-bar--icons-only {
            height: 48px;
        }

        .md3-navigation-bar__item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            height: 100%;
            padding: 8px 4px 4px;
            text-decoration: none;
            color: var(--md-sys-color-on-surface-variant);
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
            cursor: pointer;
            user-select: none;
            outline: none;
            box-sizing: border-box;
        }

        .md3-navigation-bar__item:hover {
            background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 8%, transparent);
        }

        .md3-navigation-bar__item:focus-visible {
            background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 12%, transparent);
            outline: 2px solid var(--md-sys-color-primary);
            outline-offset: 2px;
        }

        .md3-navigation-bar__item--active {
            color: var(--md-sys-color-on-surface);
        }

        .md3-navigation-bar__item--active .md3-navigation-bar__indicator {
            opacity: 1;
            transform: scaleX(1);
        }

        .md3-navigation-bar__item--disabled {
            color: var(--md-sys-color-on-surface);
            opacity: 0.38;
            cursor: not-allowed;
            pointer-events: none;
        }

        .md3-navigation-bar__icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            margin-bottom: 2px;
            font-size: 24px;
            line-height: 1;
            z-index: 1;
        }

        .md3-navigation-bar__label {
            position: relative;
            font-size: 10px;
            font-weight: 500;
            line-height: 12px;
            letter-spacing: 0.5px;
            text-align: center;
            min-height: 12px;
            max-width: 64px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            z-index: 1;
        }

        .md3-navigation-bar--icons-only .md3-navigation-bar__label {
            display: none;
        }

        .md3-navigation-bar--icons-only .md3-navigation-bar__icon {
            margin-bottom: 0;
        }

        .md3-navigation-bar__indicator {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 32px;
            height: 3px;
            background: var(--md-sys-color-on-surface);
            border-radius: 2px 2px 0 0;
            opacity: 0;
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
            z-index: 1;
        }

        .md3-navigation-bar__badge {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 16px;
            height: 16px;
            padding: 0 4px;
            background: var(--md-sys-color-error);
            color: var(--md-sys-color-on-error);
            border-radius: 8px;
            font-size: 10px;
            font-weight: 500;
            line-height: 16px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .md3-navigation-bar {
                padding: 0 4px;
            }

            .md3-navigation-bar__item {
                min-width: 48px;
                padding: 4px 8px 8px;
            }

            .md3-navigation-bar__label {
                font-size: 11px;
            }
        }

        /* Dark theme adjustments */
        @media (prefers-color-scheme: dark) {
            .md3-navigation-bar--floating {
                box-shadow: var(--md-sys-elevation-3);
            }
        }

        /* Tablet and desktop adaptations */
        @media (min-width: 840px) {
            .md3-navigation-bar {
                position: static;
                width: 80px;
                height: auto;
                flex-direction: column;
                border-top: none;
                border-right: 1px solid var(--md-sys-color-outline-variant);
                padding: 24px 0;
            }

            .md3-navigation-bar--floating {
                position: static;
                width: 80px;
                border-radius: 0;
                box-shadow: none;
                background: var(--md-sys-color-surface);
            }

            .md3-navigation-bar__item {
                width: 56px;
                height: 56px;
                margin: 4px 0;
            }
        }
        ';
    }

    /**
     * Generate JavaScript for Navigation Bar interactions
     */
    public static function getScript(): string
    {
        return "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle navigation bar interactions
            const navBars = document.querySelectorAll('.md3-navigation-bar');

            navBars.forEach(navBar => {
                const items = navBar.querySelectorAll('.md3-navigation-bar__item');

                items.forEach(item => {
                    item.addEventListener('click', function(e) {
                        if (this.classList.contains('md3-navigation-bar__item--disabled')) {
                            e.preventDefault();
                            return;
                        }

                        // Remove active state from siblings
                        items.forEach(sibling => {
                            sibling.classList.remove('md3-navigation-bar__item--active');
                            sibling.setAttribute('aria-selected', 'false');
                        });

                        // Add active state to clicked item
                        this.classList.add('md3-navigation-bar__item--active');
                        this.setAttribute('aria-selected', 'true');

                        // Emit custom event
                        const event = new CustomEvent('md3-navigation-change', {
                            detail: {
                                item: this,
                                href: this.href,
                                label: this.querySelector('.md3-navigation-bar__label')?.textContent || ''
                            }
                        });
                        navBar.dispatchEvent(event);
                    });

                    // Ripple effect on touch/click
                    item.addEventListener('pointerdown', function(e) {
                        if (this.classList.contains('md3-navigation-bar__item--disabled')) {
                            return;
                        }

                        const rect = this.getBoundingClientRect();
                        const size = Math.max(rect.width, rect.height);
                        const x = e.clientX - rect.left - size / 2;
                        const y = e.clientY - rect.top - size / 2;

                        const ripple = document.createElement('span');
                        ripple.className = 'md3-ripple';
                        ripple.style.cssText = \`
                            position: absolute;
                            border-radius: 50%;
                            background: currentColor;
                            opacity: 0.1;
                            pointer-events: none;
                            transform: scale(0);
                            animation: md3-ripple-animation 0.6s ease-out;
                            width: \${size}px;
                            height: \${size}px;
                            left: \${x}px;
                            top: \${y}px;
                        \`;

                        this.style.position = 'relative';
                        this.style.overflow = 'hidden';
                        this.appendChild(ripple);

                        setTimeout(() => {
                            if (ripple.parentNode) {
                                ripple.parentNode.removeChild(ripple);
                            }
                        }, 600);
                    });
                });
            });
        });

        // Add ripple animation CSS
        if (!document.querySelector('#md3-ripple-styles')) {
            const style = document.createElement('style');
            style.id = 'md3-ripple-styles';
            style.textContent = \`
                @keyframes md3-ripple-animation {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            \`;
            document.head.appendChild(style);
        }
        </script>
        ";
    }
}

?>