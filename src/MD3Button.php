<?php

require_once 'MD3.php';

/**
 * MD3Button - Material Design 3 Button Components
 * Generates HTML for Material Web Components buttons
 */
class MD3Button
{
    /**
     * Generate a filled button (primary action)
     *
     * @param string $text Button text
     * @param string|null $href URL for link behavior (optional)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-button
     */
    public static function filled(string $text, ?string $href = null, array $attributes = []): string
    {
        if ($href) {
            $attributes['href'] = $href;
        }

        return self::renderButton('md-filled-button', $text, $attributes);
    }

    /**
     * Generate an outlined button (secondary action)
     *
     * @param string $text Button text
     * @param string|null $href URL for link behavior (optional)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-outlined-button
     */
    public static function outlined(string $text, ?string $href = null, array $attributes = []): string
    {
        if ($href) {
            $attributes['href'] = $href;
        }

        return self::renderButton('md-outlined-button', $text, $attributes);
    }

    /**
     * Generate a text button (tertiary action)
     *
     * @param string $text Button text
     * @param string|null $href URL for link behavior (optional)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-text-button
     */
    public static function text(string $text, ?string $href = null, array $attributes = []): string
    {
        if ($href) {
            $attributes['href'] = $href;
        }

        return self::renderButton('md-text-button', $text, $attributes);
    }

    /**
     * Generate an elevated button
     *
     * @param string $text Button text
     * @param string|null $href URL for link behavior (optional)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-elevated-button
     */
    public static function elevated(string $text, ?string $href = null, array $attributes = []): string
    {
        if ($href) {
            $attributes['href'] = $href;
        }

        return self::renderButton('md-elevated-button', $text, $attributes);
    }

    /**
     * Generate a tonal button
     *
     * @param string $text Button text
     * @param string|null $href URL for link behavior (optional)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-tonal-button
     */
    public static function tonal(string $text, ?string $href = null, array $attributes = []): string
    {
        if ($href) {
            $attributes['href'] = $href;
        }

        return self::renderButton('md-filled-tonal-button', $text, $attributes);
    }

    /**
     * Generate a FAB (Floating Action Button)
     *
     * @param string $icon Material icon name
     * @param string|null $text Optional text label
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-fab
     */
    public static function fab(string $icon, ?string $text = null, array $attributes = []): string
    {
        $content = MD3::icon($icon);
        if ($text) {
            $attributes['label'] = $text;
        }

        return '<md-fab' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-fab>';
    }

    /**
     * Generate an Icon Button
     *
     * @param string $icon Material icon name
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-icon-button
     */
    public static function icon(string $icon, array $attributes = []): string
    {
        $content = MD3::icon($icon);
        return '<md-icon-button' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-icon-button>';
    }

    /**
     * Generate a filled icon button
     *
     * @param string $icon Material icon name
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-icon-button
     */
    public static function iconFilled(string $icon, array $attributes = []): string
    {
        $content = MD3::icon($icon);
        return '<md-filled-icon-button' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-filled-icon-button>';
    }

    /**
     * Generate a tonal icon button
     *
     * @param string $icon Material icon name
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-tonal-icon-button
     */
    public static function iconTonal(string $icon, array $attributes = []): string
    {
        $content = MD3::icon($icon);
        return '<md-filled-tonal-icon-button' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-filled-tonal-icon-button>';
    }

    /**
     * Generate an outlined icon button
     *
     * @param string $icon Material icon name
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-outlined-icon-button
     */
    public static function iconOutlined(string $icon, array $attributes = []): string
    {
        $content = MD3::icon($icon);
        return '<md-outlined-icon-button' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-outlined-icon-button>';
    }

    /**
     * Render button with specified tag and content
     */
    private static function renderButton(string $tag, string $text, array $attributes = []): string
    {
        $content = htmlspecialchars($text);
        return '<' . $tag . MD3::escapeAttributes($attributes) . '>' . $content . '</' . $tag . '>';
    }
}