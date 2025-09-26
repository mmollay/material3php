<?php

/**
 * Material Design 3 Slider Component
 *
 * Implementiert MD3 Sliders in verschiedenen Varianten
 * Continuous, Discrete und Range Sliders
 *
 * Features:
 * - Continuous Slider (smooth values)
 * - Discrete Slider (step values with ticks)
 * - Range Slider (min/max values)
 * - Value Labels und Tooltips
 * - Verschiedene Orientierungen
 * - Custom Steps und Marks
 * - Touch/Mouse Interaktion
 * - Accessibility Support
 */

class MD3Slider {

    /**
     * Continuous Slider (smooth values)
     */
    public static function continuous(string $name, array $options = []): string {
        $options['variant'] = 'continuous';
        $options['name'] = $name;
        return self::renderSlider($options);
    }

    /**
     * Discrete Slider (step values)
     */
    public static function discrete(string $name, array $options = []): string {
        $options['variant'] = 'discrete';
        $options['name'] = $name;
        $options['showTicks'] = true;
        return self::renderSlider($options);
    }

    /**
     * Range Slider (min/max values)
     */
    public static function range(string $name, array $options = []): string {
        $options['variant'] = 'range';
        $options['name'] = $name;
        $options['isRange'] = true;
        return self::renderSlider($options);
    }

    /**
     * Slider mit Labels
     */
    public static function withLabel(string $variant, string $name, string $label, array $options = []): string {
        $options['variant'] = $variant;
        $options['name'] = $name;
        $options['label'] = $label;
        $options['showLabel'] = true;
        return self::renderSlider($options);
    }

    /**
     * Vertical Slider
     */
    public static function vertical(string $variant, string $name, array $options = []): string {
        $options['variant'] = $variant;
        $options['name'] = $name;
        $options['orientation'] = 'vertical';
        return self::renderSlider($options);
    }

    /**
     * Render Slider Structure
     */
    private static function renderSlider(array $options = []): string {
        $variant = $options['variant'] ?? 'continuous';
        $name = $options['name'] ?? 'slider';
        $id = $options['id'] ?? 'md3-slider-' . uniqid();
        $min = $options['min'] ?? 0;
        $max = $options['max'] ?? 100;
        $value = $options['value'] ?? $min;
        $step = $options['step'] ?? ($variant === 'discrete' ? 1 : 'any');
        $orientation = $options['orientation'] ?? 'horizontal';
        $disabled = $options['disabled'] ?? false;
        $showTicks = $options['showTicks'] ?? false;
        $showLabel = $options['showLabel'] ?? false;
        $label = $options['label'] ?? '';
        $isRange = $options['isRange'] ?? false;

        // Range values
        $minValue = $isRange ? ($options['minValue'] ?? $min) : $value;
        $maxValue = $isRange ? ($options['maxValue'] ?? $max) : $value;

        $classes = ['md3-slider', "md3-slider--{$variant}", "md3-slider--{$orientation}"];
        if ($disabled) $classes[] = 'md3-slider--disabled';
        if ($isRange) $classes[] = 'md3-slider--range';
        if (!empty($options['class'])) $classes[] = $options['class'];

        // Container
        $html = '<div class="md3-slider-container">';

        // Label
        if ($showLabel && $label) {
            $html .= sprintf('<label class="md3-slider__label" for="%s">%s</label>', $id, htmlspecialchars($label));
        }

        // Slider wrapper
        $html .= sprintf('<div class="%s" id="%s-container">', implode(' ', $classes), $id);

        // Track
        $html .= '<div class="md3-slider__track">';
        $html .= '<div class="md3-slider__track-inactive"></div>';
        $html .= '<div class="md3-slider__track-active"></div>';
        $html .= '</div>';

        // Ticks (for discrete sliders)
        if ($showTicks && $step !== 'any') {
            $html .= self::renderTicks($min, $max, $step, $orientation);
        }

        // Thumbs
        if ($isRange) {
            // Range slider - two thumbs
            $html .= self::renderThumb('min', $minValue, $min, $max, $id . '-min', $name . '_min', $disabled);
            $html .= self::renderThumb('max', $maxValue, $min, $max, $id . '-max', $name . '_max', $disabled);
        } else {
            // Single thumb
            $html .= self::renderThumb('single', $value, $min, $max, $id, $name, $disabled);
        }

        $html .= '</div>'; // End slider wrapper

        // Hidden inputs for form submission
        if ($isRange) {
            $html .= sprintf('<input type="hidden" name="%s_min" value="%s" id="%s-min-input">',
                htmlspecialchars($name), $minValue, $id);
            $html .= sprintf('<input type="hidden" name="%s_max" value="%s" id="%s-max-input">',
                htmlspecialchars($name), $maxValue, $id);
        } else {
            $html .= sprintf('<input type="hidden" name="%s" value="%s" id="%s-input">',
                htmlspecialchars($name), $value, $id);
        }

        $html .= '</div>'; // End container

        return $html;
    }

    /**
     * Render Slider Thumb
     */
    private static function renderThumb(string $type, float $value, float $min, float $max, string $id, string $name, bool $disabled): string {
        $position = ($value - $min) / ($max - $min) * 100;

        $thumbClasses = ['md3-slider__thumb'];
        if ($type === 'min') $thumbClasses[] = 'md3-slider__thumb--min';
        if ($type === 'max') $thumbClasses[] = 'md3-slider__thumb--max';

        $attributes = [
            'class' => implode(' ', $thumbClasses),
            'id' => $id,
            'role' => 'slider',
            'tabindex' => $disabled ? '-1' : '0',
            'aria-valuemin' => (string)$min,
            'aria-valuemax' => (string)$max,
            'aria-valuenow' => (string)$value,
            'data-value' => (string)$value,
            'data-min' => (string)$min,
            'data-max' => (string)$max,
            'data-name' => $name,
            'data-type' => $type,
            'style' => "left: {$position}%"
        ];

        if ($disabled) {
            $attributes['aria-disabled'] = 'true';
        }

        $attributesStr = '';
        foreach ($attributes as $key => $val) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
        }

        $html = sprintf('<div%s>', $attributesStr);
        $html .= '<div class="md3-slider__thumb-knob"></div>';
        $html .= sprintf('<div class="md3-slider__value-label">%s</div>', $value);
        $html .= '</div>';

        return $html;
    }

    /**
     * Render Tick Marks
     */
    private static function renderTicks(float $min, float $max, $step, string $orientation): string {
        if ($step === 'any') return '';

        $html = '<div class="md3-slider__ticks">';

        $stepNum = is_numeric($step) ? (float)$step : 1;
        $totalSteps = ($max - $min) / $stepNum;

        for ($i = 0; $i <= $totalSteps; $i++) {
            $value = $min + ($i * $stepNum);
            $position = ($value - $min) / ($max - $min) * 100;

            $style = $orientation === 'vertical' ? "bottom: {$position}%" : "left: {$position}%";
            $html .= sprintf('<div class="md3-slider__tick" style="%s" data-value="%s"></div>',
                $style, $value);
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Get Slider CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Slider Component */
.md3-slider-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
    width: 100%;
}

.md3-slider {
    position: relative;
    width: 100%;
    height: 20px;
    display: flex;
    align-items: center;
    cursor: pointer;
    touch-action: none;
}

.md3-slider--vertical {
    width: 20px;
    height: 200px;
    flex-direction: column;
}

.md3-slider--disabled {
    cursor: not-allowed;
    opacity: 0.38;
    pointer-events: none;
}

/* Slider Label */
.md3-slider__label {
    font-size: 14px;
    font-weight: 500;
    color: var(--md-sys-color-on-surface);
    margin-bottom: 4px;
}

/* Slider Track */
.md3-slider__track {
    position: relative;
    width: 100%;
    height: 4px;
    background: transparent;
    border-radius: 2px;
}

.md3-slider--vertical .md3-slider__track {
    width: 4px;
    height: 100%;
}

.md3-slider__track-inactive {
    position: absolute;
    width: 100%;
    height: 100%;
    background: var(--md-sys-color-surface-container-highest);
    border-radius: inherit;
}

.md3-slider__track-active {
    position: absolute;
    height: 100%;
    background: var(--md-sys-color-primary);
    border-radius: inherit;
    left: 0;
    width: 0%;
    transition: width 0.1s ease-out;
}

.md3-slider--vertical .md3-slider__track-active {
    width: 100%;
    height: 0%;
    bottom: 0;
    transition: height 0.1s ease-out;
}

/* Slider Thumbs */
.md3-slider__thumb {
    position: absolute;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    cursor: grab;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    outline: none;
}

.md3-slider--vertical .md3-slider__thumb {
    margin: 0 -10px -10px 0;
}

.md3-slider__thumb:active {
    cursor: grabbing;
}

.md3-slider__thumb:focus-visible .md3-slider__thumb-knob {
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

.md3-slider__thumb-knob {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--md-sys-color-primary);
    border: 2px solid var(--md-sys-color-surface);
    box-shadow: var(--md-sys-elevation-1);
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    position: relative;
}

.md3-slider__thumb:hover .md3-slider__thumb-knob {
    transform: scale(1.1);
    box-shadow: var(--md-sys-elevation-2);
}

.md3-slider__thumb:active .md3-slider__thumb-knob {
    transform: scale(1.2);
    box-shadow: var(--md-sys-elevation-3);
}

/* Value Label */
.md3-slider__value-label {
    position: absolute;
    top: -35px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--md-sys-color-inverse-surface);
    color: var(--md-sys-color-inverse-on-surface);
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
    z-index: 3;
}

.md3-slider--vertical .md3-slider__value-label {
    top: 50%;
    left: -45px;
    transform: translateY(-50%);
}

.md3-slider__thumb:hover .md3-slider__value-label,
.md3-slider__thumb:active .md3-slider__value-label,
.md3-slider__thumb:focus .md3-slider__value-label {
    opacity: 1;
}

/* Ticks */
.md3-slider__ticks {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.md3-slider__tick {
    position: absolute;
    width: 2px;
    height: 2px;
    background: var(--md-sys-color-on-surface-variant);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    top: 50%;
}

.md3-slider--vertical .md3-slider__tick {
    left: 50%;
    transform: translate(-50%, 50%);
}

/* Range Slider */
.md3-slider--range .md3-slider__thumb--min {
    z-index: 3;
}

.md3-slider--range .md3-slider__thumb--max {
    z-index: 2;
}

.md3-slider--range .md3-slider__thumb--min .md3-slider__thumb-knob {
    background: var(--md-sys-color-secondary);
}

/* Discrete Slider */
.md3-slider--discrete .md3-slider__thumb-knob {
    box-shadow: var(--md-sys-elevation-2);
}

.md3-slider--discrete .md3-slider__value-label {
    opacity: 1;
    position: relative;
    top: -40px;
    background: var(--md-sys-color-primary);
    color: var(--md-sys-color-on-primary);
}

.md3-slider--discrete.md3-slider--vertical .md3-slider__value-label {
    top: 50%;
    left: -50px;
    transform: translateY(-50%);
}

/* Disabled State */
.md3-slider--disabled .md3-slider__track-inactive {
    background: var(--md-sys-color-on-surface);
    opacity: 0.12;
}

.md3-slider--disabled .md3-slider__track-active {
    background: var(--md-sys-color-on-surface);
    opacity: 0.38;
}

.md3-slider--disabled .md3-slider__thumb-knob {
    background: var(--md-sys-color-on-surface);
    opacity: 0.38;
    box-shadow: none;
}

.md3-slider--disabled .md3-slider__tick {
    background: var(--md-sys-color-on-surface);
    opacity: 0.38;
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-slider__thumb {
        width: 24px;
        height: 24px;
        margin: -12px 0 0 -12px;
    }

    .md3-slider--vertical .md3-slider__thumb {
        margin: 0 -12px -12px 0;
    }

    .md3-slider__thumb-knob {
        width: 24px;
        height: 24px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-slider__track-inactive {
    background: var(--md-sys-color-surface-container-highest);
}

[data-theme="dark"] .md3-slider__value-label {
    background: var(--md-sys-color-inverse-surface);
    color: var(--md-sys-color-inverse-on-surface);
}
';
    }

    /**
     * Get Slider JavaScript
     */
    public static function getJS(): string {
        return '
// Slider Management
class MD3SliderManager {
    constructor() {
        this.sliders = new Map();
        this.isDragging = false;
        this.currentThumb = null;
        this.init();
    }

    init() {
        document.querySelectorAll(".md3-slider").forEach(slider => {
            this.initSlider(slider);
        });

        // Global event listeners
        document.addEventListener("mousemove", this.handleMouseMove.bind(this));
        document.addEventListener("mouseup", this.handleMouseUp.bind(this));
        document.addEventListener("touchmove", this.handleTouchMove.bind(this), { passive: false });
        document.addEventListener("touchend", this.handleTouchEnd.bind(this));
    }

    initSlider(sliderElement) {
        const id = sliderElement.id.replace("-container", "");
        const isRange = sliderElement.classList.contains("md3-slider--range");
        const isVertical = sliderElement.classList.contains("md3-slider--vertical");
        const isDisabled = sliderElement.classList.contains("md3-slider--disabled");

        if (isDisabled) return;

        const slider = {
            element: sliderElement,
            track: sliderElement.querySelector(".md3-slider__track"),
            activeTrack: sliderElement.querySelector(".md3-slider__track-active"),
            thumbs: sliderElement.querySelectorAll(".md3-slider__thumb"),
            isRange: isRange,
            isVertical: isVertical,
            id: id
        };

        this.sliders.set(id, slider);

        // Add event listeners
        slider.thumbs.forEach(thumb => {
            thumb.addEventListener("mousedown", this.handleMouseDown.bind(this));
            thumb.addEventListener("touchstart", this.handleTouchStart.bind(this), { passive: true });
            thumb.addEventListener("keydown", this.handleKeyDown.bind(this));
        });

        // Track click
        slider.track.addEventListener("click", this.handleTrackClick.bind(this));

        // Initialize positions
        this.updateSlider(slider);
    }

    handleMouseDown(e) {
        if (e.button !== 0) return; // Only left mouse button
        e.preventDefault();
        this.startDrag(e.target.closest(".md3-slider__thumb"), e.clientX, e.clientY);
    }

    handleTouchStart(e) {
        if (e.touches.length !== 1) return;
        this.startDrag(e.target.closest(".md3-slider__thumb"), e.touches[0].clientX, e.touches[0].clientY);
    }

    handleMouseMove(e) {
        if (!this.isDragging) return;
        e.preventDefault();
        this.updateDrag(e.clientX, e.clientY);
    }

    handleTouchMove(e) {
        if (!this.isDragging || e.touches.length !== 1) return;
        e.preventDefault();
        this.updateDrag(e.touches[0].clientX, e.touches[0].clientY);
    }

    handleMouseUp(e) {
        if (!this.isDragging) return;
        this.endDrag();
    }

    handleTouchEnd(e) {
        if (!this.isDragging) return;
        this.endDrag();
    }

    handleKeyDown(e) {
        const thumb = e.target;
        const slider = this.getSliderFromThumb(thumb);
        if (!slider) return;

        const min = parseFloat(thumb.getAttribute("data-min"));
        const max = parseFloat(thumb.getAttribute("data-max"));
        const current = parseFloat(thumb.getAttribute("data-value"));
        let step = 1;

        // Determine step size
        const container = slider.element.closest(".md3-slider-container");
        if (container && container.classList.contains("md3-slider--discrete")) {
            step = 1; // or get from data attribute
        } else {
            step = (max - min) / 100; // 1% steps for continuous
        }

        let newValue = current;

        switch (e.key) {
            case "ArrowLeft":
            case "ArrowDown":
                newValue = Math.max(min, current - step);
                break;
            case "ArrowRight":
            case "ArrowUp":
                newValue = Math.min(max, current + step);
                break;
            case "Home":
                newValue = min;
                break;
            case "End":
                newValue = max;
                break;
            default:
                return;
        }

        e.preventDefault();
        this.setThumbValue(thumb, newValue);
        this.updateSlider(slider);
    }

    handleTrackClick(e) {
        const track = e.currentTarget;
        const slider = this.getSliderFromTrack(track);
        if (!slider) return;

        const rect = track.getBoundingClientRect();
        const percentage = slider.isVertical
            ? 1 - ((e.clientY - rect.top) / rect.height)
            : (e.clientX - rect.left) / rect.width;

        // Find closest thumb for range sliders
        let targetThumb = slider.thumbs[0];
        if (slider.isRange && slider.thumbs.length === 2) {
            const thumb1Value = parseFloat(slider.thumbs[0].getAttribute("data-value"));
            const thumb2Value = parseFloat(slider.thumbs[1].getAttribute("data-value"));
            const min = parseFloat(slider.thumbs[0].getAttribute("data-min"));
            const max = parseFloat(slider.thumbs[0].getAttribute("data-max"));
            const clickValue = min + (percentage * (max - min));

            const dist1 = Math.abs(clickValue - thumb1Value);
            const dist2 = Math.abs(clickValue - thumb2Value);

            targetThumb = dist1 < dist2 ? slider.thumbs[0] : slider.thumbs[1];
        }

        const min = parseFloat(targetThumb.getAttribute("data-min"));
        const max = parseFloat(targetThumb.getAttribute("data-max"));
        const newValue = min + (percentage * (max - min));

        this.setThumbValue(targetThumb, newValue);
        this.updateSlider(slider);
    }

    startDrag(thumb, clientX, clientY) {
        this.isDragging = true;
        this.currentThumb = thumb;
        thumb.classList.add("md3-slider__thumb--dragging");

        // Focus the thumb
        thumb.focus();
    }

    updateDrag(clientX, clientY) {
        if (!this.currentThumb) return;

        const slider = this.getSliderFromThumb(this.currentThumb);
        if (!slider) return;

        const rect = slider.track.getBoundingClientRect();
        const percentage = slider.isVertical
            ? 1 - ((clientY - rect.top) / rect.height)
            : (clientX - rect.left) / rect.width;

        const min = parseFloat(this.currentThumb.getAttribute("data-min"));
        const max = parseFloat(this.currentThumb.getAttribute("data-max"));
        const newValue = Math.max(min, Math.min(max, min + (percentage * (max - min))));

        this.setThumbValue(this.currentThumb, newValue);
        this.updateSlider(slider);
    }

    endDrag() {
        if (this.currentThumb) {
            this.currentThumb.classList.remove("md3-slider__thumb--dragging");
            this.currentThumb = null;
        }
        this.isDragging = false;
    }

    setThumbValue(thumb, value) {
        const min = parseFloat(thumb.getAttribute("data-min"));
        const max = parseFloat(thumb.getAttribute("data-max"));
        const clampedValue = Math.max(min, Math.min(max, value));

        thumb.setAttribute("data-value", clampedValue);
        thumb.setAttribute("aria-valuenow", clampedValue);

        // Update value label
        const valueLabel = thumb.querySelector(".md3-slider__value-label");
        if (valueLabel) {
            valueLabel.textContent = Math.round(clampedValue);
        }

        // Update hidden input
        const name = thumb.getAttribute("data-name");
        const hiddenInput = document.getElementById(thumb.id.replace("-container", "") + "-input");
        if (hiddenInput) {
            hiddenInput.value = clampedValue;
        }

        // For range sliders
        if (name.endsWith("_min") || name.endsWith("_max")) {
            const baseId = thumb.id.replace("-min", "").replace("-max", "");
            const suffix = name.endsWith("_min") ? "-min-input" : "-max-input";
            const rangeInput = document.getElementById(baseId + suffix);
            if (rangeInput) {
                rangeInput.value = clampedValue;
            }
        }

        // Dispatch change event
        const event = new CustomEvent("md3-slider-change", {
            detail: {
                thumb: thumb,
                value: clampedValue,
                name: name
            }
        });
        thumb.dispatchEvent(event);
    }

    updateSlider(slider) {
        if (slider.isRange && slider.thumbs.length === 2) {
            const value1 = parseFloat(slider.thumbs[0].getAttribute("data-value"));
            const value2 = parseFloat(slider.thumbs[1].getAttribute("data-value"));
            const min = parseFloat(slider.thumbs[0].getAttribute("data-min"));
            const max = parseFloat(slider.thumbs[0].getAttribute("data-max"));

            const minValue = Math.min(value1, value2);
            const maxValue = Math.max(value1, value2);

            const startPercent = ((minValue - min) / (max - min)) * 100;
            const endPercent = ((maxValue - min) / (max - min)) * 100;

            if (slider.isVertical) {
                slider.activeTrack.style.bottom = startPercent + "%";
                slider.activeTrack.style.height = (endPercent - startPercent) + "%";
            } else {
                slider.activeTrack.style.left = startPercent + "%";
                slider.activeTrack.style.width = (endPercent - startPercent) + "%";
            }

            // Update thumb positions
            const thumb1Percent = ((value1 - min) / (max - min)) * 100;
            const thumb2Percent = ((value2 - min) / (max - min)) * 100;

            if (slider.isVertical) {
                slider.thumbs[0].style.bottom = thumb1Percent + "%";
                slider.thumbs[1].style.bottom = thumb2Percent + "%";
            } else {
                slider.thumbs[0].style.left = thumb1Percent + "%";
                slider.thumbs[1].style.left = thumb2Percent + "%";
            }
        } else if (slider.thumbs.length === 1) {
            const value = parseFloat(slider.thumbs[0].getAttribute("data-value"));
            const min = parseFloat(slider.thumbs[0].getAttribute("data-min"));
            const max = parseFloat(slider.thumbs[0].getAttribute("data-max"));
            const percent = ((value - min) / (max - min)) * 100;

            if (slider.isVertical) {
                slider.activeTrack.style.height = percent + "%";
                slider.thumbs[0].style.bottom = percent + "%";
            } else {
                slider.activeTrack.style.width = percent + "%";
                slider.thumbs[0].style.left = percent + "%";
            }
        }
    }

    getSliderFromThumb(thumb) {
        const container = thumb.closest(".md3-slider");
        if (!container) return null;
        const id = container.id.replace("-container", "");
        return this.sliders.get(id);
    }

    getSliderFromTrack(track) {
        const container = track.closest(".md3-slider");
        if (!container) return null;
        const id = container.id.replace("-container", "");
        return this.sliders.get(id);
    }
}

// Initialize slider manager
document.addEventListener("DOMContentLoaded", function() {
    window.md3SliderManager = new MD3SliderManager();
});

// Utility functions
window.setSliderValue = function(id, value, thumbType = "single") {
    if (!window.md3SliderManager) return;

    const slider = window.md3SliderManager.sliders.get(id);
    if (!slider) return;

    let targetThumb = slider.thumbs[0];
    if (thumbType === "min" && slider.thumbs.length > 1) {
        targetThumb = slider.thumbs[0];
    } else if (thumbType === "max" && slider.thumbs.length > 1) {
        targetThumb = slider.thumbs[1];
    }

    window.md3SliderManager.setThumbValue(targetThumb, value);
    window.md3SliderManager.updateSlider(slider);
};
';
    }
}