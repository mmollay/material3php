<?php

/**
 * Material Design 3 Menu Component
 *
 * Implementiert MD3 Menus mit verschiedenen Varianten:
 * - Dropdown Menus
 * - Context Menus
 * - Sub-Menus
 * - Menu Items mit Icons, Dividers und States
 *
 * @package MD3Menu
 * @version 0.1.0
 * @since 0.1.0
 */

class MD3Menu
{
    /**
     * Generate Dropdown Menu
     *
     * @param string $trigger Trigger element HTML (button, icon, etc.)
     * @param array $items Menu items array
     * @param array $options Additional options
     * @return string HTML
     */
    public static function dropdown(string $trigger, array $items, array $options = []): string
    {
        $id = $options['id'] ?? 'md3-menu-' . uniqid();
        $triggerId = $id . '-trigger';
        $menuId = $id . '-menu';

        $classes = ['md3-menu-container'];
        if (!empty($options['class'])) {
            $classes[] = $options['class'];
        }

        $position = $options['position'] ?? 'bottom-start'; // bottom-start, bottom-end, top-start, top-end

        // Wrap trigger with proper attributes
        $triggerHtml = preg_replace(
            '/^<(\w+)/',
            '<$1 id="' . $triggerId . '" aria-haspopup="true" aria-expanded="false" aria-controls="' . $menuId . '"',
            $trigger
        );

        $menuHtml = self::buildMenu($items, $menuId, $position);

        return sprintf(
            '<div class="%s" id="%s">%s%s</div>',
            implode(' ', $classes),
            $id,
            $triggerHtml,
            $menuHtml
        );
    }

    /**
     * Generate Context Menu (right-click menu)
     */
    public static function context(array $items, array $options = []): string
    {
        $id = $options['id'] ?? 'md3-context-menu-' . uniqid();
        $target = $options['target'] ?? '.preview-area';

        $menuHtml = self::buildMenu($items, $id, 'context', ['context' => true]);

        // Add data attributes for context menu initialization
        $menuHtml = str_replace(
            'role="menu"',
            'role="menu" data-context-target="' . htmlspecialchars($target) . '"',
            $menuHtml
        );

        return $menuHtml;
    }

    /**
     * Build menu HTML structure
     */
    private static function buildMenu(array $items, string $id, string $position = 'bottom-start', array $options = []): string
    {
        $classes = ['md3-menu'];
        $classes[] = 'md3-menu--' . str_replace('-', '--', $position);

        if (!empty($options['context'])) {
            $classes[] = 'md3-menu--context';
        }

        $menuItems = '';
        foreach ($items as $item) {
            $menuItems .= self::renderMenuItem($item);
        }

        $attributes = [
            'class' => implode(' ', $classes),
            'id' => $id,
            'role' => 'menu',
            'aria-hidden' => 'true'
        ];

        if (empty($options['context'])) {
            $attributes['tabindex'] = '-1';
        }

        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        return sprintf('<div%s>%s</div>', $attributesStr, $menuItems);
    }

    /**
     * Render individual menu item
     */
    private static function renderMenuItem(array $item): string
    {
        $type = $item['type'] ?? '';

        // Handle dividers
        if ($type === 'divider') {
            return '<hr class="md3-menu__divider" role="separator">';
        }

        // Handle sub-menu headers
        if ($type === 'header') {
            return sprintf(
                '<div class="md3-menu__header">%s</div>',
                htmlspecialchars($item['text'] ?? '')
            );
        }

        // Handle regular menu items
        $text = $item['text'] ?? '';
        $icon = $item['icon'] ?? null;
        $href = $item['href'] ?? '#';
        $onclick = $item['onclick'] ?? null;
        $disabled = $item['disabled'] ?? false;
        $destructive = $item['destructive'] ?? false;
        $selected = $item['selected'] ?? false;
        $submenu = $item['submenu'] ?? null;

        $classes = ['md3-menu__item'];
        if ($disabled) $classes[] = 'md3-menu__item--disabled';
        if ($destructive) $classes[] = 'md3-menu__item--destructive';
        if ($selected) $classes[] = 'md3-menu__item--selected';
        if ($submenu) $classes[] = 'md3-menu__item--has-submenu';

        $attributes = [
            'class' => implode(' ', $classes),
            'role' => 'menuitem',
            'tabindex' => $disabled ? '-1' : '0'
        ];

        if ($disabled) {
            $attributes['aria-disabled'] = 'true';
        }

        if ($onclick) {
            $attributes['onclick'] = $onclick;
        }

        if (!$onclick && $href !== '#') {
            $tag = 'a';
            $attributes['href'] = $href;
        } else {
            $tag = 'div';
        }

        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        // Build content
        $content = '';

        // Icon
        if ($icon) {
            $content .= sprintf(
                '<span class="md3-menu__item-icon"><span class="material-symbols-outlined">%s</span></span>',
                $icon
            );
        }

        // Text
        $content .= sprintf('<span class="md3-menu__item-text">%s</span>', htmlspecialchars($text));

        // Submenu indicator
        if ($submenu) {
            $content .= '<span class="md3-menu__item-arrow"><span class="material-symbols-outlined">arrow_right</span></span>';
        }

        // Selection indicator
        if ($selected) {
            $content .= '<span class="md3-menu__item-check"><span class="material-symbols-outlined">check</span></span>';
        }

        $itemHtml = sprintf('<%s%s>%s</%s>', $tag, $attributesStr, $content, $tag);

        // Add submenu if present
        if ($submenu) {
            $submenuId = 'submenu-' . uniqid();
            $submenuHtml = self::buildMenu($submenu, $submenuId, 'right-start');
            $itemHtml = sprintf(
                '<div class="md3-menu__item-container">%s%s</div>',
                $itemHtml,
                $submenuHtml
            );
        }

        return $itemHtml;
    }

    /**
     * Generate CSS for Menu components
     */
    public static function getCSS(): string
    {
        return '
        /* Material Design 3 Menu */
        .md3-menu-container {
            position: relative;
            display: inline-block;
        }

        .md3-menu {
            position: absolute;
            min-width: 112px;
            max-width: 280px;
            background: var(--md-sys-color-surface-container);
            border-radius: 12px;
            box-shadow:
                0px 2px 6px 2px rgba(0, 0, 0, 0.15),
                0px 1px 2px 0px rgba(0, 0, 0, 0.30);
            padding: 8px 0;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.9) translateY(-8px);
            transform-origin: top left;
            transition: all 0.25s cubic-bezier(0.2, 0, 0, 1);
            z-index: 1000;
            outline: none;
            font-family: \"Google Sans\", \"Roboto\", system-ui, sans-serif;
        }

        .md3-menu--visible {
            opacity: 1;
            visibility: visible;
            transform: scale(1) translateY(0);
        }

        .md3-menu--bottom--start {
            top: 100%;
            left: 0;
        }

        .md3-menu--bottom--end {
            top: 100%;
            right: 0;
        }

        .md3-menu--top--start {
            bottom: 100%;
            left: 0;
            transform-origin: bottom left;
        }

        .md3-menu--top--end {
            bottom: 100%;
            right: 0;
            transform-origin: bottom right;
        }

        .md3-menu--context {
            position: fixed;
            z-index: 9999;
        }

        .md3-menu__header {
            padding: 8px 16px;
            font-size: 11px;
            font-weight: 500;
            color: var(--md-sys-color-on-surface-variant);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 8px;
        }

        .md3-menu__divider {
            margin: 8px 16px;
            border: none;
            height: 1px;
            background: var(--md-sys-color-outline-variant);
            opacity: 0.6;
        }

        .md3-menu__item-container {
            position: relative;
        }

        .md3-menu__item {
            display: flex;
            align-items: center;
            min-height: 48px;
            padding: 12px 16px;
            color: var(--md-sys-color-on-surface);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
            position: relative;
            outline: none;
            border-radius: 8px;
            margin: 0 8px;
            font-weight: 400;
        }

        .md3-menu__item:hover {
            background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
            transform: scale(1.02);
        }

        .md3-menu__item:focus-visible {
            background: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
            outline: 2px solid var(--md-sys-color-primary);
            outline-offset: 2px;
        }

        .md3-menu__item:active {
            background: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
            transform: scale(0.98);
        }

        .md3-menu__item--disabled {
            color: var(--md-sys-color-on-surface);
            opacity: 0.38;
            cursor: not-allowed;
            pointer-events: none;
        }

        .md3-menu__item--destructive {
            color: var(--md-sys-color-error);
        }

        .md3-menu__item--destructive:hover {
            background: var(--md-sys-color-error);
            background: color-mix(in srgb, var(--md-sys-color-error) 8%, transparent);
        }

        .md3-menu__item--selected {
            background: var(--md-sys-color-secondary-container);
            color: var(--md-sys-color-on-secondary-container);
        }

        .md3-menu__item-icon {
            width: 24px;
            height: 24px;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .md3-menu__item-text {
            flex: 1;
            font-size: 14px;
            line-height: 20px;
            font-weight: 400;
            letter-spacing: 0.25px;
        }

        .md3-menu__item-arrow,
        .md3-menu__item-check {
            width: 24px;
            height: 24px;
            margin-left: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .md3-menu__item-check {
            color: var(--md-sys-color-primary);
        }

        /* Submenu styling */
        .md3-menu__item--has-submenu:hover + .md3-menu {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        .md3-menu__item-container .md3-menu {
            left: 100%;
            top: 0;
            transform-origin: top left;
        }

        /* Animation delays for staggered appearance */
        .md3-menu--visible .md3-menu__item:nth-child(1) {
            animation: md3-menu-item-fade-in 0.2s ease-out 0ms forwards;
        }
        .md3-menu--visible .md3-menu__item:nth-child(2) {
            animation: md3-menu-item-fade-in 0.2s ease-out 50ms forwards;
        }
        .md3-menu--visible .md3-menu__item:nth-child(3) {
            animation: md3-menu-item-fade-in 0.2s ease-out 100ms forwards;
        }
        .md3-menu--visible .md3-menu__item:nth-child(4) {
            animation: md3-menu-item-fade-in 0.2s ease-out 150ms forwards;
        }
        .md3-menu--visible .md3-menu__item:nth-child(5) {
            animation: md3-menu-item-fade-in 0.2s ease-out 200ms forwards;
        }

        @keyframes md3-menu-item-fade-in {
            from {
                opacity: 0;
                transform: translateY(-4px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive behavior */
        @media (max-width: 480px) {
            .md3-menu {
                min-width: 280px;
                max-width: calc(100vw - 32px);
            }

            .md3-menu--context {
                position: fixed;
                left: 16px !important;
                right: 16px;
                width: auto;
                max-width: none;
            }
        }

        /* Dark theme adjustments */
        @media (prefers-color-scheme: dark) {
            .md3-menu {
                box-shadow: var(--md-sys-elevation-2);
            }
        }
        ';
    }

    /**
     * Generate JavaScript for Menu interactions
     */
    public static function getScript(): string
    {
        return "
        <script>
        // Global function to initialize menus (for dynamic content)
        window.initializeMenus = function() {
            // Handle dropdown menus
            const menuContainers = document.querySelectorAll('.md3-menu-container');

            // Handle context menus
            const contextMenus = document.querySelectorAll('.md3-menu--context[data-context-target]');

            menuContainers.forEach(container => {
                const trigger = container.querySelector('[aria-haspopup=\"true\"]');
                const menu = container.querySelector('.md3-menu');

                if (trigger && menu) {
                    trigger.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        const isOpen = menu.classList.contains('md3-menu--visible');

                        // Close all other menus
                        document.querySelectorAll('.md3-menu--visible').forEach(openMenu => {
                            openMenu.classList.remove('md3-menu--visible');
                            const openTrigger = openMenu.parentNode.querySelector('[aria-haspopup=\"true\"]');
                            if (openTrigger) {
                                openTrigger.setAttribute('aria-expanded', 'false');
                            }
                        });

                        if (!isOpen) {
                            menu.classList.add('md3-menu--visible');
                            trigger.setAttribute('aria-expanded', 'true');
                            menu.focus();

                            // Position adjustment for viewport
                            const rect = menu.getBoundingClientRect();
                            const viewportWidth = window.innerWidth;
                            const viewportHeight = window.innerHeight;

                            if (rect.right > viewportWidth) {
                                menu.style.left = 'auto';
                                menu.style.right = '0';
                            }

                            if (rect.bottom > viewportHeight) {
                                menu.style.top = 'auto';
                                menu.style.bottom = '100%';
                            }
                        }
                    });

                    // Handle keyboard navigation
                    menu.addEventListener('keydown', function(e) {
                        const items = Array.from(menu.querySelectorAll('.md3-menu__item:not(.md3-menu__item--disabled)'));
                        const currentIndex = items.indexOf(document.activeElement);

                        switch (e.key) {
                            case 'ArrowDown':
                                e.preventDefault();
                                const nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
                                items[nextIndex].focus();
                                break;

                            case 'ArrowUp':
                                e.preventDefault();
                                const prevIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
                                items[prevIndex].focus();
                                break;

                            case 'Escape':
                                menu.classList.remove('md3-menu--visible');
                                trigger.setAttribute('aria-expanded', 'false');
                                trigger.focus();
                                break;

                            case 'Enter':
                            case ' ':
                                if (document.activeElement.tagName === 'A') {
                                    // Let default behavior handle links
                                } else {
                                    e.preventDefault();
                                    document.activeElement.click();
                                }
                                break;
                        }
                    });

                    // Handle menu item clicks
                    menu.addEventListener('click', function(e) {
                        const item = e.target.closest('.md3-menu__item');
                        if (item && !item.classList.contains('md3-menu__item--disabled')) {
                            // Emit custom event
                            const event = new CustomEvent('md3-menu-select', {
                                detail: {
                                    item: item,
                                    text: item.querySelector('.md3-menu__item-text')?.textContent || '',
                                    menu: menu
                                }
                            });
                            container.dispatchEvent(event);

                            // Close menu after selection (unless it's a submenu parent)
                            if (!item.classList.contains('md3-menu__item--has-submenu')) {
                                menu.classList.remove('md3-menu--visible');
                                trigger.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });
                }
            });

            // Handle context menus
            contextMenus.forEach(menu => {
                const target = menu.getAttribute('data-context-target');
                const targetElement = document.querySelector(target);

                if (targetElement) {
                    // Remove existing event listeners first
                    targetElement.removeEventListener('contextmenu', window.contextMenuHandler);

                    // Create new handler
                    window.contextMenuHandler = function(e) {
                        if (e.target.closest(target)) {
                            e.preventDefault();

                            // Close other menus
                            document.querySelectorAll('.md3-menu--visible').forEach(openMenu => {
                                openMenu.classList.remove('md3-menu--visible');
                            });

                            // Position and show context menu
                            menu.style.position = 'fixed';
                            menu.style.left = e.clientX + 'px';
                            menu.style.top = e.clientY + 'px';
                            menu.classList.add('md3-menu--visible');

                            // Adjust position if menu goes off screen
                            setTimeout(() => {
                                const rect = menu.getBoundingClientRect();
                                if (rect.right > window.innerWidth) {
                                    menu.style.left = (e.clientX - rect.width) + 'px';
                                }
                                if (rect.bottom > window.innerHeight) {
                                    menu.style.top = (e.clientY - rect.height) + 'px';
                                }
                            }, 10);
                        }
                    };

                    targetElement.addEventListener('contextmenu', window.contextMenuHandler);
                }
            });

            // Close menus when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.md3-menu-container')) {
                    document.querySelectorAll('.md3-menu--visible').forEach(menu => {
                        menu.classList.remove('md3-menu--visible');
                        const trigger = menu.parentNode.querySelector('[aria-haspopup=\"true\"]');
                        if (trigger) {
                            trigger.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });

            // Close menus on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.md3-menu--visible').forEach(menu => {
                        menu.classList.remove('md3-menu--visible');
                        const trigger = menu.parentNode.querySelector('[aria-haspopup=\"true\"]');
                        if (trigger) {
                            trigger.setAttribute('aria-expanded', 'false');
                            trigger.focus();
                        }
                    });
                }
            });
        };

        // Initialize menus on page load
        document.addEventListener('DOMContentLoaded', function() {
            window.initializeMenus();
        });
        </script>
        ";
    }
}

?>