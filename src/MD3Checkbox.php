<?php

require_once 'MD3.php';

/**
 * MD3Checkbox - Material Design 3 Checkbox Components
 */
class MD3Checkbox
{
    public static function basic(string $name, string $value = '1', bool $checked = false, array $attributes = []): string
    {
        $attributes['type'] = 'checkbox';
        $attributes['name'] = $name;
        $attributes['value'] = $value;
        $attributes['class'] = 'md-checkbox';

        if ($checked) {
            $attributes['checked'] = true;
        }

        return '<input' . MD3::escapeAttributes($attributes) . '>';
    }

    public static function withLabel(string $name, string $label, string $value = '1', bool $checked = false, array $attributes = []): string
    {
        $checkboxId = 'checkbox-' . $name;
        $attributes['id'] = $checkboxId;

        $checkbox = self::basic($name, $value, $checked, $attributes);

        return '<div class="checkbox-container">' .
               $checkbox .
               '<label for="' . htmlspecialchars($checkboxId) . '">' . htmlspecialchars($label) . '</label>' .
               '</div>';
    }
}
