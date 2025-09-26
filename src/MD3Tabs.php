<?php

/**
 * Material Design 3 Tabs Component
 *
 * Implementiert MD3 Tabs mit vollständigem Styling und Interaktion
 *
 * Features:
 * - Primary Tabs
 * - Secondary Tabs
 * - Scrollable Tabs
 * - Tabs mit Icons
 * - Tabs mit Badges
 * - Disabled Tabs
 * - Tab Content Management
 * - Keyboard Navigation
 * - Touch/Swipe Support
 * - Smooth Animations
 */

class MD3Tabs {

    /**
     * Primary Tabs
     */
    public static function primary(array $tabs, string $activeTab = '', array $options = []): string {
        $options['variant'] = 'primary';
        return self::renderTabs($tabs, $activeTab, $options);
    }

    /**
     * Secondary Tabs
     */
    public static function secondary(array $tabs, string $activeTab = '', array $options = []): string {
        $options['variant'] = 'secondary';
        return self::renderTabs($tabs, $activeTab, $options);
    }

    /**
     * Scrollable Tabs
     */
    public static function scrollable(array $tabs, string $activeTab = '', array $options = []): string {
        $options['scrollable'] = true;
        return self::renderTabs($tabs, $activeTab, $options);
    }

    /**
     * Tabs mit Content Panels
     */
    public static function withContent(array $tabs, string $activeTab = '', array $options = []): string {
        $options['withContent'] = true;
        return self::renderTabs($tabs, $activeTab, $options);
    }

    /**
     * Render Tabs Structure
     */
    private static function renderTabs(array $tabs, string $activeTab = '', array $options = []): string {
        $id = $options['id'] ?? 'md3-tabs-' . uniqid();
        $variant = $options['variant'] ?? 'primary';
        $scrollable = $options['scrollable'] ?? false;
        $withContent = $options['withContent'] ?? false;
        $disabled = $options['disabled'] ?? false;

        // Auto-select first tab if none selected
        if (empty($activeTab) && !empty($tabs)) {
            $activeTab = $tabs[0]['id'] ?? $tabs[0]['label'] ?? '';
        }

        $classes = ['md3-tabs'];
        $classes[] = 'md3-tabs--' . $variant;
        if ($scrollable) $classes[] = 'md3-tabs--scrollable';
        if ($disabled) $classes[] = 'md3-tabs--disabled';
        if (!empty($options['class'])) $classes[] = $options['class'];

        $html = '<div class="md3-tabs-container" id="' . $id . '">';

        // Tab List
        $html .= '<div class="' . implode(' ', $classes) . '" role="tablist"';
        if ($disabled) $html .= ' aria-disabled="true"';
        $html .= '>';

        if ($scrollable) {
            $html .= '<button class="md3-tabs__scroll-button md3-tabs__scroll-button--start" aria-hidden="true">';
            $html .= '<span class="material-symbols-outlined">chevron_left</span>';
            $html .= '</button>';

            $html .= '<div class="md3-tabs__scroll-container">';
        }

        $html .= '<div class="md3-tabs__list">';

        foreach ($tabs as $index => $tab) {
            $tabId = $tab['id'] ?? $tab['label'] ?? 'tab-' . $index;
            $label = $tab['label'] ?? '';
            $icon = $tab['icon'] ?? '';
            $badge = $tab['badge'] ?? '';
            $tabDisabled = $disabled || ($tab['disabled'] ?? false);
            $isActive = $tabId === $activeTab;

            $tabClasses = ['md3-tabs__tab'];
            if ($isActive) $tabClasses[] = 'md3-tabs__tab--active';
            if ($tabDisabled) $tabClasses[] = 'md3-tabs__tab--disabled';
            if ($icon) $tabClasses[] = 'md3-tabs__tab--with-icon';
            if ($badge) $tabClasses[] = 'md3-tabs__tab--with-badge';

            $tabAttrs = [
                'class' => implode(' ', $tabClasses),
                'id' => $id . '-tab-' . $tabId,
                'role' => 'tab',
                'tabindex' => $isActive ? '0' : '-1',
                'aria-selected' => $isActive ? 'true' : 'false',
                'aria-controls' => $withContent ? $id . '-panel-' . $tabId : null,
                'data-tab-id' => $tabId
            ];

            if ($tabDisabled) {
                $tabAttrs['aria-disabled'] = 'true';
            }

            $tabAttrsStr = '';
            foreach ($tabAttrs as $key => $val) {
                if ($val !== null) {
                    $tabAttrsStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
                }
            }

            $html .= sprintf('<button%s>', $tabAttrsStr);

            // Tab Content
            $html .= '<div class="md3-tabs__tab-content">';

            if ($icon) {
                $html .= '<span class="md3-tabs__tab-icon">';
                $html .= '<span class="material-symbols-outlined">' . htmlspecialchars($icon) . '</span>';
                $html .= '</span>';
            }

            if ($label) {
                $html .= '<span class="md3-tabs__tab-label">' . htmlspecialchars($label) . '</span>';
            }

            if ($badge) {
                $html .= '<span class="md3-tabs__tab-badge">' . htmlspecialchars($badge) . '</span>';
            }

            $html .= '</div>'; // End tab content

            // Active Indicator
            $html .= '<div class="md3-tabs__tab-indicator"></div>';

            // Ripple Effect
            $html .= '<div class="md3-tabs__tab-ripple"></div>';

            $html .= '</button>'; // End tab
        }

        $html .= '</div>'; // End tab list

        if ($scrollable) {
            $html .= '</div>'; // End scroll container

            $html .= '<button class="md3-tabs__scroll-button md3-tabs__scroll-button--end" aria-hidden="true">';
            $html .= '<span class="material-symbols-outlined">chevron_right</span>';
            $html .= '</button>';
        }

        $html .= '</div>'; // End tabs

        // Tab Panels (if content enabled)
        if ($withContent) {
            $html .= '<div class="md3-tabs__panels">';

            foreach ($tabs as $index => $tab) {
                $tabId = $tab['id'] ?? $tab['label'] ?? 'tab-' . $index;
                $content = $tab['content'] ?? '';
                $isActive = $tabId === $activeTab;

                $panelClasses = ['md3-tabs__panel'];
                if ($isActive) $panelClasses[] = 'md3-tabs__panel--active';

                $html .= sprintf(
                    '<div class="%s" id="%s" role="tabpanel" aria-labelledby="%s"%s>',
                    implode(' ', $panelClasses),
                    $id . '-panel-' . $tabId,
                    $id . '-tab-' . $tabId,
                    $isActive ? '' : ' hidden'
                );

                $html .= $content;

                $html .= '</div>'; // End panel
            }

            $html .= '</div>'; // End panels
        }

        $html .= '</div>'; // End container

        return $html;
    }

    /**
     * Get Tabs CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Tabs Component */
.md3-tabs-container {
    width: 100%;
    position: relative;
}

.md3-tabs {
    display: flex;
    align-items: center;
    position: relative;
    background: var(--md-sys-color-surface);
    border-bottom: 1px solid var(--md-sys-color-outline-variant);
    overflow: hidden;
}

.md3-tabs--scrollable {
    overflow: visible;
}

.md3-tabs--disabled {
    opacity: 0.38;
    pointer-events: none;
}

/* Scroll Buttons */
.md3-tabs__scroll-button {
    display: none;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: var(--md-sys-color-surface);
    border: none;
    cursor: pointer;
    color: var(--md-sys-color-on-surface);
    flex-shrink: 0;
    z-index: 1;
}

.md3-tabs--scrollable .md3-tabs__scroll-button {
    display: flex;
}

.md3-tabs__scroll-button:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
}

.md3-tabs__scroll-button:disabled {
    opacity: 0.38;
    cursor: not-allowed;
}

/* Scroll Container */
.md3-tabs__scroll-container {
    flex: 1;
    overflow-x: auto;
    overflow-y: hidden;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.md3-tabs__scroll-container::-webkit-scrollbar {
    display: none;
}

/* Tab List */
.md3-tabs__list {
    display: flex;
    position: relative;
    min-width: 100%;
}

.md3-tabs--scrollable .md3-tabs__list {
    min-width: max-content;
}

/* Individual Tab */
.md3-tabs__tab {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 48px;
    padding: 0 24px;
    background: none;
    border: none;
    cursor: pointer;
    outline: none;
    color: var(--md-sys-color-on-surface-variant);
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    white-space: nowrap;
    flex-shrink: 0;
    user-select: none;
}

.md3-tabs__tab:hover {
    color: var(--md-sys-color-on-surface);
}

.md3-tabs__tab--active {
    color: var(--md-sys-color-primary);
}

.md3-tabs__tab--disabled {
    cursor: not-allowed;
    opacity: 0.38;
}

/* Primary Tabs specific styles */
.md3-tabs--primary .md3-tabs__tab {
    min-height: 56px;
}

/* Secondary Tabs specific styles */
.md3-tabs--secondary {
    border-bottom: none;
    background: transparent;
}

.md3-tabs--secondary .md3-tabs__tab {
    min-height: 40px;
    padding: 0 16px;
    border-radius: 8px;
    margin: 0 4px;
    background: var(--md-sys-color-surface-container-low);
}

.md3-tabs--secondary .md3-tabs__tab--active {
    background: var(--md-sys-color-secondary-container);
    color: var(--md-sys-color-on-secondary-container);
}

.md3-tabs--secondary .md3-tabs__tab:hover {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, var(--md-sys-color-surface-container-low));
}

/* Tab Content */
.md3-tabs__tab-content {
    display: flex;
    align-items: center;
    gap: 8px;
    position: relative;
    z-index: 1;
}

.md3-tabs__tab-icon {
    font-size: 18px;
    line-height: 1;
}

.md3-tabs__tab-label {
    line-height: 1.2;
}

.md3-tabs__tab-badge {
    background: var(--md-sys-color-error);
    color: var(--md-sys-color-on-error);
    font-size: 11px;
    font-weight: 500;
    padding: 2px 6px;
    border-radius: 10px;
    min-width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 4px;
}

.md3-tabs__tab--active .md3-tabs__tab-badge {
    background: var(--md-sys-color-primary);
    color: var(--md-sys-color-on-primary);
}

/* Tab Indicator (Primary Tabs) */
.md3-tabs__tab-indicator {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 3px;
    background: var(--md-sys-color-primary);
    border-radius: 1.5px;
    transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
    transform: translateX(-50%);
}

.md3-tabs--primary .md3-tabs__tab--active .md3-tabs__tab-indicator {
    width: 100%;
}

.md3-tabs--secondary .md3-tabs__tab-indicator {
    display: none;
}

/* Tab Ripple Effect */
.md3-tabs__tab-ripple {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: inherit;
    overflow: hidden;
    pointer-events: none;
}

.md3-tabs__tab:hover .md3-tabs__tab-ripple {
    background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
}

.md3-tabs__tab--active:hover .md3-tabs__tab-ripple {
    background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
}

.md3-tabs__tab:focus-visible {
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

/* Tab Panels */
.md3-tabs__panels {
    position: relative;
    background: var(--md-sys-color-surface);
}

.md3-tabs__panel {
    padding: 24px;
    animation: md3-tab-panel-fade-in 0.2s ease-out;
}

.md3-tabs__panel--active {
    display: block;
}

.md3-tabs__panel[hidden] {
    display: none;
}

/* Animations */
@keyframes md3-tab-panel-fade-in {
    from {
        opacity: 0;
        transform: translateY(8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes md3-tab-ripple {
    0% {
        transform: scale(0);
        opacity: 0.1;
    }
    100% {
        transform: scale(1);
        opacity: 0;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-tabs__tab {
        padding: 0 16px;
        font-size: 13px;
    }

    .md3-tabs--primary .md3-tabs__tab {
        min-height: 48px;
    }

    .md3-tabs__tab-content {
        gap: 6px;
    }

    .md3-tabs__tab-icon {
        font-size: 16px;
    }

    .md3-tabs__panel {
        padding: 16px;
    }
}

@media (max-width: 480px) {
    .md3-tabs {
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .md3-tabs::-webkit-scrollbar {
        display: none;
    }

    .md3-tabs__list {
        min-width: max-content;
    }

    .md3-tabs__tab {
        padding: 0 12px;
        min-width: max-content;
    }

    .md3-tabs--secondary .md3-tabs__tab {
        margin: 0 2px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-tabs {
    background: var(--md-sys-color-surface);
    border-bottom-color: var(--md-sys-color-outline-variant);
}

[data-theme="dark"] .md3-tabs__tab {
    color: var(--md-sys-color-on-surface-variant);
}

[data-theme="dark"] .md3-tabs__tab:hover {
    color: var(--md-sys-color-on-surface);
}

[data-theme="dark"] .md3-tabs__tab--active {
    color: var(--md-sys-color-primary);
}

[data-theme="dark"] .md3-tabs--secondary .md3-tabs__tab {
    background: var(--md-sys-color-surface-container-low);
}

[data-theme="dark"] .md3-tabs--secondary .md3-tabs__tab--active {
    background: var(--md-sys-color-secondary-container);
    color: var(--md-sys-color-on-secondary-container);
}

[data-theme="dark"] .md3-tabs__scroll-button {
    background: var(--md-sys-color-surface);
    color: var(--md-sys-color-on-surface);
}

[data-theme="dark"] .md3-tabs__panels {
    background: var(--md-sys-color-surface);
}
';
    }

    /**
     * Get Tabs JavaScript
     */
    public static function getJS(): string {
        return '
// Tabs Management
document.addEventListener("DOMContentLoaded", function() {
    // Initialize all tab containers
    document.querySelectorAll(".md3-tabs-container").forEach(initTabContainer);

    function initTabContainer(container) {
        const tabs = container.querySelectorAll(".md3-tabs__tab");
        const panels = container.querySelectorAll(".md3-tabs__panel");
        const scrollContainer = container.querySelector(".md3-tabs__scroll-container");
        const scrollButtons = container.querySelectorAll(".md3-tabs__scroll-button");

        // Tab click handling
        tabs.forEach(tab => {
            tab.addEventListener("click", () => {
                if (tab.classList.contains("md3-tabs__tab--disabled")) return;

                const tabId = tab.dataset.tabId;
                activateTab(container, tabId);
            });
        });

        // Keyboard navigation
        tabs.forEach((tab, index) => {
            tab.addEventListener("keydown", (e) => {
                if (tab.classList.contains("md3-tabs__tab--disabled")) return;

                let targetIndex;

                switch (e.key) {
                    case "ArrowLeft":
                        e.preventDefault();
                        targetIndex = (index - 1 + tabs.length) % tabs.length;
                        break;
                    case "ArrowRight":
                        e.preventDefault();
                        targetIndex = (index + 1) % tabs.length;
                        break;
                    case "Home":
                        e.preventDefault();
                        targetIndex = 0;
                        break;
                    case "End":
                        e.preventDefault();
                        targetIndex = tabs.length - 1;
                        break;
                    case "Enter":
                    case " ":
                        e.preventDefault();
                        tab.click();
                        return;
                    default:
                        return;
                }

                // Find next non-disabled tab
                while (tabs[targetIndex] && tabs[targetIndex].classList.contains("md3-tabs__tab--disabled")) {
                    if (e.key === "ArrowLeft" || e.key === "End") {
                        targetIndex = (targetIndex - 1 + tabs.length) % tabs.length;
                    } else {
                        targetIndex = (targetIndex + 1) % tabs.length;
                    }
                }

                if (tabs[targetIndex]) {
                    tabs[targetIndex].focus();
                    tabs[targetIndex].click();
                }
            });
        });

        // Scroll button handling
        if (scrollContainer && scrollButtons.length === 2) {
            const [startButton, endButton] = scrollButtons;

            startButton.addEventListener("click", () => {
                scrollContainer.scrollBy({ left: -200, behavior: "smooth" });
            });

            endButton.addEventListener("click", () => {
                scrollContainer.scrollBy({ left: 200, behavior: "smooth" });
            });

            // Update scroll button states
            function updateScrollButtons() {
                const { scrollLeft, scrollWidth, clientWidth } = scrollContainer;

                startButton.disabled = scrollLeft <= 0;
                endButton.disabled = scrollLeft >= scrollWidth - clientWidth - 1;
            }

            scrollContainer.addEventListener("scroll", updateScrollButtons);
            window.addEventListener("resize", updateScrollButtons);
            updateScrollButtons();
        }

        // Touch swipe for panels (mobile)
        if (panels.length > 0) {
            let startX = 0;
            let startY = 0;
            let isScrolling = false;

            container.addEventListener("touchstart", (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                isScrolling = undefined;
            }, { passive: true });

            container.addEventListener("touchmove", (e) => {
                if (isScrolling === false) return;

                const currentX = e.touches[0].clientX;
                const currentY = e.touches[0].clientY;
                const diffX = Math.abs(currentX - startX);
                const diffY = Math.abs(currentY - startY);

                if (isScrolling === undefined) {
                    isScrolling = diffY > diffX;
                }

                if (!isScrolling) {
                    e.preventDefault();
                }
            }, { passive: false });

            container.addEventListener("touchend", (e) => {
                if (isScrolling) return;

                const endX = e.changedTouches[0].clientX;
                const diff = startX - endX;
                const threshold = 50;

                if (Math.abs(diff) > threshold) {
                    const activeTab = container.querySelector(".md3-tabs__tab--active");
                    const currentIndex = Array.from(tabs).indexOf(activeTab);

                    let newIndex;
                    if (diff > 0) { // Swipe left - next tab
                        newIndex = Math.min(currentIndex + 1, tabs.length - 1);
                    } else { // Swipe right - previous tab
                        newIndex = Math.max(currentIndex - 1, 0);
                    }

                    if (tabs[newIndex] && !tabs[newIndex].classList.contains("md3-tabs__tab--disabled")) {
                        tabs[newIndex].click();
                    }
                }
            }, { passive: true });
        }
    }

    function activateTab(container, tabId) {
        const tabs = container.querySelectorAll(".md3-tabs__tab");
        const panels = container.querySelectorAll(".md3-tabs__panel");
        const targetTab = container.querySelector(`[data-tab-id="${tabId}"]`);
        const targetPanel = container.querySelector(`#${container.id}-panel-${tabId}`);

        if (!targetTab) return;

        // Update tab states
        tabs.forEach(tab => {
            const isActive = tab === targetTab;
            tab.classList.toggle("md3-tabs__tab--active", isActive);
            tab.setAttribute("aria-selected", isActive ? "true" : "false");
            tab.setAttribute("tabindex", isActive ? "0" : "-1");
        });

        // Update panel states
        panels.forEach(panel => {
            const isActive = panel === targetPanel;
            panel.classList.toggle("md3-tabs__panel--active", isActive);
            panel.hidden = !isActive;
        });

        // Scroll active tab into view if needed
        const scrollContainer = container.querySelector(".md3-tabs__scroll-container");
        if (scrollContainer) {
            const tabRect = targetTab.getBoundingClientRect();
            const containerRect = scrollContainer.getBoundingClientRect();

            if (tabRect.left < containerRect.left) {
                scrollContainer.scrollBy({
                    left: tabRect.left - containerRect.left - 24,
                    behavior: "smooth"
                });
            } else if (tabRect.right > containerRect.right) {
                scrollContainer.scrollBy({
                    left: tabRect.right - containerRect.right + 24,
                    behavior: "smooth"
                });
            }
        }

        // Dispatch custom event
        const event = new CustomEvent("md3-tab-change", {
            detail: {
                tabId: tabId,
                tab: targetTab,
                panel: targetPanel,
                container: container
            }
        });
        container.dispatchEvent(event);
    }

    // Add ripple effects
    document.addEventListener("pointerdown", function(e) {
        const tab = e.target.closest(".md3-tabs__tab");
        if (!tab || tab.classList.contains("md3-tabs__tab--disabled")) return;

        const ripple = tab.querySelector(".md3-tabs__tab-ripple");
        if (!ripple) return;

        const rect = tab.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;

        const rippleElement = document.createElement("span");
        rippleElement.className = "md3-tab-ripple-effect";
        rippleElement.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.1;
            pointer-events: none;
            transform: scale(0);
            animation: md3-tab-ripple 0.6s ease-out;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
        `;

        ripple.appendChild(rippleElement);

        setTimeout(() => {
            if (rippleElement.parentNode) {
                rippleElement.parentNode.removeChild(rippleElement);
            }
        }, 600);
    });
});

// Utility functions
window.activateTab = function(containerId, tabId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    const targetTab = container.querySelector(`[data-tab-id="${tabId}"]`);
    if (targetTab && !targetTab.classList.contains("md3-tabs__tab--disabled")) {
        targetTab.click();
    }
};

window.getActiveTab = function(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return null;

    const activeTab = container.querySelector(".md3-tabs__tab--active");
    return activeTab ? activeTab.dataset.tabId : null;
};

window.disableTab = function(containerId, tabId, disabled = true) {
    const container = document.getElementById(containerId);
    if (!container) return;

    const tab = container.querySelector(`[data-tab-id="${tabId}"]`);
    if (!tab) return;

    tab.classList.toggle("md3-tabs__tab--disabled", disabled);
    tab.setAttribute("aria-disabled", disabled ? "true" : "false");

    if (disabled && tab.classList.contains("md3-tabs__tab--active")) {
        // Find next available tab
        const tabs = container.querySelectorAll(".md3-tabs__tab:not(.md3-tabs__tab--disabled)");
        if (tabs.length > 0) {
            tabs[0].click();
        }
    }
};
';
    }
}