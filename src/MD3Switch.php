<?php

/**
 * Material Design 3 Switch Component
 *
 * Implementiert MD3 Switches mit vollständigem Styling und Interaktion
 *
 * Features:
 * - Standard Switch mit Thumb und Track
 * - Switch mit Icons (on/off states)
 * - Labeled Switches
 * - Disabled States
 * - Form Integration
 * - Accessibility Support
 * - Touch/Click Interaktion
 * - Smooth Animations
 */

class MD3Switch {

    /**
     * Standard Switch
     */
    public static function create(string $name, array $options = []): string {
        return self::renderSwitch($name, $options);
    }

    /**
     * Switch mit Label
     */
    public static function withLabel(string $name, string $label, array $options = []): string {
        $options['label'] = $label;
        return self::renderSwitch($name, $options);
    }

    /**
     * Switch mit Icons
     */
    public static function withIcons(string $name, string $iconOn = 'check', string $iconOff = 'close', array $options = []): string {
        $options['iconOn'] = $iconOn;
        $options['iconOff'] = $iconOff;
        $options['showIcons'] = true;
        return self::renderSwitch($name, $options);
    }

    /**
     * Disabled Switch
     */
    public static function disabled(string $name, array $options = []): string {
        $options['disabled'] = true;
        return self::renderSwitch($name, $options);
    }

    /**
     * Render Switch Structure
     */
    private static function renderSwitch(string $name, array $options = []): string {
        $id = $options['id'] ?? 'md3-switch-' . uniqid();
        $value = $options['value'] ?? '1';
        $checked = $options['checked'] ?? false;
        $disabled = $options['disabled'] ?? false;
        $label = $options['label'] ?? '';
        $showIcons = $options['showIcons'] ?? false;
        $iconOn = $options['iconOn'] ?? 'check';
        $iconOff = $options['iconOff'] ?? 'close';
        $description = $options['description'] ?? '';

        $classes = ['md3-switch'];
        if ($checked) $classes[] = 'md3-switch--checked';
        if ($disabled) $classes[] = 'md3-switch--disabled';
        if ($showIcons) $classes[] = 'md3-switch--with-icons';
        if (!empty($options['class'])) $classes[] = $options['class'];

        // Container
        $html = '<div class="md3-switch-container">';

        // Hidden input for form submission
        $inputAttrs = [
            'type' => 'checkbox',
            'name' => $name,
            'value' => $value,
            'id' => $id . '-input',
            'class' => 'md3-switch__input'
        ];

        if ($checked) $inputAttrs['checked'] = 'checked';
        if ($disabled) $inputAttrs['disabled'] = 'disabled';

        $inputAttrsStr = '';
        foreach ($inputAttrs as $key => $val) {
            $inputAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
        }

        $html .= sprintf('<input%s>', $inputAttrsStr);

        // Switch element
        $switchAttrs = [
            'class' => implode(' ', $classes),
            'id' => $id,
            'role' => 'switch',
            'tabindex' => $disabled ? '-1' : '0',
            'aria-checked' => $checked ? 'true' : 'false',
            'aria-labelledby' => $label ? $id . '-label' : null,
            'aria-describedby' => $description ? $id . '-description' : null
        ];

        if ($disabled) {
            $switchAttrs['aria-disabled'] = 'true';
        }

        $switchAttrsStr = '';
        foreach ($switchAttrs as $key => $val) {
            if ($val !== null) {
                $switchAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
            }
        }

        $html .= sprintf('<div%s>', $switchAttrsStr);

        // Track
        $html .= '<div class="md3-switch__track"></div>';

        // Handle/Thumb
        $html .= '<div class="md3-switch__handle">';
        $html .= '<div class="md3-switch__handle-track"></div>';

        // Icons (if enabled)
        if ($showIcons) {
            $html .= sprintf(
                '<div class="md3-switch__icons">
                    <span class="md3-switch__icon md3-switch__icon--on">
                        <span class="material-symbols-outlined">%s</span>
                    </span>
                    <span class="md3-switch__icon md3-switch__icon--off">
                        <span class="material-symbols-outlined">%s</span>
                    </span>
                </div>',
                $iconOn,
                $iconOff
            );
        }

        $html .= '</div>'; // End handle

        $html .= '</div>'; // End switch

        // Label
        if ($label) {
            $html .= sprintf(
                '<label class="md3-switch__label" for="%s" id="%s">%s</label>',
                $id . '-input',
                $id . '-label',
                htmlspecialchars($label)
            );
        }

        // Description
        if ($description) {
            $html .= sprintf(
                '<div class="md3-switch__description" id="%s">%s</div>',
                $id . '-description',
                htmlspecialchars($description)
            );
        }

        $html .= '</div>'; // End container

        return $html;
    }

    /**
     * Get Switch CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Switch Component */
.md3-switch-container {
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
}

.md3-switch__input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
    width: 0;
    height: 0;
}

.md3-switch {
    position: relative;
    display: inline-flex;
    align-items: center;
    width: 52px;
    height: 32px;
    cursor: pointer;
    outline: none;
    user-select: none;
    flex-shrink: 0;
}

.md3-switch--disabled {
    cursor: not-allowed;
    opacity: 0.38;
}

/* Switch Track */
.md3-switch__track {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 16px;
    background: var(--md-sys-color-surface-container-highest);
    border: 2px solid var(--md-sys-color-outline);
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    box-sizing: border-box;
}

.md3-switch--checked .md3-switch__track {
    background: var(--md-sys-color-primary);
    border-color: var(--md-sys-color-primary);
}

/* Switch Handle */
.md3-switch__handle {
    position: absolute;
    left: 4px;
    top: 50%;
    transform: translateY(-50%);
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--md-sys-color-outline);
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}

.md3-switch--checked .md3-switch__handle {
    left: 24px;
    background: var(--md-sys-color-on-primary);
    width: 24px;
    height: 24px;
}

/* Handle Track (ripple area) */
.md3-switch__handle-track {
    position: absolute;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: transparent;
    transition: background-color 0.2s;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.md3-switch:hover .md3-switch__handle-track {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
}

.md3-switch--checked:hover .md3-switch__handle-track {
    background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
}

.md3-switch:focus-visible .md3-switch__handle-track {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

.md3-switch--checked:focus-visible .md3-switch__handle-track {
    background: color-mix(in srgb, var(--md-sys-color-primary) 12%, transparent);
}

/* Switch Icons */
.md3-switch__icons {
    position: absolute;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.md3-switch__icon {
    position: absolute;
    font-size: 16px;
    transition: opacity 0.2s ease;
    color: var(--md-sys-color-surface-container-highest);
}

.md3-switch__icon--on {
    opacity: 0;
}

.md3-switch__icon--off {
    opacity: 1;
}

.md3-switch--checked .md3-switch__icon--on {
    opacity: 1;
    color: var(--md-sys-color-primary);
}

.md3-switch--checked .md3-switch__icon--off {
    opacity: 0;
}

/* Switch with Icons - larger handle */
.md3-switch--with-icons .md3-switch__handle {
    width: 24px;
    height: 24px;
}

.md3-switch--with-icons.md3-switch--checked .md3-switch__handle {
    width: 24px;
    height: 24px;
}

/* Switch Label */
.md3-switch__label {
    font-size: 14px;
    font-weight: 500;
    color: var(--md-sys-color-on-surface);
    cursor: pointer;
    user-select: none;
}

.md3-switch--disabled .md3-switch__label {
    cursor: not-allowed;
    opacity: 0.38;
}

/* Switch Description */
.md3-switch__description {
    font-size: 12px;
    color: var(--md-sys-color-on-surface-variant);
    margin-top: 4px;
}

/* Disabled State */
.md3-switch--disabled .md3-switch__track {
    background: var(--md-sys-color-surface-variant);
    border-color: var(--md-sys-color-on-surface);
    opacity: 0.12;
}

.md3-switch--disabled .md3-switch__handle {
    background: var(--md-sys-color-on-surface);
    opacity: 0.38;
}

.md3-switch--disabled.md3-switch--checked .md3-switch__track {
    background: var(--md-sys-color-on-surface);
    opacity: 0.12;
}

.md3-switch--disabled.md3-switch--checked .md3-switch__handle {
    background: var(--md-sys-color-surface);
    opacity: 1;
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-switch {
        width: 48px;
        height: 28px;
    }

    .md3-switch__handle {
        width: 20px;
        height: 20px;
        left: 4px;
    }

    .md3-switch--checked .md3-switch__handle {
        left: 24px;
        width: 20px;
        height: 20px;
    }

    .md3-switch__handle-track {
        width: 36px;
        height: 36px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-switch__track {
    background: var(--md-sys-color-surface-container-highest);
    border-color: var(--md-sys-color-outline);
}

[data-theme="dark"] .md3-switch--checked .md3-switch__track {
    background: var(--md-sys-color-primary);
    border-color: var(--md-sys-color-primary);
}

[data-theme="dark"] .md3-switch__handle {
    background: var(--md-sys-color-outline);
}

[data-theme="dark"] .md3-switch--checked .md3-switch__handle {
    background: var(--md-sys-color-on-primary);
}
';
    }

    /**
     * Get Switch JavaScript
     */
    public static function getJS(): string {
        return '
// Switch Management
document.addEventListener("DOMContentLoaded", function() {
    // Handle switch interactions
    document.addEventListener("click", function(e) {
        const switchElement = e.target.closest(".md3-switch");
        if (!switchElement || switchElement.classList.contains("md3-switch--disabled")) {
            return;
        }

        const input = switchElement.closest(".md3-switch-container").querySelector(".md3-switch__input");
        if (!input) return;

        // Toggle the input
        input.checked = !input.checked;

        // Update switch visual state
        updateSwitchState(switchElement, input.checked);

        // Dispatch change event
        const event = new Event("change", { bubbles: true });
        input.dispatchEvent(event);

        // Dispatch custom event
        const customEvent = new CustomEvent("md3-switch-change", {
            detail: {
                switch: switchElement,
                input: input,
                checked: input.checked,
                value: input.value,
                name: input.name
            }
        });
        switchElement.dispatchEvent(customEvent);
    });

    // Handle keyboard interactions
    document.addEventListener("keydown", function(e) {
        const switchElement = e.target.closest(".md3-switch");
        if (!switchElement || switchElement.classList.contains("md3-switch--disabled")) {
            return;
        }

        // Space or Enter key toggles the switch
        if (e.key === " " || e.key === "Enter") {
            e.preventDefault();
            switchElement.click();
        }
    });

    // Handle label clicks
    document.addEventListener("click", function(e) {
        const label = e.target.closest(".md3-switch__label");
        if (!label) return;

        const input = document.getElementById(label.getAttribute("for"));
        if (!input || input.disabled) return;

        const switchElement = input.closest(".md3-switch-container").querySelector(".md3-switch");
        if (switchElement) {
            switchElement.click();
        }
    });

    // Initialize all switches to correct state
    document.querySelectorAll(".md3-switch").forEach(switchElement => {
        const input = switchElement.closest(".md3-switch-container").querySelector(".md3-switch__input");
        if (input) {
            updateSwitchState(switchElement, input.checked);
        }
    });

    function updateSwitchState(switchElement, checked) {
        if (checked) {
            switchElement.classList.add("md3-switch--checked");
            switchElement.setAttribute("aria-checked", "true");
        } else {
            switchElement.classList.remove("md3-switch--checked");
            switchElement.setAttribute("aria-checked", "false");
        }
    }

    // Add ripple effect
    document.addEventListener("pointerdown", function(e) {
        const switchElement = e.target.closest(".md3-switch");
        if (!switchElement || switchElement.classList.contains("md3-switch--disabled")) {
            return;
        }

        const handleTrack = switchElement.querySelector(".md3-switch__handle-track");
        if (!handleTrack) return;

        const rect = handleTrack.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;

        const ripple = document.createElement("span");
        ripple.className = "md3-ripple";
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.1;
            pointer-events: none;
            transform: scale(0);
            animation: md3-ripple-animation 0.6s ease-out;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
        `;

        handleTrack.style.position = "relative";
        handleTrack.style.overflow = "hidden";
        handleTrack.appendChild(ripple);

        setTimeout(() => {
            if (ripple.parentNode) {
                ripple.parentNode.removeChild(ripple);
            }
        }, 600);
    });
});

// Utility functions
window.setSwitchState = function(switchId, checked) {
    const switchElement = document.getElementById(switchId);
    if (!switchElement) return;

    const input = switchElement.closest(".md3-switch-container").querySelector(".md3-switch__input");
    if (!input) return;

    input.checked = checked;

    if (checked) {
        switchElement.classList.add("md3-switch--checked");
        switchElement.setAttribute("aria-checked", "true");
    } else {
        switchElement.classList.remove("md3-switch--checked");
        switchElement.setAttribute("aria-checked", "false");
    }

    // Dispatch change event
    const event = new Event("change", { bubbles: true });
    input.dispatchEvent(event);
};

// Add ripple animation CSS if not already present
if (!document.querySelector("#md3-switch-ripple-styles")) {
    const style = document.createElement("style");
    style.id = "md3-switch-ripple-styles";
    style.textContent = `
        @keyframes md3-ripple-animation {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}
';
    }
}
