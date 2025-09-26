<?php

require_once 'MD3.php';

/**
 * MD3Tooltip - Material Design 3 Tooltip Components
 * Generates HTML for Material Web Components tooltips
 */
class MD3Tooltip
{
    /**
     * Generate a basic tooltip
     *
     * @param string $content Tooltip content text
     * @param string $targetId ID of the element to attach tooltip to
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-tooltip
     */
    public static function basic(string $content, string $targetId, array $attributes = []): string
    {
        $attributes['for'] = $targetId;

        return '<md-tooltip' . MD3::escapeAttributes($attributes) . '>' . htmlspecialchars($content) . '</md-tooltip>';
    }

    /**
     * Generate a rich tooltip with title and description
     *
     * @param string $title Tooltip title
     * @param string $description Tooltip description
     * @param string $targetId ID of the element to attach tooltip to
     * @param array $attributes Additional HTML attributes
     * @return string HTML for rich tooltip
     */
    public static function rich(string $title, string $description, string $targetId, array $attributes = []): string
    {
        $attributes['for'] = $targetId;

        $content = '<div class="tooltip-content">';
        $content .= '<div class="tooltip-title">' . htmlspecialchars($title) . '</div>';
        $content .= '<div class="tooltip-description">' . htmlspecialchars($description) . '</div>';
        $content .= '</div>';

        return '<md-tooltip' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-tooltip>';
    }

    /**
     * Generate a tooltip with icon
     *
     * @param string $content Tooltip content text
     * @param string $icon Material icon name
     * @param string $targetId ID of the element to attach tooltip to
     * @param array $attributes Additional HTML attributes
     * @return string HTML for tooltip with icon
     */
    public static function withIcon(string $content, string $icon, string $targetId, array $attributes = []): string
    {
        $attributes['for'] = $targetId;

        $tooltipContent = '<div class="tooltip-with-icon">';
        $tooltipContent .= MD3::icon($icon);
        $tooltipContent .= '<span>' . htmlspecialchars($content) . '</span>';
        $tooltipContent .= '</div>';

        return '<md-tooltip' . MD3::escapeAttributes($attributes) . '>' . $tooltipContent . '</md-tooltip>';
    }

    /**
     * Generate a tooltip with custom positioning
     *
     * @param string $content Tooltip content text
     * @param string $targetId ID of the element to attach tooltip to
     * @param string $position Tooltip position ('top', 'bottom', 'left', 'right')
     * @param array $attributes Additional HTML attributes
     * @return string HTML for positioned tooltip
     */
    public static function positioned(string $content, string $targetId, string $position = 'top', array $attributes = []): string
    {
        $attributes['for'] = $targetId;
        $attributes['position'] = $position;

        return '<md-tooltip' . MD3::escapeAttributes($attributes) . '>' . htmlspecialchars($content) . '</md-tooltip>';
    }

    /**
     * Generate a tooltip with action buttons
     *
     * @param string $content Tooltip main content
     * @param array $actions Array of action buttons ['text' => 'Button Text', 'onclick' => 'function()']
     * @param string $targetId ID of the element to attach tooltip to
     * @param array $attributes Additional HTML attributes
     * @return string HTML for action tooltip
     */
    public static function withActions(string $content, array $actions, string $targetId, array $attributes = []): string
    {
        $attributes['for'] = $targetId;

        $tooltipContent = '<div class="tooltip-content">';
        $tooltipContent .= '<div class="tooltip-text">' . htmlspecialchars($content) . '</div>';

        if (!empty($actions)) {
            require_once 'MD3Button.php';
            $tooltipContent .= '<div class="tooltip-actions">';
            foreach ($actions as $action) {
                $actionAttrs = [];
                if (isset($action['onclick'])) {
                    $actionAttrs['onclick'] = $action['onclick'];
                }
                $tooltipContent .= MD3Button::text($action['text'] ?? 'Action', null, $actionAttrs);
            }
            $tooltipContent .= '</div>';
        }

        $tooltipContent .= '</div>';

        return '<md-tooltip' . MD3::escapeAttributes($attributes) . '>' . $tooltipContent . '</md-tooltip>';
    }

    /**
     * Generate a help tooltip (question mark icon with tooltip)
     *
     * @param string $helpText Help text content
     * @param string $id Unique ID for the help icon and tooltip
     * @param array $attributes Additional HTML attributes for the icon
     * @return string HTML for help icon with tooltip
     */
    public static function help(string $helpText, string $id, array $attributes = []): string
    {
        require_once 'MD3Button.php';

        $iconAttrs = array_merge([
            'id' => $id,
            'class' => 'help-icon',
            'title' => 'Hilfe'
        ], $attributes);

        $helpIcon = MD3Button::icon('help', $iconAttrs);
        $tooltip = self::basic($helpText, $id);

        return '<span class="help-tooltip-container">' . $helpIcon . $tooltip . '</span>';
    }

    /**
     * Generate an element with tooltip attached
     *
     * @param string $elementHtml HTML of the element to attach tooltip to
     * @param string $tooltipContent Tooltip content
     * @param string $elementId ID to assign to the element
     * @param array $tooltipAttributes Additional tooltip attributes
     * @return string HTML for element with tooltip
     */
    public static function attach(string $elementHtml, string $tooltipContent, string $elementId, array $tooltipAttributes = []): string
    {
        // Add ID to the element HTML if not present
        if (strpos($elementHtml, 'id=') === false) {
            $elementHtml = str_replace('>', ' id="' . htmlspecialchars($elementId) . '">', $elementHtml);
        }

        $tooltip = self::basic($tooltipContent, $elementId, $tooltipAttributes);

        return '<div class="tooltip-wrapper">' . $elementHtml . $tooltip . '</div>';
    }

    /**
     * Generate multiple tooltips for a group of elements
     *
     * @param array $tooltips Array of tooltip definitions ['elementId' => 'tooltip content']
     * @param array $attributes Common attributes for all tooltips
     * @return string HTML for multiple tooltips
     */
    public static function group(array $tooltips, array $attributes = []): string
    {
        if (empty($tooltips)) {
            return '';
        }

        $html = '';
        foreach ($tooltips as $elementId => $content) {
            $html .= self::basic($content, $elementId, $attributes);
        }

        return $html;
    }

    /**
     * Generate a tooltip with delay settings
     *
     * @param string $content Tooltip content
     * @param string $targetId Target element ID
     * @param int $showDelay Show delay in milliseconds
     * @param int $hideDelay Hide delay in milliseconds
     * @param array $attributes Additional HTML attributes
     * @return string HTML for delayed tooltip
     */
    public static function withDelay(string $content, string $targetId, int $showDelay = 500, int $hideDelay = 300, array $attributes = []): string
    {
        $attributes['for'] = $targetId;
        $attributes['show-delay'] = $showDelay;
        $attributes['hide-delay'] = $hideDelay;

        return '<md-tooltip' . MD3::escapeAttributes($attributes) . '>' . htmlspecialchars($content) . '</md-tooltip>';
    }

    /**
     * Generate JavaScript for tooltip functionality
     *
     * @return string JavaScript code for tooltip interactions
     */
    public static function getTooltipScript(): string
    {
        return '<script>
            // Initialize tooltips
            document.addEventListener("DOMContentLoaded", function() {
                // Add hover events for tooltip triggers
                const tooltipTriggers = document.querySelectorAll("[id]");

                tooltipTriggers.forEach(function(trigger) {
                    const tooltip = document.querySelector("md-tooltip[for=\"" + trigger.id + "\"]");
                    if (tooltip) {
                        trigger.addEventListener("mouseenter", function() {
                            tooltip.style.display = "block";
                        });

                        trigger.addEventListener("mouseleave", function() {
                            tooltip.style.display = "none";
                        });
                    }
                });
            });

            function showTooltip(tooltipId) {
                const tooltip = document.getElementById(tooltipId);
                if (tooltip) {
                    tooltip.style.display = "block";
                }
            }

            function hideTooltip(tooltipId) {
                const tooltip = document.getElementById(tooltipId);
                if (tooltip) {
                    tooltip.style.display = "none";
                }
            }
        </script>';
    }
}