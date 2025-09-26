<?php

require_once 'MD3.php';

/**
 * MD3Card - Material Design 3 Card Components
 * Generates HTML for Material Web Components cards
 */
class MD3Card
{
    /**
     * Generate a filled card
     *
     * @param string $content Card content (HTML)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-card
     */
    public static function filled(string $content, array $attributes = []): string
    {
        return '<md-filled-card' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-filled-card>';
    }

    /**
     * Generate an elevated card
     *
     * @param string $content Card content (HTML)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-elevated-card
     */
    public static function elevated(string $content, array $attributes = []): string
    {
        return '<md-elevated-card' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-elevated-card>';
    }

    /**
     * Generate an outlined card
     *
     * @param string $content Card content (HTML)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-outlined-card
     */
    public static function outlined(string $content, array $attributes = []): string
    {
        return '<md-outlined-card' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-outlined-card>';
    }

    /**
     * Generate a simple card with title and content
     *
     * @param string $title Card title
     * @param string $content Card body content
     * @param string $type Card type ('filled', 'elevated', 'outlined')
     * @param array $attributes Additional HTML attributes
     * @return string HTML for card with structured content
     */
    public static function simple(string $title, string $content, string $type = 'elevated', array $attributes = []): string
    {
        $cardContent = self::buildCardContent($title, $content);

        switch ($type) {
            case 'filled':
                return self::filled($cardContent, $attributes);
            case 'outlined':
                return self::outlined($cardContent, $attributes);
            default:
                return self::elevated($cardContent, $attributes);
        }
    }

    /**
     * Generate a card with header, content, and actions
     *
     * @param string $title Card title
     * @param string $content Card body content
     * @param array $actions Array of action buttons (HTML strings)
     * @param string $type Card type ('filled', 'elevated', 'outlined')
     * @param array $attributes Additional HTML attributes
     * @return string HTML for card with actions
     */
    public static function withActions(string $title, string $content, array $actions = [], string $type = 'elevated', array $attributes = []): string
    {
        $cardContent = self::buildCardContent($title, $content);

        if (!empty($actions)) {
            $cardContent .= '<div class="card-actions" style="padding: 8px 16px 16px; display: flex; gap: 8px;">';
            foreach ($actions as $action) {
                $cardContent .= $action;
            }
            $cardContent .= '</div>';
        }

        switch ($type) {
            case 'filled':
                return self::filled($cardContent, $attributes);
            case 'outlined':
                return self::outlined($cardContent, $attributes);
            default:
                return self::elevated($cardContent, $attributes);
        }
    }

    /**
     * Generate a media card with image
     *
     * @param string $imageSrc Image source URL
     * @param string $title Card title
     * @param string $content Card body content
     * @param string $imageAlt Image alt text
     * @param string $type Card type ('filled', 'elevated', 'outlined')
     * @param array $attributes Additional HTML attributes
     * @return string HTML for media card
     */
    public static function media(string $imageSrc, string $title, string $content, string $imageAlt = '', string $type = 'elevated', array $attributes = []): string
    {
        $cardContent = '<div class="card-media" style="width: 100%; height: 200px; overflow: hidden;">';
        $cardContent .= '<img src="' . htmlspecialchars($imageSrc) . '" alt="' . htmlspecialchars($imageAlt) . '" style="width: 100%; height: 100%; object-fit: cover;">';
        $cardContent .= '</div>';
        $cardContent .= self::buildCardContent($title, $content);

        switch ($type) {
            case 'filled':
                return self::filled($cardContent, $attributes);
            case 'outlined':
                return self::outlined($cardContent, $attributes);
            default:
                return self::elevated($cardContent, $attributes);
        }
    }

    /**
     * Generate a card with custom icon
     *
     * @param string $icon Material icon name
     * @param string $title Card title
     * @param string $content Card body content
     * @param string $type Card type ('filled', 'elevated', 'outlined')
     * @param array $attributes Additional HTML attributes
     * @return string HTML for icon card
     */
    public static function withIcon(string $icon, string $title, string $content, string $type = 'elevated', array $attributes = []): string
    {
        $cardContent = '<div class="card-header" style="padding: 16px 16px 0; display: flex; align-items: center; gap: 16px;">';
        $cardContent .= MD3::icon($icon, ['style' => 'font-size: 24px;']);
        $cardContent .= '<h3 style="margin: 0; font-size: 1.25rem; font-weight: 500;">' . htmlspecialchars($title) . '</h3>';
        $cardContent .= '</div>';
        $cardContent .= '<div class="card-content" style="padding: 8px 16px 16px;">';
        $cardContent .= '<p style="margin: 0; color: var(--md-sys-color-on-surface-variant);">' . htmlspecialchars($content) . '</p>';
        $cardContent .= '</div>';

        switch ($type) {
            case 'filled':
                return self::filled($cardContent, $attributes);
            case 'outlined':
                return self::outlined($cardContent, $attributes);
            default:
                return self::elevated($cardContent, $attributes);
        }
    }

    /**
     * Build standard card content structure
     *
     * @param string $title Card title
     * @param string $content Card content
     * @return string HTML for card content
     */
    private static function buildCardContent(string $title, string $content): string
    {
        $html = '<div class="card-content" style="padding: 16px;">';
        $html .= '<h3 style="margin: 0 0 8px 0; font-size: 1.25rem; font-weight: 500;">' . htmlspecialchars($title) . '</h3>';
        $html .= '<p style="margin: 0; color: var(--md-sys-color-on-surface-variant);">' . htmlspecialchars($content) . '</p>';
        $html .= '</div>';
        return $html;
    }
}