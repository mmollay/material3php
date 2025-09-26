<?php

/**
 * Material Design 3 Icon Button Component
 *
 * Implements MD3 Icon Button specifications from https://m3.material.io/components/icon-button/overview
 *
 * Features:
 * - Standard, Filled, Outlined, Tonal variants
 * - Toggle states (selected/unselected)
 * - Disabled states
 * - Accessibility support (ARIA)
 * - Material Design 3 color tokens
 * - Interactive states (hover, focus, pressed)
 */

class MD3IconButton {

    /**
     * Standard Icon Button
     */
    public static function standard(string $icon = 'star', array $options = []): string {
        $options['type'] = 'standard';
        return self::renderIconButton($icon, $options);
    }

    /**
     * Filled Icon Button
     */
    public static function filled(string $icon = 'star', array $options = []): string {
        $options['type'] = 'filled';
        return self::renderIconButton($icon, $options);
    }

    /**
     * Outlined Icon Button
     */
    public static function outlined(string $icon = 'star', array $options = []): string {
        $options['type'] = 'outlined';
        return self::renderIconButton($icon, $options);
    }

    /**
     * Tonal Icon Button
     */
    public static function tonal(string $icon = 'star', array $options = []): string {
        $options['type'] = 'tonal';
        return self::renderIconButton($icon, $options);
    }

    /**
     * Toggle Icon Button (for selected/unselected states)
     */
    public static function toggle(string $icon = 'star', string $selectedIcon = 'star', array $options = []): string {
        $options['toggle'] = true;
        $options['selected_icon'] = $selectedIcon;
        return self::renderIconButton($icon, $options);
    }

    /**
     * Render Icon Button
     */
    private static function renderIconButton(string $icon, array $options = []): string {
        $type = $options['type'] ?? 'standard';
        $disabled = $options['disabled'] ?? false;
        $selected = $options['selected'] ?? false;
        $toggle = $options['toggle'] ?? false;
        $selectedIcon = $options['selected_icon'] ?? $icon;
        $ariaLabel = $options['aria_label'] ?? ucfirst(str_replace('_', ' ', $icon));
        $onClick = $options['onclick'] ?? '';
        $id = $options['id'] ?? 'icon-btn-' . uniqid();
        $name = $options['name'] ?? '';
        $value = $options['value'] ?? '';

        $classes = ['md3-icon-button', "md3-icon-button--{$type}"];
        if ($disabled) $classes[] = 'md3-icon-button--disabled';
        if ($selected && $toggle) $classes[] = 'md3-icon-button--selected';
        if ($toggle) $classes[] = 'md3-icon-button--toggle';

        $attributes = [
            'type' => 'button',
            'class' => implode(' ', $classes),
            'aria-label' => $ariaLabel,
            'id' => $id
        ];

        if ($disabled) $attributes['disabled'] = 'disabled';
        if ($onClick) $attributes['onclick'] = $onClick;
        if ($name) $attributes['name'] = $name;
        if ($value) $attributes['value'] = $value;

        $attrString = [];
        foreach ($attributes as $key => $val) {
            $attrString[] = $key . '="' . htmlspecialchars($val) . '"';
        }

        $currentIcon = ($toggle && $selected) ? $selectedIcon : $icon;

        $html = '<button ' . implode(' ', $attrString) . '>';
        $html .= '<span class="md3-icon-button__icon material-symbols-outlined">' . $currentIcon . '</span>';

        if ($toggle) {
            $html .= '<span class="md3-icon-button__icon md3-icon-button__icon--selected material-symbols-outlined">' . $selectedIcon . '</span>';
        }

        $html .= '<div class="md3-icon-button__ripple"></div>';
        $html .= '</button>';

        return $html;
    }

    /**
     * Get Icon Button CSS
     */
    public static function getCSS(): string {
        return '
/* Icon Button Base Styles */
.md3-icon-button {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border: none;
    border-radius: 24px;
    cursor: pointer;
    font-size: 24px;
    line-height: 1;
    overflow: hidden;
    user-select: none;
    transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1);
    background: transparent;
    color: var(--md-sys-color-on-surface-variant);
}

.md3-icon-button:focus {
    outline: none;
}

.md3-icon-button:focus-visible {
    box-shadow: 0 0 0 2px var(--md-sys-color-primary);
}

.md3-icon-button__icon {
    position: relative;
    z-index: 1;
    font-size: 24px;
    line-height: 1;
    transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1);
}

/* Toggle Icon Button */
.md3-icon-button--toggle .md3-icon-button__icon--selected {
    position: absolute;
    opacity: 0;
}

.md3-icon-button--toggle.md3-icon-button--selected .md3-icon-button__icon {
    opacity: 0;
}

.md3-icon-button--toggle.md3-icon-button--selected .md3-icon-button__icon--selected {
    opacity: 1;
}

/* Standard Icon Button */
.md3-icon-button--standard {
    background: transparent;
    color: var(--md-sys-color-on-surface-variant);
}

.md3-icon-button--standard:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 8%, transparent);
}

.md3-icon-button--standard:focus {
    background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 12%, transparent);
}

.md3-icon-button--standard:active {
    background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 12%, transparent);
}

.md3-icon-button--standard.md3-icon-button--selected {
    color: var(--md-sys-color-primary);
}

.md3-icon-button--standard.md3-icon-button--selected:hover {
    background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
}

/* Filled Icon Button */
.md3-icon-button--filled {
    background: var(--md-sys-color-primary);
    color: var(--md-sys-color-on-primary);
}

.md3-icon-button--filled:hover {
    background: var(--md-sys-color-primary);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3), 0 1px 3px 1px rgba(0, 0, 0, 0.15);
}

.md3-icon-button--filled:focus {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3), 0 1px 3px 1px rgba(0, 0, 0, 0.15);
}

.md3-icon-button--filled:active {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3), 0 1px 3px 1px rgba(0, 0, 0, 0.15);
}

.md3-icon-button--filled.md3-icon-button--selected {
    background: var(--md-sys-color-primary);
}

/* Outlined Icon Button */
.md3-icon-button--outlined {
    background: transparent;
    color: var(--md-sys-color-on-surface-variant);
    border: 1px solid var(--md-sys-color-outline);
}

.md3-icon-button--outlined:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 8%, transparent);
}

.md3-icon-button--outlined:focus {
    background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 12%, transparent);
}

.md3-icon-button--outlined:active {
    background: color-mix(in srgb, var(--md-sys-color-on-surface-variant) 12%, transparent);
}

.md3-icon-button--outlined.md3-icon-button--selected {
    background: var(--md-sys-color-inverse-surface);
    color: var(--md-sys-color-inverse-on-surface);
    border-color: transparent;
}

/* Tonal Icon Button */
.md3-icon-button--tonal {
    background: var(--md-sys-color-secondary-container);
    color: var(--md-sys-color-on-secondary-container);
}

.md3-icon-button--tonal:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-secondary-container) 8%, var(--md-sys-color-secondary-container));
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3), 0 1px 3px 1px rgba(0, 0, 0, 0.15);
}

.md3-icon-button--tonal:focus {
    background: color-mix(in srgb, var(--md-sys-color-on-secondary-container) 12%, var(--md-sys-color-secondary-container));
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3), 0 1px 3px 1px rgba(0, 0, 0, 0.15);
}

.md3-icon-button--tonal:active {
    background: color-mix(in srgb, var(--md-sys-color-on-secondary-container) 12%, var(--md-sys-color-secondary-container));
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3), 0 1px 3px 1px rgba(0, 0, 0, 0.15);
}

.md3-icon-button--tonal.md3-icon-button--selected {
    background: var(--md-sys-color-secondary-container);
}

/* Disabled State */
.md3-icon-button--disabled {
    pointer-events: none;
    opacity: 0.38;
}

.md3-icon-button--filled.md3-icon-button--disabled {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
    color: color-mix(in srgb, var(--md-sys-color-on-surface) 38%, transparent);
}

.md3-icon-button--outlined.md3-icon-button--disabled {
    border-color: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
}

/* Ripple Effect */
.md3-icon-button__ripple {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: inherit;
    overflow: hidden;
    pointer-events: none;
}

.md3-icon-button__ripple::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: currentColor;
    opacity: 0.12;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.md3-icon-button:active .md3-icon-button__ripple::before {
    width: 48px;
    height: 48px;
}

/* Dark Theme Support */
[data-theme="dark"] .md3-icon-button--standard {
    color: var(--md-sys-color-on-surface-variant);
}

[data-theme="dark"] .md3-icon-button--outlined {
    border-color: var(--md-sys-color-outline);
}
';
    }

    /**
     * Get Icon Button JavaScript for toggle functionality
     */
    public static function getJS(): string {
        return '
// Icon Button Toggle Functionality
document.addEventListener("DOMContentLoaded", function() {
    initializeIconButtons();
});

function initializeIconButtons() {
    const toggleButtons = document.querySelectorAll(".md3-icon-button--toggle");

    toggleButtons.forEach(button => {
        button.addEventListener("click", function(e) {
            if (this.hasAttribute("disabled")) return;

            const isSelected = this.classList.contains("md3-icon-button--selected");
            this.classList.toggle("md3-icon-button--selected", !isSelected);

            // Update ARIA state
            this.setAttribute("aria-pressed", (!isSelected).toString());

            // Dispatch custom event
            const event = new CustomEvent("md3-icon-button-toggle", {
                detail: {
                    selected: !isSelected,
                    button: this
                }
            });
            this.dispatchEvent(event);
        });

        // Initialize ARIA state
        const isSelected = button.classList.contains("md3-icon-button--selected");
        button.setAttribute("aria-pressed", isSelected.toString());
    });
}

// Make function globally available for AJAX content
window.initializeIconButtons = initializeIconButtons;
';
    }
}