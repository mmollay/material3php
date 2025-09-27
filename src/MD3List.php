<?php

require_once 'MD3.php';

/**
 * MD3List - Material Design 3 List Components
 * Generates functional HTML for Material Web Components lists
 */
class MD3List
{
    /**
     * Generate a simple list with navigation support
     *
     * @param array $items Array of list items ['text' => 'Item Text', 'icon' => 'optional_icon', 'href' => 'link', 'onclick' => 'function']
     * @param array $attributes Additional HTML attributes for the list
     * @return string HTML for functional list
     */
    public static function simple(array $items, array $attributes = []): string
    {
        if (empty($items)) {
            return '<ul class="md3-list"' . MD3::escapeAttributes($attributes) . '></ul>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildListItem($item);
        }

        $defaultAttrs = ['class' => 'md3-list'];
        $mergedAttrs = array_merge($defaultAttrs, $attributes);

        return '<ul' . MD3::escapeAttributes($mergedAttrs) . '>' . implode('', $listItems) . '</ul>';
    }

    /**
     * Generate a list with dividers
     *
     * @param array $items Array of list items
     * @param array $attributes Additional HTML attributes
     * @return string HTML for list with dividers
     */
    public static function withDividers(array $items, array $attributes = []): string
    {
        if (empty($items)) {
            return '<ul class="md3-list md3-list-dividers"' . MD3::escapeAttributes($attributes) . '></ul>';
        }

        $listItems = [];
        $itemCount = count($items);

        foreach ($items as $index => $item) {
            $listItems[] = self::buildListItem($item);

            // Add divider after each item except the last
            if ($index < $itemCount - 1) {
                $listItems[] = '<li class="md3-list-divider"><hr></li>';
            }
        }

        $defaultAttrs = ['class' => 'md3-list md3-list-dividers'];
        $mergedAttrs = array_merge($defaultAttrs, $attributes);

        return '<ul' . MD3::escapeAttributes($mergedAttrs) . '>' . implode('', $listItems) . '</ul>';
    }

    /**
     * Generate a list with icons
     *
     * @param array $items Array of items with 'text' and 'icon' keys
     * @param array $attributes Additional HTML attributes
     * @return string HTML for icon list
     */
    public static function withIcons(array $items, array $attributes = []): string
    {
        $defaultAttrs = ['class' => 'md3-list md3-list-icons'];
        $mergedAttrs = array_merge($defaultAttrs, $attributes);
        return self::simple($items, $mergedAttrs);
    }

    /**
     * Generate a list with avatars
     *
     * @param array $items Array of items with 'text' and 'avatar' keys
     * @param array $attributes Additional HTML attributes
     * @return string HTML for avatar list
     */
    public static function withAvatars(array $items, array $attributes = []): string
    {
        if (empty($items)) {
            return '<ul class="md3-list md3-list-avatars"' . MD3::escapeAttributes($attributes) . '></ul>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildListItem($item, 'avatar');
        }

        $defaultAttrs = ['class' => 'md3-list md3-list-avatars'];
        $mergedAttrs = array_merge($defaultAttrs, $attributes);

        return '<ul' . MD3::escapeAttributes($mergedAttrs) . '>' . implode('', $listItems) . '</ul>';
    }

    /**
     * Generate a selectable list (functional form integration)
     *
     * @param array $items Array of list items
     * @param string $name Form field name for radio/checkbox
     * @param string $type Selection type ('radio' or 'checkbox')
     * @param array $attributes Additional HTML attributes
     * @return string HTML for selectable list
     */
    public static function selectable(array $items, string $name, string $type = 'radio', array $attributes = []): string
    {
        if (empty($items)) {
            return '<ul class="md3-list md3-list-selectable"' . MD3::escapeAttributes($attributes) . '></ul>';
        }

        $listItems = [];
        foreach ($items as $index => $item) {
            $listItems[] = self::buildSelectableItem($item, $name, $type, $index);
        }

        $defaultAttrs = ['class' => 'md3-list md3-list-selectable'];
        $mergedAttrs = array_merge($defaultAttrs, $attributes);

        return '<ul' . MD3::escapeAttributes($mergedAttrs) . '>' . implode('', $listItems) . '</ul>';
    }

    /**
     * Generate a two-line list
     *
     * @param array $items Array of items with 'title', 'subtitle' keys
     * @param array $attributes Additional HTML attributes
     * @return string HTML for two-line list
     */
    public static function twoLine(array $items, array $attributes = []): string
    {
        if (empty($items)) {
            return '<ul class="md3-list md3-list-two-line"' . MD3::escapeAttributes($attributes) . '></ul>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildTwoLineItem($item);
        }

        $defaultAttrs = ['class' => 'md3-list md3-list-two-line'];
        $mergedAttrs = array_merge($defaultAttrs, $attributes);

        return '<ul' . MD3::escapeAttributes($mergedAttrs) . '>' . implode('', $listItems) . '</ul>';
    }

    /**
     * Generate a three-line list
     *
     * @param array $items Array of items with 'title', 'subtitle', 'description' keys
     * @param array $attributes Additional HTML attributes
     * @return string HTML for three-line list
     */
    public static function threeLine(array $items, array $attributes = []): string
    {
        if (empty($items)) {
            return '<ul class="md3-list md3-list-three-line"' . MD3::escapeAttributes($attributes) . '></ul>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildThreeLineItem($item);
        }

        $defaultAttrs = ['class' => 'md3-list md3-list-three-line'];
        $mergedAttrs = array_merge($defaultAttrs, $attributes);

        return '<ul' . MD3::escapeAttributes($mergedAttrs) . '>' . implode('', $listItems) . '</ul>';
    }

    /**
     * Generate a navigation list (menu-style)
     *
     * @param array $items Array of navigation items
     * @param string $activeUrl Current active URL for highlighting
     * @param array $attributes Additional HTML attributes
     * @return string HTML for navigation list
     */
    public static function navigation(array $items, string $activeUrl = '', array $attributes = []): string
    {
        if (empty($items)) {
            return '<nav class="md3-list md3-list-nav"' . MD3::escapeAttributes($attributes) . '></nav>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildNavigationItem($item, $activeUrl);
        }

        $defaultAttrs = ['class' => 'md3-list md3-list-nav', 'role' => 'navigation'];
        $mergedAttrs = array_merge($defaultAttrs, $attributes);

        return '<nav' . MD3::escapeAttributes($mergedAttrs) . '><ul>' . implode('', $listItems) . '</ul></nav>';
    }

    /**
     * Generate an action list (with buttons/actions)
     *
     * @param array $items Array of action items
     * @param array $attributes Additional HTML attributes
     * @return string HTML for action list
     */
    public static function actions(array $items, array $attributes = []): string
    {
        if (empty($items)) {
            return '<ul class="md3-list md3-list-actions"' . MD3::escapeAttributes($attributes) . '></ul>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildActionItem($item);
        }

        $defaultAttrs = ['class' => 'md3-list md3-list-actions'];
        $mergedAttrs = array_merge($defaultAttrs, $attributes);

        return '<ul' . MD3::escapeAttributes($mergedAttrs) . '>' . implode('', $listItems) . '</ul>';
    }

    /**
     * Build a single list item
     *
     * @param array $item Item data
     * @param string $type Item type ('default', 'avatar')
     * @return string HTML for list item
     */
    private static function buildListItem(array $item, string $type = 'default'): string
    {
        $text = $item['text'] ?? '';
        $icon = $item['icon'] ?? null;
        $avatar = $item['avatar'] ?? null;
        $href = $item['href'] ?? null;
        $onclick = $item['onclick'] ?? null;
        $badge = $item['badge'] ?? null;
        $meta = $item['meta'] ?? null; // timestamp, count, etc.

        $itemAttrs = ['class' => 'md3-list-item'];
        $isClickable = $href || $onclick;

        if ($isClickable) {
            $itemAttrs['class'] .= ' md3-list-item-clickable';
            if ($onclick) {
                $itemAttrs['onclick'] = $onclick;
                $itemAttrs['style'] = 'cursor: pointer;';
            }
        }

        $content = '';

        // Leading content (icon or avatar)
        if ($type === 'avatar' && $avatar) {
            $content .= '<div class="md3-list-item-start">';
            $content .= '<div class="md3-list-avatar">' . htmlspecialchars($avatar) . '</div>';
            $content .= '</div>';
        } elseif ($icon) {
            $content .= '<div class="md3-list-item-start">';
            $content .= '<span class="md3-list-icon">' . MD3::icon($icon) . '</span>';
            $content .= '</div>';
        }

        // Main content
        $content .= '<div class="md3-list-item-content">';
        $content .= '<div class="md3-list-item-text">' . htmlspecialchars($text) . '</div>';
        $content .= '</div>';

        // Trailing content (badge, meta info)
        if ($badge || $meta) {
            $content .= '<div class="md3-list-item-end">';
            if ($badge) {
                $content .= '<span class="md3-list-badge">' . htmlspecialchars($badge) . '</span>';
            }
            if ($meta) {
                $content .= '<span class="md3-list-meta">' . htmlspecialchars($meta) . '</span>';
            }
            $content .= '</div>';
        }

        $element = $href ? 'a' : 'li';
        if ($href) {
            $itemAttrs['href'] = $href;
        }

        return '<' . $element . MD3::escapeAttributes($itemAttrs) . '>' . $content . '</' . $element . '>';
    }

    /**
     * Build a selectable list item (with checkbox/radio)
     */
    private static function buildSelectableItem(array $item, string $name, string $type, int $index): string
    {
        $text = $item['text'] ?? '';
        $value = $item['value'] ?? $index;
        $checked = $item['checked'] ?? false;
        $disabled = $item['disabled'] ?? false;
        $icon = $item['icon'] ?? null;

        $inputType = $type === 'checkbox' ? 'checkbox' : 'radio';
        $inputId = 'list-item-' . $name . '-' . $value;

        $inputAttrs = [
            'type' => $inputType,
            'name' => $name,
            'value' => $value,
            'id' => $inputId
        ];

        if ($checked) {
            $inputAttrs['checked'] = true;
        }
        if ($disabled) {
            $inputAttrs['disabled'] = true;
        }

        $labelAttrs = [
            'class' => 'md3-list-item md3-list-item-selectable',
            'for' => $inputId
        ];

        $content = '<input' . MD3::escapeAttributes($inputAttrs) . '>';

        $content .= '<div class="md3-list-item-start">';
        $content .= '<div class="md3-list-selection-indicator"></div>';
        $content .= '</div>';

        if ($icon) {
            $content .= '<div class="md3-list-item-icon">';
            $content .= '<span class="md3-list-icon">' . MD3::icon($icon) . '</span>';
            $content .= '</div>';
        }

        $content .= '<div class="md3-list-item-content">';
        $content .= '<div class="md3-list-item-text">' . htmlspecialchars($text) . '</div>';
        $content .= '</div>';

        return '<li><label' . MD3::escapeAttributes($labelAttrs) . '>' . $content . '</label></li>';
    }

    /**
     * Build a two-line list item
     */
    private static function buildTwoLineItem(array $item): string
    {
        $title = $item['title'] ?? '';
        $subtitle = $item['subtitle'] ?? '';
        $icon = $item['icon'] ?? null;
        $href = $item['href'] ?? null;
        $onclick = $item['onclick'] ?? null;
        $meta = $item['meta'] ?? null;

        $itemAttrs = ['class' => 'md3-list-item md3-list-item-two-line'];
        $isClickable = $href || $onclick;

        if ($isClickable) {
            $itemAttrs['class'] .= ' md3-list-item-clickable';
            if ($onclick) {
                $itemAttrs['onclick'] = $onclick;
                $itemAttrs['style'] = 'cursor: pointer;';
            }
        }

        $content = '';

        // Leading icon
        if ($icon) {
            $content .= '<div class="md3-list-item-start">';
            $content .= '<span class="md3-list-icon">' . MD3::icon($icon) . '</span>';
            $content .= '</div>';
        }

        // Main content
        $content .= '<div class="md3-list-item-content">';
        $content .= '<div class="md3-list-item-text">' . htmlspecialchars($title) . '</div>';
        $content .= '<div class="md3-list-item-subtext">' . htmlspecialchars($subtitle) . '</div>';
        $content .= '</div>';

        // Meta info
        if ($meta) {
            $content .= '<div class="md3-list-item-end">';
            $content .= '<span class="md3-list-meta">' . htmlspecialchars($meta) . '</span>';
            $content .= '</div>';
        }

        $element = $href ? 'a' : 'li';
        if ($href) {
            $itemAttrs['href'] = $href;
        }

        return '<' . $element . MD3::escapeAttributes($itemAttrs) . '>' . $content . '</' . $element . '>';
    }

    /**
     * Build a three-line list item
     */
    private static function buildThreeLineItem(array $item): string
    {
        $title = $item['title'] ?? '';
        $subtitle = $item['subtitle'] ?? '';
        $description = $item['description'] ?? '';
        $icon = $item['icon'] ?? null;
        $href = $item['href'] ?? null;
        $onclick = $item['onclick'] ?? null;

        $itemAttrs = ['class' => 'md3-list-item md3-list-item-three-line'];
        $isClickable = $href || $onclick;

        if ($isClickable) {
            $itemAttrs['class'] .= ' md3-list-item-clickable';
            if ($onclick) {
                $itemAttrs['onclick'] = $onclick;
                $itemAttrs['style'] = 'cursor: pointer;';
            }
        }

        $content = '';

        // Leading icon
        if ($icon) {
            $content .= '<div class="md3-list-item-start">';
            $content .= '<span class="md3-list-icon">' . MD3::icon($icon) . '</span>';
            $content .= '</div>';
        }

        // Main content
        $content .= '<div class="md3-list-item-content">';
        $content .= '<div class="md3-list-item-text">' . htmlspecialchars($title) . '</div>';
        $content .= '<div class="md3-list-item-subtext">' . htmlspecialchars($subtitle) . '</div>';
        $content .= '<div class="md3-list-item-description">' . htmlspecialchars($description) . '</div>';
        $content .= '</div>';

        $element = $href ? 'a' : 'li';
        if ($href) {
            $itemAttrs['href'] = $href;
        }

        return '<' . $element . MD3::escapeAttributes($itemAttrs) . '>' . $content . '</' . $element . '>';
    }

    /**
     * Build a navigation item
     */
    private static function buildNavigationItem(array $item, string $activeUrl = ''): string
    {
        $text = $item['text'] ?? '';
        $href = $item['href'] ?? '';
        $icon = $item['icon'] ?? null;
        $badge = $item['badge'] ?? null;

        $isActive = $activeUrl && $href === $activeUrl;
        $itemAttrs = [
            'class' => 'md3-list-item md3-list-nav-item' . ($isActive ? ' md3-list-nav-active' : ''),
            'href' => $href
        ];

        $content = '';

        // Leading icon
        if ($icon) {
            $content .= '<div class="md3-list-item-start">';
            $content .= '<span class="md3-list-icon">' . MD3::icon($icon) . '</span>';
            $content .= '</div>';
        }

        // Main content
        $content .= '<div class="md3-list-item-content">';
        $content .= '<div class="md3-list-item-text">' . htmlspecialchars($text) . '</div>';
        $content .= '</div>';

        // Badge
        if ($badge) {
            $content .= '<div class="md3-list-item-end">';
            $content .= '<span class="md3-list-badge">' . htmlspecialchars($badge) . '</span>';
            $content .= '</div>';
        }

        return '<li><a' . MD3::escapeAttributes($itemAttrs) . '>' . $content . '</a></li>';
    }

    /**
     * Build an action item
     */
    private static function buildActionItem(array $item): string
    {
        $text = $item['text'] ?? '';
        $action = $item['action'] ?? '';
        $icon = $item['icon'] ?? null;
        $destructive = $item['destructive'] ?? false;

        $itemAttrs = [
            'class' => 'md3-list-item md3-list-action-item' . ($destructive ? ' md3-list-action-destructive' : ''),
            'onclick' => $action,
            'style' => 'cursor: pointer;'
        ];

        $content = '';

        // Leading icon
        if ($icon) {
            $content .= '<div class="md3-list-item-start">';
            $content .= '<span class="md3-list-icon">' . MD3::icon($icon) . '</span>';
            $content .= '</div>';
        }

        // Main content
        $content .= '<div class="md3-list-item-content">';
        $content .= '<div class="md3-list-item-text">' . htmlspecialchars($text) . '</div>';
        $content .= '</div>';

        return '<li' . MD3::escapeAttributes($itemAttrs) . '>' . $content . '</li>';
    }

    /**
     * Get List CSS
     */
    public static function getCSS(): string
    {
        return '
/* Material Design 3 List Component */
/* Base List Styles */
            .md3-list {
                list-style: none;
                margin: 0;
                padding: 0;
                background: var(--md-sys-color-surface);
                border-radius: 8px;
                border: 1px solid var(--md-sys-color-outline-variant);
            }

            .md3-list-item {
                display: flex;
                align-items: center;
                padding: 12px 16px;
                min-height: 48px;
                border-bottom: 1px solid var(--md-sys-color-outline-variant);
                transition: background-color 0.2s ease;
                text-decoration: none;
                color: var(--md-sys-color-on-surface);
            }

            .md3-list-item:last-child {
                border-bottom: none;
            }

            .md3-list-item-clickable:hover {
                background-color: var(--md-sys-color-surface-container-high);
            }

            .md3-list-item-clickable:active {
                background-color: var(--md-sys-color-surface-container-highest);
            }

            /* List Item Components */
            .md3-list-item-start {
                display: flex;
                align-items: center;
                margin-right: 16px;
                flex-shrink: 0;
            }

            .md3-list-item-content {
                flex: 1;
                min-width: 0;
            }

            .md3-list-item-end {
                display: flex;
                align-items: center;
                margin-left: 16px;
                flex-shrink: 0;
            }

            .md3-list-item-text {
                font-size: 16px;
                font-weight: 400;
                line-height: 24px;
                color: var(--md-sys-color-on-surface);
            }

            .md3-list-item-subtext {
                font-size: 14px;
                line-height: 20px;
                color: var(--md-sys-color-on-surface-variant);
                margin-top: 4px;
            }

            .md3-list-item-description {
                font-size: 12px;
                line-height: 16px;
                color: var(--md-sys-color-on-surface-variant);
                margin-top: 2px;
            }

            .md3-list-icon {
                font-size: 24px;
                color: var(--md-sys-color-on-surface-variant);
            }

            .md3-list-avatar {
                width: 40px;
                height: 40px;
                border-radius: 20px;
                background: var(--md-sys-color-primary);
                color: var(--md-sys-color-on-primary);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 500;
            }

            .md3-list-badge {
                background: var(--md-sys-color-error);
                color: var(--md-sys-color-on-error);
                border-radius: 10px;
                padding: 2px 6px;
                font-size: 12px;
                min-width: 16px;
                text-align: center;
            }

            .md3-list-meta {
                font-size: 12px;
                color: var(--md-sys-color-on-surface-variant);
            }

            /* Two-line and Three-line specific */
            .md3-list-item-two-line,
            .md3-list-item-three-line {
                min-height: 64px;
                padding: 16px;
            }

            .md3-list-item-three-line {
                min-height: 88px;
            }

            /* Selectable List */
            .md3-list-selectable .md3-list-item {
                cursor: pointer;
            }

            .md3-list-item-selectable {
                display: flex;
                align-items: center;
                width: 100%;
                text-align: left;
                background: none;
                border: none;
                cursor: pointer;
            }

            .md3-list-item-selectable input[type="radio"],
            .md3-list-item-selectable input[type="checkbox"] {
                display: none;
            }

            .md3-list-selection-indicator {
                width: 20px;
                height: 20px;
                border: 2px solid var(--md-sys-color-outline);
                border-radius: 50%;
                position: relative;
            }

            .md3-list-item-selectable input[type="checkbox"] + .md3-list-item-start .md3-list-selection-indicator {
                border-radius: 4px;
            }

            .md3-list-item-selectable input:checked + .md3-list-item-start .md3-list-selection-indicator {
                background: var(--md-sys-color-primary);
                border-color: var(--md-sys-color-primary);
            }

            .md3-list-item-selectable input:checked + .md3-list-item-start .md3-list-selection-indicator::after {
                content: "✓";
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: var(--md-sys-color-on-primary);
                font-size: 12px;
                font-weight: bold;
            }

            /* Navigation List */
            .md3-list-nav {
                border: none;
                background: transparent;
            }

            .md3-list-nav ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .md3-list-nav-item {
                color: var(--md-sys-color-on-surface);
                text-decoration: none;
            }

            .md3-list-nav-active {
                background-color: var(--md-sys-color-primary-container);
                color: var(--md-sys-color-on-primary-container);
            }

            .md3-list-nav-active .md3-list-icon {
                color: var(--md-sys-color-on-primary-container);
            }

            /* Action List */
            .md3-list-action-item:hover {
                background-color: var(--md-sys-color-surface-container-high);
            }

            .md3-list-action-destructive {
                color: var(--md-sys-color-error);
            }

            .md3-list-action-destructive .md3-list-icon {
                color: var(--md-sys-color-error);
            }

            /* Dividers */
            .md3-list-divider {
                padding: 0;
                margin: 0;
            }

            .md3-list-divider hr {
                border: none;
                height: 1px;
                background: var(--md-sys-color-outline-variant);
                margin: 0;
            }
        ';
    }

    /**
     * Get List JavaScript
     */
    public static function getJS(): string
    {
        return '
// List Interaction Management
document.addEventListener("DOMContentLoaded", function() {
                // Handle selectable list interactions
                const selectableLists = document.querySelectorAll(".md3-list-selectable");

                selectableLists.forEach(list => {
                    const items = list.querySelectorAll("input[type=radio], input[type=checkbox]");

                    items.forEach(item => {
                        item.addEventListener("change", function() {
                            // Trigger custom event for form integration
                            const changeEvent = new CustomEvent("md3-list-change", {
                                detail: {
                                    name: this.name,
                                    value: this.value,
                                    checked: this.checked,
                                    type: this.type
                                }
                            });

                            list.dispatchEvent(changeEvent);
                        });
                    });
                });

                // Handle clickable list items
                const clickableItems = document.querySelectorAll(".md3-list-item-clickable");

                clickableItems.forEach(item => {
                    item.addEventListener("click", function(e) {
                        // Add ripple effect
                        const ripple = document.createElement("div");
                        ripple.className = "md3-ripple-effect";
                        ripple.style.position = "absolute";
                        ripple.style.borderRadius = "50%";
                        ripple.style.background = "rgba(var(--md-sys-color-on-surface-rgb), 0.12)";
                        ripple.style.transform = "scale(0)";
                        ripple.style.animation = "md3-ripple 0.6s linear";
                        ripple.style.pointerEvents = "none";

                        const rect = this.getBoundingClientRect();
                        const size = Math.max(rect.width, rect.height);
                        const x = e.clientX - rect.left - size / 2;
                        const y = e.clientY - rect.top - size / 2;

                        ripple.style.width = ripple.style.height = size + "px";
                        ripple.style.left = x + "px";
                        ripple.style.top = y + "px";

                        this.style.position = "relative";
                        this.style.overflow = "hidden";
                        this.appendChild(ripple);

                        setTimeout(() => ripple.remove(), 600);
                    });
                });

                // CSS Animation for ripple effect
                if (!document.querySelector("#md3-list-animations")) {
                    const style = document.createElement("style");
                    style.id = "md3-list-animations";
                    style.textContent = `
                        @keyframes md3-ripple {
                            to {
                                transform: scale(4);
                                opacity: 0;
                            }
                        }
                    `;
                    document.head.appendChild(style);
                }
            });
';
    }
}