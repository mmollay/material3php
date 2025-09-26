<?php

require_once 'MD3.php';

/**
 * MD3DateTimePicker - Material Design 3 Date and Time Picker Components
 * Generates functional HTML for Material Design 3 date and time pickers
 */
class MD3DateTimePicker
{
    /**
     * Generate a date picker
     *
     * @param string $name Input name attribute
     * @param array $options Configuration options
     * @return string HTML for date picker
     */
    public static function date(string $name, array $options = []): string
    {
        $options['type'] = 'date';
        return self::renderDateTimePicker($name, $options);
    }

    /**
     * Generate a time picker
     *
     * @param string $name Input name attribute
     * @param array $options Configuration options
     * @return string HTML for time picker
     */
    public static function time(string $name, array $options = []): string
    {
        $options['type'] = 'time';
        return self::renderDateTimePicker($name, $options);
    }

    /**
     * Generate a datetime picker
     *
     * @param string $name Input name attribute
     * @param array $options Configuration options
     * @return string HTML for datetime picker
     */
    public static function dateTime(string $name, array $options = []): string
    {
        $options['type'] = 'datetime';
        return self::renderDateTimePicker($name, $options);
    }

    /**
     * Generate a date range picker
     *
     * @param string $startName Start date input name
     * @param string $endName End date input name
     * @param array $options Configuration options
     * @return string HTML for date range picker
     */
    public static function dateRange(string $startName, string $endName, array $options = []): string
    {
        $options['type'] = 'date-range';
        $options['endName'] = $endName;
        return self::renderDateTimePicker($startName, $options);
    }

    /**
     * Generate a month picker
     *
     * @param string $name Input name attribute
     * @param array $options Configuration options
     * @return string HTML for month picker
     */
    public static function month(string $name, array $options = []): string
    {
        $options['type'] = 'month';
        return self::renderDateTimePicker($name, $options);
    }

    /**
     * Generate a year picker
     *
     * @param string $name Input name attribute
     * @param array $options Configuration options
     * @return string HTML for year picker
     */
    public static function year(string $name, array $options = []): string
    {
        $options['type'] = 'year';
        return self::renderDateTimePicker($name, $options);
    }

    /**
     * Render date/time picker HTML
     */
    private static function renderDateTimePicker(string $name, array $options = []): string
    {
        $id = $options['id'] ?? 'md3-picker-' . uniqid();
        $type = $options['type'] ?? 'date';
        $label = $options['label'] ?? ucfirst($type) . ' Picker';
        $value = $options['value'] ?? '';
        $required = $options['required'] ?? false;
        $disabled = $options['disabled'] ?? false;
        $min = $options['min'] ?? null;
        $max = $options['max'] ?? null;
        $format = $options['format'] ?? self::getDefaultFormat($type);
        $placeholder = $options['placeholder'] ?? $format;
        $endName = $options['endName'] ?? null;

        $containerClasses = ['md3-date-time-picker'];
        $containerClasses[] = 'md3-picker-' . str_replace('_', '-', $type);

        if ($disabled) {
            $containerClasses[] = 'md3-picker-disabled';
        }

        $html = '<div class="' . implode(' ', $containerClasses) . '">';

        // Label
        if ($label) {
            $html .= '<label for="' . $id . '" class="md3-picker-label">';
            $html .= htmlspecialchars($label);
            if ($required) {
                $html .= ' <span class="md3-picker-required">*</span>';
            }
            $html .= '</label>';
        }

        if ($type === 'date-range') {
            $html .= self::renderDateRangeInputs($name, $endName, $id, $options);
        } else {
            $html .= self::renderSingleInput($name, $id, $type, $options);
        }

        // Error message container
        $html .= '<div class="md3-picker-error" id="' . $id . '-error"></div>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Render single input for date/time picker
     */
    private static function renderSingleInput(string $name, string $id, string $type, array $options): string
    {
        $value = $options['value'] ?? '';
        $required = $options['required'] ?? false;
        $disabled = $options['disabled'] ?? false;
        $min = $options['min'] ?? null;
        $max = $options['max'] ?? null;
        $placeholder = $options['placeholder'] ?? '';

        $inputClasses = ['md3-picker-input'];

        $inputAttrs = [
            'type' => 'text',
            'id' => $id,
            'name' => $name,
            'class' => implode(' ', $inputClasses),
            'placeholder' => $placeholder,
            'data-picker-type' => $type,
            'autocomplete' => 'off',
            'readonly' => true
        ];

        if ($value) {
            $inputAttrs['value'] = $value;
        }

        if ($required) {
            $inputAttrs['required'] = true;
        }

        if ($disabled) {
            $inputAttrs['disabled'] = true;
        }

        if ($min) {
            $inputAttrs['data-min'] = $min;
        }

        if ($max) {
            $inputAttrs['data-max'] = $max;
        }

        $html = '<div class="md3-picker-input-container">';
        $html .= '<input' . MD3::escapeAttributes($inputAttrs) . '>';
        $html .= '<button type="button" class="md3-picker-trigger" data-target="' . $id . '">';
        $html .= self::getPickerIcon($type);
        $html .= '</button>';
        $html .= '</div>';

        // Hidden input for form submission
        $hiddenAttrs = [
            'type' => 'hidden',
            'name' => $name,
            'id' => $id . '-hidden',
            'value' => $value
        ];
        $html .= '<input' . MD3::escapeAttributes($hiddenAttrs) . '>';

        return $html;
    }

    /**
     * Render date range inputs
     */
    private static function renderDateRangeInputs(string $startName, string $endName, string $id, array $options): string
    {
        $startValue = $options['startValue'] ?? '';
        $endValue = $options['endValue'] ?? '';
        $required = $options['required'] ?? false;
        $disabled = $options['disabled'] ?? false;
        $placeholder = $options['placeholder'] ?? 'Select date range';

        $inputClasses = ['md3-picker-input', 'md3-picker-range-input'];

        $html = '<div class="md3-picker-range-container">';

        // Start date input
        $startAttrs = [
            'type' => 'text',
            'id' => $id . '-start',
            'name' => $startName,
            'class' => implode(' ', $inputClasses),
            'placeholder' => 'Start date',
            'data-picker-type' => 'date-range',
            'data-range-type' => 'start',
            'autocomplete' => 'off',
            'readonly' => true
        ];

        if ($startValue) {
            $startAttrs['value'] = $startValue;
        }

        if ($required) {
            $startAttrs['required'] = true;
        }

        if ($disabled) {
            $startAttrs['disabled'] = true;
        }

        $html .= '<div class="md3-picker-input-container">';
        $html .= '<input' . MD3::escapeAttributes($startAttrs) . '>';
        $html .= '<button type="button" class="md3-picker-trigger" data-target="' . $id . '-start">';
        $html .= MD3::icon('calendar_month');
        $html .= '</button>';
        $html .= '</div>';

        // Range separator
        $html .= '<div class="md3-picker-range-separator">–</div>';

        // End date input
        $endAttrs = [
            'type' => 'text',
            'id' => $id . '-end',
            'name' => $endName,
            'class' => implode(' ', $inputClasses),
            'placeholder' => 'End date',
            'data-picker-type' => 'date-range',
            'data-range-type' => 'end',
            'autocomplete' => 'off',
            'readonly' => true
        ];

        if ($endValue) {
            $endAttrs['value'] = $endValue;
        }

        if ($required) {
            $endAttrs['required'] = true;
        }

        if ($disabled) {
            $endAttrs['disabled'] = true;
        }

        $html .= '<div class="md3-picker-input-container">';
        $html .= '<input' . MD3::escapeAttributes($endAttrs) . '>';
        $html .= '<button type="button" class="md3-picker-trigger" data-target="' . $id . '-end">';
        $html .= MD3::icon('calendar_month');
        $html .= '</button>';
        $html .= '</div>';

        $html .= '</div>';

        // Hidden inputs for form submission
        $html .= '<input type="hidden" name="' . $startName . '" id="' . $id . '-start-hidden" value="' . $startValue . '">';
        $html .= '<input type="hidden" name="' . $endName . '" id="' . $id . '-end-hidden" value="' . $endValue . '">';

        return $html;
    }

    /**
     * Get default format for picker type
     */
    private static function getDefaultFormat(string $type): string
    {
        switch ($type) {
            case 'date':
                return 'MM/DD/YYYY';
            case 'time':
                return 'HH:MM';
            case 'datetime':
                return 'MM/DD/YYYY HH:MM';
            case 'month':
                return 'MM/YYYY';
            case 'year':
                return 'YYYY';
            default:
                return 'MM/DD/YYYY';
        }
    }

    /**
     * Get icon for picker type
     */
    private static function getPickerIcon(string $type): string
    {
        switch ($type) {
            case 'time':
                return MD3::icon('schedule');
            case 'datetime':
                return MD3::icon('event_note');
            case 'month':
            case 'year':
                return MD3::icon('date_range');
            default:
                return MD3::icon('calendar_month');
        }
    }

    /**
     * Get Date/Time Picker CSS
     */
    public static function getCSS(): string
    {
        return '
/* Material Design 3 Date/Time Picker Component */
.md3-date-time-picker {
    display: flex;
    flex-direction: column;
    gap: 8px;
    width: 100%;
    max-width: 400px;
}

.md3-picker-label {
    font-size: 14px;
    font-weight: 500;
    color: var(--md-sys-color-on-surface);
    margin-bottom: 4px;
}

.md3-picker-required {
    color: var(--md-sys-color-error);
}

.md3-picker-input-container {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--md-sys-color-surface-container-highest);
    border: 1px solid var(--md-sys-color-outline);
    border-radius: 4px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.md3-picker-input-container:focus-within {
    border-color: var(--md-sys-color-primary);
    box-shadow: 0 0 0 2px rgba(var(--md-sys-color-primary-rgb), 0.12);
}

.md3-picker-input {
    flex: 1;
    padding: 16px;
    border: none;
    background: transparent;
    font-size: 16px;
    color: var(--md-sys-color-on-surface);
    outline: none;
    cursor: pointer;
}

.md3-picker-input::placeholder {
    color: var(--md-sys-color-on-surface-variant);
}

.md3-picker-input:disabled {
    color: var(--md-sys-color-on-surface);
    opacity: 0.38;
    cursor: not-allowed;
}

.md3-picker-trigger {
    background: none;
    border: none;
    padding: 12px;
    margin-right: 4px;
    border-radius: 8px;
    color: var(--md-sys-color-on-surface-variant);
    cursor: pointer;
    transition: background-color 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.md3-picker-trigger:hover {
    background-color: var(--md-sys-color-surface-container-high);
}

.md3-picker-trigger:active {
    background-color: var(--md-sys-color-surface-container-highest);
}

/* Date Range Picker */
.md3-picker-range-container {
    display: flex;
    align-items: center;
    gap: 8px;
}

.md3-picker-range-input {
    flex: 1;
}

.md3-picker-range-separator {
    font-weight: 500;
    color: var(--md-sys-color-on-surface-variant);
    padding: 0 4px;
}

/* Error States */
.md3-picker-error {
    font-size: 12px;
    color: var(--md-sys-color-error);
    min-height: 16px;
    margin-top: 4px;
}

.md3-date-time-picker.md3-picker-error .md3-picker-input-container {
    border-color: var(--md-sys-color-error);
}

.md3-date-time-picker.md3-picker-error .md3-picker-input-container:focus-within {
    box-shadow: 0 0 0 2px rgba(var(--md-sys-color-error-rgb), 0.12);
}

/* Disabled State */
.md3-picker-disabled {
    opacity: 0.6;
    pointer-events: none;
}

.md3-picker-disabled .md3-picker-input-container {
    background: var(--md-sys-color-surface-variant);
    border-color: var(--md-sys-color-outline-variant);
}

/* Picker Popup */
.md3-picker-popup {
    position: absolute;
    background: var(--md-sys-color-surface-container);
    border: 1px solid var(--md-sys-color-outline-variant);
    border-radius: 12px;
    box-shadow: var(--md-sys-elevation-3);
    z-index: 1000;
    min-width: 280px;
    max-width: 400px;
    padding: 16px;
}

.md3-picker-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--md-sys-color-outline-variant);
}

.md3-picker-title {
    font-size: 16px;
    font-weight: 500;
    color: var(--md-sys-color-on-surface);
}

.md3-picker-close {
    background: none;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--md-sys-color-on-surface-variant);
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.md3-picker-close:hover {
    background-color: var(--md-sys-color-surface-container-high);
}

/* Calendar Grid */
.md3-picker-calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 4px;
    margin-bottom: 16px;
}

.md3-picker-day-header {
    padding: 8px 4px;
    text-align: center;
    font-size: 12px;
    font-weight: 500;
    color: var(--md-sys-color-on-surface-variant);
}

.md3-picker-day {
    padding: 8px 4px;
    text-align: center;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.2s ease;
    font-size: 14px;
    color: var(--md-sys-color-on-surface);
}

.md3-picker-day:hover {
    background-color: var(--md-sys-color-surface-container-high);
}

.md3-picker-day.selected {
    background-color: var(--md-sys-color-primary);
    color: var(--md-sys-color-on-primary);
}

.md3-picker-day.today {
    border: 1px solid var(--md-sys-color-primary);
}

.md3-picker-day.disabled {
    color: var(--md-sys-color-on-surface);
    opacity: 0.38;
    cursor: not-allowed;
}

/* Time Picker */
.md3-time-picker {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
}

.md3-time-input {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.md3-time-value {
    font-size: 24px;
    font-weight: 500;
    color: var(--md-sys-color-on-surface);
    min-width: 40px;
    text-align: center;
}

.md3-time-controls {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.md3-time-btn {
    background: none;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--md-sys-color-on-surface-variant);
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.md3-time-btn:hover {
    background-color: var(--md-sys-color-surface-container-high);
}

/* Actions */
.md3-picker-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--md-sys-color-outline-variant);
}

/* Responsive */
@media (max-width: 480px) {
    .md3-picker-popup {
        max-width: 90vw;
        margin: 16px;
    }

    .md3-picker-range-container {
        flex-direction: column;
        gap: 12px;
    }

    .md3-picker-range-separator {
        transform: rotate(90deg);
    }
}

/* Dark Theme Support */
[data-theme="dark"] .md3-picker-popup {
    background: var(--md-sys-color-surface-container);
    border-color: var(--md-sys-color-outline);
}
';
    }

    /**
     * Get Date/Time Picker JavaScript
     */
    public static function getJS(): string
    {
        return '
// Date/Time Picker Management
class MD3DateTimePickerManager {
    constructor() {
        this.activePickerIds = new Set();
        this.init();
    }

    init() {
        document.addEventListener("click", this.handleTriggerClick.bind(this));
        document.addEventListener("click", this.handleOutsideClick.bind(this));
        document.addEventListener("keydown", this.handleKeyDown.bind(this));
    }

    handleTriggerClick(e) {
        const trigger = e.target.closest(".md3-picker-trigger");
        if (!trigger) return;

        e.preventDefault();
        e.stopPropagation();

        const targetId = trigger.dataset.target;
        const input = document.getElementById(targetId);
        if (!input) return;

        const pickerType = input.dataset.pickerType;
        this.openPicker(input, pickerType);
    }

    handleOutsideClick(e) {
        if (e.target.closest(".md3-picker-popup")) return;

        this.closeAllPickers();
    }

    handleKeyDown(e) {
        if (e.key === "Escape") {
            this.closeAllPickers();
        }
    }

    openPicker(input, type) {
        // Close any existing pickers
        this.closeAllPickers();

        const popup = this.createPickerPopup(input, type);
        document.body.appendChild(popup);
        this.positionPopup(popup, input);

        this.activePickerIds.add(input.id);

        // Focus management
        const firstFocusable = popup.querySelector("button, [tabindex]:not([tabindex=\"-1\"])");
        if (firstFocusable) {
            firstFocusable.focus();
        }

        // Initialize picker based on type
        switch (type) {
            case "date":
            case "date-range":
                this.initDatePicker(popup, input, type);
                break;
            case "time":
                this.initTimePicker(popup, input);
                break;
            case "datetime":
                this.initDateTimePicker(popup, input);
                break;
            case "month":
                this.initMonthPicker(popup, input);
                break;
            case "year":
                this.initYearPicker(popup, input);
                break;
        }
    }

    createPickerPopup(input, type) {
        const popup = document.createElement("div");
        popup.className = "md3-picker-popup";
        popup.innerHTML = `
            <div class="md3-picker-header">
                <span class="md3-picker-title">' + this.getPickerTitle(type) + '</span>
                <button class="md3-picker-close" type="button">×</button>
            </div>
            <div class="md3-picker-content"></div>
            <div class="md3-picker-actions">
                <button class="md3-button md3-button-text md3-picker-cancel">Cancel</button>
                <button class="md3-button md3-button-filled md3-picker-ok">OK</button>
            </div>
        `;

        // Add event listeners
        popup.querySelector(".md3-picker-close").addEventListener("click", () => {
            this.closePicker(popup);
        });

        popup.querySelector(".md3-picker-cancel").addEventListener("click", () => {
            this.closePicker(popup);
        });

        popup.querySelector(".md3-picker-ok").addEventListener("click", () => {
            this.applySelection(popup, input);
        });

        return popup;
    }

    initDatePicker(popup, input, type) {
        const content = popup.querySelector(".md3-picker-content");
        const today = new Date();
        const currentDate = input.value ? new Date(input.value) : today;

        const calendar = this.createCalendar(currentDate, today);
        content.appendChild(calendar);

        // Store selected date
        popup.selectedDate = currentDate;
    }

    initTimePicker(popup, input) {
        const content = popup.querySelector(".md3-picker-content");
        const currentTime = input.value ? input.value.split(":") : ["12", "00"];

        const timePicker = document.createElement("div");
        timePicker.className = "md3-time-picker";
        timePicker.innerHTML = `
            <div class="md3-time-input">
                <div class="md3-time-controls">
                    <button class="md3-time-btn" data-action="hour-up">▲</button>
                </div>
                <div class="md3-time-value" data-time="hour">' + currentTime[0] + '</div>
                <div class="md3-time-controls">
                    <button class="md3-time-btn" data-action="hour-down">▼</button>
                </div>
            </div>
            <div class="md3-time-separator">:</div>
            <div class="md3-time-input">
                <div class="md3-time-controls">
                    <button class="md3-time-btn" data-action="minute-up">▲</button>
                </div>
                <div class="md3-time-value" data-time="minute">' + currentTime[1] + '</div>
                <div class="md3-time-controls">
                    <button class="md3-time-btn" data-action="minute-down">▼</button>
                </div>
            </div>
        `;

        content.appendChild(timePicker);

        // Add time controls
        timePicker.addEventListener("click", (e) => {
            const action = e.target.dataset.action;
            if (!action) return;

            const [type, direction] = action.split("-");
            this.adjustTime(timePicker, type, direction);
        });

        popup.selectedTime = { hour: currentTime[0], minute: currentTime[1] };
    }

    createCalendar(date, today) {
        const calendar = document.createElement("div");
        calendar.className = "md3-picker-calendar";

        // Day headers
        const dayHeaders = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
        dayHeaders.forEach(day => {
            const header = document.createElement("div");
            header.className = "md3-picker-day-header";
            header.textContent = day;
            calendar.appendChild(header);
        });

        // Calendar days
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());

        for (let i = 0; i < 42; i++) {
            const currentDate = new Date(startDate);
            currentDate.setDate(startDate.getDate() + i);

            const dayElement = document.createElement("div");
            dayElement.className = "md3-picker-day";
            dayElement.textContent = currentDate.getDate();
            dayElement.dataset.date = currentDate.toISOString().split("T")[0];

            if (currentDate.getMonth() !== month) {
                dayElement.classList.add("disabled");
            }

            if (currentDate.toDateString() === today.toDateString()) {
                dayElement.classList.add("today");
            }

            if (currentDate.toDateString() === date.toDateString()) {
                dayElement.classList.add("selected");
            }

            dayElement.addEventListener("click", () => {
                calendar.querySelectorAll(".md3-picker-day").forEach(d => {
                    d.classList.remove("selected");
                });
                dayElement.classList.add("selected");
                calendar.parentNode.parentNode.selectedDate = currentDate;
            });

            calendar.appendChild(dayElement);
        }

        return calendar;
    }

    adjustTime(timePicker, type, direction) {
        const valueElement = timePicker.querySelector(`[data-time="' + type + '"]`);
        let currentValue = parseInt(valueElement.textContent);

        if (type === "hour") {
            if (direction === "up") {
                currentValue = (currentValue + 1) % 24;
            } else {
                currentValue = (currentValue - 1 + 24) % 24;
            }
        } else if (type === "minute") {
            if (direction === "up") {
                currentValue = (currentValue + 1) % 60;
            } else {
                currentValue = (currentValue - 1 + 60) % 60;
            }
        }

        valueElement.textContent = currentValue.toString().padStart(2, "0");

        // Update stored time
        const popup = timePicker.closest(".md3-picker-popup");
        popup.selectedTime[type] = currentValue.toString().padStart(2, "0");
    }

    applySelection(popup, input) {
        const pickerType = input.dataset.pickerType;

        switch (pickerType) {
            case "date":
                if (popup.selectedDate) {
                    const dateStr = popup.selectedDate.toISOString().split("T")[0];
                    const formatted = this.formatDate(popup.selectedDate, "MM/DD/YYYY");
                    input.value = formatted;
                    input.nextElementSibling.value = dateStr;
                }
                break;
            case "time":
                if (popup.selectedTime) {
                    const timeStr = `' + popup.selectedTime.hour + ':' + popup.selectedTime.minute + '`;
                    input.value = timeStr;
                    input.nextElementSibling.value = timeStr;
                }
                break;
        }

        // Trigger change event
        input.dispatchEvent(new Event("change", { bubbles: true }));

        this.closePicker(popup);
    }

    formatDate(date, format) {
        const month = (date.getMonth() + 1).toString().padStart(2, "0");
        const day = date.getDate().toString().padStart(2, "0");
        const year = date.getFullYear();

        return format
            .replace("MM", month)
            .replace("DD", day)
            .replace("YYYY", year);
    }

    getPickerTitle(type) {
        switch (type) {
            case "date": return "Select Date";
            case "time": return "Select Time";
            case "datetime": return "Select Date & Time";
            case "date-range": return "Select Date Range";
            case "month": return "Select Month";
            case "year": return "Select Year";
            default: return "Select";
        }
    }

    positionPopup(popup, input) {
        const rect = input.getBoundingClientRect();
        const popupRect = popup.getBoundingClientRect();

        let top = rect.bottom + window.scrollY + 4;
        let left = rect.left + window.scrollX;

        // Adjust if popup goes off screen
        if (left + popupRect.width > window.innerWidth) {
            left = window.innerWidth - popupRect.width - 16;
        }

        if (top + popupRect.height > window.innerHeight + window.scrollY) {
            top = rect.top + window.scrollY - popupRect.height - 4;
        }

        popup.style.position = "absolute";
        popup.style.top = top + "px";
        popup.style.left = left + "px";
    }

    closePicker(popup) {
        popup.remove();
    }

    closeAllPickers() {
        document.querySelectorAll(".md3-picker-popup").forEach(popup => {
            popup.remove();
        });
        this.activePickerIds.clear();
    }
}

// Initialize Date/Time Picker Manager
document.addEventListener("DOMContentLoaded", function() {
    new MD3DateTimePickerManager();
});

// Export for manual control
window.MD3DateTimePicker = {
    open: function(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            const manager = new MD3DateTimePickerManager();
            manager.openPicker(input, input.dataset.pickerType);
        }
    }
};
';
    }
}