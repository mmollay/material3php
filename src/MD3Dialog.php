<?php

require_once 'MD3.php';

/**
 * MD3Dialog - Material Design 3 Dialog Components
 * Generates HTML for Material Web Components dialogs
 */
class MD3Dialog
{
    /**
     * Generate a basic dialog
     *
     * @param string $id Dialog ID for scripting
     * @param string $title Dialog title
     * @param string $content Dialog body content
     * @param array $attributes Additional HTML attributes
     * @return string HTML for md-dialog
     */
    public static function basic(string $id, string $title, string $content, array $attributes = []): string
    {
        $attributes['id'] = $id;

        $dialogContent = self::buildDialogContent($title, $content);

        return '<md-dialog' . MD3::escapeAttributes($attributes) . '>' . $dialogContent . '</md-dialog>';
    }

    /**
     * Generate a dialog with actions
     *
     * @param string $id Dialog ID for scripting
     * @param string $title Dialog title
     * @param string $content Dialog body content
     * @param array $actions Array of action buttons (HTML strings)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for dialog with actions
     */
    public static function withActions(string $id, string $title, string $content, array $actions = [], array $attributes = []): string
    {
        $attributes['id'] = $id;

        $dialogContent = self::buildDialogContent($title, $content);

        if (!empty($actions)) {
            $dialogContent .= '<div slot="actions" style="display: flex; gap: 8px; justify-content: flex-end;">';
            foreach ($actions as $action) {
                $dialogContent .= $action;
            }
            $dialogContent .= '</div>';
        }

        return '<md-dialog' . MD3::escapeAttributes($attributes) . '>' . $dialogContent . '</md-dialog>';
    }

    /**
     * Generate a confirmation dialog
     *
     * @param string $id Dialog ID for scripting
     * @param string $title Dialog title
     * @param string $message Confirmation message
     * @param string $confirmText Confirm button text (default: "Confirm")
     * @param string $cancelText Cancel button text (default: "Cancel")
     * @param array $attributes Additional HTML attributes
     * @return string HTML for confirmation dialog
     */
    public static function confirm(string $id, string $title, string $message, string $confirmText = 'Confirm', string $cancelText = 'Cancel', array $attributes = []): string
    {
        require_once 'MD3Button.php';

        $actions = [
            MD3Button::text($cancelText, null, ['onclick' => "document.getElementById('$id').close()"]),
            MD3Button::filled($confirmText, null, ['onclick' => "document.getElementById('$id').close(); confirmAction()"])
        ];

        return self::withActions($id, $title, $message, $actions, $attributes);
    }

    /**
     * Generate an alert dialog
     *
     * @param string $id Dialog ID for scripting
     * @param string $title Dialog title
     * @param string $message Alert message
     * @param string $buttonText Button text (default: "OK")
     * @param array $attributes Additional HTML attributes
     * @return string HTML for alert dialog
     */
    public static function alert(string $id, string $title, string $message, string $buttonText = 'OK', array $attributes = []): string
    {
        require_once 'MD3Button.php';

        $actions = [
            MD3Button::filled($buttonText, null, ['onclick' => "document.getElementById('$id').close()"])
        ];

        return self::withActions($id, $title, $message, $actions, $attributes);
    }

    /**
     * Generate a form dialog
     *
     * @param string $id Dialog ID for scripting
     * @param string $title Dialog title
     * @param string $formContent Form fields HTML
     * @param string $submitText Submit button text (default: "Submit")
     * @param string $cancelText Cancel button text (default: "Cancel")
     * @param array $attributes Additional HTML attributes
     * @return string HTML for form dialog
     */
    public static function form(string $id, string $title, string $formContent, string $submitText = 'Submit', string $cancelText = 'Cancel', array $attributes = []): string
    {
        require_once 'MD3Button.php';

        $attributes['id'] = $id;

        $dialogContent = '<div slot="headline">' . htmlspecialchars($title) . '</div>';
        $dialogContent .= '<form slot="content" method="dialog" style="padding: 0;">';
        $dialogContent .= $formContent;
        $dialogContent .= '</form>';

        $actions = [
            MD3Button::text($cancelText, null, ['onclick' => "document.getElementById('$id').close()"]),
            MD3Button::filled($submitText, null, ['type' => 'submit', 'form' => $id . '-form'])
        ];

        $dialogContent .= '<div slot="actions" style="display: flex; gap: 8px; justify-content: flex-end;">';
        foreach ($actions as $action) {
            $dialogContent .= $action;
        }
        $dialogContent .= '</div>';

        return '<md-dialog' . MD3::escapeAttributes($attributes) . '>' . $dialogContent . '</md-dialog>';
    }

    /**
     * Generate a fullscreen dialog
     *
     * @param string $id Dialog ID for scripting
     * @param string $title Dialog title
     * @param string $content Dialog body content
     * @param array $actions Array of action buttons (HTML strings)
     * @param array $attributes Additional HTML attributes
     * @return string HTML for fullscreen dialog
     */
    public static function fullscreen(string $id, string $title, string $content, array $actions = [], array $attributes = []): string
    {
        $attributes['id'] = $id;
        $attributes['type'] = 'fullscreen';

        $dialogContent = self::buildDialogContent($title, $content);

        if (!empty($actions)) {
            $dialogContent .= '<div slot="actions" style="display: flex; gap: 8px; justify-content: flex-end;">';
            foreach ($actions as $action) {
                $dialogContent .= $action;
            }
            $dialogContent .= '</div>';
        }

        return '<md-dialog' . MD3::escapeAttributes($attributes) . '>' . $dialogContent . '</md-dialog>';
    }

    /**
     * Generate JavaScript to open a dialog
     *
     * @param string $dialogId Dialog ID
     * @return string JavaScript code to open dialog
     */
    public static function openScript(string $dialogId): string
    {
        return "document.getElementById('" . htmlspecialchars($dialogId) . "').show();";
    }

    /**
     * Generate JavaScript to close a dialog
     *
     * @param string $dialogId Dialog ID
     * @return string JavaScript code to close dialog
     */
    public static function closeScript(string $dialogId): string
    {
        return "document.getElementById('" . htmlspecialchars($dialogId) . "').close();";
    }

    /**
     * Generate a trigger button that opens a dialog
     *
     * @param string $dialogId Dialog ID to open
     * @param string $buttonText Button text
     * @param string $buttonType Button type ('filled', 'outlined', 'text', 'elevated', 'tonal')
     * @param array $buttonAttributes Additional button attributes
     * @return string HTML for trigger button
     */
    public static function trigger(string $dialogId, string $buttonText, string $buttonType = 'filled', array $buttonAttributes = []): string
    {
        require_once 'MD3Button.php';

        $buttonAttributes['onclick'] = self::openScript($dialogId);

        switch ($buttonType) {
            case 'outlined':
                return MD3Button::outlined($buttonText, null, $buttonAttributes);
            case 'text':
                return MD3Button::text($buttonText, null, $buttonAttributes);
            case 'elevated':
                return MD3Button::elevated($buttonText, null, $buttonAttributes);
            case 'tonal':
                return MD3Button::tonal($buttonText, null, $buttonAttributes);
            default:
                return MD3Button::filled($buttonText, null, $buttonAttributes);
        }
    }

    /**
     * Build standard dialog content structure
     *
     * @param string $title Dialog title
     * @param string $content Dialog content
     * @return string HTML for dialog content
     */
    private static function buildDialogContent(string $title, string $content): string
    {
        $html = '<div slot="headline">' . htmlspecialchars($title) . '</div>';
        $html .= '<div slot="content">' . htmlspecialchars($content) . '</div>';
        return $html;
    }
}