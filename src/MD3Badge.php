<?php

/**
 * Material Design 3 Badge Component
 *
 * Implementiert Badge-System für Notifications gemäß MD3 Spezifikation:
 * - Small Badge (Dot)
 * - Large Badge (mit Zahl/Text)
 * - Verschiedene Farben (Error, Primary, Secondary)
 * - Positionierung für Icons und Navigation
 *
 * @package MD3Badge
 * @version 0.1.0
 * @since 0.2.3
 */
class MD3Badge
{
    /**
     * Generate a small badge (dot indicator)
     *
     * @param array $options Configuration options
     * @return string Complete HTML for small badge
     */
    public static function small(array $options = []): string
    {
        return self::create(null, array_merge($options, ['size' => 'small']));
    }

    /**
     * Generate a large badge with content
     *
     * @param string|int $content Badge content (number or text)
     * @param array $options Configuration options
     * @return string Complete HTML for large badge
     */
    public static function large($content, array $options = []): string
    {
        return self::create($content, array_merge($options, ['size' => 'large']));
    }

    /**
     * Generate a badge attached to an element
     *
     * @param string $element The element to attach badge to
     * @param string|int|null $content Badge content (null for small badge)
     * @param array $options Configuration options
     * @return string HTML with element and badge
     */
    public static function attach(string $element, $content = null, array $options = []): string
    {
        $badge = self::create($content, array_merge($options, ['attached' => true]));

        return sprintf(
            '<div class="md3-badge-container">%s%s</div>',
            $element,
            $badge
        );
    }

    /**
     * Generate a standalone badge
     *
     * @param string|int|null $content Badge content (null for small badge)
     * @param array $options Configuration options
     * @return string Complete HTML for badge
     */
    public static function standalone($content = null, array $options = []): string
    {
        $size = $content === null ? 'small' : 'large';
        return self::create($content, array_merge($options, ['size' => $size]));
    }

    /**
     * Main badge creation method
     *
     * @param string|int|null $content Badge content
     * @param array $options Configuration options
     * @return string Complete HTML for badge
     */
    private static function create($content, array $options = []): string
    {
        $size = $options['size'] ?? ($content === null ? 'small' : 'large');
        $color = $options['color'] ?? 'error';
        $position = $options['position'] ?? 'top-right';
        $attached = $options['attached'] ?? false;
        $id = $options['id'] ?? 'md3-badge-' . uniqid();

        $classes = ['md3-badge'];
        $classes[] = 'md3-badge--' . $size;
        $classes[] = 'md3-badge--' . $color;

        if ($attached) {
            $classes[] = 'md3-badge--attached';
            $classes[] = 'md3-badge--' . $position;
        }

        $attributes = [
            'class' => implode(' ', $classes),
            'id' => $id
        ];

        if ($size === 'small' || empty($content)) {
            $attributes['aria-label'] = $options['aria-label'] ?? 'Notification indicator';
        }

        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        $displayContent = '';
        if ($size === 'large' && !empty($content)) {
            // Format large numbers (99+ for numbers > 99)
            if (is_numeric($content) && $content > 99) {
                $displayContent = '99+';
            } else {
                $displayContent = htmlspecialchars(substr($content, 0, 3)); // Max 3 chars
            }
        }

        return sprintf('<span%s>%s</span>', $attributesStr, $displayContent);
    }

    /**
     * Generate CSS for Badge components
     */
    public static function getCSS(): string
    {
        return '
        /* Material Design 3 Badge */
        .md3-badge-container {
            position: relative;
            display: inline-block;
        }

        .md3-badge {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: inherit;
            font-weight: 500;
            font-size: 11px;
            line-height: 16px;
            letter-spacing: 0.5px;
            text-align: center;
            border-radius: 8px;
            z-index: 1;
        }

        /* Small Badge (Dot) */
        .md3-badge--small {
            width: 6px;
            height: 6px;
            border-radius: 3px;
            min-width: unset;
        }

        /* Large Badge */
        .md3-badge--large {
            min-width: 16px;
            height: 16px;
            padding: 0 4px;
            border-radius: 8px;
        }

        /* Badge Colors */
        .md3-badge--error {
            background: var(--md-sys-color-error);
            color: var(--md-sys-color-on-error);
        }

        .md3-badge--primary {
            background: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
        }

        .md3-badge--secondary {
            background: var(--md-sys-color-secondary);
            color: var(--md-sys-color-on-secondary);
        }

        .md3-badge--surface {
            background: var(--md-sys-color-surface-variant);
            color: var(--md-sys-color-on-surface-variant);
        }

        /* Attached Badge Positioning */
        .md3-badge--attached {
            position: absolute;
        }

        .md3-badge--top-right {
            top: -3px;
            right: -3px;
        }

        .md3-badge--top-left {
            top: -3px;
            left: -3px;
        }

        .md3-badge--bottom-right {
            bottom: -3px;
            right: -3px;
        }

        .md3-badge--bottom-left {
            bottom: -3px;
            left: -3px;
        }

        /* Large Badge positioning adjustments */
        .md3-badge--large.md3-badge--top-right {
            top: -8px;
            right: -8px;
        }

        .md3-badge--large.md3-badge--top-left {
            top: -8px;
            left: -8px;
        }

        .md3-badge--large.md3-badge--bottom-right {
            bottom: -8px;
            right: -8px;
        }

        .md3-badge--large.md3-badge--bottom-left {
            bottom: -8px;
            left: -8px;
        }

        /* Badge on Navigation Items */
        .md3-navigation-bar__item .md3-badge--attached {
            top: 8px;
            right: 12px;
        }

        .md3-navigation-bar__item .md3-badge--large.md3-badge--attached {
            top: 4px;
            right: 8px;
        }

        /* Badge on Menu Items */
        .md3-menu__item .md3-badge--attached {
            position: static;
            margin-left: auto;
        }

        /* Badge on Icons */
        .md3-badge-container .material-symbols-outlined {
            display: block;
        }

        /* Accessibility */
        .md3-badge[aria-label] {
            cursor: default;
        }

        /* Animation */
        .md3-badge {
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
        }

        .md3-badge--hidden {
            opacity: 0;
            transform: scale(0);
        }

        .md3-badge--visible {
            opacity: 1;
            transform: scale(1);
        }

        /* Special cases for common UI elements */
        .md3-badge-container button,
        .md3-badge-container a {
            position: relative;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .md3-badge {
                outline: 1px solid;
            }
        }
        ';
    }

    /**
     * Generate JavaScript for Badge interactions
     */
    public static function getScript(): string
    {
        return "
        <script>
        // Badge Management System
        window.MD3Badge = {
            // Show/hide badge
            toggle: function(badgeId, show = true) {
                const badge = document.getElementById(badgeId);
                if (badge) {
                    if (show) {
                        badge.classList.remove('md3-badge--hidden');
                        badge.classList.add('md3-badge--visible');
                    } else {
                        badge.classList.add('md3-badge--hidden');
                        badge.classList.remove('md3-badge--visible');
                    }
                }
            },

            // Update badge content (for large badges)
            updateContent: function(badgeId, content) {
                const badge = document.getElementById(badgeId);
                if (badge && badge.classList.contains('md3-badge--large')) {
                    // Format numbers > 99 as '99+'
                    if (typeof content === 'number' && content > 99) {
                        badge.textContent = '99+';
                    } else {
                        badge.textContent = String(content).substring(0, 3);
                    }

                    // Show badge if content is provided, hide if empty
                    this.toggle(badgeId, content !== null && content !== undefined && content !== '');
                }
            },

            // Set badge color
            setColor: function(badgeId, color) {
                const badge = document.getElementById(badgeId);
                if (badge) {
                    // Remove existing color classes
                    badge.classList.remove('md3-badge--error', 'md3-badge--primary',
                                         'md3-badge--secondary', 'md3-badge--surface');
                    // Add new color class
                    badge.classList.add('md3-badge--' + color);
                }
            }
        };

        // Auto-initialize visible badges
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.md3-badge').forEach(badge => {
                badge.classList.add('md3-badge--visible');
            });
        });
        </script>
        ";
    }
}

?>