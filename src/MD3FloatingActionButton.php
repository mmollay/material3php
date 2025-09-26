<?php

/**
 * Material Design 3 Floating Action Button Component
 *
 * Implementiert alle FAB-Varianten gemäß MD3 Spezifikation:
 * - Small FAB
 * - Standard FAB
 * - Large FAB
 * - Extended FAB
 *
 * @package MD3FloatingActionButton
 * @version 0.1.0
 * @since 0.2.3
 */
class MD3FloatingActionButton
{
    /**
     * Generate a standard FAB
     *
     * @param string $icon Material icon name
     * @param array $options Configuration options
     * @return string Complete HTML for standard FAB
     */
    public static function standard(string $icon = 'add', array $options = []): string
    {
        return self::create($icon, null, array_merge($options, ['size' => 'standard']));
    }

    /**
     * Generate a small FAB
     *
     * @param string $icon Material icon name
     * @param array $options Configuration options
     * @return string Complete HTML for small FAB
     */
    public static function small(string $icon = 'add', array $options = []): string
    {
        return self::create($icon, null, array_merge($options, ['size' => 'small']));
    }

    /**
     * Generate a large FAB
     *
     * @param string $icon Material icon name
     * @param array $options Configuration options
     * @return string Complete HTML for large FAB
     */
    public static function large(string $icon = 'add', array $options = []): string
    {
        return self::create($icon, null, array_merge($options, ['size' => 'large']));
    }

    /**
     * Generate an extended FAB
     *
     * @param string $icon Material icon name
     * @param string $text FAB label text
     * @param array $options Configuration options
     * @return string Complete HTML for extended FAB
     */
    public static function extended(string $icon = 'add', string $text = 'Create', array $options = []): string
    {
        return self::create($icon, $text, array_merge($options, ['extended' => true]));
    }

    /**
     * Main FAB creation method
     *
     * @param string $icon Material icon name
     * @param string|null $text Optional label text for extended FAB
     * @param array $options Configuration options
     * @return string Complete HTML for FAB
     */
    private static function create(string $icon, ?string $text, array $options = []): string
    {
        $size = $options['size'] ?? 'standard';
        $extended = $options['extended'] ?? false;
        $onclick = $options['onclick'] ?? '';
        $disabled = $options['disabled'] ?? false;
        $id = $options['id'] ?? 'md3-fab-' . uniqid();

        $classes = ['md3-fab'];

        if ($extended) {
            $classes[] = 'md3-fab--extended';
        } else {
            $classes[] = 'md3-fab--' . $size;
        }

        if ($disabled) {
            $classes[] = 'md3-fab--disabled';
        }

        $attributes = [
            'class' => implode(' ', $classes),
            'id' => $id,
            'type' => 'button',
            'role' => 'button'
        ];

        if ($onclick && !$disabled) {
            $attributes['onclick'] = $onclick;
        }

        if ($disabled) {
            $attributes['disabled'] = 'disabled';
            $attributes['aria-disabled'] = 'true';
        }

        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        $iconHtml = sprintf('<span class="material-symbols-outlined">%s</span>', htmlspecialchars($icon));

        $content = $iconHtml;
        if ($extended && $text) {
            $content .= sprintf('<span class="md3-fab__label">%s</span>', htmlspecialchars($text));
        }

        return sprintf('<button%s>%s</button>', $attributesStr, $content);
    }

    /**
     * Generate CSS for FAB components
     */
    public static function getCSS(): string
    {
        return '
        /* Material Design 3 Floating Action Button */
        .md3-fab {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
            font-family: inherit;
            font-weight: 500;
            text-decoration: none;
            outline: none;
            overflow: hidden;
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            box-shadow: var(--md-sys-elevation-3);
        }

        /* Small FAB */
        .md3-fab--small {
            width: 40px;
            height: 40px;
            border-radius: 12px;
        }

        .md3-fab--small .material-symbols-outlined {
            font-size: 24px;
        }

        /* Standard FAB */
        .md3-fab--standard {
            width: 56px;
            height: 56px;
            border-radius: 16px;
        }

        .md3-fab--standard .material-symbols-outlined {
            font-size: 24px;
        }

        /* Large FAB */
        .md3-fab--large {
            width: 96px;
            height: 96px;
            border-radius: 28px;
        }

        .md3-fab--large .material-symbols-outlined {
            font-size: 36px;
        }

        /* Extended FAB */
        .md3-fab--extended {
            height: 56px;
            padding: 0 16px;
            border-radius: 16px;
            gap: 8px;
        }

        .md3-fab--extended .material-symbols-outlined {
            font-size: 24px;
        }

        .md3-fab__label {
            font-size: 14px;
            font-weight: 500;
            line-height: 20px;
            white-space: nowrap;
        }

        /* Hover States */
        .md3-fab:hover {
            box-shadow: var(--md-sys-elevation-4);
        }

        .md3-fab:not(.md3-fab--disabled):hover {
            background: color-mix(in srgb, var(--md-sys-color-primary-container) 92%, var(--md-sys-color-on-primary-container) 8%);
        }

        /* Active State */
        .md3-fab:active {
            box-shadow: var(--md-sys-elevation-3);
        }

        /* Focus State */
        .md3-fab:focus-visible {
            outline: 2px solid var(--md-sys-color-primary);
            outline-offset: 2px;
        }

        /* Disabled State */
        .md3-fab--disabled {
            background: var(--md-sys-color-on-surface);
            background: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
            color: var(--md-sys-color-on-surface);
            color: color-mix(in srgb, var(--md-sys-color-on-surface) 38%, transparent);
            box-shadow: none;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Ripple Effect */
        .md3-fab::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--md-sys-color-on-primary-container);
            border-radius: inherit;
            opacity: 0;
            transform: scale(0);
            transition: transform 0.2s, opacity 0.2s;
        }

        .md3-fab:active::before {
            opacity: 0.12;
            transform: scale(1);
        }

        /* Positioning utilities */
        .md3-fab--fixed {
            position: fixed;
            z-index: 1000;
        }

        .md3-fab--bottom-right {
            bottom: 16px;
            right: 16px;
        }

        .md3-fab--bottom-left {
            bottom: 16px;
            left: 16px;
        }

        .md3-fab--bottom-center {
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
        }

        @media (max-width: 480px) {
            .md3-fab--bottom-right {
                bottom: 12px;
                right: 12px;
            }

            .md3-fab--bottom-left {
                bottom: 12px;
                left: 12px;
            }
        }
        ';
    }

    /**
     * Generate JavaScript for FAB interactions
     */
    public static function getScript(): string
    {
        return "
        <script>
        // FAB Ripple Effect Enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const fabs = document.querySelectorAll('.md3-fab');

            fabs.forEach(fab => {
                fab.addEventListener('mousedown', function(e) {
                    if (!this.classList.contains('md3-fab--disabled')) {
                        // Enhanced ripple effect can be added here
                        // Current CSS handles basic ripple with ::before pseudo-element
                    }
                });
            });
        });
        </script>
        ";
    }
}

?>