<?php

/**
 * Material Design 3 Snackbar Component
 *
 * Implementiert MD3 Snackbars mit vollständigem Styling und Interaktion
 *
 * Features:
 * - Simple Snackbars
 * - Action Snackbars
 * - Dismissible Snackbars
 * - Multi-line Snackbars
 * - Icon Snackbars
 * - Error/Warning/Success States
 * - Queue Management
 * - Auto-dismiss
 * - Swipe to dismiss
 * - Positioning (top/bottom)
 */

class MD3Snackbar {

    /**
     * Simple Snackbar
     */
    public static function simple(string $message, array $options = []): string {
        return self::renderSnackbar($message, $options);
    }

    /**
     * Snackbar mit Action
     */
    public static function withAction(string $message, string $actionText, string $actionCallback = '', array $options = []): string {
        $options['action'] = [
            'text' => $actionText,
            'callback' => $actionCallback
        ];
        return self::renderSnackbar($message, $options);
    }

    /**
     * Dismissible Snackbar
     */
    public static function dismissible(string $message, array $options = []): string {
        $options['dismissible'] = true;
        return self::renderSnackbar($message, $options);
    }

    /**
     * Error Snackbar
     */
    public static function error(string $message, array $options = []): string {
        $options['type'] = 'error';
        $options['icon'] = 'error';
        return self::renderSnackbar($message, $options);
    }

    /**
     * Warning Snackbar
     */
    public static function warning(string $message, array $options = []): string {
        $options['type'] = 'warning';
        $options['icon'] = 'warning';
        return self::renderSnackbar($message, $options);
    }

    /**
     * Success Snackbar
     */
    public static function success(string $message, array $options = []): string {
        $options['type'] = 'success';
        $options['icon'] = 'check_circle';
        return self::renderSnackbar($message, $options);
    }

    /**
     * Info Snackbar
     */
    public static function info(string $message, array $options = []): string {
        $options['type'] = 'info';
        $options['icon'] = 'info';
        return self::renderSnackbar($message, $options);
    }

    /**
     * Multi-line Snackbar
     */
    public static function multiline(string $message, array $options = []): string {
        $options['multiline'] = true;
        return self::renderSnackbar($message, $options);
    }

    /**
     * Snackbar mit Icon
     */
    public static function withIcon(string $message, string $icon, array $options = []): string {
        $options['icon'] = $icon;
        return self::renderSnackbar($message, $options);
    }

    /**
     * Create Snackbar Container
     */
    public static function container(string $position = 'bottom'): string {
        return '<div class="md3-snackbar-container md3-snackbar-container--' . $position . '" id="md3-snackbar-container"></div>';
    }

    /**
     * Render Snackbar Structure
     */
    private static function renderSnackbar(string $message, array $options = []): string {
        $id = $options['id'] ?? 'md3-snackbar-' . uniqid();
        $type = $options['type'] ?? 'default';
        $icon = $options['icon'] ?? '';
        $action = $options['action'] ?? null;
        $dismissible = $options['dismissible'] ?? false;
        $multiline = $options['multiline'] ?? false;
        $duration = $options['duration'] ?? 4000; // 4 seconds default
        $position = $options['position'] ?? 'bottom';

        $classes = ['md3-snackbar'];
        $classes[] = 'md3-snackbar--' . $type;
        if ($multiline) $classes[] = 'md3-snackbar--multiline';
        if ($dismissible) $classes[] = 'md3-snackbar--dismissible';
        if ($icon) $classes[] = 'md3-snackbar--with-icon';
        if ($action) $classes[] = 'md3-snackbar--with-action';
        if (!empty($options['class'])) $classes[] = $options['class'];

        $snackbarAttrs = [
            'class' => implode(' ', $classes),
            'id' => $id,
            'role' => 'status',
            'aria-live' => 'polite',
            'data-duration' => $duration,
            'data-position' => $position
        ];

        if ($type === 'error') {
            $snackbarAttrs['role'] = 'alert';
            $snackbarAttrs['aria-live'] = 'assertive';
        }

        $snackbarAttrsStr = '';
        foreach ($snackbarAttrs as $key => $val) {
            $snackbarAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
        }

        $html = sprintf('<div%s>', $snackbarAttrsStr);

        // Surface
        $html .= '<div class="md3-snackbar__surface">';

        // Content
        $html .= '<div class="md3-snackbar__content">';

        if ($icon) {
            $html .= '<div class="md3-snackbar__icon">';
            $html .= '<span class="material-symbols-outlined">' . htmlspecialchars($icon) . '</span>';
            $html .= '</div>';
        }

        $html .= '<div class="md3-snackbar__message">' . htmlspecialchars($message) . '</div>';

        $html .= '</div>'; // End content

        // Actions
        if ($action || $dismissible) {
            $html .= '<div class="md3-snackbar__actions">';

            if ($action) {
                $actionCallback = $action['callback'] ?? '';
                $actionAttrs = [
                    'class' => 'md3-snackbar__action',
                    'type' => 'button'
                ];

                if ($actionCallback) {
                    $actionAttrs['onclick'] = $actionCallback;
                }

                $actionAttrsStr = '';
                foreach ($actionAttrs as $key => $val) {
                    $actionAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
                }

                $html .= sprintf('<button%s>%s</button>', $actionAttrsStr, htmlspecialchars($action['text']));
            }

            if ($dismissible) {
                $html .= '<button class="md3-snackbar__dismiss" type="button" aria-label="Schließen">';
                $html .= '<span class="material-symbols-outlined">close</span>';
                $html .= '</button>';
            }

            $html .= '</div>'; // End actions
        }

        $html .= '</div>'; // End surface

        // Progress indicator
        $html .= '<div class="md3-snackbar__progress"></div>';

        $html .= '</div>'; // End snackbar

        return $html;
    }

    /**
     * Get Snackbar CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Snackbar Component */
.md3-snackbar-container {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1400;
    pointer-events: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-width: 100vw;
    padding: 0 16px;
    box-sizing: border-box;
}

.md3-snackbar-container--bottom {
    bottom: 16px;
}

.md3-snackbar-container--top {
    top: 16px;
    flex-direction: column-reverse;
}

.md3-snackbar {
    position: relative;
    min-width: 344px;
    max-width: 672px;
    margin: 0 auto;
    opacity: 0;
    transform: translateY(100%);
    pointer-events: auto;
    transition: all 0.25s cubic-bezier(0.2, 0, 0, 1);
}

.md3-snackbar-container--top .md3-snackbar {
    transform: translateY(-100%);
}

.md3-snackbar--visible {
    opacity: 1;
    transform: translateY(0);
}

.md3-snackbar--exiting {
    opacity: 0;
    transform: translateX(-100%);
}

.md3-snackbar__surface {
    background: var(--md-sys-color-inverse-surface);
    color: var(--md-sys-color-inverse-on-surface);
    border-radius: 4px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    min-height: 48px;
    box-shadow: var(--md-sys-elevation-level3);
    position: relative;
    overflow: hidden;
}

.md3-snackbar--multiline .md3-snackbar__surface {
    align-items: flex-start;
    padding: 16px;
}

/* Snackbar Types */
.md3-snackbar--error .md3-snackbar__surface {
    background: var(--md-sys-color-error);
    color: var(--md-sys-color-on-error);
}

.md3-snackbar--warning .md3-snackbar__surface {
    background: var(--md-sys-color-tertiary);
    color: var(--md-sys-color-on-tertiary);
}

.md3-snackbar--success .md3-snackbar__surface {
    background: var(--md-sys-color-tertiary);
    color: var(--md-sys-color-on-tertiary);
}

.md3-snackbar--info .md3-snackbar__surface {
    background: var(--md-sys-color-primary);
    color: var(--md-sys-color-on-primary);
}

/* Content */
.md3-snackbar__content {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 0;
}

.md3-snackbar--multiline .md3-snackbar__content {
    align-items: flex-start;
}

.md3-snackbar__icon {
    font-size: 20px;
    line-height: 1;
    flex-shrink: 0;
}

.md3-snackbar__message {
    font-size: 14px;
    font-weight: 400;
    line-height: 1.4;
    word-wrap: break-word;
    flex: 1;
}

.md3-snackbar--multiline .md3-snackbar__message {
    line-height: 1.5;
}

/* Actions */
.md3-snackbar__actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.md3-snackbar--multiline .md3-snackbar__actions {
    align-items: flex-start;
    margin-top: 4px;
}

.md3-snackbar__action {
    background: none;
    border: none;
    color: var(--md-sys-color-inverse-primary);
    font-size: 14px;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    min-height: 36px;
    transition: background-color 0.15s ease;
    white-space: nowrap;
}

.md3-snackbar__action:hover {
    background: color-mix(in srgb, var(--md-sys-color-inverse-on-surface) 8%, transparent);
}

.md3-snackbar__action:focus {
    outline: 2px solid var(--md-sys-color-inverse-primary);
    outline-offset: 1px;
}

.md3-snackbar--error .md3-snackbar__action {
    color: var(--md-sys-color-on-error);
}

.md3-snackbar--warning .md3-snackbar__action {
    color: var(--md-sys-color-on-tertiary);
}

.md3-snackbar--success .md3-snackbar__action {
    color: var(--md-sys-color-on-tertiary);
}

.md3-snackbar--info .md3-snackbar__action {
    color: var(--md-sys-color-on-primary);
}

.md3-snackbar__dismiss {
    background: none;
    border: none;
    color: inherit;
    font-size: 18px;
    padding: 6px;
    border-radius: 50%;
    cursor: pointer;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.15s ease;
}

.md3-snackbar__dismiss:hover {
    background: color-mix(in srgb, var(--md-sys-color-inverse-on-surface) 8%, transparent);
}

.md3-snackbar__dismiss:focus {
    outline: 2px solid currentColor;
    outline-offset: 1px;
}

/* Progress Indicator */
.md3-snackbar__progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 2px;
    background: color-mix(in srgb, var(--md-sys-color-inverse-on-surface) 40%, transparent);
    width: 100%;
    transform-origin: left;
    transform: scaleX(1);
    transition: transform linear;
}

.md3-snackbar--error .md3-snackbar__progress {
    background: color-mix(in srgb, var(--md-sys-color-on-error) 40%, transparent);
}

.md3-snackbar--warning .md3-snackbar__progress {
    background: color-mix(in srgb, var(--md-sys-color-on-tertiary) 40%, transparent);
}

.md3-snackbar--success .md3-snackbar__progress {
    background: color-mix(in srgb, var(--md-sys-color-on-tertiary) 40%, transparent);
}

.md3-snackbar--info .md3-snackbar__progress {
    background: color-mix(in srgb, var(--md-sys-color-on-primary) 40%, transparent);
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-snackbar-container {
        left: 0;
        right: 0;
        transform: none;
        padding: 0 8px;
    }

    .md3-snackbar {
        min-width: auto;
        max-width: none;
        width: 100%;
    }

    .md3-snackbar__surface {
        padding: 12px 16px;
    }

    .md3-snackbar--multiline .md3-snackbar__surface {
        padding: 16px;
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }

    .md3-snackbar--multiline .md3-snackbar__actions {
        align-self: flex-end;
        margin-top: 0;
    }

    .md3-snackbar__message {
        font-size: 13px;
    }

    .md3-snackbar__action {
        font-size: 13px;
        padding: 6px 10px;
        min-height: 32px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-snackbar__surface {
    background: var(--md-sys-color-inverse-surface);
    color: var(--md-sys-color-inverse-on-surface);
}

[data-theme="dark"] .md3-snackbar--error .md3-snackbar__surface {
    background: var(--md-sys-color-error);
    color: var(--md-sys-color-on-error);
}

[data-theme="dark"] .md3-snackbar--warning .md3-snackbar__surface {
    background: var(--md-sys-color-tertiary);
    color: var(--md-sys-color-on-tertiary);
}

[data-theme="dark"] .md3-snackbar--success .md3-snackbar__surface {
    background: var(--md-sys-color-tertiary);
    color: var(--md-sys-color-on-tertiary);
}

[data-theme="dark"] .md3-snackbar--info .md3-snackbar__surface {
    background: var(--md-sys-color-primary);
    color: var(--md-sys-color-on-primary);
}

[data-theme="dark"] .md3-snackbar__action {
    color: var(--md-sys-color-inverse-primary);
}

/* Animation Keyframes */
@keyframes md3-snackbar-slide-in-bottom {
    from {
        opacity: 0;
        transform: translateY(100%);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes md3-snackbar-slide-in-top {
    from {
        opacity: 0;
        transform: translateY(-100%);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes md3-snackbar-slide-out-left {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateX(-100%);
    }
}

@keyframes md3-snackbar-slide-out-right {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}
';
    }

    /**
     * Get Snackbar JavaScript
     */
    public static function getJS(): string {
        return '
// Snackbar Management
document.addEventListener("DOMContentLoaded", function() {
    let snackbarQueue = [];
    let activeSnackbar = null;
    let snackbarContainer = null;

    // Initialize snackbar container
    function initSnackbarContainer() {
        snackbarContainer = document.getElementById("md3-snackbar-container");
        if (!snackbarContainer) {
            snackbarContainer = document.createElement("div");
            snackbarContainer.id = "md3-snackbar-container";
            snackbarContainer.className = "md3-snackbar-container md3-snackbar-container--bottom";
            document.body.appendChild(snackbarContainer);
        }
    }

    initSnackbarContainer();

    // Snackbar Manager
    class SnackbarManager {
        constructor() {
            this.queue = [];
            this.current = null;
            this.timers = new Map();
        }

        show(snackbarElement) {
            if (this.current) {
                this.queue.push(snackbarElement);
                return;
            }

            this.current = snackbarElement;
            this.displaySnackbar(snackbarElement);
        }

        displaySnackbar(snackbar) {
            snackbarContainer.appendChild(snackbar);

            // Initialize snackbar
            this.initSnackbar(snackbar);

            // Show with animation
            requestAnimationFrame(() => {
                snackbar.classList.add("md3-snackbar--visible");
            });

            // Auto-dismiss
            const duration = parseInt(snackbar.dataset.duration);
            if (duration > 0) {
                const progressBar = snackbar.querySelector(".md3-snackbar__progress");
                if (progressBar) {
                    progressBar.style.transitionDuration = duration + "ms";
                    progressBar.style.transform = "scaleX(0)";
                }

                const timer = setTimeout(() => {
                    this.dismiss(snackbar);
                }, duration);

                this.timers.set(snackbar, timer);
            }
        }

        initSnackbar(snackbar) {
            // Dismiss button
            const dismissBtn = snackbar.querySelector(".md3-snackbar__dismiss");
            if (dismissBtn) {
                dismissBtn.addEventListener("click", () => {
                    this.dismiss(snackbar);
                });
            }

            // Action button
            const actionBtn = snackbar.querySelector(".md3-snackbar__action");
            if (actionBtn) {
                actionBtn.addEventListener("click", () => {
                    this.dismiss(snackbar);
                });
            }

            // Swipe to dismiss (mobile)
            this.addSwipeSupport(snackbar);

            // Keyboard support
            snackbar.addEventListener("keydown", (e) => {
                if (e.key === "Escape") {
                    this.dismiss(snackbar);
                }
            });
        }

        dismiss(snackbar) {
            if (snackbar !== this.current) return;

            // Clear timer
            const timer = this.timers.get(snackbar);
            if (timer) {
                clearTimeout(timer);
                this.timers.delete(snackbar);
            }

            // Hide with animation
            snackbar.classList.remove("md3-snackbar--visible");
            snackbar.classList.add("md3-snackbar--exiting");

            // Remove from DOM after animation
            setTimeout(() => {
                if (snackbar.parentNode) {
                    snackbar.parentNode.removeChild(snackbar);
                }

                this.current = null;

                // Show next in queue
                if (this.queue.length > 0) {
                    const next = this.queue.shift();
                    this.show(next);
                }

                // Dispatch dismiss event
                const event = new CustomEvent("md3-snackbar-dismiss", {
                    detail: { snackbar }
                });
                document.dispatchEvent(event);
            }, 250);

            // Dispatch hide event
            const event = new CustomEvent("md3-snackbar-hide", {
                detail: { snackbar }
            });
            document.dispatchEvent(event);
        }

        addSwipeSupport(snackbar) {
            let startX = 0;
            let startY = 0;
            let currentX = 0;
            let currentY = 0;
            let isDragging = false;

            snackbar.addEventListener("touchstart", (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                currentX = startX;
                currentY = startY;
                isDragging = false;
            }, { passive: true });

            snackbar.addEventListener("touchmove", (e) => {
                if (!isDragging) {
                    currentX = e.touches[0].clientX;
                    currentY = e.touches[0].clientY;

                    const diffX = Math.abs(currentX - startX);
                    const diffY = Math.abs(currentY - startY);

                    if (diffX > diffY && diffX > 10) {
                        isDragging = true;
                        e.preventDefault();
                    }
                }

                if (isDragging) {
                    const translateX = currentX - startX;
                    snackbar.style.transform = `translateX(${translateX}px)`;
                    snackbar.style.opacity = Math.max(0.3, 1 - Math.abs(translateX) / 200);
                }
            }, { passive: false });

            snackbar.addEventListener("touchend", (e) => {
                if (isDragging) {
                    const diffX = currentX - startX;

                    if (Math.abs(diffX) > 100) {
                        // Swipe threshold reached - dismiss
                        snackbar.style.transform = `translateX(${diffX > 0 ? 100 : -100}%)`;
                        snackbar.style.opacity = "0";
                        this.dismiss(snackbar);
                    } else {
                        // Return to original position
                        snackbar.style.transform = "";
                        snackbar.style.opacity = "";
                    }
                }

                isDragging = false;
            }, { passive: true });
        }

        dismissAll() {
            // Clear queue
            this.queue = [];

            // Dismiss current
            if (this.current) {
                this.dismiss(this.current);
            }
        }
    }

    window.snackbarManager = new SnackbarManager();

    // Public API functions
    window.showSnackbar = function(message, options = {}) {
        const snackbar = createSnackbarElement(message, options);
        window.snackbarManager.show(snackbar);
        return snackbar;
    };

    window.showSnackbarWithAction = function(message, actionText, actionCallback, options = {}) {
        options.action = {
            text: actionText,
            callback: actionCallback
        };
        return window.showSnackbar(message, options);
    };

    window.showErrorSnackbar = function(message, options = {}) {
        options.type = "error";
        options.icon = "error";
        return window.showSnackbar(message, options);
    };

    window.showSuccessSnackbar = function(message, options = {}) {
        options.type = "success";
        options.icon = "check_circle";
        return window.showSnackbar(message, options);
    };

    window.showWarningSnackbar = function(message, options = {}) {
        options.type = "warning";
        options.icon = "warning";
        return window.showSnackbar(message, options);
    };

    window.showInfoSnackbar = function(message, options = {}) {
        options.type = "info";
        options.icon = "info";
        return window.showSnackbar(message, options);
    };

    window.dismissAllSnackbars = function() {
        window.snackbarManager.dismissAll();
    };

    function createSnackbarElement(message, options = {}) {
        const id = options.id || "md3-snackbar-" + Date.now();
        const type = options.type || "default";
        const icon = options.icon || "";
        const action = options.action || null;
        const dismissible = options.dismissible || false;
        const multiline = options.multiline || false;
        const duration = options.duration || 4000;

        const snackbar = document.createElement("div");
        snackbar.id = id;
        snackbar.className = `md3-snackbar md3-snackbar--${type}`;
        snackbar.setAttribute("role", type === "error" ? "alert" : "status");
        snackbar.setAttribute("aria-live", type === "error" ? "assertive" : "polite");
        snackbar.dataset.duration = duration;

        if (multiline) snackbar.classList.add("md3-snackbar--multiline");
        if (dismissible) snackbar.classList.add("md3-snackbar--dismissible");
        if (icon) snackbar.classList.add("md3-snackbar--with-icon");
        if (action) snackbar.classList.add("md3-snackbar--with-action");

        let html = `<div class="md3-snackbar__surface">`;
        html += `<div class="md3-snackbar__content">`;

        if (icon) {
            html += `<div class="md3-snackbar__icon">`;
            html += `<span class="material-symbols-outlined">${icon}</span>`;
            html += `</div>`;
        }

        html += `<div class="md3-snackbar__message">${message}</div>`;
        html += `</div>`;

        if (action || dismissible) {
            html += `<div class="md3-snackbar__actions">`;

            if (action) {
                html += `<button class="md3-snackbar__action" type="button"${action.callback ? ` onclick="${action.callback}"` : ""}>${action.text}</button>`;
            }

            if (dismissible) {
                html += `<button class="md3-snackbar__dismiss" type="button" aria-label="Schließen">`;
                html += `<span class="material-symbols-outlined">close</span>`;
                html += `</button>`;
            }

            html += `</div>`;
        }

        html += `</div>`;
        html += `<div class="md3-snackbar__progress"></div>`;

        snackbar.innerHTML = html;
        return snackbar;
    }

    // Handle page visibility changes
    document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            // Pause all timers when page is hidden
            window.snackbarManager.timers.forEach((timer, snackbar) => {
                clearTimeout(timer);
                window.snackbarManager.timers.delete(snackbar);

                // Stop progress animation
                const progressBar = snackbar.querySelector(".md3-snackbar__progress");
                if (progressBar) {
                    progressBar.style.animationPlayState = "paused";
                }
            });
        } else {
            // Resume timers when page becomes visible
            window.snackbarManager.timers.forEach((timer, snackbar) => {
                const progressBar = snackbar.querySelector(".md3-snackbar__progress");
                if (progressBar) {
                    progressBar.style.animationPlayState = "running";
                }
            });
        }
    });
});
';
    }
}