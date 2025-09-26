<?php

/**
 * Material Design 3 Tooltip Component
 *
 * Implementiert MD3 Tooltips mit vollständigem Styling und Interaktion
 *
 * Features:
 * - Basic Tooltips
 * - Rich Tooltips mit Titel und Beschreibung
 * - Tooltips mit Icons
 * - Positionierbare Tooltips
 * - Help Tooltips
 * - Action Tooltips
 * - Delayed Tooltips
 * - Keyboard Support
 * - Touch Support
 * - Smooth Animations
 */

class MD3Tooltip {

    /**
     * Basic Tooltip
     */
    public static function basic(string $content, string $targetId, array $options = []): string {
        return self::renderTooltip($content, $targetId, $options);
    }

    /**
     * Rich Tooltip mit Titel und Beschreibung
     */
    public static function rich(string $title, string $description, string $targetId, array $options = []): string {
        $options['rich'] = true;
        $options['title'] = $title;
        $options['description'] = $description;
        return self::renderTooltip('', $targetId, $options);
    }

    /**
     * Tooltip mit Icon
     */
    public static function withIcon(string $content, string $icon, string $targetId, array $options = []): string {
        $options['icon'] = $icon;
        return self::renderTooltip($content, $targetId, $options);
    }

    /**
     * Help Tooltip (Question Mark Icon)
     */
    public static function help(string $helpText, string $id, array $options = []): string {
        $options['isHelp'] = true;
        $options['helpId'] = $id;
        return self::renderTooltip($helpText, $id . '-trigger', $options);
    }

    /**
     * Tooltip mit Actions
     */
    public static function withActions(string $content, array $actions, string $targetId, array $options = []): string {
        $options['actions'] = $actions;
        return self::renderTooltip($content, $targetId, $options);
    }

    /**
     * Positioniertes Tooltip
     */
    public static function positioned(string $content, string $targetId, string $position = 'top', array $options = []): string {
        $options['position'] = $position;
        return self::renderTooltip($content, $targetId, $options);
    }

    /**
     * Delayed Tooltip
     */
    public static function withDelay(string $content, string $targetId, int $showDelay = 500, int $hideDelay = 300, array $options = []): string {
        $options['showDelay'] = $showDelay;
        $options['hideDelay'] = $hideDelay;
        return self::renderTooltip($content, $targetId, $options);
    }

    /**
     * Attach Tooltip zu Element
     */
    public static function attach(string $elementHtml, string $tooltipContent, string $elementId, array $options = []): string {
        // Add ID to element if not present
        if (strpos($elementHtml, 'id=') === false) {
            $elementHtml = str_replace('>', ' id="' . htmlspecialchars($elementId) . '">', $elementHtml);
        }

        $tooltip = self::renderTooltip($tooltipContent, $elementId, $options);

        return '<div class="md3-tooltip-wrapper">' . $elementHtml . $tooltip . '</div>';
    }

    /**
     * Render Tooltip Structure
     */
    private static function renderTooltip(string $content, string $targetId, array $options = []): string {
        $id = $options['id'] ?? 'md3-tooltip-' . uniqid();
        $position = $options['position'] ?? 'top';
        $showDelay = $options['showDelay'] ?? 500;
        $hideDelay = $options['hideDelay'] ?? 300;
        $rich = $options['rich'] ?? false;
        $icon = $options['icon'] ?? '';
        $actions = $options['actions'] ?? [];
        $isHelp = $options['isHelp'] ?? false;
        $helpId = $options['helpId'] ?? '';

        $classes = ['md3-tooltip'];
        $classes[] = 'md3-tooltip--' . $position;
        if ($rich) $classes[] = 'md3-tooltip--rich';
        if ($icon) $classes[] = 'md3-tooltip--with-icon';
        if (!empty($actions)) $classes[] = 'md3-tooltip--with-actions';
        if (!empty($options['class'])) $classes[] = $options['class'];

        $html = '';

        // Help icon trigger (if help tooltip)
        if ($isHelp) {
            $html .= '<button class="md3-tooltip__help-trigger" id="' . $targetId . '" aria-describedby="' . $id . '" type="button">';
            $html .= '<span class="material-symbols-outlined">help</span>';
            $html .= '</button>';
        }

        // Tooltip element
        $tooltipAttrs = [
            'class' => implode(' ', $classes),
            'id' => $id,
            'role' => 'tooltip',
            'data-target' => $targetId,
            'data-show-delay' => $showDelay,
            'data-hide-delay' => $hideDelay,
            'aria-hidden' => 'true'
        ];

        $tooltipAttrsStr = '';
        foreach ($tooltipAttrs as $key => $val) {
            $tooltipAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
        }

        $html .= sprintf('<div%s>', $tooltipAttrsStr);

        // Tooltip arrow
        $html .= '<div class="md3-tooltip__arrow"></div>';

        // Tooltip content container
        $html .= '<div class="md3-tooltip__content">';

        if ($rich) {
            // Rich tooltip with title and description
            if (!empty($options['title'])) {
                $html .= '<div class="md3-tooltip__title">' . htmlspecialchars($options['title']) . '</div>';
            }
            if (!empty($options['description'])) {
                $html .= '<div class="md3-tooltip__description">' . htmlspecialchars($options['description']) . '</div>';
            }
        } else {
            // Regular content
            $html .= '<div class="md3-tooltip__text">';

            if ($icon) {
                $html .= '<span class="md3-tooltip__icon">';
                $html .= '<span class="material-symbols-outlined">' . htmlspecialchars($icon) . '</span>';
                $html .= '</span>';
            }

            $html .= '<span class="md3-tooltip__text-content">' . htmlspecialchars($content) . '</span>';

            $html .= '</div>';
        }

        // Actions (if any)
        if (!empty($actions)) {
            $html .= '<div class="md3-tooltip__actions">';
            foreach ($actions as $action) {
                $actionText = $action['text'] ?? 'Action';
                $actionOnclick = $action['onclick'] ?? '';
                $actionClass = $action['class'] ?? '';

                $actionAttrs = [
                    'class' => 'md3-tooltip__action ' . $actionClass,
                    'type' => 'button'
                ];

                if ($actionOnclick) {
                    $actionAttrs['onclick'] = $actionOnclick;
                }

                $actionAttrsStr = '';
                foreach ($actionAttrs as $key => $val) {
                    $actionAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
                }

                $html .= sprintf('<button%s>%s</button>', $actionAttrsStr, htmlspecialchars($actionText));
            }
            $html .= '</div>';
        }

        $html .= '</div>'; // End content

        $html .= '</div>'; // End tooltip

        return $html;
    }

    /**
     * Get Tooltip CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Tooltip Component */
.md3-tooltip-wrapper {
    position: relative;
    display: inline-block;
}

.md3-tooltip {
    position: absolute;
    z-index: 1000;
    background: var(--md-sys-color-inverse-surface);
    color: var(--md-sys-color-inverse-on-surface);
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    line-height: 1.3;
    max-width: 200px;
    word-wrap: break-word;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.15s ease-in-out, visibility 0.15s ease-in-out, transform 0.15s ease-in-out;
    transform: scale(0.8);
    box-shadow: var(--md-sys-elevation-level2);
}

.md3-tooltip--visible {
    opacity: 1;
    visibility: visible;
    transform: scale(1);
}

.md3-tooltip--rich {
    max-width: 280px;
    padding: 12px 16px;
}

.md3-tooltip--with-actions {
    pointer-events: auto;
}

/* Tooltip Arrow */
.md3-tooltip__arrow {
    position: absolute;
    width: 8px;
    height: 8px;
    background: var(--md-sys-color-inverse-surface);
    transform: rotate(45deg);
}

/* Position: Top */
.md3-tooltip--top {
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) scale(0.8);
    margin-bottom: 8px;
}

.md3-tooltip--top.md3-tooltip--visible {
    transform: translateX(-50%) scale(1);
}

.md3-tooltip--top .md3-tooltip__arrow {
    top: 100%;
    left: 50%;
    transform: translateX(-50%) rotate(45deg);
    margin-top: -4px;
}

/* Position: Bottom */
.md3-tooltip--bottom {
    top: 100%;
    left: 50%;
    transform: translateX(-50%) scale(0.8);
    margin-top: 8px;
}

.md3-tooltip--bottom.md3-tooltip--visible {
    transform: translateX(-50%) scale(1);
}

.md3-tooltip--bottom .md3-tooltip__arrow {
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) rotate(45deg);
    margin-bottom: -4px;
}

/* Position: Left */
.md3-tooltip--left {
    right: 100%;
    top: 50%;
    transform: translateY(-50%) scale(0.8);
    margin-right: 8px;
}

.md3-tooltip--left.md3-tooltip--visible {
    transform: translateY(-50%) scale(1);
}

.md3-tooltip--left .md3-tooltip__arrow {
    left: 100%;
    top: 50%;
    transform: translateY(-50%) rotate(45deg);
    margin-left: -4px;
}

/* Position: Right */
.md3-tooltip--right {
    left: 100%;
    top: 50%;
    transform: translateY(-50%) scale(0.8);
    margin-left: 8px;
}

.md3-tooltip--right.md3-tooltip--visible {
    transform: translateY(-50%) scale(1);
}

.md3-tooltip--right .md3-tooltip__arrow {
    right: 100%;
    top: 50%;
    transform: translateY(-50%) rotate(45deg);
    margin-right: -4px;
}

/* Tooltip Content */
.md3-tooltip__content {
    position: relative;
    z-index: 1;
}

.md3-tooltip__text {
    display: flex;
    align-items: center;
    gap: 6px;
}

.md3-tooltip__icon {
    font-size: 16px;
    line-height: 1;
    flex-shrink: 0;
}

.md3-tooltip__text-content {
    flex: 1;
}

/* Rich Tooltip Content */
.md3-tooltip__title {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 4px;
}

.md3-tooltip__description {
    font-weight: 400;
    opacity: 0.9;
}

/* Tooltip Actions */
.md3-tooltip__actions {
    display: flex;
    gap: 8px;
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid color-mix(in srgb, var(--md-sys-color-inverse-on-surface) 20%, transparent);
}

.md3-tooltip__action {
    background: none;
    border: none;
    color: var(--md-sys-color-inverse-primary);
    font-size: 12px;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.15s ease;
}

.md3-tooltip__action:hover {
    background: color-mix(in srgb, var(--md-sys-color-inverse-on-surface) 10%, transparent);
}

.md3-tooltip__action:focus {
    outline: 2px solid var(--md-sys-color-inverse-primary);
    outline-offset: 1px;
}

/* Help Tooltip Trigger */
.md3-tooltip__help-trigger {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    background: none;
    border: none;
    border-radius: 50%;
    color: var(--md-sys-color-on-surface-variant);
    cursor: pointer;
    font-size: 16px;
    transition: all 0.15s ease;
}

.md3-tooltip__help-trigger:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
    color: var(--md-sys-color-on-surface);
}

.md3-tooltip__help-trigger:focus {
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-tooltip {
        max-width: 160px;
        font-size: 11px;
        padding: 6px 10px;
    }

    .md3-tooltip--rich {
        max-width: 240px;
        padding: 10px 14px;
    }

    .md3-tooltip__title {
        font-size: 13px;
    }

    .md3-tooltip__icon {
        font-size: 14px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-tooltip {
    background: var(--md-sys-color-inverse-surface);
    color: var(--md-sys-color-inverse-on-surface);
    box-shadow: var(--md-sys-elevation-level2);
}

[data-theme="dark"] .md3-tooltip__arrow {
    background: var(--md-sys-color-inverse-surface);
}

[data-theme="dark"] .md3-tooltip__action {
    color: var(--md-sys-color-inverse-primary);
}

[data-theme="dark"] .md3-tooltip__help-trigger {
    color: var(--md-sys-color-on-surface-variant);
}

[data-theme="dark"] .md3-tooltip__help-trigger:hover {
    color: var(--md-sys-color-on-surface);
}

/* Animation for smooth entrance */
@keyframes md3-tooltip-fade-in {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes md3-tooltip-fade-out {
    from {
        opacity: 1;
        transform: scale(1);
    }
    to {
        opacity: 0;
        transform: scale(0.8);
    }
}
';
    }

    /**
     * Get Tooltip JavaScript
     */
    public static function getJS(): string {
        return '
// Tooltip Management
document.addEventListener("DOMContentLoaded", function() {
    let activeTooltips = new Map();
    let showTimeouts = new Map();
    let hideTimeouts = new Map();

    // Initialize all tooltips
    document.querySelectorAll(".md3-tooltip").forEach(initTooltip);

    function initTooltip(tooltip) {
        const targetId = tooltip.dataset.target;
        const target = document.getElementById(targetId);

        if (!target) return;

        const showDelay = parseInt(tooltip.dataset.showDelay) || 500;
        const hideDelay = parseInt(tooltip.dataset.hideDelay) || 300;

        // Position tooltip relative to target
        positionTooltip(tooltip, target);

        // Mouse events
        target.addEventListener("mouseenter", () => {
            clearTimeout(hideTimeouts.get(tooltip));
            hideTimeouts.delete(tooltip);

            const timeoutId = setTimeout(() => {
                showTooltip(tooltip);
            }, showDelay);

            showTimeouts.set(tooltip, timeoutId);
        });

        target.addEventListener("mouseleave", () => {
            clearTimeout(showTimeouts.get(tooltip));
            showTimeouts.delete(tooltip);

            const timeoutId = setTimeout(() => {
                hideTooltip(tooltip);
            }, hideDelay);

            hideTimeouts.set(tooltip, timeoutId);
        });

        // Touch events (mobile)
        target.addEventListener("touchstart", (e) => {
            e.preventDefault();

            // Hide other tooltips
            document.querySelectorAll(".md3-tooltip--visible").forEach(t => {
                if (t !== tooltip) hideTooltip(t);
            });

            if (tooltip.classList.contains("md3-tooltip--visible")) {
                hideTooltip(tooltip);
            } else {
                showTooltip(tooltip);

                // Auto-hide after 3 seconds on touch
                setTimeout(() => {
                    hideTooltip(tooltip);
                }, 3000);
            }
        }, { passive: false });

        // Keyboard events
        target.addEventListener("focus", () => {
            showTooltip(tooltip);
        });

        target.addEventListener("blur", () => {
            hideTooltip(tooltip);
        });

        target.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                hideTooltip(tooltip);
            }
        });

        // Keep tooltip visible when hovering over it (for interactive tooltips)
        if (tooltip.classList.contains("md3-tooltip--with-actions")) {
            tooltip.addEventListener("mouseenter", () => {
                clearTimeout(hideTimeouts.get(tooltip));
                hideTimeouts.delete(tooltip);
            });

            tooltip.addEventListener("mouseleave", () => {
                const timeoutId = setTimeout(() => {
                    hideTooltip(tooltip);
                }, hideDelay);

                hideTimeouts.set(tooltip, timeoutId);
            });
        }
    }

    function showTooltip(tooltip) {
        // Update position before showing
        const targetId = tooltip.dataset.target;
        const target = document.getElementById(targetId);
        if (target) {
            positionTooltip(tooltip, target);
        }

        tooltip.classList.add("md3-tooltip--visible");
        tooltip.setAttribute("aria-hidden", "false");
        activeTooltips.set(tooltip, true);

        // Dispatch custom event
        const event = new CustomEvent("md3-tooltip-show", {
            detail: { tooltip, target }
        });
        tooltip.dispatchEvent(event);
    }

    function hideTooltip(tooltip) {
        tooltip.classList.remove("md3-tooltip--visible");
        tooltip.setAttribute("aria-hidden", "true");
        activeTooltips.delete(tooltip);

        // Dispatch custom event
        const event = new CustomEvent("md3-tooltip-hide", {
            detail: { tooltip }
        });
        tooltip.dispatchEvent(event);
    }

    function positionTooltip(tooltip, target) {
        const targetRect = target.getBoundingClientRect();
        const tooltipRect = tooltip.getBoundingClientRect();
        const viewport = {
            width: window.innerWidth,
            height: window.innerHeight
        };

        // Reset position classes
        tooltip.classList.remove("md3-tooltip--top", "md3-tooltip--bottom", "md3-tooltip--left", "md3-tooltip--right");

        let position = "top";

        // Determine best position based on available space
        const spaceTop = targetRect.top;
        const spaceBottom = viewport.height - targetRect.bottom;
        const spaceLeft = targetRect.left;
        const spaceRight = viewport.width - targetRect.right;

        const tooltipHeight = tooltipRect.height || 40;
        const tooltipWidth = tooltipRect.width || 200;

        if (spaceTop >= tooltipHeight + 16) {
            position = "top";
        } else if (spaceBottom >= tooltipHeight + 16) {
            position = "bottom";
        } else if (spaceLeft >= tooltipWidth + 16) {
            position = "left";
        } else if (spaceRight >= tooltipWidth + 16) {
            position = "right";
        } else {
            // Default to top if no space available
            position = "top";
        }

        tooltip.classList.add(`md3-tooltip--${position}`);
    }

    // Hide all tooltips when scrolling or resizing
    window.addEventListener("scroll", () => {
        activeTooltips.forEach((_, tooltip) => {
            hideTooltip(tooltip);
        });
    });

    window.addEventListener("resize", () => {
        activeTooltips.forEach((_, tooltip) => {
            const targetId = tooltip.dataset.target;
            const target = document.getElementById(targetId);
            if (target) {
                positionTooltip(tooltip, target);
            }
        });
    });

    // Hide tooltips when clicking outside
    document.addEventListener("click", (e) => {
        if (!e.target.closest(".md3-tooltip") && !e.target.closest("[id]")) {
            activeTooltips.forEach((_, tooltip) => {
                hideTooltip(tooltip);
            });
        }
    });

    // Handle dynamic content
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === Node.ELEMENT_NODE) {
                    const tooltips = node.querySelectorAll ? node.querySelectorAll(".md3-tooltip") : [];
                    tooltips.forEach(initTooltip);

                    if (node.classList && node.classList.contains("md3-tooltip")) {
                        initTooltip(node);
                    }
                }
            });
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});

// Utility functions
window.showTooltip = function(tooltipId) {
    const tooltip = document.getElementById(tooltipId);
    if (tooltip) {
        tooltip.classList.add("md3-tooltip--visible");
        tooltip.setAttribute("aria-hidden", "false");
    }
};

window.hideTooltip = function(tooltipId) {
    const tooltip = document.getElementById(tooltipId);
    if (tooltip) {
        tooltip.classList.remove("md3-tooltip--visible");
        tooltip.setAttribute("aria-hidden", "true");
    }
};

window.toggleTooltip = function(tooltipId) {
    const tooltip = document.getElementById(tooltipId);
    if (tooltip) {
        if (tooltip.classList.contains("md3-tooltip--visible")) {
            hideTooltip(tooltipId);
        } else {
            showTooltip(tooltipId);
        }
    }
};
';
    }

    /**
     * Legacy method for backward compatibility
     */
    public static function getTooltipScript(): string {
        return '<script>' . self::getJS() . '</script>';
    }
}