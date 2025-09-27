<?php

require_once 'MD3.php';

/**
 * MD3Select - Material Design 3 Select Components
 * Generates HTML for CSS-based Material Design 3 select fields
 */
class MD3Select
{
    /**
     * Generate a filled select field
     */
    public static function filled(string $name, string $label, array $options = [], string $selected = '', array $attributes = []): string
    {
        return self::renderSelect($name, $label, $options, $selected, $attributes, 'filled');
    }

    /**
     * Generate an outlined select field
     */
    public static function outlined(string $name, string $label, array $options = [], string $selected = '', array $attributes = []): string
    {
        return self::renderSelect($name, $label, $options, $selected, $attributes, 'outlined');
    }

    /**
     * Generate a select field with icons
     */
    public static function withIcons(string $name, string $label, array $options = [], string $selected = '', bool $outlined = false, array $attributes = []): string
    {
        $variant = $outlined ? 'outlined' : 'filled';

        // Convert options to include icon display
        $processedOptions = [];
        foreach ($options as $value => $option) {
            if (is_array($option)) {
                $icon = isset($option['icon']) ? $option['icon'] . ' ' : '';
                $processedOptions[$value] = $icon . ($option['label'] ?? $value);
            } else {
                $processedOptions[$value] = $option;
            }
        }

        return self::renderSelect($name, $label, $processedOptions, $selected, $attributes, $variant);
    }

    /**
     * Generate a multi-select field
     */
    public static function multiple(string $name, string $label, array $options = [], array $selected = [], bool $outlined = false, array $attributes = []): string
    {
        $attributes['multiple'] = true;
        $fieldName = $name . '[]';
        $variant = $outlined ? 'outlined' : 'filled';

        return self::renderSelect($fieldName, $label, $options, '', $attributes, $variant, $selected);
    }

    /**
     * Generate a large select field (MD3 Large variant)
     */
    public static function large(string $name, string $label, array $options = [], string $selected = '', bool $outlined = false, array $attributes = []): string
    {
        $variant = $outlined ? 'outlined' : 'filled';
        $attributes['data-size'] = 'large';
        return self::renderSelect($name, $label, $options, $selected, $attributes, $variant);
    }

    /**
     * Generate a dense select field (smaller variant)
     */
    public static function dense(string $name, string $label, array $options = [], string $selected = '', bool $outlined = false, array $attributes = []): string
    {
        $variant = $outlined ? 'outlined' : 'filled';
        $attributes['data-size'] = 'dense';
        return self::renderSelect($name, $label, $options, $selected, $attributes, $variant);
    }

    /**
     * Generate a country select field with flags
     */
    public static function country(string $name, string $label = 'Land', string $selected = 'DE', bool $outlined = false, array $attributes = []): string
    {
        $countries = [
            'DE' => '🇩🇪 Deutschland',
            'AT' => '🇦🇹 Österreich',
            'CH' => '🇨🇭 Schweiz',
            'US' => '🇺🇸 United States',
            'GB' => '🇬🇧 United Kingdom',
            'FR' => '🇫🇷 France',
            'IT' => '🇮🇹 Italy',
            'ES' => '🇪🇸 Spain',
            'NL' => '🇳🇱 Netherlands',
            'BE' => '🇧🇪 Belgium',
            'PL' => '🇵🇱 Poland',
            'CZ' => '🇨🇿 Czech Republic'
        ];

        $variant = $outlined ? 'outlined' : 'filled';
        return self::renderSelect($name, $label, $countries, $selected, $attributes, $variant);
    }

    /**
     * Render select field with specified variant
     */
    private static function renderSelect(string $name, string $label, array $options, string $selected, array $attributes, string $variant, array $multiSelected = []): string
    {
        $selectId = 'select-' . str_replace(['[', ']'], '', $name) . '-' . uniqid();
        $isMultiple = isset($attributes['multiple']);
        $disabled = $attributes['disabled'] ?? false;
        $required = $attributes['required'] ?? false;

        // Remove our custom attributes
        unset($attributes['disabled'], $attributes['required'], $attributes['data-size']);

        // Build classes for container (TextField-style)
        $classes = ['md3-textfield', "md3-textfield--{$variant}", 'md3-select-container'];
        if ($disabled) $classes[] = 'md3-textfield--disabled';
        if ($required) $classes[] = 'md3-textfield--required';

        // Add size variant classes
        $size = $attributes['data-size'] ?? 'standard';
        if ($size !== 'standard') {
            $classes[] = 'md3-textfield--' . $size;
        }

        // Get selected option label for display
        $selectedLabel = '';
        if (!empty($selected) && isset($options[$selected])) {
            $selectedLabel = is_array($options[$selected]) ? $options[$selected]['label'] : $options[$selected];
        }

        // Add has-value class if there's a selection
        if (!empty($selectedLabel)) {
            $classes[] = 'md3-select--has-value';
        }

        $html = '<div class="' . implode(' ', $classes) . '">';

        if ($variant === 'outlined') {
            // Outlined TextField style
            $html .= '<div class="md3-textfield__outline">';
            $html .= '<div class="md3-textfield__outline-start"></div>';
            $html .= '<div class="md3-textfield__outline-notch">';
            $html .= '<label class="md3-textfield__label" for="' . $selectId . '">' . htmlspecialchars($label) . '</label>';
            $html .= '</div>';
            $html .= '<div class="md3-textfield__outline-end"></div>';
            $html .= '</div>';
        } else {
            // Filled TextField style
            $html .= '<label class="md3-textfield__label" for="' . $selectId . '">' . htmlspecialchars($label) . '</label>';
        }

        // Hidden select element for functionality
        $selectAttrs = array_merge([
            'id' => $selectId,
            'name' => $name,
            'class' => 'md3-select__native'
        ], $attributes);

        if ($disabled) {
            $selectAttrs['disabled'] = 'disabled';
        }

        $html .= '<select' . self::attributesToString($selectAttrs) . ' style="opacity: 0; position: absolute; pointer-events: none;">';

        foreach ($options as $value => $optionLabel) {
            if (is_array($optionLabel)) {
                $value = $optionLabel['value'] ?? '';
                $optionLabel = $optionLabel['label'] ?? $value;
            }

            $isSelected = $isMultiple ? in_array($value, $multiSelected) : ($value == $selected);
            $selectedAttr = $isSelected ? ' selected' : '';

            $html .= '<option value="' . htmlspecialchars($value) . '"' . $selectedAttr . '>';
            $html .= htmlspecialchars($optionLabel);
            $html .= '</option>';
        }

        $html .= '</select>';

        // TextField-style input display
        $html .= '<div class="md3-textfield__input md3-select__display" data-select-id="' . $selectId . '">';
        $html .= htmlspecialchars($selectedLabel);
        $html .= '</div>';

        // Dropdown arrow
        $html .= '<div class="md3-select__arrow">';
        $html .= '<span class="material-symbols-outlined">arrow_drop_down</span>';
        $html .= '</div>';

        // Supporting text line for filled variant
        if ($variant === 'filled') {
            $html .= '<div class="md3-textfield__active-indicator"></div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Convert attributes array to string
     */
    private static function attributesToString(array $attributes): string
    {
        $result = '';
        foreach ($attributes as $key => $value) {
            if ($value === true) {
                $result .= ' ' . htmlspecialchars($key);
            } elseif ($value !== false && $value !== null) {
                $result .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
            }
        }
        return $result;
    }

    /**
     * Get CSS for Material Design 3 Select Components
     */
    public static function getCSS(): string
    {
        return '
/* MD3 Select - TextField Style */
.md3-select-container {
    position: relative;
    cursor: pointer;
}

.md3-select-container .md3-textfield__input {
    cursor: pointer;
    user-select: none;
    padding-right: 48px !important; /* Space for dropdown arrow */
}

.md3-select__native {
    opacity: 0 !important;
    position: absolute !important;
    pointer-events: none !important;
}

.md3-select__display {
    position: relative;
    background: transparent;
    border: none;
    outline: none;
    font-family: inherit;
    color: var(--md-sys-color-on-surface);
    cursor: pointer;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.md3-select__arrow {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    z-index: 2;
    color: var(--md-sys-color-on-surface-variant);
    transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.md3-select-container:hover .md3-select__arrow {
    color: var(--md-sys-color-on-surface);
}

.md3-select__arrow .material-symbols-outlined {
    font-size: 24px;
    line-height: 1;
}

/* Filled variant specific styles */
.md3-select-container.md3-textfield--filled {
    cursor: pointer;
}

.md3-select-container.md3-textfield--filled .md3-textfield__label {
    pointer-events: none;
}

/* Outlined variant specific styles */
.md3-select-container.md3-textfield--outlined {
    cursor: pointer;
}

.md3-select-container.md3-textfield--outlined .md3-textfield__label {
    pointer-events: none;
}

/* Disabled state */
.md3-select-container.md3-textfield--disabled {
    cursor: not-allowed;
}

.md3-select-container.md3-textfield--disabled .md3-select__display {
    cursor: not-allowed;
    opacity: 0.38;
}

.md3-select-container.md3-textfield--disabled .md3-select__arrow {
    opacity: 0.38;
}

/* Focus states */
.md3-select-container:focus-within .md3-textfield__label,
.md3-select-container.md3-select--has-value .md3-textfield__label {
    transform: translateY(-50%) scale(0.75);
}

.md3-select-container.md3-textfield--filled:focus-within .md3-textfield__label,
.md3-select-container.md3-textfield--filled.md3-select--has-value .md3-textfield__label {
    transform: translateY(-106%) scale(0.75);
}

/* Has value state */
.md3-select-container.md3-select--has-value .md3-textfield__label {
    color: var(--md-sys-color-primary);
}

/* Hover effects */
.md3-select-container:hover:not(.md3-textfield--disabled) .md3-textfield__outline .md3-textfield__outline-start,
.md3-select-container:hover:not(.md3-textfield--disabled) .md3-textfield__outline .md3-textfield__outline-end {
    border-color: var(--md-sys-color-on-surface);
}

.md3-select-container:hover:not(.md3-textfield--disabled) .md3-textfield__active-indicator {
    background-color: var(--md-sys-color-on-surface);
}

/* Size variants */
.md3-select-container.md3-textfield--large .md3-textfield__input {
    height: 64px;
    padding: 20px 48px 8px 16px;
}

.md3-select-container.md3-textfield--dense .md3-textfield__input {
    height: 48px;
    padding: 12px 48px 12px 16px;
}
        ';
    }

    /**
     * Get JavaScript for select field enhancement
     */
    public static function getSelectScript(): string
    {
        return '<script>
// Enhanced Select Field Functionality
document.addEventListener("DOMContentLoaded", function() {
    // Initialize all select containers
    document.querySelectorAll(".md3-select-container").forEach(function(container) {
        const nativeSelect = container.querySelector(".md3-select__native");
        const display = container.querySelector(".md3-select__display");

        if (!nativeSelect || !display) return;

        // Update display when selection changes
        nativeSelect.addEventListener("change", function() {
            const selectedOption = nativeSelect.options[nativeSelect.selectedIndex];
            display.textContent = selectedOption ? selectedOption.text : "";

            // Update has-value class
            if (nativeSelect.value) {
                container.classList.add("md3-select--has-value");
            } else {
                container.classList.remove("md3-select--has-value");
            }
        });

        // Click on container opens native select
        container.addEventListener("click", function(e) {
            if (!container.classList.contains("md3-textfield--disabled")) {
                nativeSelect.focus();
                nativeSelect.click();
            }
        });

        // Initial state check
        if (nativeSelect.value) {
            container.classList.add("md3-select--has-value");
        }
    });
});
</script>';
    }
}

?>