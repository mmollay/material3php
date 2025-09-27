<?php

/**
 * Material Design 3 Toolbar Component
 *
 * Implementiert MD3 Toolbars für verschiedene Use Cases
 * Top App Bar, Bottom App Bar, Navigation Toolbar
 */

class MD3Toolbar {

    /**
     * Top App Bar (Standard)
     */
    public static function topAppBar(string $title, array $options = []): string {
        $leadingIcon = $options['leading_icon'] ?? 'menu';
        $trailingActions = $options['trailing_actions'] ?? [];
        $scrollBehavior = $options['scroll_behavior'] ?? 'standard'; // standard, medium, large, center-aligned

        $id = $options['id'] ?? 'md3-toolbar-' . uniqid();

        $classes = ['md3-toolbar', 'md3-toolbar--top', "md3-toolbar--{$scrollBehavior}"];
        if ($options['prominent'] ?? false) $classes[] = 'md3-toolbar--prominent';

        $toolbar = '<div class="' . implode(' ', $classes) . '" id="' . htmlspecialchars($id) . '">';

        // Leading icon/navigation
        if ($leadingIcon) {
            $toolbar .= '<button class="md3-toolbar__leading" aria-label="Navigation">';
            $toolbar .= '<span class="material-symbols-outlined">' . htmlspecialchars($leadingIcon) . '</span>';
            $toolbar .= '</button>';
        }

        // Title
        $toolbar .= '<div class="md3-toolbar__title">' . htmlspecialchars($title) . '</div>';

        // Trailing actions
        if (!empty($trailingActions)) {
            $toolbar .= '<div class="md3-toolbar__trailing">';
            foreach ($trailingActions as $action) {
                $toolbar .= '<button class="md3-toolbar__action" aria-label="' . htmlspecialchars($action['label'] ?? 'Action') . '"';
                if ($action['onclick'] ?? false) {
                    $toolbar .= ' onclick="' . htmlspecialchars($action['onclick']) . '"';
                }
                $toolbar .= '>';
                $toolbar .= '<span class="material-symbols-outlined">' . htmlspecialchars($action['icon'] ?? 'more_vert') . '</span>';
                $toolbar .= '</button>';
            }
            $toolbar .= '</div>';
        }

        $toolbar .= '</div>';

        return $toolbar;
    }

    /**
     * Bottom App Bar
     */
    public static function bottomAppBar(array $actions = [], array $options = []): string {
        $fabIcon = $options['fab_icon'] ?? null;
        $fabPosition = $options['fab_position'] ?? 'end'; // start, center, end

        $id = $options['id'] ?? 'md3-toolbar-bottom-' . uniqid();

        $toolbar = '<div class="md3-toolbar md3-toolbar--bottom" id="' . htmlspecialchars($id) . '">';

        // Actions container
        $toolbar .= '<div class="md3-toolbar__actions">';
        foreach ($actions as $action) {
            $toolbar .= '<button class="md3-toolbar__action" aria-label="' . htmlspecialchars($action['label'] ?? 'Action') . '"';
            if ($action['onclick'] ?? false) {
                $toolbar .= ' onclick="' . htmlspecialchars($action['onclick']) . '"';
            }
            $toolbar .= '>';
            $toolbar .= '<span class="material-symbols-outlined">' . htmlspecialchars($action['icon'] ?? 'home') . '</span>';
            $toolbar .= '</button>';
        }
        $toolbar .= '</div>';

        // Floating Action Button
        if ($fabIcon) {
            $toolbar .= '<div class="md3-toolbar__fab md3-toolbar__fab--' . htmlspecialchars($fabPosition) . '">';
            $toolbar .= '<button class="md3-fab md3-fab--primary" aria-label="' . htmlspecialchars($options['fab_label'] ?? 'Main action') . '"';
            if ($options['fab_onclick'] ?? false) {
                $toolbar .= ' onclick="' . htmlspecialchars($options['fab_onclick']) . '"';
            }
            $toolbar .= '>';
            $toolbar .= '<span class="material-symbols-outlined">' . htmlspecialchars($fabIcon) . '</span>';
            $toolbar .= '</button>';
            $toolbar .= '</div>';
        }

        $toolbar .= '</div>';

        return $toolbar;
    }

    /**
     * Navigation Toolbar (für Breadcrumbs, etc.)
     */
    public static function navigation(array $items, array $options = []): string {
        $id = $options['id'] ?? 'md3-toolbar-nav-' . uniqid();

        $toolbar = '<nav class="md3-toolbar md3-toolbar--navigation" id="' . htmlspecialchars($id) . '">';
        $toolbar .= '<div class="md3-toolbar__content">';

        foreach ($items as $index => $item) {
            if ($index > 0) {
                $toolbar .= '<span class="md3-toolbar__separator">';
                $toolbar .= '<span class="material-symbols-outlined">chevron_right</span>';
                $toolbar .= '</span>';
            }

            if ($item['href'] ?? false) {
                $toolbar .= '<a href="' . htmlspecialchars($item['href']) . '" class="md3-toolbar__nav-item">';
                $toolbar .= htmlspecialchars($item['text']);
                $toolbar .= '</a>';
            } else {
                $toolbar .= '<span class="md3-toolbar__nav-item md3-toolbar__nav-item--current">';
                $toolbar .= htmlspecialchars($item['text']);
                $toolbar .= '</span>';
            }
        }

        $toolbar .= '</div>';
        $toolbar .= '</nav>';

        return $toolbar;
    }

    /**
     * Get Toolbar CSS
     */
    public static function getCSS(): string {
        return '
/* MD3 Toolbar Component */
.md3-toolbar {
    display: flex;
    align-items: center;
    min-height: 64px;
    padding: 0 16px;
    background: var(--md-sys-color-surface);
    color: var(--md-sys-color-on-surface);
    box-sizing: border-box;
    position: relative;
    width: 100%;
}

/* Top App Bar */
.md3-toolbar--top {
    background: var(--md-sys-color-surface-container);
    border-bottom: 1px solid var(--md-sys-color-outline-variant);
    box-shadow: var(--md-sys-elevation-1);
}

.md3-toolbar--medium {
    min-height: 112px;
}

.md3-toolbar--large {
    min-height: 152px;
}

.md3-toolbar--prominent {
    min-height: 128px;
}

.md3-toolbar__leading {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border: none;
    background: transparent;
    border-radius: 24px;
    color: var(--md-sys-color-on-surface);
    cursor: pointer;
    transition: background-color 0.2s;
    margin-right: 16px;
}

.md3-toolbar__leading:hover {
    background: var(--md-sys-color-on-surface);
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
}

.md3-toolbar__title {
    flex: 1;
    font-size: 22px;
    font-weight: 400;
    line-height: 28px;
    color: var(--md-sys-color-on-surface);
    margin: 0;
}

.md3-toolbar__trailing {
    display: flex;
    align-items: center;
    gap: 8px;
}

.md3-toolbar__action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border: none;
    background: transparent;
    border-radius: 24px;
    color: var(--md-sys-color-on-surface-variant);
    cursor: pointer;
    transition: all 0.2s;
}

.md3-toolbar__action:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
    color: var(--md-sys-color-on-surface);
}

/* Bottom App Bar */
.md3-toolbar--bottom {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: var(--md-sys-color-surface-container);
    border-top: 1px solid var(--md-sys-color-outline-variant);
    box-shadow: var(--md-sys-elevation-3);
    justify-content: space-between;
    z-index: 1000;
}

.md3-toolbar__actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.md3-toolbar__fab {
    position: relative;
}

.md3-toolbar__fab--end {
    margin-left: auto;
}

.md3-toolbar__fab--center {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

.md3-fab {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    border: none;
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: var(--md-sys-elevation-3);
}

.md3-fab--primary {
    background: var(--md-sys-color-primary-container);
    color: var(--md-sys-color-on-primary-container);
}

.md3-fab:hover {
    box-shadow: var(--md-sys-elevation-4);
    transform: scale(1.05);
}

/* Navigation Toolbar */
.md3-toolbar--navigation {
    background: var(--md-sys-color-surface-variant);
    min-height: 48px;
    padding: 8px 16px;
}

.md3-toolbar__content {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
}

.md3-toolbar__separator {
    display: flex;
    align-items: center;
    color: var(--md-sys-color-on-surface-variant);
    font-size: 16px;
}

.md3-toolbar__nav-item {
    color: var(--md-sys-color-primary);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.md3-toolbar__nav-item:hover {
    background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
}

.md3-toolbar__nav-item--current {
    color: var(--md-sys-color-on-surface);
    background: var(--md-sys-color-surface-container-highest);
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-toolbar {
        min-height: 56px;
        padding: 0 12px;
    }

    .md3-toolbar__title {
        font-size: 20px;
    }

    .md3-toolbar__leading,
    .md3-toolbar__action {
        width: 40px;
        height: 40px;
    }

    .md3-toolbar__leading {
        margin-right: 12px;
    }
}

/* Dark Theme */
[data-theme="dark"] .md3-toolbar--top {
    background: var(--md-sys-color-surface);
}

[data-theme="dark"] .md3-toolbar--bottom {
    background: var(--md-sys-color-surface);
}
';
    }

    /**
     * Get Toolbar JavaScript
     */
    public static function getJS(): string {
        return '
// MD3 Toolbar Interactions
document.addEventListener("DOMContentLoaded", function() {
    // Handle scroll behavior for top app bars
    const topToolbars = document.querySelectorAll(".md3-toolbar--top");

    topToolbars.forEach(toolbar => {
        let lastScrollTop = 0;

        window.addEventListener("scroll", function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                toolbar.style.transform = "translateY(-100%)";
            } else {
                // Scrolling up
                toolbar.style.transform = "translateY(0)";
            }

            lastScrollTop = scrollTop;
        }, { passive: true });
    });

    // Add ripple effects to toolbar actions
    const toolbarActions = document.querySelectorAll(".md3-toolbar__action, .md3-toolbar__leading");

    toolbarActions.forEach(action => {
        action.addEventListener("click", function(e) {
            const ripple = document.createElement("div");
            ripple.className = "md3-ripple";
            ripple.style.position = "absolute";
            ripple.style.borderRadius = "50%";
            ripple.style.background = "rgba(var(--md-sys-color-on-surface-rgb), 0.2)";
            ripple.style.transform = "scale(0)";
            ripple.style.animation = "md3-ripple 0.6s linear";
            ripple.style.pointerEvents = "none";

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + "px";
            ripple.style.left = x + "px";
            ripple.style.top = y + "px";

            this.style.position = "relative";
            this.style.overflow = "hidden";
            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });
});
';
    }
}