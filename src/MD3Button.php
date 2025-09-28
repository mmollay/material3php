<?php


/**
 * MD3Button - Material Design 3 Button Components
 * Generates HTML for CSS-based Material Design 3 buttons
 */
class MD3Button
{
    /**
     * Generate a filled button (primary action)
     */
    public static function filled(string $text, ?string $href = null, array $attributes = []): string
    {
        $icon = $attributes['data-icon'] ?? '';
        $onclick = $attributes['onclick'] ?? '';
        $content = '';

        if ($icon) {
            $content .= '<span class="material-symbols-outlined">' . htmlspecialchars($icon) . '</span>';
        }
        $content .= htmlspecialchars($text);

        if ($href) {
            $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
            return '<a href="' . htmlspecialchars($href) . '"' . $clickHandler . ' style="text-decoration: none;"><md-filled-button>' . $content . '</md-filled-button></a>';
        }

        $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
        return '<md-filled-button' . $clickHandler . '>' . $content . '</md-filled-button>';
    }

    /**
     * Generate an outlined button (secondary action)
     */
    public static function outlined(string $text, ?string $href = null, array $attributes = []): string
    {
        $icon = $attributes['data-icon'] ?? '';
        $onclick = $attributes['onclick'] ?? '';
        $content = '';

        if ($icon) {
            $content .= '<span class="material-symbols-outlined">' . htmlspecialchars($icon) . '</span>';
        }
        $content .= htmlspecialchars($text);

        if ($href) {
            $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
            return '<a href="' . htmlspecialchars($href) . '"' . $clickHandler . ' style="text-decoration: none;"><md-outlined-button>' . $content . '</md-outlined-button></a>';
        }

        $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
        return '<md-outlined-button' . $clickHandler . '>' . $content . '</md-outlined-button>';
    }

    /**
     * Generate a text button (tertiary action)
     */
    public static function text(string $text, ?string $href = null, array $attributes = []): string
    {
        $icon = $attributes['data-icon'] ?? '';
        $onclick = $attributes['onclick'] ?? '';
        $content = '';

        if ($icon) {
            $content .= '<span class="material-symbols-outlined">' . htmlspecialchars($icon) . '</span>';
        }
        $content .= htmlspecialchars($text);

        if ($href) {
            $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
            return '<a href="' . htmlspecialchars($href) . '"' . $clickHandler . ' style="text-decoration: none;"><md-text-button>' . $content . '</md-text-button></a>';
        }

        $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
        return '<md-text-button' . $clickHandler . '>' . $content . '</md-text-button>';
    }

    /**
     * Generate an elevated button
     */
    public static function elevated(string $text, ?string $href = null, array $attributes = []): string
    {
        $icon = $attributes['data-icon'] ?? '';
        $onclick = $attributes['onclick'] ?? '';
        $content = '';

        if ($icon) {
            $content .= '<span class="material-symbols-outlined">' . htmlspecialchars($icon) . '</span>';
        }
        $content .= htmlspecialchars($text);

        if ($href) {
            $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
            return '<a href="' . htmlspecialchars($href) . '"' . $clickHandler . ' style="text-decoration: none;"><md-elevated-button>' . $content . '</md-elevated-button></a>';
        }

        $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
        return '<md-elevated-button' . $clickHandler . '>' . $content . '</md-elevated-button>';
    }

    /**
     * Generate a tonal button
     */
    public static function tonal(string $text, ?string $href = null, array $attributes = []): string
    {
        $icon = $attributes['data-icon'] ?? '';
        $onclick = $attributes['onclick'] ?? '';
        $content = '';

        if ($icon) {
            $content .= '<span class="material-symbols-outlined">' . htmlspecialchars($icon) . '</span>';
        }
        $content .= htmlspecialchars($text);

        if ($href) {
            $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
            return '<a href="' . htmlspecialchars($href) . '"' . $clickHandler . ' style="text-decoration: none;"><md-tonal-button>' . $content . '</md-tonal-button></a>';
        }

        $clickHandler = $onclick ? ' onclick="' . htmlspecialchars($onclick) . '"' : '';
        return '<md-tonal-button' . $clickHandler . '>' . $content . '</md-tonal-button>';
    }

    /**
     * Render button with specified classes and content
     */
    private static function renderButton(string $text, ?string $href, array $attributes, array $classes): string
    {
        // Add icon support
        $icon = $attributes['data-icon'] ?? '';
        unset($attributes['data-icon']);

        // Merge additional classes
        if (isset($attributes['class'])) {
            $classes[] = $attributes['class'];
            unset($attributes['class']);
        }

        $classStr = implode(' ', $classes);
        $content = '';

        // Add icon if provided
        if ($icon) {
            $content .= '<span class="material-symbols-outlined md3-button__icon">' . htmlspecialchars($icon) . '</span>';
        }

        // Add text
        $content .= '<span class="md3-button__label">' . htmlspecialchars($text) . '</span>';

        // Choose tag based on href
        if ($href) {
            $tag = 'a';
            $attributes['href'] = $href;
        } else {
            $tag = 'button';
            $attributes['type'] = $attributes['type'] ?? 'button';
        }

        // Build attributes string
        $attributesStr = ' class="' . htmlspecialchars($classStr) . '"';
        foreach ($attributes as $key => $value) {
            $attributesStr .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
        }

        return '<' . $tag . $attributesStr . '>' . $content . '</' . $tag . '>';
    }

    /**
     * Get CSS for Material Design 3 Buttons
     */
    public static function getCSS(): string
    {
        return '
/* MD3 Button Base Styles */
.md3-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 40px;
    padding: 0 24px;
    border-radius: 20px;
    font-family: inherit;
    font-size: 14px;
    font-weight: 500;
    line-height: 20px;
    letter-spacing: 0.1px;
    text-decoration: none;
    border: none;
    outline: none;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    position: relative;
    overflow: hidden;
    white-space: nowrap;
    min-width: 64px;
    box-sizing: border-box;
}

.md3-button:disabled {
    opacity: 0.38;
    cursor: not-allowed;
    pointer-events: none;
}

.md3-button__label {
    position: relative;
    z-index: 1;
}

.md3-button__icon {
    font-size: 18px;
    margin-right: 8px;
    position: relative;
    z-index: 1;
}

.md3-button__icon:only-child {
    margin-right: 0;
}

/* Filled Button */
.md3-button--filled {
    background: var(--md-sys-color-primary);
    color: var(--md-sys-color-on-primary);
}

.md3-button--filled:hover {
    background: color-mix(in srgb, var(--md-sys-color-primary) 92%, var(--md-sys-color-on-primary) 8%);
    box-shadow: var(--md-sys-elevation-1);
}

.md3-button--filled:focus-visible {
    background: color-mix(in srgb, var(--md-sys-color-primary) 88%, var(--md-sys-color-on-primary) 12%);
}

.md3-button--filled:active {
    background: color-mix(in srgb, var(--md-sys-color-primary) 88%, var(--md-sys-color-on-primary) 12%);
    box-shadow: none;
}

/* Outlined Button */
.md3-button--outlined {
    background: transparent;
    color: var(--md-sys-color-primary);
    border: 1px solid var(--md-sys-color-outline);
}

.md3-button--outlined:hover {
    background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
    border-color: var(--md-sys-color-outline);
}

.md3-button--outlined:focus-visible {
    background: color-mix(in srgb, var(--md-sys-color-primary) 12%, transparent);
    border-color: var(--md-sys-color-primary);
}

.md3-button--outlined:active {
    background: color-mix(in srgb, var(--md-sys-color-primary) 12%, transparent);
}

/* Text Button */
.md3-button--text {
    background: transparent;
    color: var(--md-sys-color-primary);
    padding: 0 12px;
}

.md3-button--text:hover {
    background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
}

.md3-button--text:focus-visible {
    background: color-mix(in srgb, var(--md-sys-color-primary) 12%, transparent);
}

.md3-button--text:active {
    background: color-mix(in srgb, var(--md-sys-color-primary) 12%, transparent);
}

/* Elevated Button */
.md3-button--elevated {
    background: var(--md-sys-color-surface-container-low);
    color: var(--md-sys-color-primary);
    box-shadow: var(--md-sys-elevation-1);
}

.md3-button--elevated:hover {
    background: color-mix(in srgb, var(--md-sys-color-surface-container-low) 92%, var(--md-sys-color-primary) 8%);
    box-shadow: var(--md-sys-elevation-2);
}

.md3-button--elevated:focus-visible {
    background: color-mix(in srgb, var(--md-sys-color-surface-container-low) 88%, var(--md-sys-color-primary) 12%);
}

.md3-button--elevated:active {
    background: color-mix(in srgb, var(--md-sys-color-surface-container-low) 88%, var(--md-sys-color-primary) 12%);
    box-shadow: var(--md-sys-elevation-1);
}

/* Tonal Button */
.md3-button--tonal {
    background: var(--md-sys-color-secondary-container);
    color: var(--md-sys-color-on-secondary-container);
}

.md3-button--tonal:hover {
    background: color-mix(in srgb, var(--md-sys-color-secondary-container) 92%, var(--md-sys-color-on-secondary-container) 8%);
    box-shadow: var(--md-sys-elevation-1);
}

.md3-button--tonal:focus-visible {
    background: color-mix(in srgb, var(--md-sys-color-secondary-container) 88%, var(--md-sys-color-on-secondary-container) 12%);
}

.md3-button--tonal:active {
    background: color-mix(in srgb, var(--md-sys-color-secondary-container) 88%, var(--md-sys-color-on-secondary-container) 12%);
    box-shadow: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-button {
        height: 36px;
        padding: 0 16px;
        font-size: 13px;
    }

    .md3-button--text {
        padding: 0 8px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-button--filled {
    background: var(--md-sys-color-primary);
    color: var(--md-sys-color-on-primary);
}

[data-theme="dark"] .md3-button--outlined {
    border-color: var(--md-sys-color-outline);
    color: var(--md-sys-color-primary);
}

[data-theme="dark"] .md3-button--elevated {
    background: var(--md-sys-color-surface-container-low);
    color: var(--md-sys-color-primary);
}
';
    }
}