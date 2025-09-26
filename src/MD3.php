<?php

/**
 * MD3 - Material Design 3 Library for PHP
 * Central class for resource management and initialization
 */
class MD3
{
    private static $initialized = false;
    private static $version = '2.0.1';

    /**
     * Initialize Material Design 3 resources
     * Pure CSS implementation ohne externe CDN-Abhängigkeiten
     *
     * @param bool $includeRipple Whether to include ripple effects (default: true)
     * @param bool $includeIcons Whether to include Material Icons (default: true)
     * @return string HTML for resource includes
     */
    public static function init(bool $includeRipple = true, bool $includeIcons = true): string
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

        // Material Design 3 Tokens
        $html[] = ':root {';
        $html[] = '  color-scheme: light dark;';
        $html[] = '  --md-sys-color-primary: #6750A4;';
        $html[] = '  --md-sys-color-on-primary: #FFFFFF;';
        $html[] = '  --md-sys-color-primary-container: #EADDFF;';
        $html[] = '  --md-sys-color-on-primary-container: #21005D;';
        $html[] = '  --md-sys-color-secondary: #625B71;';
        $html[] = '  --md-sys-color-on-secondary: #FFFFFF;';
        $html[] = '  --md-sys-color-secondary-container: #E8DEF8;';
        $html[] = '  --md-sys-color-on-secondary-container: #1D192B;';
        $html[] = '  --md-sys-color-tertiary: #7D5260;';
        $html[] = '  --md-sys-color-on-tertiary: #FFFFFF;';
        $html[] = '  --md-sys-color-surface: #FEF7FF;';
        $html[] = '  --md-sys-color-on-surface: #1D1B20;';
        $html[] = '  --md-sys-color-surface-variant: #E7E0EC;';
        $html[] = '  --md-sys-color-on-surface-variant: #49454F;';
        $html[] = '  --md-sys-color-background: #FEF7FF;';
        $html[] = '  --md-sys-color-on-background: #1D1B20;';
        $html[] = '  --md-sys-color-surface-container-lowest: #FFFFFF;';
        $html[] = '  --md-sys-color-surface-container: #F3EDF7;';
        $html[] = '  --md-sys-color-surface-container-high: #ECE6F0;';
        $html[] = '  --md-sys-color-outline: #79747E;';
        $html[] = '  --md-sys-color-outline-variant: #CAC4D0;';
        $html[] = '  --md-sys-color-error: #BA1A1A;';
        $html[] = '  --md-sys-color-on-error: #FFFFFF;';
        $html[] = '}';

        // Dark theme
        $html[] = '@media (prefers-color-scheme: dark) {';
        $html[] = '  :root {';
        $html[] = '    --md-sys-color-primary: #D0BCFF;';
        $html[] = '    --md-sys-color-on-primary: #371E73;';
        $html[] = '    --md-sys-color-primary-container: #4F378B;';
        $html[] = '    --md-sys-color-on-primary-container: #EADDFF;';
        $html[] = '    --md-sys-color-surface: #141218;';
        $html[] = '    --md-sys-color-on-surface: #E6E0E9;';
        $html[] = '    --md-sys-color-background: #141218;';
        $html[] = '    --md-sys-color-on-background: #E6E0E9;';
        $html[] = '    --md-sys-color-surface-container-lowest: #0F0D13;';
        $html[] = '    --md-sys-color-surface-container: #211F26;';
        $html[] = '    --md-sys-color-surface-container-high: #2B2930;';
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
        $html[] = 'md-tooltip, md-switch, md-checkbox, md-radio {';
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

        // Form Controls
        $html[] = 'md-switch, md-checkbox, md-radio {';
        $html[] = '  display: inline-block;';
        $html[] = '  cursor: pointer;';
        $html[] = '}';

        $html[] = 'md-switch {';
        $html[] = '  width: 52px;';
        $html[] = '  height: 32px;';
        $html[] = '  background-color: var(--md-sys-color-surface-container-high);';
        $html[] = '  border-radius: 16px;';
        $html[] = '  position: relative;';
        $html[] = '  border: 2px solid var(--md-sys-color-outline);';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '}';

        $html[] = 'md-checkbox, md-radio {';
        $html[] = '  width: 18px;';
        $html[] = '  height: 18px;';
        $html[] = '  border: 2px solid var(--md-sys-color-outline);';
        $html[] = '  background-color: transparent;';
        $html[] = '  transition: all 0.2s ease;';
        $html[] = '}';

        $html[] = 'md-checkbox {';
        $html[] = '  border-radius: 2px;';
        $html[] = '}';

        $html[] = 'md-radio {';
        $html[] = '  border-radius: 50%;';
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
     * Get current library version
     */
    public static function getVersion(): string
    {
        return self::$version;
    }

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
}