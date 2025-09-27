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
     * Generate a country select field
     */
    public static function country(string $name, string $label = 'Land', string $selected = 'DE', bool $outlined = false, array $attributes = []): string
    {
        $countries = [
            'DE' => 'Deutschland',
            'AT' => 'Österreich',
            'CH' => 'Schweiz',
            'US' => 'USA',
            'GB' => 'Vereinigtes Königreich',
            'FR' => 'Frankreich',
            'IT' => 'Italien',
            'ES' => 'Spanien',
            'NL' => 'Niederlande',
            'BE' => 'Belgien'
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

        // Remove our custom attributes from select element
        unset($attributes['disabled']);

        $classes = ['md3-select', "md3-select--{$variant}"];
        if ($disabled) $classes[] = 'md3-select--disabled';

        $containerAttrs = [
            'class' => implode(' ', $classes),
            'data-variant' => $variant
        ];

        $selectAttrs = array_merge([
            'id' => $selectId,
            'name' => $name
        ], $attributes);

        if ($disabled) {
            $selectAttrs['disabled'] = 'disabled';
        }

        $html = '<div' . self::attributesToString($containerAttrs) . '>';

        // Label (for filled variant it will be positioned absolutely)
        $html .= '<label for="' . htmlspecialchars($selectId) . '" class="md3-select__label">' . htmlspecialchars($label) . '</label>';

        // Select element
        $html .= '<select' . self::attributesToString($selectAttrs) . '>';

        foreach ($options as $value => $optionLabel) {
            // Handle both simple array and complex array formats
            if (is_array($optionLabel)) {
                $value = $optionLabel['value'] ?? '';
                $optionLabel = $optionLabel['label'] ?? $value;
            }

            $isSelected = $isMultiple
                ? in_array($value, $multiSelected)
                : ($value == $selected);
            $selectedAttr = $isSelected ? ' selected' : '';

            $html .= '<option value="' . htmlspecialchars($value) . '"' . $selectedAttr . '>';
            $html .= htmlspecialchars($optionLabel);
            $html .= '</option>';
        }

        $html .= '</select>';

        // Dropdown arrow
        $html .= '<div class="md3-select__arrow">';
        $html .= '<span class="material-symbols-outlined">arrow_drop_down</span>';
        $html .= '</div>';

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
/* MD3 Select Base Styles */
.md3-select {
    position: relative;
    display: inline-block;
    width: 100%;
    min-width: 200px;
    font-family: inherit;
}

.md3-select__label {
    position: absolute;
    pointer-events: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 16px;
    color: var(--md-sys-color-on-surface-variant);
    z-index: 1;
}

.md3-select select {
    width: 100%;
    height: 56px;
    padding: 16px 48px 16px 16px;
    font-family: inherit;
    font-size: 16px;
    line-height: 24px;
    color: var(--md-sys-color-on-surface);
    background: transparent;
    border: none;
    outline: none;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    box-sizing: border-box;
}

.md3-select select:disabled {
    cursor: not-allowed;
    opacity: 0.38;
}

.md3-select__arrow {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--md-sys-color-on-surface-variant);
    transition: transform 0.2s, color 0.2s;
}

.md3-select select:focus + .md3-select__arrow,
.md3-select:hover .md3-select__arrow {
    color: var(--md-sys-color-primary);
}

/* Filled Select */
.md3-select--filled {
    background: var(--md-sys-color-surface-container-highest);
    border-radius: 4px 4px 0 0;
    border-bottom: 1px solid var(--md-sys-color-on-surface-variant);
    transition: border-bottom-color 0.2s;
}

.md3-select--filled:hover {
    border-bottom-color: var(--md-sys-color-on-surface);
}

.md3-select--filled:focus-within {
    border-bottom: 2px solid var(--md-sys-color-primary);
}

.md3-select--filled .md3-select__label {
    left: 16px;
    top: 8px;
    font-size: 12px;
    color: var(--md-sys-color-primary);
    background: none;
}

/* Outlined Select */
.md3-select--outlined {
    border: 1px solid var(--md-sys-color-outline);
    border-radius: 4px;
    background: var(--md-sys-color-surface);
    transition: border-color 0.2s;
}

.md3-select--outlined:hover {
    border-color: var(--md-sys-color-on-surface);
}

.md3-select--outlined:focus-within {
    border: 2px solid var(--md-sys-color-primary);
}

.md3-select--outlined:focus-within select {
    padding: 15px 47px 15px 15px;
}

.md3-select--outlined .md3-select__label {
    left: 12px;
    top: -8px;
    font-size: 12px;
    color: var(--md-sys-color-primary);
    background: var(--md-sys-color-surface);
    padding: 0 4px;
}

/* Error State */
.md3-select--error {
    border-color: var(--md-sys-color-error) !important;
}

.md3-select--error .md3-select__label {
    color: var(--md-sys-color-error) !important;
}

.md3-select--error .md3-select__arrow {
    color: var(--md-sys-color-error) !important;
}

/* Disabled State */
.md3-select--disabled {
    opacity: 0.38;
    pointer-events: none;
}

.md3-select--disabled.md3-select--filled {
    background: var(--md-sys-color-on-surface);
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 4%, transparent);
    border-bottom-color: var(--md-sys-color-on-surface);
    border-bottom-color: color-mix(in srgb, var(--md-sys-color-on-surface) 38%, transparent);
}

.md3-select--disabled.md3-select--outlined {
    border-color: var(--md-sys-color-on-surface);
    border-color: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
}

/* Multiple Select */
.md3-select select[multiple] {
    height: auto;
    min-height: 120px;
    padding: 8px 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-select {
        min-width: 0;
    }

    .md3-select select {
        height: 48px;
        padding: 12px 40px 12px 12px;
        font-size: 14px;
    }

    .md3-select--filled .md3-select__label {
        left: 12px;
        top: 6px;
        font-size: 11px;
    }

    .md3-select--outlined .md3-select__label {
        left: 8px;
        font-size: 11px;
    }

    .md3-select__arrow {
        right: 8px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-select--filled {
    background: var(--md-sys-color-surface-container-highest);
}

[data-theme="dark"] .md3-select--outlined {
    background: var(--md-sys-color-surface);
    border-color: var(--md-sys-color-outline);
}
';
    }

    /**
     * Get JavaScript for select field enhancement
     */
    public static function getSelectScript(): string
    {
        return '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectFields = document.querySelectorAll(".md3-select");

            selectFields.forEach(function(selectField) {
                const select = selectField.querySelector("select");
                if (!select) return;

                // Handle focus/blur for better visual feedback
                select.addEventListener("focus", function() {
                    selectField.classList.add("md3-select--focused");
                });

                select.addEventListener("blur", function() {
                    selectField.classList.remove("md3-select--focused");
                });

                // Custom change event
                select.addEventListener("change", function() {
                    selectField.dispatchEvent(new CustomEvent("md-select-change", {
                        detail: { value: this.value, name: this.name }
                    }));
                });
            });
        });

        // Utility functions
        function getSelectValue(selectName) {
            const select = document.querySelector("select[name=\"" + selectName + "\"]");
            return select ? select.value : null;
        }

        function setSelectValue(selectName, value) {
            const select = document.querySelector("select[name=\"" + selectName + "\"]");
            if (select) {
                select.value = value;
                select.dispatchEvent(new Event("change"));
            }
        }
        </script>';
    }
}