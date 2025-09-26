<?php

require_once 'MD3.php';

/**
 * MD3TextField - Material Design 3 Text Field Components
 * Generates HTML for Material Web Components text fields
 */
class MD3TextField
{
    /**
     * Generate a filled text field
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-text-field
     */
    public static function filled(string $name, string $label, array $attributes = []): string
    {
        $type = $attributes['type'] ?? 'text';
        $value = $attributes['value'] ?? '';
        $placeholder = $attributes['placeholder'] ?? $label;

        // Remove internal attributes
        unset($attributes['type'], $attributes['value'], $attributes['placeholder']);

        if ($type === 'textarea') {
            $rows = $attributes['rows'] ?? 3;
            unset($attributes['rows']);
            $input = '<textarea name="' . htmlspecialchars($name) . '" placeholder="' . htmlspecialchars($placeholder) . '" rows="' . $rows . '"' . MD3::escapeAttributes($attributes) . '>' . htmlspecialchars($value) . '</textarea>';
        } else {
            $input = '<input type="' . htmlspecialchars($type) . '" name="' . htmlspecialchars($name) . '" placeholder="' . htmlspecialchars($placeholder) . '" value="' . htmlspecialchars($value) . '"' . MD3::escapeAttributes($attributes) . '>';
        }

        return '<md-filled-text-field>' . $input . '</md-filled-text-field>';
    }

    /**
     * Generate an outlined text field
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-outlined-text-field
     */
    public static function outlined(string $name, string $label, array $attributes = []): string
    {
        $type = $attributes['type'] ?? 'text';
        $value = $attributes['value'] ?? '';
        $placeholder = $attributes['placeholder'] ?? $label;

        // Remove internal attributes
        unset($attributes['type'], $attributes['value'], $attributes['placeholder']);

        if ($type === 'textarea') {
            $rows = $attributes['rows'] ?? 3;
            unset($attributes['rows']);
            $input = '<textarea name="' . htmlspecialchars($name) . '" placeholder="' . htmlspecialchars($placeholder) . '" rows="' . $rows . '"' . MD3::escapeAttributes($attributes) . '>' . htmlspecialchars($value) . '</textarea>';
        } else {
            $input = '<input type="' . htmlspecialchars($type) . '" name="' . htmlspecialchars($name) . '" placeholder="' . htmlspecialchars($placeholder) . '" value="' . htmlspecialchars($value) . '"' . MD3::escapeAttributes($attributes) . '>';
        }

        return '<md-outlined-text-field>' . $input . '</md-outlined-text-field>';
    }

    /**
     * Generate a password field (filled)
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-text-field with password type
     */
    public static function password(string $name, string $label = 'Password', array $attributes = []): string
    {
        $attributes['type'] = 'password';
        return self::filled($name, $label, $attributes);
    }

    /**
     * Generate an outlined password field
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-outlined-text-field with password type
     */
    public static function passwordOutlined(string $name, string $label = 'Password', array $attributes = []): string
    {
        $attributes['type'] = 'password';
        return self::outlined($name, $label, $attributes);
    }

    /**
     * Generate an email field (filled)
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-text-field with email type
     */
    public static function email(string $name, string $label = 'Email', array $attributes = []): string
    {
        $attributes['type'] = 'email';
        return self::filled($name, $label, $attributes);
    }

    /**
     * Generate an outlined email field
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-outlined-text-field with email type
     */
    public static function emailOutlined(string $name, string $label = 'Email', array $attributes = []): string
    {
        $attributes['type'] = 'email';
        return self::outlined($name, $label, $attributes);
    }

    /**
     * Generate a number field (filled)
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes (min, max, step)
     * @return string HTML for md-filled-text-field with number type
     */
    public static function number(string $name, string $label, array $attributes = []): string
    {
        $attributes['type'] = 'number';
        return self::filled($name, $label, $attributes);
    }

    /**
     * Generate an outlined number field
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes (min, max, step)
     * @return string HTML for md-outlined-text-field with number type
     */
    public static function numberOutlined(string $name, string $label, array $attributes = []): string
    {
        $attributes['type'] = 'number';
        return self::outlined($name, $label, $attributes);
    }

    /**
     * Generate a search field (filled)
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-text-field with search type
     */
    public static function search(string $name, string $label = 'Search', array $attributes = []): string
    {
        $attributes['type'] = 'search';
        return self::filled($name, $label, $attributes);
    }

    /**
     * Generate an outlined search field
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-outlined-text-field with search type
     */
    public static function searchOutlined(string $name, string $label = 'Search', array $attributes = []): string
    {
        $attributes['type'] = 'search';
        return self::outlined($name, $label, $attributes);
    }

    /**
     * Generate a textarea field (filled)
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes (rows)
     * @return string HTML for md-filled-text-field with multiline
     */
    public static function textarea(string $name, string $label, array $attributes = []): string
    {
        $attributes['type'] = 'textarea';
        if (!isset($attributes['rows'])) {
            $attributes['rows'] = 3;
        }
        return self::filled($name, $label, $attributes);
    }

    /**
     * Generate an outlined textarea field
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $attributes Additional HTML attributes (rows)
     * @return string HTML for md-outlined-text-field with multiline
     */
    public static function textareaOutlined(string $name, string $label, array $attributes = []): string
    {
        $attributes['type'] = 'textarea';
        if (!isset($attributes['rows'])) {
            $attributes['rows'] = 3;
        }
        return self::outlined($name, $label, $attributes);
    }

    /**
     * Generate a field with leading icon
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param string $icon Material icon name
     * @param bool $outlined Whether to use outlined style (default: false)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for text field with leading icon
     */
    public static function withLeadingIcon(string $name, string $label, string $icon, bool $outlined = false, array $attributes = []): string
    {
        $iconHtml = MD3::icon($icon, ['slot' => 'leading-icon']);
        $method = $outlined ? 'outlined' : 'filled';
        $fieldHtml = self::$method($name, $label, $attributes);

        return str_replace('></md-', '>' . $iconHtml . '</md-', $fieldHtml);
    }

    /**
     * Generate a field with trailing icon
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param string $icon Material icon name
     * @param bool $outlined Whether to use outlined style (default: false)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for text field with trailing icon
     */
    public static function withTrailingIcon(string $name, string $label, string $icon, bool $outlined = false, array $attributes = []): string
    {
        $iconHtml = MD3::icon($icon, ['slot' => 'trailing-icon']);
        $method = $outlined ? 'outlined' : 'filled';
        $fieldHtml = self::$method($name, $label, $attributes);

        return str_replace('></md-', '>' . $iconHtml . '</md-', $fieldHtml);
    }
}