<?php

/**
 * Material Design 3 Progress Indicator Component
 *
 * Implementiert MD3 Progress Indicators in verschiedenen Varianten
 * Linear und Circular Progress Indicators
 *
 * Features:
 * - Linear Progress (Determinate/Indeterminate)
 * - Circular Progress (Determinate/Indeterminate)
 * - Buffer Support für Linear Progress
 * - Label und Percentage Display
 * - Animationen und Transitions
 * - Verschiedene Größen
 * - Accessibility Support
 */

class MD3Progress {

    /**
     * Linear Progress Indicator
     */
    public static function linear(float $value = null, array $options = []): string {
        $options['variant'] = 'linear';
        $options['value'] = $value;
        return self::renderProgress($options);
    }

    /**
     * Circular Progress Indicator
     */
    public static function circular(float $value = null, array $options = []): string {
        $options['variant'] = 'circular';
        $options['value'] = $value;
        return self::renderProgress($options);
    }

    /**
     * Linear Progress mit Buffer (z.B. für Video Loading)
     */
    public static function linearWithBuffer(float $value, float $buffer, array $options = []): string {
        $options['variant'] = 'linear';
        $options['value'] = $value;
        $options['buffer'] = $buffer;
        return self::renderProgress($options);
    }

    /**
     * Progress mit Label
     */
    public static function withLabel(string $variant, float $value = null, string $label = '', array $options = []): string {
        $options['variant'] = $variant;
        $options['value'] = $value;
        $options['label'] = $label;
        $options['showLabel'] = true;
        return self::renderProgress($options);
    }

    /**
     * Progress mit Percentage
     */
    public static function withPercentage(string $variant, float $value, array $options = []): string {
        $options['variant'] = $variant;
        $options['value'] = $value;
        $options['showPercentage'] = true;
        return self::renderProgress($options);
    }

    /**
     * Render Progress Structure
     */
    private static function renderProgress(array $options = []): string {
        $variant = $options['variant'] ?? 'linear';
        $value = $options['value'] ?? null;
        $buffer = $options['buffer'] ?? null;
        $id = $options['id'] ?? 'md3-progress-' . uniqid();
        $size = $options['size'] ?? 'medium';
        $label = $options['label'] ?? '';
        $showLabel = $options['showLabel'] ?? false;
        $showPercentage = $options['showPercentage'] ?? false;
        $indeterminate = $value === null;

        $classes = ['md3-progress', "md3-progress--{$variant}", "md3-progress--{$size}"];
        if ($indeterminate) $classes[] = 'md3-progress--indeterminate';
        if (!empty($options['class'])) $classes[] = $options['class'];

        $attributes = [
            'class' => implode(' ', $classes),
            'id' => $id,
            'role' => 'progressbar',
            'aria-valuemin' => '0',
            'aria-valuemax' => '100'
        ];

        if (!$indeterminate) {
            $attributes['aria-valuenow'] = (string)($value * 100);
        }

        if ($label) {
            $attributes['aria-label'] = $label;
        }

        // Build progress content based on variant
        $content = '';
        if ($variant === 'circular') {
            $content = self::renderCircularProgress($value, $size, $indeterminate);
        } else {
            $content = self::renderLinearProgress($value, $buffer, $indeterminate);
        }

        // Build label/percentage display
        $labelHtml = '';
        if ($showLabel || $showPercentage) {
            $labelText = '';
            if ($showLabel && $label) {
                $labelText = htmlspecialchars($label);
            }
            if ($showPercentage && !$indeterminate) {
                $percentage = round($value * 100, 1) . '%';
                $labelText .= $labelText ? " ({$percentage})" : $percentage;
            }
            if ($labelText) {
                $labelHtml = sprintf('<div class="md3-progress__label">%s</div>', $labelText);
            }
        }

        $attributesStr = '';
        foreach ($attributes as $key => $val) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
        }

        return sprintf(
            '<div class="md3-progress-container">%s<div%s>%s</div></div>',
            $labelHtml,
            $attributesStr,
            $content
        );
    }

    /**
     * Render Linear Progress
     */
    private static function renderLinearProgress(float $value = null, float $buffer = null, bool $indeterminate = false): string {
        $content = '<div class="md3-progress__track">';

        if ($buffer !== null && !$indeterminate) {
            $bufferWidth = $buffer * 100;
            $content .= sprintf(
                '<div class="md3-progress__buffer" style="width: %s%%"></div>',
                $bufferWidth
            );
        }

        if ($indeterminate) {
            $content .= '<div class="md3-progress__bar md3-progress__bar--indeterminate"></div>';
        } else {
            $progressWidth = $value * 100;
            $content .= sprintf(
                '<div class="md3-progress__bar" style="width: %s%%"></div>',
                $progressWidth
            );
        }

        $content .= '</div>';

        return $content;
    }

    /**
     * Render Circular Progress
     */
    private static function renderCircularProgress(float $value = null, string $size = 'medium', bool $indeterminate = false): string {
        // SVG dimensions based on size
        $dimensions = [
            'small' => ['size' => 24, 'stroke' => 2, 'radius' => 10],
            'medium' => ['size' => 48, 'stroke' => 4, 'radius' => 20],
            'large' => ['size' => 64, 'stroke' => 6, 'radius' => 26]
        ];

        $dim = $dimensions[$size] ?? $dimensions['medium'];
        $circumference = 2 * M_PI * $dim['radius'];

        $svgContent = '';
        if ($indeterminate) {
            $svgContent = sprintf(
                '<circle class="md3-progress__circle md3-progress__circle--indeterminate"
                         cx="%d" cy="%d" r="%d"
                         stroke-width="%d"
                         stroke-dasharray="%s"
                         fill="none"></circle>',
                $dim['size'] / 2,
                $dim['size'] / 2,
                $dim['radius'],
                $dim['stroke'],
                $circumference
            );
        } else {
            $progress = $value * $circumference;
            $remaining = $circumference - $progress;

            $svgContent = sprintf(
                '<circle class="md3-progress__circle-bg"
                         cx="%d" cy="%d" r="%d"
                         stroke-width="%d"
                         fill="none"></circle>
                 <circle class="md3-progress__circle"
                         cx="%d" cy="%d" r="%d"
                         stroke-width="%d"
                         stroke-dasharray="%s %s"
                         stroke-dashoffset="0"
                         fill="none"
                         transform="rotate(-90 %d %d)"></circle>',
                $dim['size'] / 2, $dim['size'] / 2, $dim['radius'], $dim['stroke'],
                $dim['size'] / 2, $dim['size'] / 2, $dim['radius'], $dim['stroke'],
                $progress, $remaining,
                $dim['size'] / 2, $dim['size'] / 2
            );
        }

        return sprintf(
            '<svg class="md3-progress__svg" width="%d" height="%d" viewBox="0 0 %d %d">%s</svg>',
            $dim['size'],
            $dim['size'],
            $dim['size'],
            $dim['size'],
            $svgContent
        );
    }

    /**
     * Get Progress CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Progress Indicator Component */
.md3-progress-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
    width: 100%;
}

.md3-progress {
    position: relative;
    overflow: hidden;
    background: var(--md-sys-color-surface-container-highest);
}

/* Linear Progress */
.md3-progress--linear {
    width: 100%;
    height: 4px;
    border-radius: 2px;
}

.md3-progress--linear.md3-progress--small {
    height: 2px;
    border-radius: 1px;
}

.md3-progress--linear.md3-progress--large {
    height: 6px;
    border-radius: 3px;
}

.md3-progress__track {
    position: relative;
    width: 100%;
    height: 100%;
    background: var(--md-sys-color-surface-container-highest);
    border-radius: inherit;
    overflow: hidden;
}

.md3-progress__buffer {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background: var(--md-sys-color-surface-container-high);
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: inherit;
}

.md3-progress__bar {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background: var(--md-sys-color-primary);
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: inherit;
}

/* Linear Indeterminate Animation */
.md3-progress__bar--indeterminate {
    width: 100%;
    animation: md3-linear-indeterminate 2s infinite linear;
    transform-origin: left;
}

@keyframes md3-linear-indeterminate {
    0% {
        transform: translateX(-100%) scaleX(0);
    }
    50% {
        transform: translateX(-100%) scaleX(1);
    }
    100% {
        transform: translateX(100%) scaleX(1);
    }
}

/* Circular Progress */
.md3-progress--circular {
    display: flex;
    align-items: center;
    justify-content: center;
}

.md3-progress__svg {
    display: block;
}

.md3-progress__circle-bg {
    stroke: var(--md-sys-color-surface-container-highest);
}

.md3-progress__circle {
    stroke: var(--md-sys-color-primary);
    stroke-linecap: round;
    transition: stroke-dasharray 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Circular Indeterminate Animation */
.md3-progress__circle--indeterminate {
    stroke: var(--md-sys-color-primary);
    stroke-linecap: round;
    animation: md3-circular-rotate 2s linear infinite, md3-circular-dash 1.5s ease-in-out infinite;
    transform-origin: center;
}

@keyframes md3-circular-rotate {
    100% {
        transform: rotate(360deg);
    }
}

@keyframes md3-circular-dash {
    0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
    }
    50% {
        stroke-dasharray: 100, 200;
        stroke-dashoffset: -15;
    }
    100% {
        stroke-dasharray: 100, 200;
        stroke-dashoffset: -125;
    }
}

/* Progress Label */
.md3-progress__label {
    font-size: 12px;
    font-weight: 500;
    color: var(--md-sys-color-on-surface-variant);
    text-align: center;
}

.md3-progress-container .md3-progress--linear + .md3-progress__label {
    text-align: left;
}

/* Size Variants */
.md3-progress--small.md3-progress--circular .md3-progress__svg {
    width: 24px;
    height: 24px;
}

.md3-progress--medium.md3-progress--circular .md3-progress__svg {
    width: 48px;
    height: 48px;
}

.md3-progress--large.md3-progress--circular .md3-progress__svg {
    width: 64px;
    height: 64px;
}

/* States */
.md3-progress--error .md3-progress__bar,
.md3-progress--error .md3-progress__circle {
    stroke: var(--md-sys-color-error);
    background: var(--md-sys-color-error);
}

.md3-progress--success .md3-progress__bar,
.md3-progress--success .md3-progress__circle {
    stroke: var(--md-sys-color-tertiary);
    background: var(--md-sys-color-tertiary);
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .md3-progress__bar--indeterminate {
        animation: none;
        width: 50%;
    }

    .md3-progress__circle--indeterminate {
        animation: none;
        stroke-dasharray: 50, 200;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-progress__track {
    background: var(--md-sys-color-surface-container-highest);
}

[data-theme="dark"] .md3-progress__buffer {
    background: var(--md-sys-color-surface-container-high);
}
';
    }

    /**
     * Get Progress JavaScript
     */
    public static function getJS(): string {
        return '
// Progress Management
class MD3ProgressManager {
    constructor() {
        this.progressElements = new Map();
        this.init();
    }

    init() {
        // Initialize all progress elements
        document.querySelectorAll(".md3-progress").forEach(element => {
            this.registerProgress(element);
        });
    }

    registerProgress(element) {
        const id = element.id;
        if (id) {
            this.progressElements.set(id, {
                element: element,
                variant: element.classList.contains("md3-progress--circular") ? "circular" : "linear",
                indeterminate: element.classList.contains("md3-progress--indeterminate")
            });
        }
    }

    updateProgress(id, value, buffer = null) {
        const progress = this.progressElements.get(id);
        if (!progress || progress.indeterminate) return;

        const element = progress.element;

        // Update aria attributes
        element.setAttribute("aria-valuenow", Math.round(value * 100));

        if (progress.variant === "linear") {
            const bar = element.querySelector(".md3-progress__bar");
            if (bar) {
                bar.style.width = (value * 100) + "%";
            }

            // Update buffer if provided
            if (buffer !== null) {
                const bufferElement = element.querySelector(".md3-progress__buffer");
                if (bufferElement) {
                    bufferElement.style.width = (buffer * 100) + "%";
                }
            }
        } else if (progress.variant === "circular") {
            const circle = element.querySelector(".md3-progress__circle");
            if (circle) {
                const radius = parseFloat(circle.getAttribute("r"));
                const circumference = 2 * Math.PI * radius;
                const progressLength = value * circumference;
                const remaining = circumference - progressLength;

                circle.setAttribute("stroke-dasharray", `${progressLength} ${remaining}`);
            }
        }

        // Update percentage label if present
        const container = element.closest(".md3-progress-container");
        const label = container?.querySelector(".md3-progress__label");
        if (label && label.textContent.includes("%")) {
            const percentage = Math.round(value * 100) + "%";
            label.textContent = label.textContent.replace(/\\d+(\\.\\d+)?%/, percentage);
        }

        // Dispatch update event
        const event = new CustomEvent("md3-progress-update", {
            detail: {
                id: id,
                value: value,
                percentage: value * 100,
                buffer: buffer
            }
        });
        element.dispatchEvent(event);
    }

    setIndeterminate(id, indeterminate = true) {
        const progress = this.progressElements.get(id);
        if (!progress) return;

        const element = progress.element;

        if (indeterminate) {
            element.classList.add("md3-progress--indeterminate");
            element.removeAttribute("aria-valuenow");

            if (progress.variant === "linear") {
                const bar = element.querySelector(".md3-progress__bar");
                if (bar) {
                    bar.classList.add("md3-progress__bar--indeterminate");
                    bar.style.width = "100%";
                }
            } else if (progress.variant === "circular") {
                const circle = element.querySelector(".md3-progress__circle");
                if (circle) {
                    circle.classList.add("md3-progress__circle--indeterminate");
                    const radius = parseFloat(circle.getAttribute("r"));
                    const circumference = 2 * Math.PI * radius;
                    circle.setAttribute("stroke-dasharray", circumference);
                }
            }
        } else {
            element.classList.remove("md3-progress--indeterminate");

            if (progress.variant === "linear") {
                const bar = element.querySelector(".md3-progress__bar");
                if (bar) {
                    bar.classList.remove("md3-progress__bar--indeterminate");
                }
            } else if (progress.variant === "circular") {
                const circle = element.querySelector(".md3-progress__circle");
                if (circle) {
                    circle.classList.remove("md3-progress__circle--indeterminate");
                }
            }
        }

        progress.indeterminate = indeterminate;
    }

    setState(id, state) {
        const progress = this.progressElements.get(id);
        if (!progress) return;

        const element = progress.element;

        // Remove existing state classes
        element.classList.remove("md3-progress--error", "md3-progress--success");

        // Add new state class
        if (state === "error" || state === "success") {
            element.classList.add(`md3-progress--${state}`);
        }
    }
}

// Initialize progress manager
document.addEventListener("DOMContentLoaded", function() {
    window.md3ProgressManager = new MD3ProgressManager();
});

// Utility functions for easy access
window.updateProgress = function(id, value, buffer = null) {
    if (window.md3ProgressManager) {
        window.md3ProgressManager.updateProgress(id, value, buffer);
    }
};

window.setProgressIndeterminate = function(id, indeterminate = true) {
    if (window.md3ProgressManager) {
        window.md3ProgressManager.setIndeterminate(id, indeterminate);
    }
};

window.setProgressState = function(id, state) {
    if (window.md3ProgressManager) {
        window.md3ProgressManager.setState(id, state);
    }
};
';
    }
}