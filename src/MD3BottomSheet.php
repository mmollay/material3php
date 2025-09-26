<?php

require_once 'MD3.php';

/**
 * MD3BottomSheet - Material Design 3 Bottom Sheet Components
 * Generates functional HTML for Material Design 3 bottom sheets
 */
class MD3BottomSheet
{
    /**
     * Generate a standard bottom sheet
     *
     * @param string $content The content of the bottom sheet
     * @param array $options Configuration options
     * @return string HTML for bottom sheet
     */
    public static function standard(string $content, array $options = []): string
    {
        $options['variant'] = 'standard';
        return self::renderBottomSheet($content, $options);
    }

    /**
     * Generate a modal bottom sheet
     *
     * @param string $content The content of the bottom sheet
     * @param array $options Configuration options
     * @return string HTML for modal bottom sheet
     */
    public static function modal(string $content, array $options = []): string
    {
        $options['variant'] = 'modal';
        $options['modal'] = true;
        return self::renderBottomSheet($content, $options);
    }

    /**
     * Generate a bottom sheet with handle
     *
     * @param string $content The content of the bottom sheet
     * @param array $options Configuration options
     * @return string HTML for bottom sheet with handle
     */
    public static function withHandle(string $content, array $options = []): string
    {
        $options['handle'] = true;
        return self::renderBottomSheet($content, $options);
    }

    /**
     * Generate a full-screen bottom sheet
     *
     * @param string $content The content of the bottom sheet
     * @param array $options Configuration options
     * @return string HTML for full-screen bottom sheet
     */
    public static function fullScreen(string $content, array $options = []): string
    {
        $options['variant'] = 'fullscreen';
        return self::renderBottomSheet($content, $options);
    }

    /**
     * Generate a bottom sheet with header
     *
     * @param string $title The title text
     * @param string $content The content of the bottom sheet
     * @param array $options Configuration options
     * @return string HTML for bottom sheet with header
     */
    public static function withHeader(string $title, string $content, array $options = []): string
    {
        $options['title'] = $title;
        $options['header'] = true;
        return self::renderBottomSheet($content, $options);
    }

    /**
     * Generate a bottom sheet with actions
     *
     * @param string $content The content of the bottom sheet
     * @param array $actions Array of action buttons
     * @param array $options Configuration options
     * @return string HTML for bottom sheet with actions
     */
    public static function withActions(string $content, array $actions = [], array $options = []): string
    {
        $options['actions'] = $actions;
        return self::renderBottomSheet($content, $options);
    }

    /**
     * Render bottom sheet HTML
     */
    private static function renderBottomSheet(string $content, array $options = []): string
    {
        $id = $options['id'] ?? 'md3-bottom-sheet-' . uniqid();
        $variant = $options['variant'] ?? 'standard';
        $modal = $options['modal'] ?? false;
        $handle = $options['handle'] ?? false;
        $header = $options['header'] ?? false;
        $title = $options['title'] ?? '';
        $actions = $options['actions'] ?? [];
        $trigger = $options['trigger'] ?? null;
        $dismissible = $options['dismissible'] ?? true;
        $maxHeight = $options['maxHeight'] ?? '75vh';

        $classes = ['md3-bottom-sheet'];
        $classes[] = 'md3-bottom-sheet-' . $variant;

        if ($modal) {
            $classes[] = 'md3-bottom-sheet-modal';
        }

        $attributes = [
            'id' => $id,
            'class' => implode(' ', $classes),
            'data-dismissible' => $dismissible ? 'true' : 'false',
            'style' => "--md3-bottom-sheet-max-height: {$maxHeight};",
            'role' => 'dialog',
            'aria-modal' => $modal ? 'true' : 'false',
            'aria-hidden' => 'true'
        ];

        $html = '<div' . MD3::escapeAttributes($attributes) . '>';

        // Backdrop for modal sheets
        if ($modal) {
            $html .= '<div class="md3-bottom-sheet-backdrop"></div>';
        }

        // Sheet container
        $html .= '<div class="md3-bottom-sheet-container">';

        // Handle
        if ($handle) {
            $html .= '<div class="md3-bottom-sheet-handle"></div>';
        }

        // Header
        if ($header && $title) {
            $html .= '<div class="md3-bottom-sheet-header">';
            $html .= '<h2 class="md3-bottom-sheet-title">' . htmlspecialchars($title) . '</h2>';
            if ($dismissible) {
                $html .= '<button class="md3-bottom-sheet-close" aria-label="Close">';
                $html .= MD3::icon('close');
                $html .= '</button>';
            }
            $html .= '</div>';
        }

        // Content
        $html .= '<div class="md3-bottom-sheet-content">';
        $html .= $content;
        $html .= '</div>';

        // Actions
        if (!empty($actions)) {
            $html .= '<div class="md3-bottom-sheet-actions">';
            foreach ($actions as $action) {
                $html .= self::renderAction($action);
            }
            $html .= '</div>';
        }

        $html .= '</div>'; // container
        $html .= '</div>'; // sheet

        // Trigger button if specified
        if ($trigger) {
            $triggerAttrs = [
                'type' => 'button',
                'class' => 'md3-button md3-button-filled',
                'data-md3-bottom-sheet-trigger' => $id
            ];

            $html .= '<button' . MD3::escapeAttributes($triggerAttrs) . '>';
            $html .= htmlspecialchars($trigger);
            $html .= '</button>';
        }

        return $html;
    }

    /**
     * Render action button
     */
    private static function renderAction(array $action): string
    {
        $text = $action['text'] ?? '';
        $onclick = $action['onclick'] ?? '';
        $variant = $action['variant'] ?? 'text';
        $icon = $action['icon'] ?? null;
        $disabled = $action['disabled'] ?? false;

        $classes = ['md3-button'];
        $classes[] = 'md3-button-' . $variant;

        $attributes = [
            'type' => 'button',
            'class' => implode(' ', $classes)
        ];

        if ($onclick) {
            $attributes['onclick'] = $onclick;
        }

        if ($disabled) {
            $attributes['disabled'] = true;
        }

        $html = '<button' . MD3::escapeAttributes($attributes) . '>';

        if ($icon) {
            $html .= MD3::icon($icon);
        }

        $html .= htmlspecialchars($text);
        $html .= '</button>';

        return $html;
    }

    /**
     * Get Bottom Sheet CSS
     */
    public static function getCSS(): string
    {
        return '
/* Material Design 3 Bottom Sheet Component */
.md3-bottom-sheet {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    visibility: hidden;
    transition: visibility 0.3s ease;
}

.md3-bottom-sheet.md3-bottom-sheet-open {
    visibility: visible;
}

.md3-bottom-sheet-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.md3-bottom-sheet-open .md3-bottom-sheet-backdrop {
    opacity: 1;
}

.md3-bottom-sheet-container {
    background: var(--md-sys-color-surface-container-low);
    border-radius: 28px 28px 0 0;
    box-shadow: var(--md-sys-elevation-3);
    max-height: var(--md3-bottom-sheet-max-height, 75vh);
    transform: translateY(100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.md3-bottom-sheet-open .md3-bottom-sheet-container {
    transform: translateY(0);
}

.md3-bottom-sheet-handle {
    width: 32px;
    height: 4px;
    background: var(--md-sys-color-on-surface-variant);
    border-radius: 2px;
    margin: 12px auto 8px;
    opacity: 0.4;
    cursor: grab;
}

.md3-bottom-sheet-handle:active {
    cursor: grabbing;
}

.md3-bottom-sheet-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    border-bottom: 1px solid var(--md-sys-color-outline-variant);
    flex-shrink: 0;
}

.md3-bottom-sheet-title {
    font-size: 20px;
    font-weight: 500;
    line-height: 28px;
    color: var(--md-sys-color-on-surface);
    margin: 0;
}

.md3-bottom-sheet-close {
    background: none;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--md-sys-color-on-surface-variant);
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.md3-bottom-sheet-close:hover {
    background-color: var(--md-sys-color-surface-container-high);
}

.md3-bottom-sheet-content {
    padding: 16px 24px;
    overflow-y: auto;
    flex: 1;
    color: var(--md-sys-color-on-surface);
    line-height: 1.5;
}

.md3-bottom-sheet-actions {
    display: flex;
    gap: 8px;
    padding: 16px 24px;
    justify-content: flex-end;
    border-top: 1px solid var(--md-sys-color-outline-variant);
    flex-shrink: 0;
}

/* Variants */
.md3-bottom-sheet-fullscreen .md3-bottom-sheet-container {
    height: 100vh;
    border-radius: 0;
    max-height: none;
}

.md3-bottom-sheet-modal .md3-bottom-sheet-backdrop {
    display: block;
}

.md3-bottom-sheet-standard .md3-bottom-sheet-backdrop {
    display: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-bottom-sheet-container {
        border-radius: 16px 16px 0 0;
    }

    .md3-bottom-sheet-content {
        padding: 16px;
    }

    .md3-bottom-sheet-actions {
        padding: 16px;
    }

    .md3-bottom-sheet-header {
        padding: 16px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-bottom-sheet-container {
    background: var(--md-sys-color-surface-container-low);
}

[data-theme="dark"] .md3-bottom-sheet-backdrop {
    background: rgba(0, 0, 0, 0.7);
}
';
    }

    /**
     * Get Bottom Sheet JavaScript
     */
    public static function getJS(): string
    {
        return '
// Bottom Sheet Management
class MD3BottomSheetManager {
    constructor() {
        this.activeSheet = null;
        this.init();
    }

    init() {
        document.addEventListener("click", this.handleTriggerClick.bind(this));
        document.addEventListener("click", this.handleCloseClick.bind(this));
        document.addEventListener("click", this.handleBackdropClick.bind(this));
        document.addEventListener("keydown", this.handleKeyDown.bind(this));

        // Touch handling for swipe to dismiss
        document.addEventListener("touchstart", this.handleTouchStart.bind(this));
        document.addEventListener("touchmove", this.handleTouchMove.bind(this));
        document.addEventListener("touchend", this.handleTouchEnd.bind(this));
    }

    handleTriggerClick(e) {
        const trigger = e.target.closest("[data-md3-bottom-sheet-trigger]");
        if (!trigger) return;

        e.preventDefault();
        const sheetId = trigger.dataset.md3BottomSheetTrigger;
        const sheet = document.getElementById(sheetId);
        if (sheet) {
            this.openSheet(sheet);
        }
    }

    handleCloseClick(e) {
        const closeBtn = e.target.closest(".md3-bottom-sheet-close");
        if (!closeBtn) return;

        e.preventDefault();
        const sheet = closeBtn.closest(".md3-bottom-sheet");
        if (sheet) {
            this.closeSheet(sheet);
        }
    }

    handleBackdropClick(e) {
        if (!e.target.classList.contains("md3-bottom-sheet-backdrop")) return;

        const sheet = e.target.closest(".md3-bottom-sheet");
        if (sheet && sheet.dataset.dismissible === "true") {
            this.closeSheet(sheet);
        }
    }

    handleKeyDown(e) {
        if (e.key === "Escape" && this.activeSheet) {
            if (this.activeSheet.dataset.dismissible === "true") {
                this.closeSheet(this.activeSheet);
            }
        }
    }

    openSheet(sheet) {
        if (this.activeSheet && this.activeSheet !== sheet) {
            this.closeSheet(this.activeSheet);
        }

        this.activeSheet = sheet;
        sheet.classList.add("md3-bottom-sheet-open");
        sheet.setAttribute("aria-hidden", "false");

        // Focus management
        const firstFocusable = sheet.querySelector("button, [href], input, select, textarea, [tabindex]:not([tabindex=\"-1\"])");
        if (firstFocusable) {
            firstFocusable.focus();
        }

        // Dispatch open event
        sheet.dispatchEvent(new CustomEvent("md3-bottom-sheet-open", {
            detail: { sheet }
        }));
    }

    closeSheet(sheet) {
        sheet.classList.remove("md3-bottom-sheet-open");
        sheet.setAttribute("aria-hidden", "true");

        if (this.activeSheet === sheet) {
            this.activeSheet = null;
        }

        // Dispatch close event
        sheet.dispatchEvent(new CustomEvent("md3-bottom-sheet-close", {
            detail: { sheet }
        }));
    }

    // Touch handling for swipe to dismiss
    handleTouchStart(e) {
        if (!this.activeSheet) return;

        const handle = e.target.closest(".md3-bottom-sheet-handle");
        const container = e.target.closest(".md3-bottom-sheet-container");

        if (handle || container) {
            this.touchStartY = e.touches[0].clientY;
            this.touchStartTime = Date.now();
            this.isDragging = true;
        }
    }

    handleTouchMove(e) {
        if (!this.isDragging || !this.activeSheet) return;

        const currentY = e.touches[0].clientY;
        const deltaY = currentY - this.touchStartY;

        if (deltaY > 0) { // Only allow downward swipes
            const container = this.activeSheet.querySelector(".md3-bottom-sheet-container");
            container.style.transform = `translateY(${deltaY}px)`;
        }
    }

    handleTouchEnd(e) {
        if (!this.isDragging || !this.activeSheet) return;

        const container = this.activeSheet.querySelector(".md3-bottom-sheet-container");
        const deltaY = e.changedTouches[0].clientY - this.touchStartY;
        const velocity = deltaY / (Date.now() - this.touchStartTime);

        // Close if swiped down significantly or with high velocity
        if (deltaY > 100 || velocity > 0.5) {
            if (this.activeSheet.dataset.dismissible === "true") {
                this.closeSheet(this.activeSheet);
            }
        }

        // Reset transform
        container.style.transform = "";
        this.isDragging = false;
    }
}

// Initialize Bottom Sheet Manager
document.addEventListener("DOMContentLoaded", function() {
    new MD3BottomSheetManager();
});

// Export for manual control
window.MD3BottomSheet = {
    open: function(sheetId) {
        const sheet = document.getElementById(sheetId);
        if (sheet) {
            const manager = new MD3BottomSheetManager();
            manager.openSheet(sheet);
        }
    },
    close: function(sheetId) {
        const sheet = document.getElementById(sheetId);
        if (sheet) {
            const manager = new MD3BottomSheetManager();
            manager.closeSheet(sheet);
        }
    }
};
';
    }
}