<?php

/**
 * Material Design 3 Checkbox Component
 *
 * Implementiert MD3 Checkboxes mit vollständigem Styling und Interaktion
 *
 * Features:
 * - Standard Checkbox mit Check-Animation
 * - Indeterminate State Support
 * - Labeled Checkboxes
 * - Disabled States
 * - Form Integration
 * - Accessibility Support
 * - Touch/Click Interaktion
 * - Ripple Effects
 */

class MD3Checkbox {

    /**
     * Standard Checkbox
     */
    public static function create(string $name, array $options = []): string {
        return self::renderCheckbox($name, $options);
    }

    /**
     * Checkbox mit Label
     */
    public static function withLabel(string $name, string $label, array $options = []): string {
        $options['label'] = $label;
        return self::renderCheckbox($name, $options);
    }

    /**
     * Indeterminate Checkbox (mixed state)
     */
    public static function indeterminate(string $name, array $options = []): string {
        $options['indeterminate'] = true;
        return self::renderCheckbox($name, $options);
    }

    /**
     * Disabled Checkbox
     */
    public static function disabled(string $name, array $options = []): string {
        $options['disabled'] = true;
        return self::renderCheckbox($name, $options);
    }

    /**
     * Render Checkbox Structure
     */
    private static function renderCheckbox(string $name, array $options = []): string {
        $id = $options['id'] ?? 'md3-checkbox-' . uniqid();
        $value = $options['value'] ?? '1';
        $checked = $options['checked'] ?? false;
        $disabled = $options['disabled'] ?? false;
        $indeterminate = $options['indeterminate'] ?? false;
        $label = $options['label'] ?? '';
        $description = $options['description'] ?? '';

        $classes = ['md3-checkbox'];
        if ($checked) $classes[] = 'md3-checkbox--checked';
        if ($disabled) $classes[] = 'md3-checkbox--disabled';
        if ($indeterminate) $classes[] = 'md3-checkbox--indeterminate';
        if (!empty($options['class'])) $classes[] = $options['class'];

        // Container
        $html = '<div class="md3-checkbox-container">';

        // Hidden input for form submission
        $inputAttrs = [
            'type' => 'checkbox',
            'name' => $name,
            'value' => $value,
            'id' => $id . '-input',
            'class' => 'md3-checkbox__input'
        ];

        if ($checked && !$indeterminate) $inputAttrs['checked'] = 'checked';
        if ($disabled) $inputAttrs['disabled'] = 'disabled';

        $inputAttrsStr = '';
        foreach ($inputAttrs as $key => $val) {
            $inputAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
        }

        $html .= sprintf('<input%s>', $inputAttrsStr);

        // Checkbox element
        $checkboxAttrs = [
            'class' => implode(' ', $classes),
            'id' => $id,
            'role' => 'checkbox',
            'tabindex' => $disabled ? '-1' : '0',
            'aria-checked' => $indeterminate ? 'mixed' : ($checked ? 'true' : 'false'),
            'aria-labelledby' => $label ? $id . '-label' : null,
            'aria-describedby' => $description ? $id . '-description' : null
        ];

        if ($disabled) {
            $checkboxAttrs['aria-disabled'] = 'true';
        }

        $checkboxAttrsStr = '';
        foreach ($checkboxAttrs as $key => $val) {
            if ($val !== null) {
                $checkboxAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
            }
        }

        $html .= sprintf('<div%s>', $checkboxAttrsStr);

        // Checkbox background/frame
        $html .= '<div class="md3-checkbox__background">';
        $html .= '<div class="md3-checkbox__frame"></div>';
        $html .= '<div class="md3-checkbox__checkmark">
                    <svg class="md3-checkbox__checkmark-path" viewBox="0 0 24 24">
                        <path class="md3-checkbox__checkmark-check" d="M4.1,12.7 9,17.6 20.3,6.3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>';
        $html .= '<div class="md3-checkbox__mixedmark"></div>';
        $html .= '</div>';

        // Ripple container
        $html .= '<div class="md3-checkbox__ripple"></div>';

        $html .= '</div>'; // End checkbox

        // Label
        if ($label) {
            $html .= sprintf(
                '<label class="md3-checkbox__label" for="%s" id="%s">%s</label>',
                $id . '-input',
                $id . '-label',
                htmlspecialchars($label)
            );
        }

        // Description
        if ($description) {
            $html .= sprintf(
                '<div class="md3-checkbox__description" id="%s">%s</div>',
                $id . '-description',
                htmlspecialchars($description)
            );
        }

        $html .= '</div>'; // End container

        return $html;
    }

    /**
     * Get Checkbox CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Checkbox Component */
.md3-checkbox-container {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    position: relative;
}

.md3-checkbox__input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
    width: 0;
    height: 0;
}

.md3-checkbox {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    cursor: pointer;
    outline: none;
    user-select: none;
    flex-shrink: 0;
    margin: 3px;
}

.md3-checkbox--disabled {
    cursor: not-allowed;
    opacity: 0.38;
}

/* Checkbox Background */
.md3-checkbox__background {
    position: absolute;
    width: 18px;
    height: 18px;
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
}

.md3-checkbox__frame {
    position: absolute;
    width: 18px;
    height: 18px;
    border: 2px solid var(--md-sys-color-on-surface-variant);
    border-radius: 2px;
    box-sizing: border-box;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
}

.md3-checkbox--checked .md3-checkbox__frame,
.md3-checkbox--indeterminate .md3-checkbox__frame {
    background: var(--md-sys-color-primary);
    border-color: var(--md-sys-color-primary);
}

/* Checkmark */
.md3-checkbox__checkmark {
    position: absolute;
    width: 18px;
    height: 18px;
    opacity: 0;
    transition: opacity 0.2s cubic-bezier(0.2, 0, 0, 1);
}

.md3-checkbox--checked .md3-checkbox__checkmark {
    opacity: 1;
}

.md3-checkbox__checkmark-path {
    width: 18px;
    height: 18px;
    color: var(--md-sys-color-on-primary);
}

.md3-checkbox__checkmark-check {
    stroke-dasharray: 22;
    stroke-dashoffset: 22;
    animation: none;
}

.md3-checkbox--checked .md3-checkbox__checkmark-check {
    animation: md3-checkbox-check 0.2s ease-in-out forwards;
}

@keyframes md3-checkbox-check {
    to {
        stroke-dashoffset: 0;
    }
}

/* Mixed mark (indeterminate) */
.md3-checkbox__mixedmark {
    position: absolute;
    width: 10px;
    height: 2px;
    background: var(--md-sys-color-on-primary);
    border-radius: 1px;
    opacity: 0;
    transition: opacity 0.2s cubic-bezier(0.2, 0, 0, 1);
    transform: scale(0);
}

.md3-checkbox--indeterminate .md3-checkbox__mixedmark {
    opacity: 1;
    transform: scale(1);
}

.md3-checkbox--indeterminate .md3-checkbox__checkmark {
    opacity: 0;
}

/* Ripple Effect */
.md3-checkbox__ripple {
    position: absolute;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: transparent;
    transition: background-color 0.2s;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
}

.md3-checkbox:hover .md3-checkbox__ripple {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
}

.md3-checkbox--checked:hover .md3-checkbox__ripple,
.md3-checkbox--indeterminate:hover .md3-checkbox__ripple {
    background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
}

.md3-checkbox:focus-visible .md3-checkbox__ripple {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

.md3-checkbox--checked:focus-visible .md3-checkbox__ripple,
.md3-checkbox--indeterminate:focus-visible .md3-checkbox__ripple {
    background: color-mix(in srgb, var(--md-sys-color-primary) 12%, transparent);
}

/* Checkbox Label */
.md3-checkbox__label {
    font-size: 14px;
    font-weight: 400;
    color: var(--md-sys-color-on-surface);
    cursor: pointer;
    user-select: none;
    line-height: 20px;
}

.md3-checkbox--disabled .md3-checkbox__label {
    cursor: not-allowed;
    opacity: 0.38;
}

/* Checkbox Description */
.md3-checkbox__description {
    font-size: 12px;
    color: var(--md-sys-color-on-surface-variant);
    margin-top: 4px;
    line-height: 16px;
}

/* Disabled State */
.md3-checkbox--disabled .md3-checkbox__frame {
    border-color: var(--md-sys-color-on-surface);
    opacity: 0.38;
}

.md3-checkbox--disabled.md3-checkbox--checked .md3-checkbox__frame,
.md3-checkbox--disabled.md3-checkbox--indeterminate .md3-checkbox__frame {
    background: var(--md-sys-color-on-surface);
    border-color: var(--md-sys-color-on-surface);
    opacity: 0.38;
}

.md3-checkbox--disabled .md3-checkbox__checkmark-path,
.md3-checkbox--disabled .md3-checkbox__mixedmark {
    color: var(--md-sys-color-surface);
    background: var(--md-sys-color-surface);
}

/* Error State */
.md3-checkbox--error .md3-checkbox__frame {
    border-color: var(--md-sys-color-error);
}

.md3-checkbox--error.md3-checkbox--checked .md3-checkbox__frame,
.md3-checkbox--error.md3-checkbox--indeterminate .md3-checkbox__frame {
    background: var(--md-sys-color-error);
    border-color: var(--md-sys-color-error);
}

.md3-checkbox--error:hover .md3-checkbox__ripple {
    background: color-mix(in srgb, var(--md-sys-color-error) 8%, transparent);
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-checkbox {
        width: 20px;
        height: 20px;
        margin: 2px;
    }

    .md3-checkbox__background,
    .md3-checkbox__frame,
    .md3-checkbox__checkmark {
        width: 20px;
        height: 20px;
    }

    .md3-checkbox__checkmark-path {
        width: 20px;
        height: 20px;
    }

    .md3-checkbox__ripple {
        width: 44px;
        height: 44px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-checkbox__frame {
    border-color: var(--md-sys-color-on-surface-variant);
}

[data-theme="dark"] .md3-checkbox--checked .md3-checkbox__frame,
[data-theme="dark"] .md3-checkbox--indeterminate .md3-checkbox__frame {
    background: var(--md-sys-color-primary);
    border-color: var(--md-sys-color-primary);
}
';
    }

    /**
     * Get Checkbox JavaScript
     */
    public static function getJS(): string {
        return '
// Checkbox Management
document.addEventListener("DOMContentLoaded", function() {
    // Handle checkbox interactions
    document.addEventListener("click", function(e) {
        const checkboxElement = e.target.closest(".md3-checkbox");
        if (!checkboxElement || checkboxElement.classList.contains("md3-checkbox--disabled")) {
            return;
        }

        const input = checkboxElement.closest(".md3-checkbox-container").querySelector(".md3-checkbox__input");
        if (!input) return;

        // Toggle the input
        input.checked = !input.checked;

        // Update checkbox visual state
        updateCheckboxState(checkboxElement, input.checked, false);

        // Dispatch change event
        const event = new Event("change", { bubbles: true });
        input.dispatchEvent(event);

        // Dispatch custom event
        const customEvent = new CustomEvent("md3-checkbox-change", {
            detail: {
                checkbox: checkboxElement,
                input: input,
                checked: input.checked,
                value: input.value,
                name: input.name
            }
        });
        checkboxElement.dispatchEvent(customEvent);
    });

    // Handle keyboard interactions
    document.addEventListener("keydown", function(e) {
        const checkboxElement = e.target.closest(".md3-checkbox");
        if (!checkboxElement || checkboxElement.classList.contains("md3-checkbox--disabled")) {
            return;
        }

        // Space key toggles the checkbox
        if (e.key === " ") {
            e.preventDefault();
            checkboxElement.click();
        }
    });

    // Handle label clicks
    document.addEventListener("click", function(e) {
        const label = e.target.closest(".md3-checkbox__label");
        if (!label) return;

        const input = document.getElementById(label.getAttribute("for"));
        if (!input || input.disabled) return;

        const checkboxElement = input.closest(".md3-checkbox-container").querySelector(".md3-checkbox");
        if (checkboxElement) {
            checkboxElement.click();
        }
    });

    // Initialize all checkboxes to correct state
    document.querySelectorAll(".md3-checkbox").forEach(checkboxElement => {
        const input = checkboxElement.closest(".md3-checkbox-container").querySelector(".md3-checkbox__input");
        if (input) {
            const isIndeterminate = checkboxElement.classList.contains("md3-checkbox--indeterminate");
            updateCheckboxState(checkboxElement, input.checked, isIndeterminate);
        }
    });

    function updateCheckboxState(checkboxElement, checked, indeterminate) {
        // Remove all states
        checkboxElement.classList.remove("md3-checkbox--checked", "md3-checkbox--indeterminate");

        if (indeterminate) {
            checkboxElement.classList.add("md3-checkbox--indeterminate");
            checkboxElement.setAttribute("aria-checked", "mixed");
        } else if (checked) {
            checkboxElement.classList.add("md3-checkbox--checked");
            checkboxElement.setAttribute("aria-checked", "true");
        } else {
            checkboxElement.setAttribute("aria-checked", "false");
        }
    }

    // Add ripple effect
    document.addEventListener("pointerdown", function(e) {
        const checkboxElement = e.target.closest(".md3-checkbox");
        if (!checkboxElement || checkboxElement.classList.contains("md3-checkbox--disabled")) {
            return;
        }

        const rippleContainer = checkboxElement.querySelector(".md3-checkbox__ripple");
        if (!rippleContainer) return;

        const rect = rippleContainer.getBoundingClientRect();
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

        rippleContainer.style.position = "relative";
        rippleContainer.style.overflow = "hidden";
        rippleContainer.appendChild(ripple);

        setTimeout(() => {
            if (ripple.parentNode) {
                ripple.parentNode.removeChild(ripple);
            }
        }, 600);
    });
});

// Utility functions
window.setCheckboxState = function(checkboxId, checked, indeterminate = false) {
    const checkboxElement = document.getElementById(checkboxId);
    if (!checkboxElement) return;

    const input = checkboxElement.closest(".md3-checkbox-container").querySelector(".md3-checkbox__input");
    if (!input) return;

    input.checked = checked && !indeterminate;

    // Remove all states
    checkboxElement.classList.remove("md3-checkbox--checked", "md3-checkbox--indeterminate");

    if (indeterminate) {
        checkboxElement.classList.add("md3-checkbox--indeterminate");
        checkboxElement.setAttribute("aria-checked", "mixed");
    } else if (checked) {
        checkboxElement.classList.add("md3-checkbox--checked");
        checkboxElement.setAttribute("aria-checked", "true");
    } else {
        checkboxElement.setAttribute("aria-checked", "false");
    }

    // Dispatch change event
    const event = new Event("change", { bubbles: true });
    input.dispatchEvent(event);
};

window.setCheckboxIndeterminate = function(checkboxId, indeterminate = true) {
    const checkboxElement = document.getElementById(checkboxId);
    if (!checkboxElement) return;

    if (indeterminate) {
        checkboxElement.classList.remove("md3-checkbox--checked");
        checkboxElement.classList.add("md3-checkbox--indeterminate");
        checkboxElement.setAttribute("aria-checked", "mixed");
    } else {
        checkboxElement.classList.remove("md3-checkbox--indeterminate");
        checkboxElement.setAttribute("aria-checked", "false");
    }
};

// Add ripple animation CSS if not already present
if (!document.querySelector("#md3-checkbox-ripple-styles")) {
    const style = document.createElement("style");
    style.id = "md3-checkbox-ripple-styles";
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
