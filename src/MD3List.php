<?php

require_once 'MD3.php';

/**
 * MD3List - Material Design 3 List Components
 * Generates HTML for Material Web Components lists
 */
class MD3List
{
    /**
     * Generate a simple list
     *
     * @param array $items Array of list items ['text' => 'Item Text', 'icon' => 'optional_icon']
     * @param array $attributes Additional HTML attributes for the list
     * @return string HTML for md-list
     */
    public static function simple(array $items, array $attributes = []): string
    {
        if (empty($items)) {
            return '<md-list' . MD3::escapeAttributes($attributes) . '></md-list>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildListItem($item);
        }

        return '<md-list' . MD3::escapeAttributes($attributes) . '>' . implode('', $listItems) . '</md-list>';
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
            return '<md-list' . MD3::escapeAttributes($attributes) . '></md-list>';
        }

        $listItems = [];
        $itemCount = count($items);

        foreach ($items as $index => $item) {
            $listItems[] = self::buildListItem($item);

            // Add divider after each item except the last
            if ($index < $itemCount - 1) {
                $listItems[] = '<md-divider></md-divider>';
            }
        }

        return '<md-list' . MD3::escapeAttributes($attributes) . '>' . implode('', $listItems) . '</md-list>';
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
        return self::simple($items, $attributes);
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
            return '<md-list' . MD3::escapeAttributes($attributes) . '></md-list>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildListItem($item, 'avatar');
        }

        return '<md-list' . MD3::escapeAttributes($attributes) . '>' . implode('', $listItems) . '</md-list>';
    }

    /**
     * Generate a selectable list
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
            return '<md-list' . MD3::escapeAttributes($attributes) . '></md-list>';
        }

        $listItems = [];
        foreach ($items as $index => $item) {
            $listItems[] = self::buildSelectableItem($item, $name, $type, $index);
        }

        return '<md-list' . MD3::escapeAttributes($attributes) . '>' . implode('', $listItems) . '</md-list>';
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
            return '<md-list' . MD3::escapeAttributes($attributes) . '></md-list>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildTwoLineItem($item);
        }

        return '<md-list' . MD3::escapeAttributes($attributes) . '>' . implode('', $listItems) . '</md-list>';
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
            return '<md-list' . MD3::escapeAttributes($attributes) . '></md-list>';
        }

        $listItems = [];
        foreach ($items as $item) {
            $listItems[] = self::buildThreeLineItem($item);
        }

        return '<md-list' . MD3::escapeAttributes($attributes) . '>' . implode('', $listItems) . '</md-list>';
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

        $itemAttrs = [];
        if ($href) {
            $itemAttrs['href'] = $href;
        }
        if ($onclick) {
            $itemAttrs['onclick'] = $onclick;
        }

        $content = '';

        // Leading content (icon or avatar)
        if ($type === 'avatar' && $avatar) {
            $content .= '<div slot="start"><div class="list-avatar">' . htmlspecialchars($avatar) . '</div></div>';
        } elseif ($icon) {
            $content .= '<div slot="start">' . MD3::icon($icon) . '</div>';
        }

        // Main content
        $content .= '<div slot="headline">' . htmlspecialchars($text) . '</div>';

        $tag = $href ? 'md-list-item' : 'md-list-item';
        return '<' . $tag . MD3::escapeAttributes($itemAttrs) . '>' . $content . '</' . $tag . '>';
    }

    /**
     * Build a selectable list item
     */
    private static function buildSelectableItem(array $item, string $name, string $type, int $index): string
    {
        $text = $item['text'] ?? '';
        $value = $item['value'] ?? $index;
        $checked = $item['checked'] ?? false;

        $inputType = $type === 'checkbox' ? 'checkbox' : 'radio';
        $inputAttrs = [
            'type' => $inputType,
            'name' => $name,
            'value' => $value
        ];

        if ($checked) {
            $inputAttrs['checked'] = true;
        }

        $content = '<div slot="start"><input' . MD3::escapeAttributes($inputAttrs) . '></div>';
        $content .= '<div slot="headline">' . htmlspecialchars($text) . '</div>';

        return '<md-list-item>' . $content . '</md-list-item>';
    }

    /**
     * Build a two-line list item
     */
    private static function buildTwoLineItem(array $item): string
    {
        $title = $item['title'] ?? '';
        $subtitle = $item['subtitle'] ?? '';
        $icon = $item['icon'] ?? null;

        $content = '';
        if ($icon) {
            $content .= '<div slot="start">' . MD3::icon($icon) . '</div>';
        }

        $content .= '<div slot="headline">' . htmlspecialchars($title) . '</div>';
        $content .= '<div slot="supporting-text">' . htmlspecialchars($subtitle) . '</div>';

        return '<md-list-item>' . $content . '</md-list-item>';
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

        $content = '';
        if ($icon) {
            $content .= '<div slot="start">' . MD3::icon($icon) . '</div>';
        }

        $content .= '<div slot="headline">' . htmlspecialchars($title) . '</div>';
        $content .= '<div slot="supporting-text">' . htmlspecialchars($subtitle) . '</div>';
        $content .= '<div slot="trailing-supporting-text">' . htmlspecialchars($description) . '</div>';

        return '<md-list-item>' . $content . '</md-list-item>';
    }
}