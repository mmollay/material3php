<?php

/**
 * Material Design 3 Card Component
 *
 * Implementiert MD3 Cards in verschiedenen Varianten
 * Surface, Filled, Elevated und Outlined Cards
 *
 * Features:
 * - Surface Card (Standard ohne Erhebung)
 * - Filled Card (mit Hintergrundfarbe)
 * - Elevated Card (mit Schatten)
 * - Outlined Card (mit Rahmen)
 * - Header, Content und Action Areas
 * - Responsive Design
 * - Click/Hover Interaktionen
 */

class MD3Card {

    /**
     * Surface Card (Standard)
     */
    public static function surface(string $content, array $options = []): string {
        $options['variant'] = 'surface';
        return self::renderCard($content, $options);
    }

    /**
     * Filled Card (mit Hintergrundfarbe)
     */
    public static function filled(string $content, array $options = []): string {
        $options['variant'] = 'filled';
        return self::renderCard($content, $options);
    }

    /**
     * Elevated Card (mit Schatten)
     */
    public static function elevated(string $content, array $options = []): string {
        $options['variant'] = 'elevated';
        return self::renderCard($content, $options);
    }

    /**
     * Outlined Card (mit Rahmen)
     */
    public static function outlined(string $content, array $options = []): string {
        $options['variant'] = 'outlined';
        return self::renderCard($content, $options);
    }

    /**
     * Card mit Header, Content und Actions
     */
    public static function withHeader(string $title, string $content, array $options = []): string {
        $subtitle = $options['subtitle'] ?? '';
        $icon = $options['icon'] ?? '';
        $actions = $options['actions'] ?? [];

        $headerHtml = self::renderHeader($title, $subtitle, $icon);
        $actionsHtml = !empty($actions) ? self::renderActions($actions) : '';

        $fullContent = $headerHtml . '<div class="md3-card__content">' . $content . '</div>' . $actionsHtml;

        return self::renderCard($fullContent, $options);
    }

    /**
     * Media Card mit Bild
     */
    public static function media(string $imageSrc, string $title, string $content, array $options = []): string {
        $imageAlt = $options['imageAlt'] ?? $title;
        $actions = $options['actions'] ?? [];

        $mediaHtml = sprintf(
            '<div class="md3-card__media"><img src="%s" alt="%s" class="md3-card__image"></div>',
            htmlspecialchars($imageSrc),
            htmlspecialchars($imageAlt)
        );

        $headerHtml = self::renderHeader($title, $options['subtitle'] ?? '', $options['icon'] ?? '');
        $actionsHtml = !empty($actions) ? self::renderActions($actions) : '';

        $fullContent = $mediaHtml . $headerHtml . '<div class="md3-card__content">' . $content . '</div>' . $actionsHtml;

        return self::renderCard($fullContent, $options);
    }

    /**
     * Render Card Structure
     */
    private static function renderCard(string $content, array $options = []): string {
        $variant = $options['variant'] ?? 'surface';
        $id = $options['id'] ?? 'md3-card-' . uniqid();
        $clickable = $options['clickable'] ?? false;
        $href = $options['href'] ?? '';
        $disabled = $options['disabled'] ?? false;

        $classes = ['md3-card', "md3-card--{$variant}"];
        if ($clickable) $classes[] = 'md3-card--clickable';
        if ($disabled) $classes[] = 'md3-card--disabled';
        if (!empty($options['class'])) $classes[] = $options['class'];

        $attributes = [
            'class' => implode(' ', $classes),
            'id' => $id
        ];

        if ($disabled) {
            $attributes['aria-disabled'] = 'true';
        }

        // Clickable card als Link oder Button
        if ($clickable && !$disabled) {
            if ($href) {
                $tag = 'a';
                $attributes['href'] = $href;
                $attributes['role'] = 'button';
            } else {
                $tag = 'button';
                $attributes['type'] = 'button';
            }
        } else {
            $tag = 'div';
        }

        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        return sprintf('<%s%s>%s</%s>', $tag, $attributesStr, $content, $tag);
    }

    /**
     * Render Card Header
     */
    private static function renderHeader(string $title, string $subtitle = '', string $icon = ''): string {
        $iconHtml = $icon ? sprintf('<span class="md3-card__header-icon"><span class="material-symbols-outlined">%s</span></span>', $icon) : '';

        $textHtml = sprintf(
            '<div class="md3-card__header-text">
                <div class="md3-card__title">%s</div>%s
            </div>',
            htmlspecialchars($title),
            $subtitle ? sprintf('<div class="md3-card__subtitle">%s</div>', htmlspecialchars($subtitle)) : ''
        );

        return sprintf(
            '<div class="md3-card__header">%s%s</div>',
            $iconHtml,
            $textHtml
        );
    }

    /**
     * Render Card Actions
     */
    private static function renderActions(array $actions): string {
        $actionsHtml = '';
        foreach ($actions as $action) {
            $text = $action['text'] ?? '';
            $href = $action['href'] ?? '#';
            $icon = $action['icon'] ?? '';
            $primary = $action['primary'] ?? false;

            $buttonClass = $primary ? 'md3-button md3-button--filled' : 'md3-button md3-button--text';
            $iconHtml = $icon ? sprintf('<span class="material-symbols-outlined">%s</span>', $icon) : '';

            $actionsHtml .= sprintf(
                '<a href="%s" class="%s">%s%s</a>',
                $href,
                $buttonClass,
                $iconHtml,
                htmlspecialchars($text)
            );
        }

        return sprintf('<div class="md3-card__actions">%s</div>', $actionsHtml);
    }

    /**
     * Get Card CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Card Component */
.md3-card {
    position: relative;
    display: flex;
    flex-direction: column;
    border-radius: 12px;
    background: var(--md-sys-color-surface);
    color: var(--md-sys-color-on-surface);
    overflow: hidden;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    text-decoration: none;
    border: none;
    text-align: left;
    font-family: inherit;
    cursor: default;
    outline: none;
}

/* Card Variants */
.md3-card--surface {
    background: var(--md-sys-color-surface);
}

.md3-card--filled {
    background: var(--md-sys-color-surface-container-highest);
}

.md3-card--elevated {
    background: var(--md-sys-color-surface-container-low);
    box-shadow: var(--md-sys-elevation-1);
}

.md3-card--outlined {
    background: var(--md-sys-color-surface);
    border: 1px solid var(--md-sys-color-outline-variant);
}

/* Clickable Cards */
.md3-card--clickable {
    cursor: pointer;
}

.md3-card--clickable:hover {
    box-shadow: var(--md-sys-elevation-2);
}

.md3-card--clickable:focus-visible {
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

.md3-card--clickable:active {
    transform: scale(0.98);
}

.md3-card--elevated.md3-card--clickable:hover {
    box-shadow: var(--md-sys-elevation-3);
}

/* Disabled Cards */
.md3-card--disabled {
    opacity: 0.38;
    pointer-events: none;
    cursor: not-allowed;
}

/* Card Header */
.md3-card__header {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 16px 16px 0;
    min-height: 72px;
}

.md3-card__header-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--md-sys-color-surface-container-highest);
    border-radius: 20px;
    color: var(--md-sys-color-primary);
    font-size: 24px;
    flex-shrink: 0;
}

.md3-card__header-text {
    flex: 1;
    padding-top: 8px;
}

.md3-card__title {
    font-size: 16px;
    font-weight: 500;
    line-height: 24px;
    color: var(--md-sys-color-on-surface);
    margin-bottom: 4px;
}

.md3-card__subtitle {
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    color: var(--md-sys-color-on-surface-variant);
}

/* Card Content */
.md3-card__content {
    padding: 16px;
    flex: 1;
    font-size: 14px;
    line-height: 20px;
    color: var(--md-sys-color-on-surface-variant);
}

.md3-card__header + .md3-card__content {
    padding-top: 8px;
}

/* Card Actions */
.md3-card__actions {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px 16px;
    margin-top: auto;
}

.md3-card__actions .md3-button {
    margin: 0;
}

/* Media Support */
.md3-card__media {
    position: relative;
    background: var(--md-sys-color-surface-container-high);
}

.md3-card__image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: var(--md-sys-color-surface-container-high);
}

.md3-card__media + .md3-card__content,
.md3-card__media + .md3-card__header {
    padding-top: 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-card {
        border-radius: 8px;
    }

    .md3-card__header {
        padding: 12px 12px 0;
        min-height: 64px;
    }

    .md3-card__content {
        padding: 12px;
    }

    .md3-card__header + .md3-card__content {
        padding-top: 8px;
    }

    .md3-card__actions {
        padding: 8px 12px 12px;
    }

    .md3-card__image {
        height: 160px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-card--elevated {
    box-shadow: var(--md-sys-elevation-1);
}

[data-theme="dark"] .md3-card--clickable:hover {
    box-shadow: var(--md-sys-elevation-2);
}

[data-theme="dark"] .md3-card--elevated.md3-card--clickable:hover {
    box-shadow: var(--md-sys-elevation-3);
}
';
    }

    /**
     * Get Card JavaScript
     */
    public static function getJS(): string {
        return '
// Card Interaction Management
document.addEventListener("DOMContentLoaded", function() {
    const clickableCards = document.querySelectorAll(".md3-card--clickable");

    clickableCards.forEach(card => {
        // Add ripple effect on click
        card.addEventListener("pointerdown", function(e) {
            if (this.classList.contains("md3-card--disabled")) {
                return;
            }

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            const ripple = document.createElement("span");
            ripple.className = "md3-ripple";
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: currentColor;
                opacity: 0.1;
                pointer-events: none;
                transform: scale(0);
                animation: md3-ripple-animation 0.6s ease-out;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                z-index: 1;
            `;

            this.style.position = "relative";
            this.style.overflow = "hidden";
            this.appendChild(ripple);

            setTimeout(() => {
                if (ripple.parentNode) {
                    ripple.parentNode.removeChild(ripple);
                }
            }, 600);
        });

        // Handle keyboard navigation
        card.addEventListener("keydown", function(e) {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                this.click();
            }
        });
    });
});

// Add ripple animation CSS if not already present
if (!document.querySelector("#md3-card-ripple-styles")) {
    const style = document.createElement("style");
    style.id = "md3-card-ripple-styles";
    style.textContent = `
        @keyframes md3-ripple-animation {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}
';
    }
}