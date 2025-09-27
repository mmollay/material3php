<?php

require_once 'MD3.php';

/**
 * MD3Breadcrumb - Material Design 3 Breadcrumb Navigation
 * Generates HTML for breadcrumb navigation using Material Web Components
 */
class MD3Breadcrumb
{
    /**
     * Generate breadcrumb navigation from array of items
     *
     * @param array $items Array of breadcrumb items [['label' => 'Home', 'href' => '/'], ...]
     * @param array $attributes Additional HTML attributes for container
     * @return string HTML for breadcrumb navigation
     */
    public static function fromArray(array $items, array $attributes = []): string
    {
        if (empty($items)) {
            return '';
        }

        $containerAttrs = array_merge([
            'style' => 'display: flex; align-items: center; gap: 8px; padding: 8px 0;'
        ], $attributes);

        $html = '<nav' . MD3::escapeAttributes($containerAttrs) . ' aria-label="Breadcrumb">';

        $totalItems = count($items);
        foreach ($items as $index => $item) {
            $isLast = ($index === $totalItems - 1);

            if ($isLast) {
                $html .= '<span style="color: var(--md-sys-color-on-surface-variant);">' . htmlspecialchars($item['label']) . '</span>';
            } else {
                if (isset($item['href'])) {
                    $html .= '<md-text-button href="' . htmlspecialchars($item['href']) . '">' . htmlspecialchars($item['label']) . '</md-text-button>';
                } else {
                    $html .= '<span style="color: var(--md-sys-color-primary);">' . htmlspecialchars($item['label']) . '</span>';
                }
                $html .= MD3::icon('chevron_right', [
                    'style' => 'color: var(--md-sys-color-on-surface-variant); font-size: 16px;'
                ]);
            }
        }

        $html .= '</nav>';
        return $html;
    }

    /**
     * Generate breadcrumb from current route/path
     *
     * @param string $currentPath Current URL path (e.g., "/dashboard/users/edit")
     * @param string $baseUrl Base URL for links (default: "")
     * @param array $pathLabels Custom labels for path segments (e.g., ['dashboard' => 'Dashboard'])
     * @param array $attributes Additional HTML attributes for container
     * @return string HTML for breadcrumb navigation
     */
    public static function fromCurrentRoute(string $currentPath, string $baseUrl = '', array $pathLabels = [], array $attributes = []): string
    {
        $path = trim($currentPath, '/');
        if (empty($path)) {
            return self::fromArray([['label' => 'Home', 'href' => $baseUrl ?: '/']], $attributes);
        }

        $segments = explode('/', $path);
        $items = [['label' => 'Home', 'href' => $baseUrl ?: '/']];

        $currentPath = $baseUrl;
        foreach ($segments as $index => $segment) {
            $currentPath .= '/' . $segment;
            $label = isset($pathLabels[$segment]) ? $pathLabels[$segment] : ucfirst(str_replace(['-', '_'], ' ', $segment));

            $items[] = [
                'label' => $label,
                'href' => $currentPath
            ];
        }

        return self::fromArray($items, $attributes);
    }

    /**
     * Generate breadcrumb with custom separator
     *
     * @param array $items Array of breadcrumb items
     * @param string $separator Material icon name for separator (default: 'chevron_right')
     * @param array $attributes Additional HTML attributes for container
     * @return string HTML for breadcrumb navigation
     */
    public static function withSeparator(array $items, string $separator = 'chevron_right', array $attributes = []): string
    {
        if (empty($items)) {
            return '';
        }

        $containerAttrs = array_merge([
            'style' => 'display: flex; align-items: center; gap: 8px; padding: 8px 0;'
        ], $attributes);

        $html = '<nav' . MD3::escapeAttributes($containerAttrs) . ' aria-label="Breadcrumb">';

        $totalItems = count($items);
        foreach ($items as $index => $item) {
            $isLast = ($index === $totalItems - 1);

            if ($isLast) {
                $html .= '<span style="color: var(--md-sys-color-on-surface-variant);">' . htmlspecialchars($item['label']) . '</span>';
            } else {
                if (isset($item['href'])) {
                    $html .= '<md-text-button href="' . htmlspecialchars($item['href']) . '">' . htmlspecialchars($item['label']) . '</md-text-button>';
                } else {
                    $html .= '<span style="color: var(--md-sys-color-primary);">' . htmlspecialchars($item['label']) . '</span>';
                }
                $html .= MD3::icon($separator, [
                    'style' => 'color: var(--md-sys-color-on-surface-variant); font-size: 16px;'
                ]);
            }
        }

        $html .= '</nav>';
        return $html;
    }

    /**
     * Generate breadcrumb with icons
     *
     * @param array $items Array of breadcrumb items with optional 'icon' key
     * @param array $attributes Additional HTML attributes for container
     * @return string HTML for breadcrumb navigation with icons
     */
    public static function withIcons(array $items, array $attributes = []): string
    {
        if (empty($items)) {
            return '';
        }

        $containerAttrs = array_merge([
            'style' => 'display: flex; align-items: center; gap: 8px; padding: 8px 0;'
        ], $attributes);

        $html = '<nav' . MD3::escapeAttributes($containerAttrs) . ' aria-label="Breadcrumb">';

        $totalItems = count($items);
        foreach ($items as $index => $item) {
            $isLast = ($index === $totalItems - 1);

            $content = '';
            if (isset($item['icon'])) {
                $content .= MD3::icon($item['icon'], ['style' => 'font-size: 16px; margin-right: 4px;']);
            }
            $content .= htmlspecialchars($item['label']);

            if ($isLast) {
                $html .= '<span style="color: var(--md-sys-color-on-surface-variant); display: flex; align-items: center;">' . $content . '</span>';
            } else {
                if (isset($item['href'])) {
                    $html .= '<md-text-button href="' . htmlspecialchars($item['href']) . '" style="display: flex; align-items: center;">' . $content . '</md-text-button>';
                } else {
                    $html .= '<span style="color: var(--md-sys-color-primary); display: flex; align-items: center;">' . $content . '</span>';
                }
                $html .= MD3::icon('chevron_right', [
                    'style' => 'color: var(--md-sys-color-on-surface-variant); font-size: 16px;'
                ]);
            }
        }

        $html .= '</nav>';
        return $html;
    }

    /**
     * Generate simple breadcrumb with just text separators
     *
     * @param array $items Array of breadcrumb items
     * @param string $separator Text separator (default: '/')
     * @param array $attributes Additional HTML attributes for container
     * @return string HTML for simple breadcrumb navigation
     */
    public static function simple(array $items, string $separator = '/', array $attributes = []): string
    {
        if (empty($items)) {
            return '';
        }

        $containerAttrs = array_merge([
            'style' => 'padding: 8px 0; font-size: 0.875rem;'
        ], $attributes);

        $html = '<nav' . MD3::escapeAttributes($containerAttrs) . ' aria-label="Breadcrumb">';

        $totalItems = count($items);
        foreach ($items as $index => $item) {
            $isLast = ($index === $totalItems - 1);

            if ($isLast) {
                $html .= '<span style="color: var(--md-sys-color-on-surface-variant);">' . htmlspecialchars($item['label']) . '</span>';
            } else {
                if (isset($item['href'])) {
                    $html .= '<a href="' . htmlspecialchars($item['href']) . '" style="color: var(--md-sys-color-primary); text-decoration: none;">' . htmlspecialchars($item['label']) . '</a>';
                } else {
                    $html .= '<span style="color: var(--md-sys-color-primary);">' . htmlspecialchars($item['label']) . '</span>';
                }
                $html .= ' <span style="color: var(--md-sys-color-on-surface-variant); margin: 0 4px;">' . htmlspecialchars($separator) . '</span> ';
            }
        }

        $html .= '</nav>';
        return $html;
    }

    /**
     * Get CSS for Material Design 3 Breadcrumb Navigation
     */
    public static function getCSS(): string
    {
        return '
/* MD3 Breadcrumb Navigation CSS */
nav[aria-label="Breadcrumb"] {
    color: var(--md-sys-color-on-surface);
    font-family: var(--md-sys-typescale-body-medium-font-family-name);
    font-size: var(--md-sys-typescale-body-medium-font-size);
    font-weight: var(--md-sys-typescale-body-medium-font-weight);
    line-height: var(--md-sys-typescale-body-medium-line-height);
}

nav[aria-label="Breadcrumb"] md-text-button {
    --md-text-button-label-text-color: var(--md-sys-color-primary);
    min-height: auto;
    padding: 4px 8px;
}

nav[aria-label="Breadcrumb"] md-text-button:hover {
    --md-text-button-hover-label-text-color: var(--md-sys-color-primary);
    --md-text-button-hover-state-layer-color: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
}

nav[aria-label="Breadcrumb"] a {
    transition: color 0.2s ease;
    border-radius: 4px;
    padding: 2px 4px;
}

nav[aria-label="Breadcrumb"] a:hover {
    color: var(--md-sys-color-primary) !important;
    background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
}

/* Responsive breadcrumb */
@media (max-width: 768px) {
    nav[aria-label="Breadcrumb"] {
        font-size: 0.75rem;
    }

    nav[aria-label="Breadcrumb"] md-text-button {
        padding: 2px 4px;
        font-size: 0.75rem;
    }
}

/* Dark Theme Support */
[data-theme="dark"] nav[aria-label="Breadcrumb"] md-text-button {
    --md-text-button-label-text-color: var(--md-sys-color-primary);
}

[data-theme="dark"] nav[aria-label="Breadcrumb"] a {
    color: var(--md-sys-color-primary);
}
';
    }
}