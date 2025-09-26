<?php

require_once 'MD3.php';

/**
 * MD3Switch - Material Design 3 Switch Components
 * Generates HTML for Material Web Components switches
 */
class MD3Switch
{
    /**
     * Generate a basic switch
     *
     * @param string $name Field name attribute
     * @param string $value Switch value
     * @param bool $checked Whether switch is initially checked
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-switch
     */
    public static function basic(string $name, string $value = '1', bool $checked = false, array $attributes = []): string
    {
        $attributes['type'] = 'checkbox';
        $attributes['name'] = $name;
        $attributes['value'] = $value;
        $attributes['class'] = 'md-switch';

        if ($checked) {
            $attributes['checked'] = true;
        }

        return '<input' . MD3::escapeAttributes($attributes) . '>';
    }

    /**
     * Generate a switch with label
     *
     * @param string $name Field name
     * @param string $label Label text
     * @param string $value Switch value
     * @param bool $checked Whether checked initially
     * @param array $attributes Additional HTML attributes
     * @return string HTML for labeled switch
     */
    public static function withLabel(string $name, string $label, string $value = '1', bool $checked = false, array $attributes = []): string
    {
        $switchId = 'switch-' . $name;
        $attributes['id'] = $switchId;

        $switch = self::basic($name, $value, $checked, $attributes);

        return '<div class="switch-container">' .
               $switch .
               '<label for="' . htmlspecialchars($switchId) . '">' . htmlspecialchars($label) . '</label>' .
               '</div>';
    }

    /**
     * Generate a disabled switch
     *
     * @param string $name Field name
     * @param string $value Switch value
     * @param bool $checked Whether checked
     * @param array $attributes Additional HTML attributes
     * @return string HTML for disabled switch
     */
    public static function disabled(string $name, string $value = '1', bool $checked = false, array $attributes = []): string
    {
        $attributes['disabled'] = true;
        return self::basic($name, $value, $checked, $attributes);
    }
}
