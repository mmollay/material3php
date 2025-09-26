<?php

/**
 * MD3 - Material Design 3 Library for PHP
 * Central class for resource management and initialization
 */
class MD3
{
    private static $initialized = false;
    private static $version = null;

    /**
     * Initialize Material Design 3 resources
     * Pure CSS implementation ohne externe CDN-Abhängigkeiten
     *
     * @param bool $includeRipple Whether to include ripple effects (default: true)
     * @param bool $includeIcons Whether to include Material Icons (default: true)
     * @param string $theme Theme name (default, ocean, forest, sunset, minimal)
     * @return string HTML for resource includes
     */
    public static function init(bool $includeRipple = true, bool $includeIcons = true, string $theme = 'default'): string
    {
        if (self::$initialized) {
            return '';
        }

        self::$initialized = true;

        $html = [];

        // Material Icons (nur diese externe Abhängigkeit)
        if ($includeIcons) {
            $html[] = '<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">';
        }

        // Vollständiges Material Design 3 CSS
        $html[] = '<style>';

        // Get theme colors
        $themeColors = self::getThemeColors($theme);

        // Material Design 3 Tokens
        $html[] = ':root {';
        $html[] = '  color-scheme: light dark;';
        foreach ($themeColors['light'] as $token => $color) {
            $html[] = "  --md-sys-color-{$token}: {$color};";
        }
        $html[] = '}';

        // Dark theme
        $html[] = '[data-theme="dark"], @media (prefers-color-scheme: dark) {';
        $html[] = '  :root:not([data-theme="light"]) {';
        foreach ($themeColors['dark'] as $token => $color) {
            $html[] = "    --md-sys-color-{$token}: {$color};";
        }
        $html[] = '  }';
        $html[] = '}';

        // Base styling
        $html[] = 'body {';
        $html[] = '  font-family: "Roboto", system-ui, sans-serif;';
        $html[] = '  margin: 0;';
        $html[] = '  padding: 16px;';
        $html[] = '  background-color: var(--md-sys-color-background);';
        $html[] = '  color: var(--md-sys-color-on-background);';
        $html[] = '}';

        // Custom Element Reset (wichtig!)
        $html[] = 'md-filled-button, md-outlined-button, md-text-button, md-elevated-button, md-filled-tonal-button,';
        $html[] = 'md-icon-button, md-filled-icon-button, md-filled-tonal-icon-button, md-outlined-icon-button,';
        $html[] = 'md-fab, md-filled-text-field, md-outlined-text-field, md-elevated-card, md-filled-card, md-outlined-card,';
        $html[] = 'md-list, md-list-item, md-divider, md-chip-set, md-assist-chip, md-filter-chip, md-input-chip, md-suggestion-chip,';
        $html[] = 'md-tooltip, md-switch, md-checkbox, md-radio, md-filled-select, md-outlined-select {';
        $html[] = '  display: block;';
        $html[] = '}';

        // Button Base Styles
        $html[] = 'md-filled-button, md-outlined-button, md-text-button, md-elevated-button, md-filled-tonal-button {';
        $html[] = '  display: inline-flex;';
        $html[] = '  align-items: center;';
        $html[] = '  justify-content: center;';
        $html[] = '  height: 40px;';
        $html[] = '  padding: 0 24px;';
        $html[] = '  border-radius: 20px;';
        $html[] = '  font-family: inherit;';
        $html[] = '  font-size: 14px;';
        $html[] = '  font-weight: 500;';
        $html[] = '  letter-spacing: 0.1px;';
        $html[] = '  text-decoration: none;';
        $html[] = '  border: none;';
        $html[] = '  cursor: pointer;';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '  position: relative;';
        $html[] = '  overflow: hidden;';
        $html[] = '}';

        // Filled Button
        $html[] = 'md-filled-button {';
        $html[] = '  background-color: var(--md-sys-color-primary);';
        $html[] = '  color: var(--md-sys-color-on-primary);';
        $html[] = '}';
        $html[] = 'md-filled-button:hover {';
        $html[] = '  box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.3), 0px 1px 3px 1px rgba(0, 0, 0, 0.15);';
        $html[] = '}';

        // Outlined Button
        $html[] = 'md-outlined-button {';
        $html[] = '  background-color: transparent;';
        $html[] = '  color: var(--md-sys-color-primary);';
        $html[] = '  border: 1px solid var(--md-sys-color-outline);';
        $html[] = '}';
        $html[] = 'md-outlined-button:hover {';
        $html[] = '  background-color: rgba(103, 80, 164, 0.08);';
        $html[] = '}';

        // Text Button
        $html[] = 'md-text-button {';
        $html[] = '  background-color: transparent;';
        $html[] = '  color: var(--md-sys-color-primary);';
        $html[] = '  padding: 0 12px;';
        $html[] = '}';
        $html[] = 'md-text-button:hover {';
        $html[] = '  background-color: rgba(103, 80, 164, 0.08);';
        $html[] = '}';

        // Elevated Button
        $html[] = 'md-elevated-button {';
        $html[] = '  background-color: var(--md-sys-color-surface-container);';
        $html[] = '  color: var(--md-sys-color-primary);';
        $html[] = '  box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.3), 0px 1px 3px 1px rgba(0, 0, 0, 0.15);';
        $html[] = '}';
        $html[] = 'md-elevated-button:hover {';
        $html[] = '  box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.3), 0px 4px 8px 3px rgba(0, 0, 0, 0.15);';
        $html[] = '}';

        // Tonal Button
        $html[] = 'md-filled-tonal-button {';
        $html[] = '  background-color: var(--md-sys-color-secondary-container);';
        $html[] = '  color: var(--md-sys-color-on-secondary-container);';
        $html[] = '}';
        $html[] = 'md-filled-tonal-button:hover {';
        $html[] = '  box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.3), 0px 1px 3px 1px rgba(0, 0, 0, 0.15);';
        $html[] = '}';

        // Icon Buttons
        $html[] = 'md-icon-button, md-filled-icon-button, md-filled-tonal-icon-button, md-outlined-icon-button {';
        $html[] = '  display: inline-flex;';
        $html[] = '  align-items: center;';
        $html[] = '  justify-content: center;';
        $html[] = '  width: 48px;';
        $html[] = '  height: 48px;';
        $html[] = '  border-radius: 50%;';
        $html[] = '  border: none;';
        $html[] = '  cursor: pointer;';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '}';

        $html[] = 'md-icon-button {';
        $html[] = '  background-color: transparent;';
        $html[] = '  color: var(--md-sys-color-on-surface-variant);';
        $html[] = '}';
        $html[] = 'md-icon-button:hover {';
        $html[] = '  background-color: rgba(73, 69, 79, 0.08);';
        $html[] = '}';

        $html[] = 'md-filled-icon-button {';
        $html[] = '  background-color: var(--md-sys-color-primary);';
        $html[] = '  color: var(--md-sys-color-on-primary);';
        $html[] = '}';

        $html[] = 'md-filled-tonal-icon-button {';
        $html[] = '  background-color: var(--md-sys-color-secondary-container);';
        $html[] = '  color: var(--md-sys-color-on-secondary-container);';
        $html[] = '}';

        $html[] = 'md-outlined-icon-button {';
        $html[] = '  background-color: transparent;';
        $html[] = '  color: var(--md-sys-color-on-surface-variant);';
        $html[] = '  border: 1px solid var(--md-sys-color-outline);';
        $html[] = '}';

        // FAB
        $html[] = 'md-fab {';
        $html[] = '  display: inline-flex;';
        $html[] = '  align-items: center;';
        $html[] = '  justify-content: center;';
        $html[] = '  width: 56px;';
        $html[] = '  height: 56px;';
        $html[] = '  border-radius: 16px;';
        $html[] = '  background-color: var(--md-sys-color-primary-container);';
        $html[] = '  color: var(--md-sys-color-on-primary-container);';
        $html[] = '  border: none;';
        $html[] = '  cursor: pointer;';
        $html[] = '  box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.3), 0px 4px 8px 3px rgba(0, 0, 0, 0.15);';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '}';
        $html[] = 'md-fab:hover {';
        $html[] = '  box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.3), 0px 4px 12px 6px rgba(0, 0, 0, 0.15);';
        $html[] = '}';

        // Text Fields
        $html[] = 'md-filled-text-field, md-outlined-text-field {';
        $html[] = '  display: flex;';
        $html[] = '  flex-direction: column;';
        $html[] = '  position: relative;';
        $html[] = '  width: 100%;';
        $html[] = '  min-width: 200px;';
        $html[] = '}';

        $html[] = 'md-filled-text-field input, md-filled-text-field textarea,';
        $html[] = 'md-outlined-text-field input, md-outlined-text-field textarea {';
        $html[] = '  font-family: inherit;';
        $html[] = '  font-size: 16px;';
        $html[] = '  padding: 16px;';
        $html[] = '  border: none;';
        $html[] = '  outline: none;';
        $html[] = '  background: transparent;';
        $html[] = '  color: var(--md-sys-color-on-surface);';
        $html[] = '}';

        // Filled Text Field
        $html[] = 'md-filled-text-field {';
        $html[] = '  background-color: var(--md-sys-color-surface-container-high);';
        $html[] = '  border-radius: 4px 4px 0 0;';
        $html[] = '  border-bottom: 1px solid var(--md-sys-color-on-surface-variant);';
        $html[] = '}';
        $html[] = 'md-filled-text-field:focus-within {';
        $html[] = '  border-bottom: 2px solid var(--md-sys-color-primary);';
        $html[] = '}';

        // Outlined Text Field
        $html[] = 'md-outlined-text-field {';
        $html[] = '  border: 1px solid var(--md-sys-color-outline);';
        $html[] = '  border-radius: 4px;';
        $html[] = '}';
        $html[] = 'md-outlined-text-field:focus-within {';
        $html[] = '  border: 2px solid var(--md-sys-color-primary);';
        $html[] = '}';

        // Cards
        $html[] = 'md-elevated-card, md-filled-card, md-outlined-card {';
        $html[] = '  display: block;';
        $html[] = '  border-radius: 12px;';
        $html[] = '  overflow: hidden;';
        $html[] = '}';

        $html[] = 'md-elevated-card {';
        $html[] = '  background: var(--md-sys-color-surface-container-lowest);';
        $html[] = '  box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.3), 0px 1px 3px 1px rgba(0, 0, 0, 0.15);';
        $html[] = '}';

        $html[] = 'md-outlined-card {';
        $html[] = '  background: var(--md-sys-color-surface);';
        $html[] = '  border: 1px solid var(--md-sys-color-outline-variant);';
        $html[] = '}';

        $html[] = 'md-filled-card {';
        $html[] = '  background: var(--md-sys-color-surface-container);';
        $html[] = '}';

        // Dialog
        $html[] = 'md-dialog {';
        $html[] = '  position: fixed;';
        $html[] = '  top: 50%;';
        $html[] = '  left: 50%;';
        $html[] = '  transform: translate(-50%, -50%);';
        $html[] = '  background: var(--md-sys-color-surface-container-high);';
        $html[] = '  border-radius: 28px;';
        $html[] = '  padding: 24px;';
        $html[] = '  min-width: 280px;';
        $html[] = '  max-width: 560px;';
        $html[] = '  box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.3), 0px 4px 8px 3px rgba(0, 0, 0, 0.15);';
        $html[] = '  z-index: 1000;';
        $html[] = '  display: none;';
        $html[] = '}';
        $html[] = 'md-dialog[open] {';
        $html[] = '  display: block;';
        $html[] = '}';

        // Lists
        $html[] = 'md-list {';
        $html[] = '  background: var(--md-sys-color-surface);';
        $html[] = '  border-radius: 8px;';
        $html[] = '  padding: 8px 0;';
        $html[] = '}';

        $html[] = 'md-list-item {';
        $html[] = '  display: flex;';
        $html[] = '  align-items: center;';
        $html[] = '  min-height: 48px;';
        $html[] = '  padding: 8px 16px;';
        $html[] = '  cursor: pointer;';
        $html[] = '  transition: background-color 0.2s ease;';
        $html[] = '}';
        $html[] = 'md-list-item:hover {';
        $html[] = '  background-color: var(--md-sys-color-surface-container);';
        $html[] = '}';

        $html[] = 'md-divider {';
        $html[] = '  height: 1px;';
        $html[] = '  background-color: var(--md-sys-color-outline-variant);';
        $html[] = '  margin: 8px 16px;';
        $html[] = '}';

        // Chips
        $html[] = 'md-chip-set {';
        $html[] = '  display: flex;';
        $html[] = '  flex-wrap: wrap;';
        $html[] = '  gap: 8px;';
        $html[] = '}';

        $html[] = 'md-assist-chip, md-filter-chip, md-input-chip, md-suggestion-chip {';
        $html[] = '  display: inline-flex;';
        $html[] = '  align-items: center;';
        $html[] = '  height: 32px;';
        $html[] = '  padding: 0 16px;';
        $html[] = '  border-radius: 8px;';
        $html[] = '  font-size: 14px;';
        $html[] = '  font-weight: 500;';
        $html[] = '  cursor: pointer;';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '}';

        $html[] = 'md-assist-chip {';
        $html[] = '  background-color: var(--md-sys-color-surface-container);';
        $html[] = '  color: var(--md-sys-color-on-surface);';
        $html[] = '  border: 1px solid var(--md-sys-color-outline);';
        $html[] = '}';

        $html[] = 'md-filter-chip {';
        $html[] = '  background-color: var(--md-sys-color-surface-container);';
        $html[] = '  color: var(--md-sys-color-on-surface);';
        $html[] = '  border: 1px solid var(--md-sys-color-outline);';
        $html[] = '}';
        $html[] = 'md-filter-chip[selected] {';
        $html[] = '  background-color: var(--md-sys-color-secondary-container);';
        $html[] = '  color: var(--md-sys-color-on-secondary-container);';
        $html[] = '}';

        $html[] = 'md-input-chip {';
        $html[] = '  background-color: var(--md-sys-color-surface-container-high);';
        $html[] = '  color: var(--md-sys-color-on-surface);';
        $html[] = '}';

        // Form Controls - Use actual HTML form elements with MD3 styling
        $html[] = '.switch-container, .checkbox-container, .radio-container {';
        $html[] = '  display: flex;';
        $html[] = '  align-items: center;';
        $html[] = '  gap: 12px;';
        $html[] = '  margin: 8px 0;';
        $html[] = '}';

        $html[] = '.switch-container label, .checkbox-container label, .radio-container label {';
        $html[] = '  font-size: 14px;';
        $html[] = '  color: var(--md-sys-color-on-surface);';
        $html[] = '  cursor: pointer;';
        $html[] = '}';

        // Switch styling
        $html[] = 'input[type="checkbox"].md-switch {';
        $html[] = '  appearance: none;';
        $html[] = '  width: 52px;';
        $html[] = '  height: 32px;';
        $html[] = '  background-color: var(--md-sys-color-surface-container-high);';
        $html[] = '  border-radius: 16px;';
        $html[] = '  border: 2px solid var(--md-sys-color-outline);';
        $html[] = '  position: relative;';
        $html[] = '  cursor: pointer;';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '}';

        $html[] = 'input[type="checkbox"].md-switch:checked {';
        $html[] = '  background-color: var(--md-sys-color-primary);';
        $html[] = '  border-color: var(--md-sys-color-primary);';
        $html[] = '}';

        $html[] = 'input[type="checkbox"].md-switch::before {';
        $html[] = '  content: "";';
        $html[] = '  position: absolute;';
        $html[] = '  width: 20px;';
        $html[] = '  height: 20px;';
        $html[] = '  border-radius: 50%;';
        $html[] = '  background-color: var(--md-sys-color-outline);';
        $html[] = '  top: 4px;';
        $html[] = '  left: 4px;';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '}';

        $html[] = 'input[type="checkbox"].md-switch:checked::before {';
        $html[] = '  background-color: var(--md-sys-color-on-primary);';
        $html[] = '  transform: translateX(20px);';
        $html[] = '}';

        // Checkbox styling
        $html[] = 'input[type="checkbox"].md-checkbox {';
        $html[] = '  appearance: none;';
        $html[] = '  width: 18px;';
        $html[] = '  height: 18px;';
        $html[] = '  border: 2px solid var(--md-sys-color-outline);';
        $html[] = '  border-radius: 2px;';
        $html[] = '  background-color: transparent;';
        $html[] = '  cursor: pointer;';
        $html[] = '  position: relative;';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '}';

        $html[] = 'input[type="checkbox"].md-checkbox:checked {';
        $html[] = '  background-color: var(--md-sys-color-primary);';
        $html[] = '  border-color: var(--md-sys-color-primary);';
        $html[] = '}';

        $html[] = 'input[type="checkbox"].md-checkbox:checked::before {';
        $html[] = '  content: "✓";';
        $html[] = '  position: absolute;';
        $html[] = '  color: var(--md-sys-color-on-primary);';
        $html[] = '  font-size: 12px;';
        $html[] = '  font-weight: bold;';
        $html[] = '  top: -1px;';
        $html[] = '  left: 2px;';
        $html[] = '}';

        // Radio styling
        $html[] = 'input[type="radio"].md-radio {';
        $html[] = '  appearance: none;';
        $html[] = '  width: 18px;';
        $html[] = '  height: 18px;';
        $html[] = '  border: 2px solid var(--md-sys-color-outline);';
        $html[] = '  border-radius: 50%;';
        $html[] = '  background-color: transparent;';
        $html[] = '  cursor: pointer;';
        $html[] = '  position: relative;';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '}';

        $html[] = 'input[type="radio"].md-radio:checked {';
        $html[] = '  border-color: var(--md-sys-color-primary);';
        $html[] = '}';

        $html[] = 'input[type="radio"].md-radio:checked::before {';
        $html[] = '  content: "";';
        $html[] = '  position: absolute;';
        $html[] = '  width: 10px;';
        $html[] = '  height: 10px;';
        $html[] = '  border-radius: 50%;';
        $html[] = '  background-color: var(--md-sys-color-primary);';
        $html[] = '  top: 2px;';
        $html[] = '  left: 2px;';
        $html[] = '}';

        // Select Fields
        $html[] = 'md-filled-select, md-outlined-select {';
        $html[] = '  display: block;';
        $html[] = '  position: relative;';
        $html[] = '  width: 100%;';
        $html[] = '  min-width: 200px;';
        $html[] = '}';

        $html[] = 'md-filled-select select, md-outlined-select select {';
        $html[] = '  width: 100%;';
        $html[] = '  font-family: inherit;';
        $html[] = '  font-size: 16px;';
        $html[] = '  padding: 16px;';
        $html[] = '  border: none;';
        $html[] = '  background: transparent;';
        $html[] = '  color: var(--md-sys-color-on-surface);';
        $html[] = '  cursor: pointer;';
        $html[] = '}';

        $html[] = 'md-filled-select {';
        $html[] = '  background-color: var(--md-sys-color-surface-container-high);';
        $html[] = '  border-radius: 4px 4px 0 0;';
        $html[] = '  border-bottom: 1px solid var(--md-sys-color-on-surface-variant);';
        $html[] = '}';

        $html[] = 'md-outlined-select {';
        $html[] = '  border: 1px solid var(--md-sys-color-outline);';
        $html[] = '  border-radius: 4px;';
        $html[] = '}';

        $html[] = 'md-filled-select label, md-outlined-select label {';
        $html[] = '  position: absolute;';
        $html[] = '  top: -8px;';
        $html[] = '  left: 12px;';
        $html[] = '  font-size: 12px;';
        $html[] = '  color: var(--md-sys-color-primary);';
        $html[] = '  background: var(--md-sys-color-surface);';
        $html[] = '  padding: 0 4px;';
        $html[] = '  pointer-events: none;';
        $html[] = '}';

        // Tooltips
        $html[] = 'md-tooltip {';
        $html[] = '  position: absolute;';
        $html[] = '  background: var(--md-sys-color-surface-container-high);';
        $html[] = '  color: var(--md-sys-color-on-surface);';
        $html[] = '  padding: 8px 12px;';
        $html[] = '  border-radius: 4px;';
        $html[] = '  font-size: 12px;';
        $html[] = '  box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.3);';
        $html[] = '  z-index: 1000;';
        $html[] = '  display: none;';
        $html[] = '  white-space: nowrap;';
        $html[] = '}';

        // Search specific styles
        $html[] = '.search-overlay {';
        $html[] = '  position: fixed;';
        $html[] = '  top: 0;';
        $html[] = '  left: 0;';
        $html[] = '  width: 100%;';
        $html[] = '  height: 100%;';
        $html[] = '  background: var(--md-sys-color-surface);';
        $html[] = '  z-index: 1000;';
        $html[] = '}';

        $html[] = '.search-header {';
        $html[] = '  display: flex;';
        $html[] = '  align-items: center;';
        $html[] = '  padding: 8px;';
        $html[] = '  gap: 8px;';
        $html[] = '  border-bottom: 1px solid var(--md-sys-color-outline-variant);';
        $html[] = '}';

        $html[] = '</style>';

        // JavaScript für Dialog-Funktionalität
        if ($includeRipple) {
            $html[] = '<script>';
            $html[] = 'class MDDialog extends HTMLElement {';
            $html[] = '  constructor() { super(); }';
            $html[] = '  show() { this.setAttribute("open", ""); }';
            $html[] = '  close() { this.removeAttribute("open"); }';
            $html[] = '}';
            $html[] = 'customElements.define("md-dialog", MDDialog);';
            $html[] = '</script>';
        }

        return implode("\n", $html);
    }

    /**
     * Reset initialization state (useful for testing)
     */
    public static function reset(): void
    {
        self::$initialized = false;
    }

    /**
     * Get current library version (removed duplicate - see line 613)
     */

    /**
     * Generate Material Icon
     *
     * @param string $icon Icon name from Material Symbols
     * @param array $attributes Additional HTML attributes
     * @return string HTML for material icon
     */
    public static function icon(string $icon, array $attributes = []): string
    {
        $attrs = [];
        foreach ($attributes as $key => $value) {
            $attrs[] = htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
        }

        $attrString = $attrs ? ' ' . implode(' ', $attrs) : '';

        return '<span class="material-symbols-outlined"' . $attrString . '>' . htmlspecialchars($icon) . '</span>';
    }

    /**
     * Escape HTML attributes
     */
    public static function escapeAttributes(array $attributes): string
    {
        $attrs = [];
        foreach ($attributes as $key => $value) {
            if ($value === null || $value === false) {
                continue;
            }
            if ($value === true) {
                $attrs[] = htmlspecialchars($key);
            } else {
                $attrs[] = htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
            }
        }
        return $attrs ? ' ' . implode(' ', $attrs) : '';
    }

    /**
     * Get theme colors for a specific theme
     * Delegates to MD3Theme class
     *
     * @param string $theme Theme name
     * @return array Theme colors for light and dark modes
     */
    public static function getThemeColors(string $theme = 'default'): array
    {
        require_once 'MD3Theme.php';
        return MD3Theme::getThemeColors($theme);
    }

    /**
     * Get library version from VERSION file
     *
     * @return string Current version
     */
    public static function getVersion(): string
    {
        if (self::$version === null) {
            $versionFile = dirname(__DIR__) . '/VERSION';
            if (file_exists($versionFile)) {
                self::$version = trim(file_get_contents($versionFile));
            } else {
                self::$version = '2.1.0'; // Fallback version
            }
        }
        return self::$version;
    }

    /**
     * Get version info with additional metadata
     *
     * @return array Version information
     */
    public static function getVersionInfo(): array
    {
        return [
            'version' => self::getVersion(),
            'name' => 'Material Design 3 PHP Library',
            'build_date' => date('Y-m-d'),
            'php_version' => PHP_VERSION,
            'material_web_components' => false, // We don't use the official components
            'css_only' => true,
            'offline_ready' => true,
            'components' => [
                'MD3Button', 'MD3TextField', 'MD3Card', 'MD3Breadcrumb',
                'MD3Dialog', 'MD3List', 'MD3Search', 'MD3Chip', 'MD3Tooltip',
                'MD3Switch', 'MD3Checkbox', 'MD3Radio', 'MD3Select', 'MD3Theme'
            ]
        ];
    }

    /**
     * Check if a component class exists
     *
     * @param string $component Component name (e.g., 'Button', 'TextField')
     * @return bool Whether component exists
     */
    public static function hasComponent(string $component): bool
    {
        $className = 'MD3' . ucfirst($component);
        return class_exists($className);
    }

    /**
     * Get changelog entries for current or specific version
     *
     * @param string|null $version Specific version or null for current
     * @return array Changelog entries
     */
    public static function getChangelog(string $version = null): array
    {
        $changelogFile = dirname(__DIR__) . '/CHANGELOG.md';
        if (!file_exists($changelogFile)) {
            return ['error' => 'Changelog not found'];
        }

        $changelog = file_get_contents($changelogFile);
        $targetVersion = $version ?? self::getVersion();

        // Extract version section
        $pattern = '/## \[' . preg_quote($targetVersion) . '\].*?\n(.*?)(?=\n## \[|$)/s';
        if (preg_match($pattern, $changelog, $matches)) {
            $content = trim($matches[1]);

            // Parse sections
            $sections = [];
            if (preg_match_all('/### (.*?)\n(.*?)(?=\n### |$)/s', $content, $sectionMatches, PREG_SET_ORDER)) {
                foreach ($sectionMatches as $match) {
                    $sectionName = trim($match[1]);
                    $sectionContent = trim($match[2]);

                    // Parse list items
                    $items = [];
                    if (preg_match_all('/^- (.*)$/m', $sectionContent, $itemMatches)) {
                        $items = $itemMatches[1];
                    }

                    $sections[$sectionName] = $items;
                }
            }

            return [
                'version' => $targetVersion,
                'sections' => $sections,
                'raw' => $content
            ];
        }

        return ['error' => "Version {$targetVersion} not found in changelog"];
    }

    /**
     * Generate version information display
     *
     * @param bool $includeChangelog Include changelog for current version
     * @return string HTML for version display
     */
    public static function getVersionDisplay(bool $includeChangelog = false): string
    {
        $info = self::getVersionInfo();
        $html = '<div class="md3-version-info">';

        $html .= '<div class="version-header">';
        $html .= '<h3>' . self::icon('info') . ' ' . htmlspecialchars($info['name']) . '</h3>';
        $html .= '<div class="version-badge">v' . htmlspecialchars($info['version']) . '</div>';
        $html .= '</div>';

        $html .= '<div class="version-details">';
        $html .= '<div class="detail-item"><strong>Build:</strong> ' . htmlspecialchars($info['build_date']) . '</div>';
        $html .= '<div class="detail-item"><strong>PHP:</strong> ' . htmlspecialchars($info['php_version']) . '</div>';
        $html .= '<div class="detail-item"><strong>Komponenten:</strong> ' . count($info['components']) . '</div>';
        $html .= '<div class="detail-item"><strong>Offline:</strong> ' . ($info['offline_ready'] ? '✅' : '❌') . '</div>';
        $html .= '</div>';

        if ($includeChangelog) {
            $changelog = self::getChangelog();
            if (isset($changelog['sections'])) {
                $html .= '<div class="version-changelog">';
                $html .= '<h4>Changelog v' . htmlspecialchars($changelog['version']) . '</h4>';

                foreach ($changelog['sections'] as $section => $items) {
                    $html .= '<div class="changelog-section">';
                    $html .= '<h5>' . htmlspecialchars($section) . '</h5>';
                    $html .= '<ul>';
                    foreach ($items as $item) {
                        $html .= '<li>' . htmlspecialchars($item) . '</li>';
                    }
                    $html .= '</ul>';
                    $html .= '</div>';
                }

                $html .= '</div>';
            }
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Generate CSS for version display
     *
     * @return string CSS for version components
     */
    public static function getVersionCSS(): string
    {
        return '<style>
            .md3-version-info {
                background: var(--md-sys-color-surface-container);
                border: 1px solid var(--md-sys-color-outline-variant);
                border-radius: 12px;
                padding: 16px;
                margin: 16px 0;
            }

            .version-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 12px;
            }

            .version-header h3 {
                margin: 0;
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--md-sys-color-on-surface);
            }

            .version-badge {
                background: var(--md-sys-color-primary);
                color: var(--md-sys-color-on-primary);
                padding: 4px 12px;
                border-radius: 16px;
                font-weight: 500;
                font-size: 14px;
            }

            .version-details {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 8px;
                margin-bottom: 16px;
            }

            .detail-item {
                font-size: 14px;
                color: var(--md-sys-color-on-surface-variant);
            }

            .version-changelog {
                border-top: 1px solid var(--md-sys-color-outline-variant);
                padding-top: 16px;
            }

            .version-changelog h4 {
                margin: 0 0 12px 0;
                color: var(--md-sys-color-primary);
            }

            .changelog-section {
                margin-bottom: 16px;
            }

            .changelog-section h5 {
                margin: 0 0 8px 0;
                font-size: 14px;
                font-weight: 600;
                color: var(--md-sys-color-on-surface);
            }

            .changelog-section ul {
                margin: 0;
                padding-left: 20px;
                font-size: 14px;
                color: var(--md-sys-color-on-surface-variant);
            }

            .changelog-section li {
                margin-bottom: 4px;
            }
        </style>';
    }
}