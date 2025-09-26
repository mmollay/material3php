<?php

/**
 * Material Design 3 Navigation Rail Component
 *
 * Implementiert MD3 Navigation Rail für mittlere Geräte (Tablets)
 * Kompakte vertikale Navigation an der linken Seite
 *
 * Features:
 * - Kompakte vertikale Navigation für Tablets
 * - Optional mit Header/FAB Bereich
 * - Navigation Items mit Icons, Labels und Active States
 * - Material Design 3 Farben und Spacing
 * - Responsive für verschiedene Bildschirmgrößen
 */

class MD3NavigationRail {

    /**
     * Standard Navigation Rail
     */
    public static function create(array $items, array $options = []): string {
        return self::renderNavigationRail($items, $options);
    }

    /**
     * Navigation Rail mit Header/FAB
     */
    public static function withHeader(array $items, array $options = []): string {
        $options['show_header'] = true;
        return self::renderNavigationRail($items, $options);
    }

    /**
     * Compact Navigation Rail (nur Icons)
     */
    public static function compact(array $items, array $options = []): string {
        $options['compact'] = true;
        return self::renderNavigationRail($items, $options);
    }

    /**
     * Render Navigation Rail
     */
    private static function renderNavigationRail(array $items, array $options = []): string {
        $id = $options['id'] ?? 'md3-nav-rail-' . uniqid();
        $showHeader = $options['show_header'] ?? false;
        $compact = $options['compact'] ?? false;
        $fabIcon = $options['fab_icon'] ?? 'add';
        $fabAction = $options['fab_action'] ?? '';

        $classes = ['md3-navigation-rail'];
        if ($compact) $classes[] = 'md3-navigation-rail--compact';

        // Build header with optional FAB
        $headerHtml = '';
        if ($showHeader) {
            $headerHtml = '<div class="md3-navigation-rail__header">';
            if ($fabIcon) {
                $headerHtml .= sprintf(
                    '<button class="md3-navigation-rail__fab" onclick="%s" aria-label="Create new">
                        <span class="material-symbols-outlined">%s</span>
                    </button>',
                    $fabAction ?: 'console.log("FAB clicked")',
                    $fabIcon
                );
            }
            $headerHtml .= '</div>';
        }

        // Build navigation items
        $itemsHtml = '<div class="md3-navigation-rail__content">';
        foreach ($items as $item) {
            $itemsHtml .= self::renderNavigationItem($item, $compact);
        }
        $itemsHtml .= '</div>';

        return sprintf(
            '<nav class="%s" id="%s" role="navigation" aria-label="Main navigation">%s%s</nav>',
            implode(' ', $classes),
            $id,
            $headerHtml,
            $itemsHtml
        );
    }

    /**
     * Render individual navigation item
     */
    private static function renderNavigationItem(array $item, bool $compact = false): string {
        $icon = $item['icon'] ?? '';
        $label = $item['label'] ?? '';
        $href = $item['href'] ?? '#';
        $active = $item['active'] ?? false;
        $badge = $item['badge'] ?? null;
        $disabled = $item['disabled'] ?? false;

        $classes = ['md3-navigation-rail__item'];
        if ($active) $classes[] = 'md3-navigation-rail__item--active';
        if ($disabled) $classes[] = 'md3-navigation-rail__item--disabled';

        $attributes = [
            'class' => implode(' ', $classes),
            'href' => $href,
            'role' => 'button',
            'aria-label' => $label ?: $icon
        ];

        if ($disabled) {
            $attributes['aria-disabled'] = 'true';
            $attributes['tabindex'] = '-1';
        }

        if ($active) {
            $attributes['aria-current'] = 'page';
        }

        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        // Build badge HTML
        $badgeHtml = '';
        if ($badge !== null && $badge > 0) {
            $badgeText = $badge > 99 ? '99+' : (string)$badge;
            $badgeHtml = sprintf(
                '<span class="md3-navigation-rail__badge">%s</span>',
                $badgeText
            );
        }

        // Build item content
        $iconHtml = $icon ? sprintf(
            '<span class="md3-navigation-rail__icon"><span class="material-symbols-outlined">%s</span>%s</span>',
            $icon,
            $badgeHtml
        ) : '';

        $labelHtml = (!$compact && $label) ? sprintf(
            '<span class="md3-navigation-rail__label">%s</span>',
            htmlspecialchars($label)
        ) : '';

        return sprintf(
            '<a%s>%s%s<span class="md3-navigation-rail__indicator"></span></a>',
            $attributesStr,
            $iconHtml,
            $labelHtml
        );
    }

    /**
     * Get Navigation Rail CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Navigation Rail */
.md3-navigation-rail {
    position: fixed;
    top: 0;
    left: 0;
    width: 80px;
    height: 100vh;
    background: var(--md-sys-color-surface);
    border-right: 1px solid var(--md-sys-color-outline-variant);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 4px 0;
    z-index: 1000;
    box-shadow: var(--md-sys-elevation-1);
}

.md3-navigation-rail--compact {
    width: 72px;
}

.md3-navigation-rail__header {
    padding: 8px 0 16px;
    margin-bottom: 8px;
    border-bottom: 1px solid var(--md-sys-color-outline-variant);
    width: 100%;
    display: flex;
    justify-content: center;
}

.md3-navigation-rail__fab {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: var(--md-sys-color-primary-container);
    color: var(--md-sys-color-on-primary-container);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    box-shadow: var(--md-sys-elevation-3);
}

.md3-navigation-rail__fab:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-primary-container) 8%, var(--md-sys-color-primary-container));
    box-shadow: var(--md-sys-elevation-4);
}

.md3-navigation-rail__fab:active {
    box-shadow: var(--md-sys-elevation-1);
}

.md3-navigation-rail__content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 4px 0;
}

.md3-navigation-rail__item {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 72px;
    min-height: 72px;
    padding: 12px 8px;
    border-radius: 16px;
    text-decoration: none;
    color: var(--md-sys-color-on-surface-variant);
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    cursor: pointer;
    user-select: none;
    outline: none;
    box-sizing: border-box;
}

.md3-navigation-rail__item:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 8%, transparent);
}

.md3-navigation-rail__item:focus-visible {
    background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 12%, transparent);
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

.md3-navigation-rail__item--active {
    background: var(--md-sys-color-secondary-container);
    color: var(--md-sys-color-on-secondary-container);
}

.md3-navigation-rail__item--active:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-secondary-container) 8%, var(--md-sys-color-secondary-container));
}

.md3-navigation-rail__item--disabled {
    opacity: 0.38;
    pointer-events: none;
    cursor: not-allowed;
}

.md3-navigation-rail__icon {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    margin-bottom: 4px;
    font-size: 24px;
    line-height: 1;
}

.md3-navigation-rail__label {
    font-size: 12px;
    font-weight: 500;
    line-height: 16px;
    letter-spacing: 0.5px;
    text-align: center;
    max-width: 64px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.md3-navigation-rail--compact .md3-navigation-rail__item {
    width: 64px;
    min-height: 56px;
    padding: 12px 4px;
}

.md3-navigation-rail--compact .md3-navigation-rail__label {
    display: none;
}

.md3-navigation-rail--compact .md3-navigation-rail__icon {
    margin-bottom: 0;
}

.md3-navigation-rail__badge {
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
}

.md3-navigation-rail__indicator {
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%) scaleY(0);
    width: 3px;
    height: 32px;
    background: var(--md-sys-color-primary);
    border-radius: 0 2px 2px 0;
    opacity: 0;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
}

.md3-navigation-rail__item--active .md3-navigation-rail__indicator {
    opacity: 1;
    transform: translateY(-50%) scaleY(1);
}

/* Responsive Behavior */
@media (max-width: 1024px) {
    .md3-navigation-rail {
        display: none;
    }
}

@media (min-width: 1024px) and (max-width: 1200px) {
    .md3-navigation-rail {
        width: 72px;
    }

    .md3-navigation-rail__item {
        width: 64px;
        min-height: 64px;
    }

    .md3-navigation-rail__label {
        font-size: 11px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-navigation-rail {
    border-right-color: var(--md-sys-color-outline-variant);
}

/* Body padding when rail is active */
@media (min-width: 1024px) {
    body.has-navigation-rail {
        padding-left: 80px;
    }

    body.has-navigation-rail.navigation-rail-compact {
        padding-left: 72px;
    }
}
';
    }

    /**
     * Get Navigation Rail JavaScript
     */
    public static function getJS(): string {
        return '
// Navigation Rail Management
document.addEventListener("DOMContentLoaded", function() {
    const navigationRail = document.querySelector(".md3-navigation-rail");

    if (navigationRail) {
        // Add body class for layout adjustment
        document.body.classList.add("has-navigation-rail");

        if (navigationRail.classList.contains("md3-navigation-rail--compact")) {
            document.body.classList.add("navigation-rail-compact");
        }

        // Handle responsive behavior
        function handleResize() {
            if (window.innerWidth < 1024) {
                document.body.classList.remove("has-navigation-rail", "navigation-rail-compact");
            } else {
                document.body.classList.add("has-navigation-rail");
                if (navigationRail.classList.contains("md3-navigation-rail--compact")) {
                    document.body.classList.add("navigation-rail-compact");
                }
            }
        }

        window.addEventListener("resize", handleResize);
        handleResize(); // Initial check
    }

    // Navigation item click handling
    const railItems = document.querySelectorAll(".md3-navigation-rail__item");
    railItems.forEach(item => {
        item.addEventListener("click", function(e) {
            if (this.hasAttribute("aria-disabled")) {
                e.preventDefault();
                return;
            }

            // Remove active from other items
            railItems.forEach(otherItem => {
                otherItem.classList.remove("md3-navigation-rail__item--active");
                otherItem.removeAttribute("aria-current");
            });

            // Add active to clicked item
            this.classList.add("md3-navigation-rail__item--active");
            this.setAttribute("aria-current", "page");

            // Dispatch custom event
            const event = new CustomEvent("md3-navigation-rail-select", {
                detail: {
                    item: this,
                    href: this.getAttribute("href")
                }
            });
            this.dispatchEvent(event);
        });
    });
});
';
    }
}