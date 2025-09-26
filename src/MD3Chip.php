<?php

/**
 * Material Design 3 Chip Component
 *
 * Implementiert MD3 Chips in verschiedenen Varianten
 * Input, Filter, Suggestion und Assist Chips
 *
 * Features:
 * - Input Chips (mit Remove-Funktion)
 * - Filter Chips (auswählbar)
 * - Suggestion Chips (Vorschläge)
 * - Assist Chips (Aktionen)
 * - Chip Sets für Gruppierungen
 * - Interaktive Funktionen
 * - Responsive Design
 */

class MD3Chip {

    /**
     * Input Chip (mit Remove-Button)
     */
    public static function input(string $label, array $options = []): string {
        $options['variant'] = 'input';
        $options['removable'] = true;
        return self::renderChip($label, $options);
    }

    /**
     * Filter Chip (auswählbar)
     */
    public static function filter(string $label, array $options = []): string {
        $options['variant'] = 'filter';
        $options['selectable'] = true;
        return self::renderChip($label, $options);
    }

    /**
     * Suggestion Chip (Vorschläge)
     */
    public static function suggestion(string $label, array $options = []): string {
        $options['variant'] = 'suggestion';
        return self::renderChip($label, $options);
    }

    /**
     * Assist Chip (Aktionen)
     */
    public static function assist(string $label, array $options = []): string {
        $options['variant'] = 'assist';
        return self::renderChip($label, $options);
    }

    /**
     * Chip Set (Container für mehrere Chips)
     */
    public static function set(array $chips, array $options = []): string {
        $id = $options['id'] ?? 'md3-chip-set-' . uniqid();
        $variant = $options['variant'] ?? 'filter';

        $classes = ['md3-chip-set', "md3-chip-set--{$variant}"];
        if (!empty($options['class'])) $classes[] = $options['class'];

        return sprintf(
            '<div class="%s" id="%s" role="group">%s</div>',
            implode(' ', $classes),
            $id,
            implode('', $chips)
        );
    }

    /**
     * Filter Chip Set mit Optionen
     */
    public static function filterSet(array $options, string $name, array $setOptions = []): string {
        $chips = [];
        foreach ($options as $option) {
            $label = $option['label'] ?? '';
            $value = $option['value'] ?? $label;
            $selected = $option['selected'] ?? false;
            $icon = $option['icon'] ?? '';

            $chipOptions = [
                'value' => $value,
                'name' => $name,
                'selected' => $selected,
                'icon' => $icon
            ];

            $chips[] = self::filter($label, $chipOptions);
        }

        $setOptions['variant'] = 'filter';
        return self::set($chips, $setOptions);
    }

    /**
     * Input Chip Field mit Add-Funktion
     */
    public static function inputField(string $name, array $options = []): string {
        $placeholder = $options['placeholder'] ?? 'Neuen Tag hinzufügen...';
        $existingChips = $options['chips'] ?? [];
        $id = $options['id'] ?? 'md3-chip-input-' . uniqid();

        $html = sprintf('<div class="md3-chip-input" id="%s">', $id);

        // Chip container
        $html .= '<div class="md3-chip-input__chips">';
        foreach ($existingChips as $chipValue) {
            $html .= self::input($chipValue, ['name' => $name, 'value' => $chipValue]);
        }
        $html .= '</div>';

        // Input field
        $html .= sprintf(
            '<input type="text" class="md3-chip-input__field" placeholder="%s" data-name="%s">',
            htmlspecialchars($placeholder),
            htmlspecialchars($name)
        );

        $html .= '</div>';

        return $html;
    }

    /**
     * Render Chip Structure
     */
    private static function renderChip(string $label, array $options = []): string {
        $variant = $options['variant'] ?? 'assist';
        $id = $options['id'] ?? 'md3-chip-' . uniqid();
        $icon = $options['icon'] ?? '';
        $removable = $options['removable'] ?? false;
        $selectable = $options['selectable'] ?? false;
        $selected = $options['selected'] ?? false;
        $disabled = $options['disabled'] ?? false;
        $href = $options['href'] ?? '';
        $value = $options['value'] ?? $label;
        $name = $options['name'] ?? '';

        $classes = ['md3-chip', "md3-chip--{$variant}"];
        if ($selected) $classes[] = 'md3-chip--selected';
        if ($disabled) $classes[] = 'md3-chip--disabled';
        if (!empty($options['class'])) $classes[] = $options['class'];

        $attributes = [
            'class' => implode(' ', $classes),
            'id' => $id,
            'data-value' => $value
        ];

        if ($name) $attributes['data-name'] = $name;
        if ($disabled) $attributes['aria-disabled'] = 'true';

        // Tag auswählen
        $tag = 'button';
        $attributes['type'] = 'button';

        if ($href) {
            $tag = 'a';
            $attributes['href'] = $href;
            unset($attributes['type']);
        }

        // Build content
        $content = '';

        // Leading icon
        if ($icon) {
            $content .= sprintf('<span class="md3-chip__icon"><span class="material-symbols-outlined">%s</span></span>', $icon);
        }

        // Label
        $content .= sprintf('<span class="md3-chip__label">%s</span>', htmlspecialchars($label));

        // Trailing elements
        if ($removable) {
            $content .= '<span class="md3-chip__remove"><span class="material-symbols-outlined">close</span></span>';
        }

        if ($selectable) {
            $content .= '<span class="md3-chip__checkmark"><span class="material-symbols-outlined">check</span></span>';
        }

        // Hidden input for form submission (filter chips)
        $hiddenInput = '';
        if ($selectable && $name) {
            $hiddenInput = sprintf(
                '<input type="hidden" name="%s" value="%s" id="hidden-%s">',
                htmlspecialchars($name),
                $selected ? htmlspecialchars($value) : '',
                $id
            );
        }

        $attributesStr = '';
        foreach ($attributes as $key => $val) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($val));
        }

        return $hiddenInput . sprintf('<%s%s>%s</%s>', $tag, $attributesStr, $content, $tag);
    }

    /**
     * Get Chip CSS
     */
    public static function getCSS(): string {
        return '
/* Material Design 3 Chip Component */
.md3-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    height: 32px;
    padding: 0 16px;
    border-radius: 16px;
    border: 1px solid var(--md-sys-color-outline);
    background: var(--md-sys-color-surface);
    color: var(--md-sys-color-on-surface);
    font-size: 14px;
    font-weight: 500;
    line-height: 20px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    user-select: none;
    outline: none;
    box-sizing: border-box;
}

.md3-chip:hover {
    background: var(--md-sys-color-surface-container-high);
    border-color: var(--md-sys-color-outline);
}

.md3-chip:focus-visible {
    outline: 2px solid var(--md-sys-color-primary);
    outline-offset: 2px;
}

.md3-chip:active {
    background: var(--md-sys-color-surface-container-highest);
    transform: scale(0.98);
}

/* Chip Variants */
.md3-chip--assist {
    background: var(--md-sys-color-surface);
    border-color: var(--md-sys-color-outline);
}

.md3-chip--filter {
    background: var(--md-sys-color-surface);
    border-color: var(--md-sys-color-outline);
}

.md3-chip--filter.md3-chip--selected {
    background: var(--md-sys-color-secondary-container);
    color: var(--md-sys-color-on-secondary-container);
    border-color: var(--md-sys-color-secondary-container);
}

.md3-chip--input {
    background: var(--md-sys-color-surface-container-low);
    border-color: var(--md-sys-color-outline);
}

.md3-chip--suggestion {
    background: var(--md-sys-color-surface);
    border-color: var(--md-sys-color-outline);
}

/* Disabled State */
.md3-chip--disabled {
    opacity: 0.38;
    pointer-events: none;
    cursor: not-allowed;
}

/* Chip Elements */
.md3-chip__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    font-size: 18px;
    margin-left: -4px;
}

.md3-chip__label {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}

.md3-chip__remove {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    font-size: 18px;
    margin-right: -4px;
    border-radius: 50%;
    transition: background-color 0.2s;
    cursor: pointer;
}

.md3-chip__remove:hover {
    background: var(--md-sys-color-surface-container-highest);
}

.md3-chip__checkmark {
    display: none;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    font-size: 16px;
    margin-right: -4px;
    color: var(--md-sys-color-primary);
}

.md3-chip--selected .md3-chip__checkmark {
    display: flex;
}

/* Chip Set */
.md3-chip-set {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}

.md3-chip-set--filter {
    gap: 8px;
}

.md3-chip-set--input {
    gap: 4px;
}

/* Chip Input Field */
.md3-chip-input {
    display: flex;
    flex-direction: column;
    gap: 8px;
    width: 100%;
}

.md3-chip-input__chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    min-height: 32px;
}

.md3-chip-input__field {
    height: 40px;
    padding: 8px 12px;
    border: 1px solid var(--md-sys-color-outline);
    border-radius: 4px;
    background: var(--md-sys-color-surface);
    color: var(--md-sys-color-on-surface);
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
}

.md3-chip-input__field:focus {
    border-color: var(--md-sys-color-primary);
}

.md3-chip-input__field::placeholder {
    color: var(--md-sys-color-on-surface-variant);
}

/* Responsive Design */
@media (max-width: 768px) {
    .md3-chip {
        height: 28px;
        padding: 0 12px;
        font-size: 12px;
    }

    .md3-chip__label {
        max-width: 150px;
    }

    .md3-chip-set {
        gap: 6px;
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-chip--filter.md3-chip--selected {
    background: var(--md-sys-color-secondary-container);
    color: var(--md-sys-color-on-secondary-container);
}
';
    }

    /**
     * Get Chip JavaScript
     */
    public static function getJS(): string {
        return '
// Chip Management
document.addEventListener("DOMContentLoaded", function() {
    // Filter chip selection
    document.addEventListener("click", function(e) {
        const filterChip = e.target.closest(".md3-chip--filter");
        if (filterChip && !filterChip.classList.contains("md3-chip--disabled")) {
            const isSelected = filterChip.classList.contains("md3-chip--selected");
            const value = filterChip.getAttribute("data-value");
            const name = filterChip.getAttribute("data-name");

            if (isSelected) {
                filterChip.classList.remove("md3-chip--selected");
            } else {
                filterChip.classList.add("md3-chip--selected");
            }

            // Update hidden input
            const hiddenInput = document.getElementById("hidden-" + filterChip.id);
            if (hiddenInput) {
                hiddenInput.value = isSelected ? "" : value;
                hiddenInput.dispatchEvent(new Event("change"));
            }

            // Dispatch custom event
            const event = new CustomEvent("md3-chip-change", {
                detail: {
                    chip: filterChip,
                    name: name,
                    value: value,
                    selected: !isSelected
                }
            });
            filterChip.dispatchEvent(event);
        }
    });

    // Remove chip functionality
    document.addEventListener("click", function(e) {
        const removeButton = e.target.closest(".md3-chip__remove");
        if (removeButton) {
            const chip = removeButton.closest(".md3-chip");
            if (chip) {
                // Dispatch remove event
                const event = new CustomEvent("md3-chip-remove", {
                    detail: {
                        chip: chip,
                        value: chip.getAttribute("data-value")
                    }
                });
                chip.dispatchEvent(event);

                // Remove chip
                chip.remove();
            }
        }
    });

    // Chip input field functionality
    const chipInputs = document.querySelectorAll(".md3-chip-input__field");
    chipInputs.forEach(input => {
        input.addEventListener("keydown", function(e) {
            if (e.key === "Enter" && this.value.trim()) {
                e.preventDefault();
                const chipValue = this.value.trim();
                const chipName = this.getAttribute("data-name");
                const chipContainer = this.closest(".md3-chip-input");
                const chipsArea = chipContainer.querySelector(".md3-chip-input__chips");

                // Create new chip
                const newChip = document.createElement("button");
                newChip.className = "md3-chip md3-chip--input";
                newChip.setAttribute("data-value", chipValue);
                newChip.setAttribute("data-name", chipName);
                newChip.type = "button";

                newChip.innerHTML = `
                    <span class="md3-chip__label">${chipValue}</span>
                    <span class="md3-chip__remove">
                        <span class="material-symbols-outlined">close</span>
                    </span>
                `;

                // Add hidden input
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = chipName;
                hiddenInput.value = chipValue;
                chipContainer.appendChild(hiddenInput);

                chipsArea.appendChild(newChip);
                this.value = "";

                // Dispatch add event
                const event = new CustomEvent("md3-chip-add", {
                    detail: {
                        chip: newChip,
                        value: chipValue,
                        name: chipName
                    }
                });
                chipContainer.dispatchEvent(event);
            }
        });
    });

    // Suggestion chip functionality
    document.addEventListener("click", function(e) {
        const suggestionChip = e.target.closest(".md3-chip--suggestion");
        if (suggestionChip) {
            const value = suggestionChip.getAttribute("data-value");

            // Dispatch suggestion event
            const event = new CustomEvent("md3-chip-suggestion", {
                detail: {
                    chip: suggestionChip,
                    value: value
                }
            });
            suggestionChip.dispatchEvent(event);
        }
    });

    // Assist chip functionality
    document.addEventListener("click", function(e) {
        const assistChip = e.target.closest(".md3-chip--assist");
        if (assistChip && !assistChip.getAttribute("href")) {
            const value = assistChip.getAttribute("data-value");

            // Dispatch assist event
            const event = new CustomEvent("md3-chip-assist", {
                detail: {
                    chip: assistChip,
                    value: value
                }
            });
            assistChip.dispatchEvent(event);
        }
    });
});
';
    }
}