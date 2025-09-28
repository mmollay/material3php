<?php

/**
 * MD3Select - Material Design 3 Select Components
 * Generates proper Material Design 3 select fields using md-filled-select and md-outlined-select
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
     * Render modern Material Design 3 select
     */
    private static function renderSelect(string $name, string $label, array $options, string $selected, array $attributes, string $variant): string
    {
        $selectId = 'select-' . str_replace(['[', ']'], '', $name) . '-' . uniqid();
        $disabled = $attributes['disabled'] ?? false;
        $required = $attributes['required'] ?? false;

        // Remove our custom attributes
        unset($attributes['disabled'], $attributes['required']);

        // Build attributes string
        $attrStr = '';
        foreach ($attributes as $key => $value) {
            $attrStr .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
        }

        // Generate options HTML
        $optionsHtml = '';
        foreach ($options as $value => $option) {
            $optionLabel = is_array($option) ? $option['label'] : $option;
            $isSelected = ($value == $selected) ? ' selected' : '';
            $optionsHtml .= '<md-select-option value="' . htmlspecialchars($value) . '"' . $isSelected . '>';
            $optionsHtml .= '<div slot="headline">' . htmlspecialchars($optionLabel) . '</div>';
            $optionsHtml .= '</md-select-option>';
        }

        // Generate the select element
        if ($variant === 'outlined') {
            $html = '<md-outlined-select';
        } else {
            $html = '<md-filled-select';
        }

        $html .= ' id="' . $selectId . '"';
        $html .= ' name="' . htmlspecialchars($name) . '"';
        $html .= ' label="' . htmlspecialchars($label) . '"';

        if ($disabled) $html .= ' disabled';
        if ($required) $html .= ' required';
        if (!empty($selected)) $html .= ' value="' . htmlspecialchars($selected) . '"';

        $html .= $attrStr;
        $html .= '>';
        $html .= $optionsHtml;
        $html .= $variant === 'outlined' ? '</md-outlined-select>' : '</md-filled-select>';

        return $html;
    }

    /**
     * Generate a select with countries
     */
    public static function countries(string $name, string $label = 'Country', string $selected = '', bool $outlined = false, array $attributes = []): string
    {
        $countries = [
            'AT' => 'Austria',
            'DE' => 'Germany',
            'CH' => 'Switzerland',
            'US' => 'United States',
            'GB' => 'United Kingdom',
            'FR' => 'France',
            'IT' => 'Italy',
            'ES' => 'Spain',
            'NL' => 'Netherlands',
            'BE' => 'Belgium'
        ];

        $variant = $outlined ? 'outlined' : 'filled';
        return self::renderSelect($name, $label, $countries, $selected, $attributes, $variant);
    }

    /**
     * Get CSS for Material Design 3 Select components
     */
    public static function getCSS(): string
    {
        return '
/* Material Design 3 Select Styles */
md-filled-select,
md-outlined-select {
    width: 100%;
    margin: 8px 0;
}

md-filled-select {
    --md-filled-select-text-field-container-color: var(--md-sys-color-surface-container-highest);
    --md-filled-select-text-field-focus-label-text-color: var(--md-sys-color-primary);
    --md-filled-select-text-field-label-text-color: var(--md-sys-color-on-surface-variant);
    --md-filled-select-text-field-input-text-color: var(--md-sys-color-on-surface);
    --md-filled-select-text-field-supporting-text-color: var(--md-sys-color-on-surface-variant);
    --md-filled-select-text-field-error-focus-label-text-color: var(--md-sys-color-error);
    --md-filled-select-text-field-error-label-text-color: var(--md-sys-color-error);
    --md-filled-select-text-field-error-supporting-text-color: var(--md-sys-color-error);
    --md-filled-select-text-field-caret-color: var(--md-sys-color-primary);
}

md-outlined-select {
    --md-outlined-select-text-field-focus-outline-color: var(--md-sys-color-primary);
    --md-outlined-select-text-field-focus-label-text-color: var(--md-sys-color-primary);
    --md-outlined-select-text-field-label-text-color: var(--md-sys-color-on-surface-variant);
    --md-outlined-select-text-field-outline-color: var(--md-sys-color-outline);
    --md-outlined-select-text-field-input-text-color: var(--md-sys-color-on-surface);
    --md-outlined-select-text-field-supporting-text-color: var(--md-sys-color-on-surface-variant);
    --md-outlined-select-text-field-error-focus-outline-color: var(--md-sys-color-error);
    --md-outlined-select-text-field-error-focus-label-text-color: var(--md-sys-color-error);
    --md-outlined-select-text-field-error-label-text-color: var(--md-sys-color-error);
    --md-outlined-select-text-field-error-outline-color: var(--md-sys-color-error);
    --md-outlined-select-text-field-error-supporting-text-color: var(--md-sys-color-error);
    --md-outlined-select-text-field-caret-color: var(--md-sys-color-primary);
}

md-select-option {
    --md-menu-item-label-text-color: var(--md-sys-color-on-surface);
    --md-menu-item-selected-container-color: var(--md-sys-color-secondary-container);
}

/* Dark theme support */
[data-theme="dark"] md-filled-select {
    --md-filled-select-text-field-container-color: var(--md-sys-color-surface-container-highest);
}

[data-theme="dark"] md-outlined-select {
    --md-outlined-select-text-field-outline-color: var(--md-sys-color-outline);
}
';
    }
}