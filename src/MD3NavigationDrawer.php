<?php

/**
 * Material Design 3 Navigation Drawer Component
 *
 * Implementiert MD3 Navigation Drawer für größere Geräte (Desktop/Tablet)
 * Slide-in Seitennavigation mit Header, Items und Overlay-Funktionalität
 *
 * Features:
 * - Standard und Modal Navigation Drawer
 * - Header-Bereich mit Titel/Logo
 * - Navigation Items mit Icons, Labels und Active States
 * - Section Dividers und Subheader
 * - Responsive Overlay für Mobile
 * - Material Design 3 Farben und Animationen
 */

class MD3NavigationDrawer {

    /**
     * Standard Navigation Drawer (immer sichtbar)
     */
    public static function standard(array $items, array $options = []): string {
        $options['type'] = 'standard';
        return self::renderNavigationDrawer($items, $options);
    }

    /**
     * Modal Navigation Drawer (mit Overlay)
     */
    public static function modal(array $items, array $options = []): string {
        $options['type'] = 'modal';
        return self::renderNavigationDrawer($items, $options);
    }

    /**
     * Render Navigation Drawer
     */
    private static function renderNavigationDrawer(array $items, array $options = []): string {
        $type = $options['type'] ?? 'standard';
        $title = $options['title'] ?? '';
        $subtitle = $options['subtitle'] ?? '';
        $id = $options['id'] ?? 'md3-nav-drawer-' . uniqid();
        $open = $options['open'] ?? false;

        $classes = ['md3-navigation-drawer', "md3-navigation-drawer--{$type}"];
        if ($open) $classes[] = 'md3-navigation-drawer--open';

        // Build header
        $headerHtml = '';
        if ($title || $subtitle) {
            $headerHtml = '<div class="md3-navigation-drawer__header">';
            if ($title) {
                $headerHtml .= '<div class="md3-navigation-drawer__title">' . htmlspecialchars($title) . '</div>';
            }
            if ($subtitle) {
                $headerHtml .= '<div class="md3-navigation-drawer__subtitle">' . htmlspecialchars($subtitle) . '</div>';
            }
            $headerHtml .= '</div>';
        }

        // Build navigation items
        $itemsHtml = '<div class="md3-navigation-drawer__content">';
        foreach ($items as $item) {
            $itemsHtml .= self::renderNavigationItem($item);
        }
        $itemsHtml .= '</div>';

        $html = sprintf(
            '<div class="%s" id="%s" role="navigation" aria-label="Main navigation">%s%s</div>',
            implode(' ', $classes),
            $id,
            $headerHtml,
            $itemsHtml
        );

        // Add overlay for modal type
        if ($type === 'modal') {
            $overlayClass = $open ? 'md3-navigation-drawer__overlay md3-navigation-drawer__overlay--visible' : 'md3-navigation-drawer__overlay';
            $html .= sprintf('<div class="%s" onclick="closeNavigationDrawer(\'%s\')"></div>', $overlayClass, $id);
        }

        return $html;
    }

    /**
     * Render individual navigation item
     */
    private static function renderNavigationItem(array $item): string {
        // Handle dividers
        if (($item['type'] ?? '') === 'divider') {
            return '<div class="md3-navigation-drawer__divider"></div>';
        }

        // Handle subheaders
        if (($item['type'] ?? '') === 'subheader') {
            return sprintf(
                '<div class="md3-navigation-drawer__subheader">%s</div>',
                htmlspecialchars($item['text'] ?? '')
            );
        }

        // Regular navigation item
        $icon = $item['icon'] ?? '';
        $text = $item['text'] ?? '';
        $href = $item['href'] ?? '#';
        $active = $item['active'] ?? false;
        $badge = $item['badge'] ?? null;
        $disabled = $item['disabled'] ?? false;

        $classes = ['md3-navigation-drawer__item'];
        if ($active) $classes[] = 'md3-navigation-drawer__item--active';
        if ($disabled) $classes[] = 'md3-navigation-drawer__item--disabled';

        $attributes = [
            'class' => implode(' ', $classes),
            'href' => $href,
            'role' => 'button'
        ];

        if ($disabled) {
            $attributes['aria-disabled'] = 'true';
            $attributes['tabindex'] = '-1';
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
                '<span class="md3-navigation-drawer__badge">%s</span>',
                $badgeText
            );
        }

        // Build item content
        $iconHtml = $icon ? sprintf(
            '<span class="md3-navigation-drawer__icon"><span class="material-symbols-outlined">%s</span>%s</span>',
            $icon,
            $badgeHtml
        ) : '';

        $textHtml = $text ? sprintf(
            '<span class="md3-navigation-drawer__text">%s</span>',
            htmlspecialchars($text)
        ) : '';

        return sprintf(
            '<a%s>%s%s<span class="md3-navigation-drawer__indicator"></span></a>',
            $attributesStr,
            $iconHtml,
            $textHtml
        );
    }

    /**
     * Get Navigation Drawer CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Navigation Drawer */
.md3-navigation-drawer {
    position: fixed;
    top: 0;
    left: -360px;
    width: 360px;
    height: 100vh;
    background: var(--md-sys-color-surface);
    border-right: 1px solid var(--md-sys-color-outline-variant);
    display: flex;
    flex-direction: column;
    z-index: 1200;
    transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--md-sys-elevation-1);
}

.md3-navigation-drawer--standard {
    position: relative;
    left: 0;
    box-shadow: none;
}

.md3-navigation-drawer--open {
    left: 0;
}

.md3-navigation-drawer__header {
    padding: 28px 28px 16px;
    border-bottom: 1px solid var(--md-sys-color-outline-variant);
    min-height: 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.md3-navigation-drawer__title {
    font-size: 22px;
    font-weight: 400;
    line-height: 28px;
    color: var(--md-sys-color-on-surface);
    margin-bottom: 4px;
}

.md3-navigation-drawer__subtitle {
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    color: var(--md-sys-color-on-surface-variant);
}

.md3-navigation-drawer__content {
    flex: 1;
    overflow-y: auto;
    padding: 12px 0;
}

.md3-navigation-drawer__item {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    min-height: 56px;
    padding: 16px 28px 16px 16px;
    margin: 0 12px;
    border-radius: 28px;
    text-decoration: none;
    color: var(--md-sys-color-on-surface-variant);
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    cursor: pointer;
    user-select: none;
    outline: none;
    box-sizing: border-box;
    font-size: 14px;
    font-weight: 500;
}

.md3-navigation-drawer__item:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
}

.md3-navigation-drawer__item:focus-visible {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

.md3-navigation-drawer__item--active {
    background: var(--md-sys-color-secondary-container);
    color: var(--md-sys-color-on-secondary-container);
}

.md3-navigation-drawer__item--active:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-secondary-container) 8%, var(--md-sys-color-secondary-container));
}

.md3-navigation-drawer__item--disabled {
    opacity: 0.38;
    pointer-events: none;
    cursor: not-allowed;
}

.md3-navigation-drawer__icon {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    margin-right: 12px;
    font-size: 24px;
    line-height: 1;
}

.md3-navigation-drawer__text {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
    line-height: 20px;
    letter-spacing: 0.1px;
}

.md3-navigation-drawer__badge {
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

.md3-navigation-drawer__divider {
    height: 1px;
    background: var(--md-sys-color-outline-variant);
    margin: 8px 28px;
}

.md3-navigation-drawer__subheader {
    padding: 16px 28px 8px;
    font-size: 11px;
    font-weight: 500;
    line-height: 16px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: var(--md-sys-color-on-surface-variant);
}

.md3-navigation-drawer__indicator {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: var(--md-sys-color-primary);
    border-radius: 0 2px 2px 0;
    opacity: 0;
    transition: opacity 0.2s cubic-bezier(0.2, 0, 0, 1);
}

.md3-navigation-drawer__item--active .md3-navigation-drawer__indicator {
    opacity: 1;
}

/* Modal Overlay */
.md3-navigation-drawer__overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.32);
    z-index: 1100;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.md3-navigation-drawer__overlay--visible {
    opacity: 1;
    pointer-events: auto;
}

/* Responsive Behavior */
@media (max-width: 768px) {
    .md3-navigation-drawer {
        width: 320px;
    }

    .md3-navigation-drawer--standard {
        position: fixed;
        left: -320px;
    }

    .md3-navigation-drawer--standard.md3-navigation-drawer--open {
        left: 0;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-navigation-drawer {
    border-right-color: var(--md-sys-color-outline-variant);
}

[data-theme="dark"] .md3-navigation-drawer__overlay {
    background: rgba(0, 0, 0, 0.5);
}
';
    }

    /**
     * Get Navigation Drawer JavaScript
     */
    public static function getJS(): string {
        return '
// Navigation Drawer Management
function openNavigationDrawer(drawerId) {
    const drawer = document.getElementById(drawerId);
    const overlay = document.querySelector(".md3-navigation-drawer__overlay");

    if (drawer) {
        drawer.classList.add("md3-navigation-drawer--open");
        if (overlay) {
            overlay.classList.add("md3-navigation-drawer__overlay--visible");
        }

        // Dispatch open event
        const event = new CustomEvent("md3-navigation-drawer-open", {
            detail: { drawer: drawer, drawerId: drawerId }
        });
        drawer.dispatchEvent(event);
    }
}

function closeNavigationDrawer(drawerId) {
    const drawer = document.getElementById(drawerId);
    const overlay = document.querySelector(".md3-navigation-drawer__overlay");

    if (drawer) {
        drawer.classList.remove("md3-navigation-drawer--open");
        if (overlay) {
            overlay.classList.remove("md3-navigation-drawer__overlay--visible");
        }

        // Dispatch close event
        const event = new CustomEvent("md3-navigation-drawer-close", {
            detail: { drawer: drawer, drawerId: drawerId }
        });
        drawer.dispatchEvent(event);
    }
}

function toggleNavigationDrawer(drawerId) {
    const drawer = document.getElementById(drawerId);
    if (drawer) {
        const isOpen = drawer.classList.contains("md3-navigation-drawer--open");
        if (isOpen) {
            closeNavigationDrawer(drawerId);
        } else {
            openNavigationDrawer(drawerId);
        }
    }
}

// Initialize Navigation Drawer
document.addEventListener("DOMContentLoaded", function() {
    // Close drawer on escape key
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") {
            const openDrawers = document.querySelectorAll(".md3-navigation-drawer--open");
            openDrawers.forEach(drawer => {
                closeNavigationDrawer(drawer.id);
            });
        }
    });

    // Handle responsive behavior
    function handleResize() {
        const standardDrawers = document.querySelectorAll(".md3-navigation-drawer--standard");
        standardDrawers.forEach(drawer => {
            if (window.innerWidth <= 768) {
                drawer.classList.remove("md3-navigation-drawer--open");
            }
        });
    }

    window.addEventListener("resize", handleResize);
    handleResize(); // Initial check
});

// Make functions globally available
window.openNavigationDrawer = openNavigationDrawer;
window.closeNavigationDrawer = closeNavigationDrawer;
window.toggleNavigationDrawer = toggleNavigationDrawer;
';
    }
}