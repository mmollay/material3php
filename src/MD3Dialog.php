<?php

/**
 * Material Design 3 Dialog Component
 *
 * Implementiert vollständige MD3 Dialog-Funktionalität mit nativem CSS/HTML:
 * - Basic Dialogs
 * - Alert Dialogs
 * - Confirmation Dialogs
 * - Full-screen Dialogs
 * - Form Dialogs
 *
 * @package MD3Dialog
 * @version 0.1.0
 * @since 0.1.0
 */
class MD3Dialog
{
    /**
     * Generate a basic dialog
     *
     * @param string $id Dialog ID for scripting
     * @param string $title Dialog title
     * @param string $content Dialog body content
     * @param array $options Dialog options
     * @return string Complete HTML for dialog
     */
    public static function basic(string $id, string $title, string $content, array $options = []): string
    {
        return self::create($id, $title, $content, [], $options);
    }

    /**
     * Generate an alert dialog
     *
     * @param string $id Dialog ID
     * @param string $title Dialog title
     * @param string $message Alert message
     * @param array $options Dialog options
     * @return string Complete HTML
     */
    public static function alert(string $id, string $title, string $message, array $options = []): string
    {
        $actions = [
            [
                'text' => $options['confirmText'] ?? 'OK',
                'type' => 'filled',
                'onclick' => "MD3Dialog.close('$id')"
            ]
        ];

        return self::create($id, $title, $message, $actions, array_merge($options, ['type' => 'alert']));
    }

    /**
     * Generate a confirmation dialog
     *
     * @param string $id Dialog ID
     * @param string $title Dialog title
     * @param string $message Confirmation message
     * @param array $options Dialog options
     * @return string Complete HTML
     */
    public static function confirm(string $id, string $title, string $message, array $options = []): string
    {
        $actions = [
            [
                'text' => $options['cancelText'] ?? 'Cancel',
                'type' => 'text',
                'onclick' => "MD3Dialog.close('$id')"
            ],
            [
                'text' => $options['confirmText'] ?? 'Confirm',
                'type' => 'filled',
                'onclick' => $options['onConfirm'] ?? "MD3Dialog.close('$id')"
            ]
        ];

        return self::create($id, $title, $message, $actions, array_merge($options, ['type' => 'confirm']));
    }

    /**
     * Generate a full-screen dialog
     *
     * @param string $id Dialog ID
     * @param string $title Dialog title
     * @param string $content Dialog content
     * @param array $actions Actions array
     * @param array $options Dialog options
     * @return string Complete HTML
     */
    public static function fullscreen(string $id, string $title, string $content, array $actions = [], array $options = []): string
    {
        return self::create($id, $title, $content, $actions, array_merge($options, ['fullscreen' => true]));
    }

    /**
     * Generate a form dialog
     *
     * @param string $id Dialog ID
     * @param string $title Dialog title
     * @param string $formContent Form HTML content
     * @param array $options Dialog options
     * @return string Complete HTML
     */
    public static function form(string $id, string $title, string $formContent, array $options = []): string
    {
        $actions = [
            [
                'text' => $options['cancelText'] ?? 'Cancel',
                'type' => 'text',
                'onclick' => "MD3Dialog.close('$id')"
            ],
            [
                'text' => $options['submitText'] ?? 'Save',
                'type' => 'filled',
                'onclick' => $options['onSubmit'] ?? "MD3Dialog.submitForm('$id')"
            ]
        ];

        $wrappedContent = sprintf('<form id="%s-form" class="md3-dialog__form">%s</form>', $id, $formContent);

        return self::create($id, $title, $wrappedContent, $actions, array_merge($options, ['type' => 'form']));
    }

    /**
     * Main dialog creation method
     *
     * @param string $id Dialog ID
     * @param string $title Dialog title
     * @param string $content Dialog content
     * @param array $actions Actions array
     * @param array $options Dialog options
     * @return string Complete HTML
     */
    private static function create(string $id, string $title, string $content, array $actions = [], array $options = []): string
    {
        $classes = ['md3-dialog'];
        $overlayClasses = ['md3-dialog-overlay'];

        if (!empty($options['fullscreen'])) {
            $classes[] = 'md3-dialog--fullscreen';
        }

        if (!empty($options['type'])) {
            $classes[] = 'md3-dialog--' . $options['type'];
        }

        $dialogContent = self::buildDialogStructure($id, $title, $content, $actions, $options);

        return sprintf(
            '<div class="%s" id="%s-overlay" style="display: none;" aria-hidden="true">'
            . '<div class="%s" id="%s" role="dialog" aria-labelledby="%s-title" aria-modal="true">'
            . '%s'
            . '</div>'
            . '</div>',
            implode(' ', $overlayClasses),
            $id,
            implode(' ', $classes),
            $id,
            $id,
            $dialogContent
        );
    }

    /**
     * Build complete dialog structure
     */
    private static function buildDialogStructure(string $id, string $title, string $content, array $actions, array $options): string
    {
        $html = '';

        // Header
        if (!empty($options['fullscreen'])) {
            $html .= sprintf(
                '<header class="md3-dialog__header">'
                . '<button class="md3-dialog__close" onclick="MD3Dialog.close(\'%s\')" aria-label="Close">'
                . '<span class="material-symbols-outlined">close</span>'
                . '</button>'
                . '<h2 class="md3-dialog__title" id="%s-title">%s</h2>'
                . '</header>',
                $id,
                $id,
                htmlspecialchars($title)
            );
        } else {
            if (!empty($title)) {
                $html .= sprintf(
                    '<header class="md3-dialog__header">'
                    . '<h2 class="md3-dialog__title" id="%s-title">%s</h2>'
                    . '</header>',
                    $id,
                    htmlspecialchars($title)
                );
            }
        }

        // Content
        if (!empty($content)) {
            $html .= sprintf(
                '<main class="md3-dialog__content">%s</main>',
                $content
            );
        }

        // Actions
        if (!empty($actions)) {
            $html .= '<footer class="md3-dialog__actions">';
            foreach ($actions as $action) {
                $html .= self::renderAction($action);
            }
            $html .= '</footer>';
        }

        return $html;
    }

    /**
     * Render action button
     */
    private static function renderAction(array $action): string
    {
        $type = $action['type'] ?? 'text';
        $text = $action['text'] ?? 'Action';
        $onclick = $action['onclick'] ?? '';
        $disabled = $action['disabled'] ?? false;

        $classes = ['md3-button', 'md3-button--' . $type];
        if ($disabled) $classes[] = 'md3-button--disabled';

        $attributes = [
            'class' => implode(' ', $classes),
            'type' => 'button'
        ];

        if ($onclick) {
            $attributes['onclick'] = $onclick;
        }

        if ($disabled) {
            $attributes['disabled'] = 'disabled';
        }

        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        return sprintf('<button%s>%s</button>', $attributesStr, htmlspecialchars($text));
    }

    /**
     * Generate CSS for Dialog components
     */
    public static function getCSS(): string
    {
        return '
        /* Material Design 3 Dialog */
        .md3-dialog-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.32);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s cubic-bezier(0.2, 0, 0, 1);
        }

        .md3-dialog-overlay[aria-hidden="false"] {
            opacity: 1;
        }

        .md3-dialog {
            background: var(--md-sys-color-surface-container-high);
            border-radius: 28px;
            box-shadow: var(--md-sys-elevation-3);
            min-width: 280px;
            max-width: 560px;
            max-height: calc(100vh - 48px);
            display: flex;
            flex-direction: column;
            transform: scale(0.8);
            transition: transform 0.2s cubic-bezier(0.2, 0, 0, 1);
            outline: none;
        }

        .md3-dialog-overlay[aria-hidden="false"] .md3-dialog {
            transform: scale(1);
        }

        .md3-dialog--fullscreen {
            width: 100%;
            height: 100%;
            max-width: none;
            max-height: none;
            border-radius: 0;
            transform: translateY(100%);
        }

        .md3-dialog-overlay[aria-hidden="false"] .md3-dialog--fullscreen {
            transform: translateY(0);
        }

        .md3-dialog__header {
            padding: 24px 24px 0;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .md3-dialog--fullscreen .md3-dialog__header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
        }

        .md3-dialog__close {
            background: none;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--md-sys-color-on-surface);
            transition: background-color 0.2s;
        }

        .md3-dialog__close:hover {
            background: var(--md-sys-color-on-surface);
            background: color-mix(in srgb, var(--md-sys-color-on-surface) 8%, transparent);
        }

        .md3-dialog__title {
            font-size: 24px;
            font-weight: 400;
            line-height: 32px;
            color: var(--md-sys-color-on-surface);
            margin: 0;
            flex: 1;
        }

        .md3-dialog__content {
            padding: 16px 24px;
            color: var(--md-sys-color-on-surface-variant);
            font-size: 14px;
            line-height: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .md3-dialog__actions {
            padding: 16px 24px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            flex-shrink: 0;
        }

        .md3-dialog--fullscreen .md3-dialog__actions {
            padding: 16px 24px;
            border-top: 1px solid var(--md-sys-color-outline-variant);
        }

        .md3-dialog__form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Button styles for dialog actions */
        .md3-dialog .md3-button {
            padding: 10px 24px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
            line-height: 20px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            min-width: 48px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .md3-button--text {
            background: transparent;
            color: var(--md-sys-color-primary);
        }

        .md3-button--text:hover {
            background: var(--md-sys-color-primary);
            background: color-mix(in srgb, var(--md-sys-color-primary) 8%, transparent);
        }

        .md3-button--filled {
            background: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
        }

        .md3-button--filled:hover {
            background: color-mix(in srgb, var(--md-sys-color-primary) 92%, var(--md-sys-color-on-primary) 8%);
        }

        .md3-button--disabled {
            background: var(--md-sys-color-on-surface);
            background: color-mix(in srgb, var(--md-sys-color-on-surface) 12%, transparent);
            color: var(--md-sys-color-on-surface);
            opacity: 0.38;
            cursor: not-allowed;
        }

        /* Responsive behavior */
        @media (max-width: 480px) {
            .md3-dialog {
                margin: 16px;
                min-width: calc(100vw - 32px);
                max-width: calc(100vw - 32px);
            }

            .md3-dialog__actions {
                flex-direction: column;
            }
        }
        ';
    }

    /**
     * Generate JavaScript for Dialog functionality
     */
    public static function getScript(): string
    {
        return "
        <script>
        window.MD3Dialog = {
            open: function(id) {
                const overlay = document.getElementById(id + '-overlay');
                if (overlay) {
                    overlay.style.display = 'flex';
                    setTimeout(() => {
                        overlay.setAttribute('aria-hidden', 'false');
                        const dialog = document.getElementById(id);
                        if (dialog) {
                            dialog.focus();
                        }
                    }, 10);

                    // Emit open event
                    const event = new CustomEvent('md3-dialog-open', {
                        detail: { id: id }
                    });
                    document.dispatchEvent(event);
                }
            },

            close: function(id) {
                const overlay = document.getElementById(id + '-overlay');
                if (overlay) {
                    overlay.setAttribute('aria-hidden', 'true');
                    setTimeout(() => {
                        overlay.style.display = 'none';
                    }, 200);

                    // Emit close event
                    const event = new CustomEvent('md3-dialog-close', {
                        detail: { id: id }
                    });
                    document.dispatchEvent(event);
                }
            },

            toggle: function(id) {
                const overlay = document.getElementById(id + '-overlay');
                if (overlay && overlay.style.display === 'none') {
                    this.open(id);
                } else {
                    this.close(id);
                }
            },

            submitForm: function(id) {
                const form = document.getElementById(id + '-form');
                if (form) {
                    // Emit form submit event
                    const event = new CustomEvent('md3-dialog-form-submit', {
                        detail: {
                            id: id,
                            form: form,
                            data: new FormData(form)
                        }
                    });
                    document.dispatchEvent(event);

                    // Close dialog after submit (can be prevented by event listener)
                    if (!event.defaultPrevented) {
                        this.close(id);
                    }
                }
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Handle ESC key to close dialogs
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const openDialog = document.querySelector('.md3-dialog-overlay[aria-hidden=\"false\"]');
                    if (openDialog) {
                        const id = openDialog.id.replace('-overlay', '');
                        MD3Dialog.close(id);
                    }
                }
            });

            // Handle backdrop clicks
            document.querySelectorAll('.md3-dialog-overlay').forEach(overlay => {
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) {
                        const id = overlay.id.replace('-overlay', '');
                        MD3Dialog.close(id);
                    }
                });
            });

            // Focus management for accessibility
            document.addEventListener('md3-dialog-open', function(e) {
                // Store currently focused element
                const activeElement = document.activeElement;
                if (activeElement) {
                    activeElement.setAttribute('data-previous-focus', 'true');
                }
            });

            document.addEventListener('md3-dialog-close', function(e) {
                // Restore focus to previously focused element
                const previousFocus = document.querySelector('[data-previous-focus=\"true\"]');
                if (previousFocus) {
                    previousFocus.focus();
                    previousFocus.removeAttribute('data-previous-focus');
                }
            });
        });
        </script>
        ";
    }
}

?>