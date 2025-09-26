<?php

/**
 * Material Design 3 Radio Button Component
 *
 * Implementiert MD3 Radio Buttons mit vollständigem Styling und Interaktion
 *
 * Features:
 * - Standard Radio Buttons
 * - Radio Button Groups
 * - Labeled Radio Buttons
 * - Disabled States
 * - Error States
 * - Form Integration
 * - Accessibility Support
 * - Touch/Click Interaktion
 * - Smooth Animations
 */

class MD3Radio {

    /**
     * Standard Radio Button
     */
    public static function create(string $name, string $value, array $options = []): string {
        return self::renderRadio($name, $value, $options);
    }

    /**
     * Radio Button mit Label
     */
    public static function withLabel(string $name, string $value, string $label, array $options = []): string {
        $options['label'] = $label;
        return self::renderRadio($name, $value, $options);
    }

    /**
     * Radio Button Group
     */
    public static function group(string $name, array $options, string $selected = '', array $groupOptions = []): string {
        $groupId = $groupOptions['id'] ?? 'md3-radio-group-' . uniqid();
        $label = $groupOptions['label'] ?? '';
        $description = $groupOptions['description'] ?? '';
        $disabled = $groupOptions['disabled'] ?? false;
        $error = $groupOptions['error'] ?? false;
        $errorMessage = $groupOptions['errorMessage'] ?? '';
        $orientation = $groupOptions['orientation'] ?? 'vertical'; // vertical or horizontal

        $classes = ['md3-radio-group'];
        if ($orientation === 'horizontal') $classes[] = 'md3-radio-group--horizontal';
        if ($disabled) $classes[] = 'md3-radio-group--disabled';
        if ($error) $classes[] = 'md3-radio-group--error';

        $html = '<div class="' . implode(' ', $classes) . '" id="' . $groupId . '"';
        if ($disabled) $html .= ' aria-disabled="true"';
        if ($description) $html .= ' aria-describedby="' . $groupId . '-description"';
        if ($error && $errorMessage) $html .= ' aria-describedby="' . $groupId . '-error"';
        $html .= '>';

        // Group Label
        if ($label) {
            $html .= '<div class="md3-radio-group__label" id="' . $groupId . '-label">' . htmlspecialchars($label) . '</div>';
        }

        // Radio Options Container
        $html .= '<div class="md3-radio-group__options" role="radiogroup"';
        if ($label) $html .= ' aria-labelledby="' . $groupId . '-label"';
        $html .= '>';

        foreach ($options as $option) {
            $radioOptions = [
                'checked' => $option['value'] === $selected,
                'disabled' => $disabled || ($option['disabled'] ?? false),
                'description' => $option['description'] ?? ''
            ];

            if (!empty($groupOptions['class'])) {
                $radioOptions['class'] = $groupOptions['class'];
            }

            $html .= self::withLabel($name, $option['value'], $option['label'], $radioOptions);
        }

        $html .= '</div>'; // End options

        // Description
        if ($description) {
            $html .= '<div class="md3-radio-group__description" id="' . $groupId . '-description">' . htmlspecialchars($description) . '</div>';
        }

        // Error Message
        if ($error && $errorMessage) {
            $html .= '<div class="md3-radio-group__error" id="' . $groupId . '-error">' . htmlspecialchars($errorMessage) . '</div>';
        }

        $html .= '</div>'; // End group

        return $html;
    }

    /**
     * Disabled Radio Button
     */
    public static function disabled(string $name, string $value, array $options = []): string {
        $options['disabled'] = true;
        return self::renderRadio($name, $value, $options);
    }

    /**
     * Radio Button mit Error State
     */
    public static function withError(string $name, string $value, string $errorMessage, array $options = []): string {
        $options['error'] = true;
        $options['errorMessage'] = $errorMessage;
        return self::renderRadio($name, $value, $options);
    }

    /**
     * Render Radio Button Structure
     */
    private static function renderRadio(string $name, string $value, array $options = []): string {
        $id = $options['id'] ?? 'md3-radio-' . uniqid();
        $checked = $options['checked'] ?? false;
        $disabled = $options['disabled'] ?? false;
        $label = $options['label'] ?? '';
        $description = $options['description'] ?? '';
        $error = $options['error'] ?? false;
        $errorMessage = $options['errorMessage'] ?? '';

        $classes = ['md3-radio'];
        if ($checked) $classes[] = 'md3-radio--checked';
        if ($disabled) $classes[] = 'md3-radio--disabled';
        if ($error) $classes[] = 'md3-radio--error';
        if (!empty($options['class'])) $classes[] = $options['class'];

        // Container
        $html = '<div class="md3-radio-container">';

        // Hidden input for form submission
        $inputAttrs = [
            'type' => 'radio',
            'name' => $name,
            'value' => $value,
            'id' => $id . '-input',
            'class' => 'md3-radio__input'
        ];

        if ($checked) $inputAttrs['checked'] = 'checked';
        if ($disabled) $inputAttrs['disabled'] = 'disabled';

        $inputAttrsStr = '';
        foreach ($inputAttrs as $key => $val) {
            $inputAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
        }

        $html .= sprintf('<input%s>', $inputAttrsStr);

        // Radio element
        $radioAttrs = [
            'class' => implode(' ', $classes),
            'id' => $id,
            'role' => 'radio',
            'tabindex' => $disabled ? '-1' : '0',
            'aria-checked' => $checked ? 'true' : 'false',
            'aria-labelledby' => $label ? $id . '-label' : null,
            'aria-describedby' => $description ? $id . '-description' : null
        ];

        if ($disabled) {
            $radioAttrs['aria-disabled'] = 'true';
        }

        if ($error && $errorMessage) {
            $radioAttrs['aria-describedby'] = $id . '-error';
        }

        $radioAttrsStr = '';
        foreach ($radioAttrs as $key => $val) {
            if ($val !== null) {
                $radioAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
            }
        }

        $html .= sprintf('<div%s>', $radioAttrsStr);

        // Outer Circle
        $html .= '<div class="md3-radio__outer-circle"></div>';

        // Inner Circle
        $html .= '<div class="md3-radio__inner-circle"></div>';

        // Ripple Container
        $html .= '<div class="md3-radio__ripple"></div>';

        $html .= '</div>'; // End radio

        // Label
        if ($label) {
            $html .= sprintf(
                '<label class="md3-radio__label" for="%s" id="%s">%s</label>',
                $id . '-input',
                $id . '-label',
                htmlspecialchars($label)
            );
        }

        // Description
        if ($description) {
            $html .= sprintf(
                '<div class="md3-radio__description" id="%s">%s</div>',
                $id . '-description',
                htmlspecialchars($description)
            );
        }

        // Error Message
        if ($error && $errorMessage) {
            $html .= sprintf(
                '<div class="md3-radio__error" id="%s">%s</div>',
                $id . '-error',
                htmlspecialchars($errorMessage)
            );
        }

        $html .= '</div>'; // End container

        return $html;
    }

    /**
     * Get Radio CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Radio Button Component */
.md3-radio-container {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    position: relative;
    margin: 8px 0;
}

.md3-radio__input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
    width: 0;
    height: 0;
}

.md3-radio {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    cursor: pointer;
    outline: none;
    user-select: none;
    flex-shrink: 0;
    margin-top: 2px;
}

.md3-radio--disabled {
    cursor: not-allowed;
    opacity: 0.38;
}

/* Outer Circle */
.md3-radio__outer-circle {
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid var(--md-sys-color-on-surface-variant);
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    box-sizing: border-box;
}

.md3-radio--checked .md3-radio__outer-circle {
    border-color: var(--md-sys-color-primary);
    border-width: 2px;
}

.md3-radio--error .md3-radio__outer-circle {
    border-color: var(--md-sys-color-error);
}

.md3-radio--checked.md3-radio--error .md3-radio__outer-circle {
    border-color: var(--md-sys-color-error);
}

/* Inner Circle */
.md3-radio__inner-circle {
    position: absolute;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--md-sys-color-primary);
    transform: scale(0);
    transition: transform 0.2s cubic-bezier(0.2, 0, 0, 1);
}

.md3-radio--checked .md3-radio__inner-circle {
    transform: scale(1);
}

.md3-radio--error .md3-radio__inner-circle {
    background: var(--md-sys-color-error);
}

/* Ripple Effect */
.md3-radio__ripple {
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

.md3-radio:hover .md3-radio__ripple {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
}

.md3-radio--checked:hover .md3-radio__ripple {
    background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
}

.md3-radio:focus-visible .md3-radio__ripple {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

.md3-radio--checked:focus-visible .md3-radio__ripple {
    background: color-mix(in srgb, var(--md-sys-color-primary) 12%, transparent);
}

.md3-radio--error:hover .md3-radio__ripple {
    background: color-mix(in srgb, var(--md-sys-color-error) 8%, transparent);
}

.md3-radio--error:focus-visible .md3-radio__ripple {
    background: color-mix(in srgb, var(--md-sys-color-error) 12%, transparent);
    outline-color: var(--md-sys-color-error);
}

/* Radio Label */
.md3-radio__label {
    font-size: 14px;
    font-weight: 400;
    color: var(--md-sys-color-on-surface);
    cursor: pointer;
    user-select: none;
    line-height: 1.4;
    flex: 1;
}

.md3-radio--disabled .md3-radio__label {
    cursor: not-allowed;
    opacity: 0.38;
}

.md3-radio--error .md3-radio__label {
    color: var(--md-sys-color-error);
}

/* Radio Description */
.md3-radio__description {
    font-size: 12px;
    color: var(--md-sys-color-on-surface-variant);
    margin-top: 4px;
    line-height: 1.3;
}

.md3-radio--error .md3-radio__description {
    color: var(--md-sys-color-error);
}

/* Radio Error Message */
.md3-radio__error {
    font-size: 12px;
    color: var(--md-sys-color-error);
    margin-top: 4px;
    line-height: 1.3;
}

/* Radio Group */
.md3-radio-group {
    margin: 16px 0;
}

.md3-radio-group__label {
    font-size: 14px;
    font-weight: 500;
    color: var(--md-sys-color-on-surface);
    margin-bottom: 8px;
}

.md3-radio-group--error .md3-radio-group__label {
    color: var(--md-sys-color-error);
}

.md3-radio-group__options {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.md3-radio-group--horizontal .md3-radio-group__options {
    flex-direction: row;
    flex-wrap: wrap;
    gap: 16px;
}

.md3-radio-group__description {
    font-size: 12px;
    color: var(--md-sys-color-on-surface-variant);
    margin-top: 8px;
    line-height: 1.3;
}

.md3-radio-group__error {
    font-size: 12px;
    color: var(--md-sys-color-error);
    margin-top: 8px;
    line-height: 1.3;
}

/* Disabled Group State */
.md3-radio-group--disabled {
    opacity: 0.38;
}

.md3-radio-group--disabled .md3-radio-group__label {
    color: var(--md-sys-color-on-surface);
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-radio-group--horizontal .md3-radio-group__options {
        flex-direction: column;
        gap: 4px;
    }

    .md3-radio-container {
        gap: 8px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-radio__outer-circle {
    border-color: var(--md-sys-color-on-surface-variant);
}

[data-theme="dark"] .md3-radio--checked .md3-radio__outer-circle {
    border-color: var(--md-sys-color-primary);
}

[data-theme="dark"] .md3-radio__inner-circle {
    background: var(--md-sys-color-primary);
}

[data-theme="dark"] .md3-radio--error .md3-radio__outer-circle {
    border-color: var(--md-sys-color-error);
}

[data-theme="dark"] .md3-radio--error .md3-radio__inner-circle {
    background: var(--md-sys-color-error);
}

/* Animation for better feedback */
@keyframes md3-radio-ripple {
    0% {
        transform: translate(-50%, -50%) scale(0);
        opacity: 0.1;
    }
    100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0;
    }
}

.md3-radio__ripple.md3-radio__ripple--active {
    animation: md3-radio-ripple 0.6s ease-out;
}
';
    }

    /**
     * Get Radio JavaScript
     */
    public static function getJS(): string {
        return '
// Radio Button Management
document.addEventListener("DOMContentLoaded", function() {
    // Handle radio button interactions
    document.addEventListener("click", function(e) {
        const radioElement = e.target.closest(".md3-radio");
        if (!radioElement || radioElement.classList.contains("md3-radio--disabled")) {
            return;
        }

        const input = radioElement.closest(".md3-radio-container").querySelector(".md3-radio__input");
        if (!input) return;

        // Uncheck other radios with the same name
        const otherRadios = document.querySelectorAll(`input[name="' + input.name + '"]`);
        otherRadios.forEach(radio => {
            if (radio !== input) {
                radio.checked = false;
                const otherRadioElement = radio.closest(".md3-radio-container").querySelector(".md3-radio");
                if (otherRadioElement) {
                    updateRadioState(otherRadioElement, false);
                }
            }
        });

        // Check current radio
        input.checked = true;
        updateRadioState(radioElement, true);

        // Dispatch change event
        const event = new Event("change", { bubbles: true });
        input.dispatchEvent(event);

        // Dispatch custom event
        const customEvent = new CustomEvent("md3-radio-change", {
            detail: {
                radio: radioElement,
                input: input,
                checked: input.checked,
                value: input.value,
                name: input.name
            }
        });
        radioElement.dispatchEvent(customEvent);
    });

    // Handle keyboard interactions
    document.addEventListener("keydown", function(e) {
        const radioElement = e.target.closest(".md3-radio");
        if (!radioElement || radioElement.classList.contains("md3-radio--disabled")) {
            return;
        }

        const input = radioElement.closest(".md3-radio-container").querySelector(".md3-radio__input");
        if (!input) return;

        // Space or Enter key selects the radio
        if (e.key === " " || e.key === "Enter") {
            e.preventDefault();
            radioElement.click();
        }

        // Arrow keys navigate within radio groups
        if (e.key === "ArrowDown" || e.key === "ArrowRight" ||
            e.key === "ArrowUp" || e.key === "ArrowLeft") {
            e.preventDefault();

            const allRadios = Array.from(document.querySelectorAll(`input[name="' + input.name + '"]`));
            const currentIndex = allRadios.indexOf(input);
            let nextIndex;

            if (e.key === "ArrowDown" || e.key === "ArrowRight") {
                nextIndex = (currentIndex + 1) % allRadios.length;
            } else {
                nextIndex = (currentIndex - 1 + allRadios.length) % allRadios.length;
            }

            const nextRadio = allRadios[nextIndex];
            const nextRadioElement = nextRadio.closest(".md3-radio-container").querySelector(".md3-radio");

            if (nextRadioElement && !nextRadioElement.classList.contains("md3-radio--disabled")) {
                nextRadioElement.focus();
                nextRadioElement.click();
            }
        }
    });

    // Handle label clicks
    document.addEventListener("click", function(e) {
        const label = e.target.closest(".md3-radio__label");
        if (!label) return;

        const input = document.getElementById(label.getAttribute("for"));
        if (!input || input.disabled) return;

        const radioElement = input.closest(".md3-radio-container").querySelector(".md3-radio");
        if (radioElement) {
            radioElement.click();
        }
    });

    // Initialize all radios to correct state
    document.querySelectorAll(".md3-radio").forEach(radioElement => {
        const input = radioElement.closest(".md3-radio-container").querySelector(".md3-radio__input");
        if (input) {
            updateRadioState(radioElement, input.checked);
        }
    });

    function updateRadioState(radioElement, checked) {
        if (checked) {
            radioElement.classList.add("md3-radio--checked");
            radioElement.setAttribute("aria-checked", "true");
        } else {
            radioElement.classList.remove("md3-radio--checked");
            radioElement.setAttribute("aria-checked", "false");
        }
    }

    // Add ripple effect
    document.addEventListener("pointerdown", function(e) {
        const radioElement = e.target.closest(".md3-radio");
        if (!radioElement || radioElement.classList.contains("md3-radio--disabled")) {
            return;
        }

        const ripple = radioElement.querySelector(".md3-radio__ripple");
        if (!ripple) return;

        // Add ripple animation class
        ripple.classList.add("md3-radio__ripple--active");

        // Remove class after animation
        setTimeout(() => {
            ripple.classList.remove("md3-radio__ripple--active");
        }, 600);
    });
});

// Utility functions
window.setRadioValue = function(name, value) {
    const radios = document.querySelectorAll(`input[name="' + name + '"]`);
    radios.forEach(radio => {
        const radioElement = radio.closest(".md3-radio-container").querySelector(".md3-radio");
        if (radio.value === value) {
            radio.checked = true;
            if (radioElement) {
                radioElement.classList.add("md3-radio--checked");
                radioElement.setAttribute("aria-checked", "true");
            }
        } else {
            radio.checked = false;
            if (radioElement) {
                radioElement.classList.remove("md3-radio--checked");
                radioElement.setAttribute("aria-checked", "false");
            }
        }
    });

    // Dispatch change event
    const selectedRadio = document.querySelector(`input[name="' + name + '"][value="' + value + '"]`);
    if (selectedRadio) {
        const event = new Event("change", { bubbles: true });
        selectedRadio.dispatchEvent(event);
    }
};

window.getRadioValue = function(name) {
    const selectedRadio = document.querySelector(`input[name="' + name + '"]:checked`);
    return selectedRadio ? selectedRadio.value : null;
};
';
    }
}