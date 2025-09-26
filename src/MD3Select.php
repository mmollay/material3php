<?php

require_once 'MD3.php';

/**
 * MD3Select - Material Design 3 Select Components
 * Generates HTML for Material Web Components select fields
 */
class MD3Select
{
    /**
     * Generate a filled select field
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $options Array of options ['value' => 'label'] or [['value' => 'val', 'label' => 'Label']]
     * @param string $selected Selected value
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-filled-select
     */
    public static function filled(string $name, string $label, array $options = [], string $selected = '', array $attributes = []): string
    {
        $selectId = 'select-' . $name;
        $attributes['id'] = $selectId;

        $selectElement = '<md-filled-select' . MD3::escapeAttributes($attributes) . '>';
        $selectElement .= '<select name="' . htmlspecialchars($name) . '">';

        foreach ($options as $value => $optionLabel) {
            // Handle both simple array and complex array formats
            if (is_array($optionLabel)) {
                $value = $optionLabel['value'] ?? '';
                $optionLabel = $optionLabel['label'] ?? $value;
            }

            $isSelected = ($value == $selected) ? ' selected' : '';
            $selectElement .= '<option value="' . htmlspecialchars($value) . '"' . $isSelected . '>';
            $selectElement .= htmlspecialchars($optionLabel);
            $selectElement .= '</option>';
        }

        $selectElement .= '</select>';
        $selectElement .= '<label for="' . $selectId . '">' . htmlspecialchars($label) . '</label>';
        $selectElement .= '</md-filled-select>';

        return $selectElement;
    }

    /**
     * Generate an outlined select field
     *
     * @param string $name Field name attribute
     * @param string $label Field label
     * @param array $options Array of options
     * @param string $selected Selected value
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-outlined-select
     */
    public static function outlined(string $name, string $label, array $options = [], string $selected = '', array $attributes = []): string
    {
        $selectId = 'select-' . $name;
        $attributes['id'] = $selectId;

        $selectElement = '<md-outlined-select' . MD3::escapeAttributes($attributes) . '>';
        $selectElement .= '<select name="' . htmlspecialchars($name) . '">';

        foreach ($options as $value => $optionLabel) {
            if (is_array($optionLabel)) {
                $value = $optionLabel['value'] ?? '';
                $optionLabel = $optionLabel['label'] ?? $value;
            }

            $isSelected = ($value == $selected) ? ' selected' : '';
            $selectElement .= '<option value="' . htmlspecialchars($value) . '"' . $isSelected . '>';
            $selectElement .= htmlspecialchars($optionLabel);
            $selectElement .= '</option>';
        }

        $selectElement .= '</select>';
        $selectElement .= '<label for="' . $selectId . '">' . htmlspecialchars($label) . '</label>';
        $selectElement .= '</md-outlined-select>';

        return $selectElement;
    }

    /**
     * Generate a select field with icons
     *
     * @param string $name Field name
     * @param string $label Field label
     * @param array $options Array with icons ['value' => ['label' => 'Text', 'icon' => 'icon_name']]
     * @param string $selected Selected value
     * @param bool $outlined Use outlined style
     * @param array $attributes Additional attributes
     * @return string HTML for select with icons
     */
    public static function withIcons(string $name, string $label, array $options = [], string $selected = '', bool $outlined = false, array $attributes = []): string
    {
        $method = $outlined ? 'outlined' : 'filled';

        // Convert options to include icon display
        $processedOptions = [];
        foreach ($options as $value => $option) {
            if (is_array($option)) {
                $icon = isset($option['icon']) ? MD3::icon($option['icon']) . ' ' : '';
                $processedOptions[$value] = $icon . ($option['label'] ?? $value);
            } else {
                $processedOptions[$value] = $option;
            }
        }

        return self::$method($name, $label, $processedOptions, $selected, $attributes);
    }

    /**
     * Generate a multi-select field
     *
     * @param string $name Field name (will have [] appended)
     * @param string $label Field label
     * @param array $options Available options
     * @param array $selected Array of selected values
     * @param bool $outlined Use outlined style
     * @param array $attributes Additional attributes
     * @return string HTML for multi-select
     */
    public static function multiple(string $name, string $label, array $options = [], array $selected = [], bool $outlined = false, array $attributes = []): string
    {
        $attributes['multiple'] = true;
        $fieldName = $name . '[]';

        $selectId = 'select-' . $name;
        $attributes['id'] = $selectId;

        $tag = $outlined ? 'md-outlined-select' : 'md-filled-select';
        $selectElement = '<' . $tag . MD3::escapeAttributes($attributes) . '>';
        $selectElement .= '<select name="' . htmlspecialchars($fieldName) . '" multiple>';

        foreach ($options as $value => $optionLabel) {
            if (is_array($optionLabel)) {
                $value = $optionLabel['value'] ?? '';
                $optionLabel = $optionLabel['label'] ?? $value;
            }

            $isSelected = in_array($value, $selected) ? ' selected' : '';
            $selectElement .= '<option value="' . htmlspecialchars($value) . '"' . $isSelected . '>';
            $selectElement .= htmlspecialchars($optionLabel);
            $selectElement .= '</option>';
        }

        $selectElement .= '</select>';
        $selectElement .= '<label for="' . $selectId . '">' . htmlspecialchars($label) . '</label>';
        $selectElement .= '</' . $tag . '>';

        return $selectElement;
    }

    /**
     * Generate a select field with grouped options
     *
     * @param string $name Field name
     * @param string $label Field label
     * @param array $optionGroups Array of groups ['Group Name' => ['value' => 'label']]
     * @param string $selected Selected value
     * @param bool $outlined Use outlined style
     * @param array $attributes Additional attributes
     * @return string HTML for grouped select
     */
    public static function grouped(string $name, string $label, array $optionGroups = [], string $selected = '', bool $outlined = false, array $attributes = []): string
    {
        $selectId = 'select-' . $name;
        $attributes['id'] = $selectId;

        $tag = $outlined ? 'md-outlined-select' : 'md-filled-select';
        $selectElement = '<' . $tag . MD3::escapeAttributes($attributes) . '>';
        $selectElement .= '<select name="' . htmlspecialchars($name) . '">';

        foreach ($optionGroups as $groupName => $options) {
            $selectElement .= '<optgroup label="' . htmlspecialchars($groupName) . '">';

            foreach ($options as $value => $optionLabel) {
                if (is_array($optionLabel)) {
                    $value = $optionLabel['value'] ?? '';
                    $optionLabel = $optionLabel['label'] ?? $value;
                }

                $isSelected = ($value == $selected) ? ' selected' : '';
                $selectElement .= '<option value="' . htmlspecialchars($value) . '"' . $isSelected . '>';
                $selectElement .= htmlspecialchars($optionLabel);
                $selectElement .= '</option>';
            }

            $selectElement .= '</optgroup>';
        }

        $selectElement .= '</select>';
        $selectElement .= '<label for="' . $selectId . '">' . htmlspecialchars($label) . '</label>';
        $selectElement .= '</' . $tag . '>';

        return $selectElement;
    }

    /**
     * Generate a country select field
     *
     * @param string $name Field name
     * @param string $label Field label
     * @param string $selected Selected country code
     * @param bool $outlined Use outlined style
     * @param array $attributes Additional attributes
     * @return string HTML for country select
     */
    public static function country(string $name, string $label = 'Land', string $selected = 'DE', bool $outlined = false, array $attributes = []): string
    {
        $countries = [
            'DE' => 'Deutschland',
            'AT' => 'Österreich',
            'CH' => 'Schweiz',
            'US' => 'USA',
            'GB' => 'Vereinigtes Königreich',
            'FR' => 'Frankreich',
            'IT' => 'Italien',
            'ES' => 'Spanien',
            'NL' => 'Niederlande',
            'BE' => 'Belgien'
        ];

        $method = $outlined ? 'outlined' : 'filled';
        return self::$method($name, $label, $countries, $selected, $attributes);
    }

    /**
     * Generate JavaScript for select field enhancement
     *
     * @return string JavaScript code for select interactions
     */
    public static function getSelectScript(): string
    {
        return '<script>
            // Enhanced select functionality
            document.addEventListener("DOMContentLoaded", function() {
                const selectFields = document.querySelectorAll("md-filled-select, md-outlined-select");

                selectFields.forEach(function(selectField) {
                    const select = selectField.querySelector("select");
                    if (select) {
                        select.addEventListener("change", function() {
                            // Trigger custom event for select changes
                            selectField.dispatchEvent(new CustomEvent("md-select-change", {
                                detail: { value: this.value, name: this.name }
                            }));
                        });
                    }
                });
            });

            function getSelectValue(selectName) {
                const select = document.querySelector("select[name=\"" + selectName + "\"]");
                return select ? select.value : null;
            }

            function setSelectValue(selectName, value) {
                const select = document.querySelector("select[name=\"" + selectName + "\"]");
                if (select) {
                    select.value = value;
                    select.dispatchEvent(new Event("change"));
                }
            }
        </script>';
    }
}