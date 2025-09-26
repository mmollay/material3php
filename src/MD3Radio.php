<?php

require_once 'MD3.php';

/**
 * MD3Radio - Material Design 3 Radio Button Components
 */
class MD3Radio
{
    public static function basic(string $name, string $value, bool $checked = false, array $attributes = []): string
    {
        $attributes['name'] = $name;
        $attributes['value'] = $value;
        
        if ($checked) {
            $attributes['checked'] = true;
        }

        return '<md-radio' . MD3::escapeAttributes($attributes) . '></md-radio>';
    }

    public static function withLabel(string $name, string $value, string $label, bool $checked = false, array $attributes = []): string
    {
        $radioId = 'radio-' . $name . '-' . $value;
        $attributes['id'] = $radioId;
        
        $radio = self::basic($name, $value, $checked, $attributes);
        
        return '<div class="radio-container">' . 
               '<label for="' . htmlspecialchars($radioId) . '">' . htmlspecialchars($label) . '</label>' .
               $radio . 
               '</div>';
    }

    public static function group(string $name, array $options, string $selectedValue = '', array $attributes = []): string
    {
        $html = '<div class="radio-group"' . MD3::escapeAttributes($attributes) . '>';
        
        foreach ($options as $option) {
            $value = $option['value'] ?? '';
            $label = $option['label'] ?? $value;
            $checked = ($value === $selectedValue);
            
            $html .= self::withLabel($name, $value, $label, $checked);
        }
        
        $html .= '</div>';
        return $html;
    }
}
