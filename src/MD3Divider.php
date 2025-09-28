<?php

/**
 * Material Design 3 Divider Component
 *
 * Simple divider component for separating content sections
 * Supports horizontal and vertical dividers with different styles
 *
 * @package MD3Divider
 * @version 0.1.0
 * @since 0.2.40
 */

class MD3Divider
{
    /**
     * Generate a horizontal divider
     *
     * @param array $options Configuration options
     * @return string HTML for horizontal divider
     */
    public static function horizontal(array $options = []): string
    {
        $id = $options['id'] ?? 'md3-divider-' . uniqid();
        $classes = ['md3-divider', 'md3-divider--horizontal'];

        if (!empty($options['class'])) {
            $classes[] = $options['class'];
        }

        if (!empty($options['inset'])) {
            $classes[] = 'md3-divider--inset';
        }

        return sprintf(
            '<hr class="%s" id="%s" role="separator">',
            implode(' ', $classes),
            $id
        );
    }

    /**
     * Generate a vertical divider
     *
     * @param array $options Configuration options
     * @return string HTML for vertical divider
     */
    public static function vertical(array $options = []): string
    {
        $id = $options['id'] ?? 'md3-divider-' . uniqid();
        $classes = ['md3-divider', 'md3-divider--vertical'];

        if (!empty($options['class'])) {
            $classes[] = $options['class'];
        }

        $height = $options['height'] ?? '24px';

        return sprintf(
            '<div class="%s" id="%s" style="height: %s" role="separator" aria-orientation="vertical"></div>',
            implode(' ', $classes),
            $id,
            htmlspecialchars($height)
        );
    }

    /**
     * Generate CSS for divider components
     *
     * @return string CSS
     */
    public static function getCSS(): string
    {
        return '
        .md3-divider {
            border: none;
            background-color: var(--md-sys-color-outline-variant);
            margin: 0;
        }

        .md3-divider--horizontal {
            width: 100%;
            height: 1px;
            margin: 16px 0;
        }

        .md3-divider--vertical {
            width: 1px;
            display: inline-block;
            vertical-align: middle;
            margin: 0 8px;
        }

        .md3-divider--inset {
            margin-left: 16px;
            margin-right: 16px;
        }

        /* Dark theme support */
        @media (prefers-color-scheme: dark) {
            .md3-divider {
                background-color: var(--md-sys-color-outline-variant, rgba(255, 255, 255, 0.12));
            }
        }
        ';
    }
}