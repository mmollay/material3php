<?php

require_once 'MD3.php';

/**
 * MD3Chip - Material Design 3 Chip Components
 * Generates HTML for Material Web Components chips
 */
class MD3Chip
{
    /**
     * Generate a basic assist chip
     *
     * @param string $label Chip label text
     * @param string $icon Optional leading icon
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-assist-chip
     */
    public static function assist(string $label, string $icon = '', array $attributes = []): string
    {
        $content = '';
        if ($icon) {
            $content .= '<div slot="icon">' . MD3::icon($icon) . '</div>';
        }
        $content .= htmlspecialchars($label);

        return '<md-assist-chip' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-assist-chip>';
    }

    /**
     * Generate a filter chip
     *
     * @param string $label Chip label text
     * @param string $value Chip value for form submission
     * @param string $name Form field name
     * @param bool $selected Whether chip is initially selected
     * @param string $icon Optional leading icon
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filter-chip
     */
    public static function filter(string $label, string $value, string $name, bool $selected = false, string $icon = '', array $attributes = []): string
    {
        if ($selected) {
            $attributes['selected'] = true;
        }

        $attributes['data-value'] = $value;
        $attributes['data-name'] = $name;
        $attributes['onclick'] = 'toggleFilterChip(this)';

        $content = '';
        if ($icon) {
            $content .= '<div slot="icon">' . MD3::icon($icon) . '</div>';
        }
        $content .= htmlspecialchars($label);

        // Hidden input for form submission
        $hiddenInput = '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' .
                      ($selected ? htmlspecialchars($value) : '') . '" id="hidden-' . htmlspecialchars($name . '-' . $value) . '">';

        return $hiddenInput . '<md-filter-chip' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-filter-chip>';
    }

    /**
     * Generate an input chip (for user-generated content)
     *
     * @param string $label Chip label text
     * @param string $value Chip value
     * @param string $name Form field name
     * @param string $icon Optional leading icon
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-input-chip
     */
    public static function input(string $label, string $value = '', string $name = '', string $icon = '', array $attributes = []): string
    {
        $attributes['data-value'] = $value ?: $label;
        if ($name) {
            $attributes['data-name'] = $name;
        }

        $content = '';
        if ($icon) {
            $content .= '<div slot="icon">' . MD3::icon($icon) . '</div>';
        }
        $content .= htmlspecialchars($label);

        // Remove button
        $content .= '<div slot="remove-trailing-icon">' . MD3::icon('close') . '</div>';

        return '<md-input-chip' . MD3::escapeAttributes($attributes) . ' removable>' . $content . '</md-input-chip>';
    }

    /**
     * Generate a suggestion chip
     *
     * @param string $label Chip label text
     * @param string $value Chip value when selected
     * @param string $icon Optional leading icon
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-suggestion-chip
     */
    public static function suggestion(string $label, string $value = '', string $icon = '', array $attributes = []): string
    {
        $attributes['data-value'] = $value ?: $label;
        $attributes['onclick'] = 'selectSuggestionChip(this)';

        $content = '';
        if ($icon) {
            $content .= '<div slot="icon">' . MD3::icon($icon) . '</div>';
        }
        $content .= htmlspecialchars($label);

        return '<md-suggestion-chip' . MD3::escapeAttributes($attributes) . '>' . $content . '</md-suggestion-chip>';
    }

    /**
     * Generate a chip set (container for multiple chips)
     *
     * @param array $chips Array of chip HTML strings
     * @param string $type Chip set type ('filter', 'input', 'suggestion')
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-chip-set
     */
    public static function set(array $chips, string $type = 'filter', array $attributes = []): string
    {
        if (empty($chips)) {
            return '<md-chip-set' . MD3::escapeAttributes($attributes) . '></md-chip-set>';
        }

        $attributes['data-type'] = $type;

        return '<md-chip-set' . MD3::escapeAttributes($attributes) . '>' . implode('', $chips) . '</md-chip-set>';
    }

    /**
     * Generate multiple filter chips from array
     *
     * @param array $options Array of chip options ['label', 'value', 'selected', 'icon']
     * @param string $name Form field name
     * @param array $attributes Additional HTML attributes for chip set
     * @return string HTML for filter chip set
     */
    public static function filterSet(array $options, string $name, array $attributes = []): string
    {
        $chips = [];

        foreach ($options as $option) {
            $label = $option['label'] ?? $option['value'] ?? '';
            $value = $option['value'] ?? $label;
            $selected = $option['selected'] ?? false;
            $icon = $option['icon'] ?? '';

            $chips[] = self::filter($label, $value, $name, $selected, $icon);
        }

        return self::set($chips, 'filter', $attributes);
    }

    /**
     * Generate multiple assist chips from array
     *
     * @param array $options Array of chip options ['label', 'icon', 'onclick']
     * @param array $attributes Additional HTML attributes for chip set
     * @return string HTML for assist chip set
     */
    public static function assistSet(array $options, array $attributes = []): string
    {
        $chips = [];

        foreach ($options as $option) {
            $label = $option['label'] ?? '';
            $icon = $option['icon'] ?? '';
            $chipAttributes = [];

            if (isset($option['onclick'])) {
                $chipAttributes['onclick'] = $option['onclick'];
            }
            if (isset($option['href'])) {
                $chipAttributes['href'] = $option['href'];
            }

            $chips[] = self::assist($label, $icon, $chipAttributes);
        }

        return self::set($chips, 'assist', $attributes);
    }

    /**
     * Generate chip input field (for creating new chips)
     *
     * @param string $name Form field name
     * @param string $placeholder Placeholder text
     * @param array $existingChips Array of existing chip values
     * @param array $attributes Additional HTML attributes
     * @return string HTML for chip input field
     */
    public static function inputField(string $name, string $placeholder = 'Neuen Tag hinzufügen...', array $existingChips = [], array $attributes = []): string
    {
        $fieldId = 'chip-input-' . $name;
        $containerClass = 'chip-input-container';

        $html = '<div class="' . $containerClass . '">';

        // Existing chips
        if (!empty($existingChips)) {
            $html .= '<div class="existing-chips">';
            foreach ($existingChips as $chip) {
                $html .= self::input($chip, $chip, $name);
            }
            $html .= '</div>';
        }

        // Input field
        $inputAttrs = array_merge([
            'type' => 'text',
            'id' => $fieldId,
            'placeholder' => $placeholder,
            'onkeypress' => 'handleChipInput(event, this)'
        ], $attributes);

        $html .= '<input' . MD3::escapeAttributes($inputAttrs) . '>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Generate JavaScript for chip functionality
     *
     * @return string JavaScript code for chip interactions
     */
    public static function getChipScript(): string
    {
        return '<script>
            function toggleFilterChip(chip) {
                const value = chip.getAttribute("data-value");
                const name = chip.getAttribute("data-name");
                const hiddenInput = document.getElementById("hidden-" + name + "-" + value);

                if (chip.hasAttribute("selected")) {
                    chip.removeAttribute("selected");
                    hiddenInput.value = "";
                } else {
                    chip.setAttribute("selected", "");
                    hiddenInput.value = value;
                }
            }

            function selectSuggestionChip(chip) {
                const value = chip.getAttribute("data-value");
                console.log("Selected suggestion:", value);
                // Implement your suggestion selection logic here
            }

            function handleChipInput(event, input) {
                if (event.key === "Enter" && input.value.trim() !== "") {
                    const chipValue = input.value.trim();
                    const chipName = input.name || "chips";

                    // Create new chip
                    const chipContainer = input.closest(".chip-input-container");
                    let existingChips = chipContainer.querySelector(".existing-chips");

                    if (!existingChips) {
                        existingChips = document.createElement("div");
                        existingChips.className = "existing-chips";
                        chipContainer.insertBefore(existingChips, input);
                    }

                    // Add the new chip (simplified HTML creation)
                    const newChip = document.createElement("md-input-chip");
                    newChip.setAttribute("removable", "");
                    newChip.setAttribute("data-value", chipValue);
                    newChip.innerHTML = chipValue + "<div slot=\"remove-trailing-icon\"><span class=\"material-symbols-outlined\">close</span></div>";

                    existingChips.appendChild(newChip);

                    // Clear input
                    input.value = "";

                    event.preventDefault();
                }
            }

            // Remove chip functionality
            document.addEventListener("click", function(e) {
                if (e.target.closest("md-input-chip [slot=\"remove-trailing-icon\"]")) {
                    const chip = e.target.closest("md-input-chip");
                    if (chip) {
                        chip.remove();
                    }
                }
            });
        </script>';
    }
}