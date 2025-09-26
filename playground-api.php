<?php
/**
 * Material Design 3 PHP Library - Playground API
 * Generates components dynamically for the interactive playground
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['component'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Load required classes
require_once 'src/MD3.php';
require_once 'src/MD3Button.php';
require_once 'src/MD3TextField.php';
require_once 'src/MD3Card.php';
require_once 'src/MD3List.php';
require_once 'src/MD3NavigationBar.php';
require_once 'src/MD3Menu.php';
require_once 'src/MD3Dialog.php';
require_once 'src/MD3Switch.php';
require_once 'src/MD3Checkbox.php';
require_once 'src/MD3Radio.php';
require_once 'src/MD3Select.php';
require_once 'src/MD3Chip.php';

$component = $input['component'];
$values = $input['values'] ?? [];

try {
    $result = generateComponent($component, $values);
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Component generation failed',
        'message' => $e->getMessage()
    ]);
}

function generateComponent($component, $values) {
    $html = '';
    $php = '';

    switch ($component) {
        case 'button':
            $html = generateButton($values);
            $php = generateButtonPHP($values);
            break;

        case 'textfield':
            $html = generateTextField($values);
            $php = generateTextFieldPHP($values);
            break;

        case 'card':
            $html = generateCard($values);
            $php = generateCardPHP($values);
            break;

        case 'select':
            $html = generateSelect($values);
            $php = generateSelectPHP($values);
            break;

        case 'switch':
            $html = generateSwitch($values);
            $php = generateSwitchPHP($values);
            break;

        case 'checkbox':
            $html = generateCheckbox($values);
            $php = generateCheckboxPHP($values);
            break;

        case 'radio':
            $html = generateRadio($values);
            $php = generateRadioPHP($values);
            break;

        case 'list':
            $html = generateList($values);
            $php = generateListPHP($values);
            break;

        case 'chip':
            $html = generateChip($values);
            $php = generateChipPHP($values);
            break;

        case 'navigation':
            $html = generateNavigation($values);
            $php = generateNavigationPHP($values);
            break;

        case 'menu':
            $html = generateMenu($values);
            $php = generateMenuPHP($values);
            break;

        case 'dialog':
            $html = generateDialog($values);
            $php = generateDialogPHP($values);
            break;

        default:
            throw new Exception('Unknown component: ' . $component);
    }

    return [
        'html' => $html,
        'php' => $php,
        'component' => $component
    ];
}

function generateButton($values) {
    $type = $values['type'] ?? 'filled';
    $text = $values['text'] ?? 'Click me';
    $icon = !empty($values['icon']) ? $values['icon'] : null;
    $disabled = $values['disabled'] ?? false;

    $attributes = [];
    if ($disabled) $attributes['disabled'] = true;

    switch ($type) {
        case 'filled':
            return MD3Button::filled($text, $icon, $attributes);
        case 'outlined':
            return MD3Button::outlined($text, $icon, $attributes);
        case 'text':
            return MD3Button::text($text, $icon, $attributes);
        case 'elevated':
            return MD3Button::elevated($text, $icon, $attributes);
        case 'tonal':
            return MD3Button::tonal($text, $icon, $attributes);
        default:
            return MD3Button::filled($text, $icon, $attributes);
    }
}

function generateButtonPHP($values) {
    $type = $values['type'] ?? 'filled';
    $text = $values['text'] ?? 'Click me';
    $icon = !empty($values['icon']) ? $values['icon'] : null;
    $disabled = $values['disabled'] ?? false;

    $code = "<?php\n";
    $code .= "require_once 'src/MD3Button.php';\n\n";

    $params = ["'" . addslashes($text) . "'"];

    if ($icon) {
        $params[] = "'" . addslashes($icon) . "'";
    } else {
        $params[] = 'null';
    }

    if ($disabled) {
        $params[] = "['disabled' => true]";
    }

    $methodParams = implode(', ', $params);

    switch ($type) {
        case 'filled':
            $code .= "echo MD3Button::filled({$methodParams});";
            break;
        case 'outlined':
            $code .= "echo MD3Button::outlined({$methodParams});";
            break;
        case 'text':
            $code .= "echo MD3Button::text({$methodParams});";
            break;
        case 'elevated':
            $code .= "echo MD3Button::elevated({$methodParams});";
            break;
        case 'tonal':
            $code .= "echo MD3Button::tonal({$methodParams});";
            break;
    }

    return $code;
}

function generateTextField($values) {
    $type = $values['type'] ?? 'filled';
    $label = $values['label'] ?? 'Enter text';
    $placeholder = $values['placeholder'] ?? '';
    $leadingIcon = !empty($values['leadingIcon']) ? $values['leadingIcon'] : null;
    $trailingIcon = !empty($values['trailingIcon']) ? $values['trailingIcon'] : null;

    $attributes = [];
    if ($placeholder) $attributes['placeholder'] = $placeholder;

    if ($leadingIcon && $trailingIcon) {
        // Both icons - not commonly supported, use leading
        return $type === 'outlined'
            ? MD3TextField::outlinedWithLeadingIcon('demo_field', $label, $leadingIcon, $attributes)
            : MD3TextField::withLeadingIcon('demo_field', $label, $leadingIcon, $attributes);
    } elseif ($leadingIcon) {
        return $type === 'outlined'
            ? MD3TextField::outlinedWithLeadingIcon('demo_field', $label, $leadingIcon, $attributes)
            : MD3TextField::withLeadingIcon('demo_field', $label, $leadingIcon, $attributes);
    } elseif ($trailingIcon) {
        return $type === 'outlined'
            ? MD3TextField::outlinedWithTrailingIcon('demo_field', $label, $trailingIcon, $attributes)
            : MD3TextField::withTrailingIcon('demo_field', $label, $trailingIcon, $attributes);
    } else {
        return $type === 'outlined'
            ? MD3TextField::outlined('demo_field', $label, $attributes)
            : MD3TextField::filled('demo_field', $label, $attributes);
    }
}

function generateTextFieldPHP($values) {
    $type = $values['type'] ?? 'filled';
    $label = $values['label'] ?? 'Enter text';
    $placeholder = $values['placeholder'] ?? '';
    $leadingIcon = !empty($values['leadingIcon']) ? $values['leadingIcon'] : null;
    $trailingIcon = !empty($values['trailingIcon']) ? $values['trailingIcon'] : null;

    $code = "<?php\n";
    $code .= "require_once 'src/MD3TextField.php';\n\n";

    $params = ["'demo_field'", "'" . addslashes($label) . "'"];

    if ($leadingIcon) {
        $params[] = "'" . addslashes($leadingIcon) . "'";
    }

    $attributes = [];
    if ($placeholder) $attributes['placeholder'] = $placeholder;

    if (!empty($attributes)) {
        $attrCode = '[';
        $attrPairs = [];
        foreach ($attributes as $key => $value) {
            $attrPairs[] = "'{$key}' => '" . addslashes($value) . "'";
        }
        $attrCode .= implode(', ', $attrPairs) . ']';
        $params[] = $attrCode;
    }

    $methodParams = implode(', ', $params);

    if ($leadingIcon && $trailingIcon) {
        $method = $type === 'outlined' ? 'outlinedWithLeadingIcon' : 'withLeadingIcon';
    } elseif ($leadingIcon) {
        $method = $type === 'outlined' ? 'outlinedWithLeadingIcon' : 'withLeadingIcon';
    } elseif ($trailingIcon) {
        $method = $type === 'outlined' ? 'outlinedWithTrailingIcon' : 'withTrailingIcon';
    } else {
        $method = $type === 'outlined' ? 'outlined' : 'filled';
    }

    $code .= "echo MD3TextField::{$method}({$methodParams});";

    return $code;
}

function generateCard($values) {
    $type = $values['type'] ?? 'elevated';
    $title = $values['title'] ?? 'Card Title';
    $content = $values['content'] ?? 'This is the card content area.';
    $icon = !empty($values['icon']) ? $values['icon'] : null;

    if ($icon) {
        return MD3Card::withIcon($icon, $title, $content, $type);
    } else {
        return MD3Card::simple($title, $content, $type);
    }
}

function generateCardPHP($values) {
    $type = $values['type'] ?? 'elevated';
    $title = $values['title'] ?? 'Card Title';
    $content = $values['content'] ?? 'This is the card content area.';
    $icon = !empty($values['icon']) ? $values['icon'] : null;

    $code = "<?php\n";
    $code .= "require_once 'src/MD3Card.php';\n\n";

    if ($icon) {
        $params = [
            "'" . addslashes($icon) . "'",
            "'" . addslashes($title) . "'",
            "'" . addslashes($content) . "'",
            "'" . addslashes($type) . "'"
        ];
        $code .= "echo MD3Card::withIcon(" . implode(', ', $params) . ");";
    } else {
        $params = [
            "'" . addslashes($title) . "'",
            "'" . addslashes($content) . "'",
            "'" . addslashes($type) . "'"
        ];
        $code .= "echo MD3Card::simple(" . implode(', ', $params) . ");";
    }

    return $code;
}

function generateSelect($values) {
    $type = $values['type'] ?? 'filled';
    $label = $values['label'] ?? 'Choose option';
    $optionsText = $values['options'] ?? 'Option 1\nOption 2\nOption 3';

    $options = [];
    $lines = explode("\n", trim($optionsText));
    foreach ($lines as $i => $line) {
        $line = trim($line);
        if ($line) {
            $options['option_' . $i] = $line;
        }
    }

    return $type === 'outlined'
        ? MD3Select::outlined('demo_select', $label, $options)
        : MD3Select::filled('demo_select', $label, $options);
}

function generateSelectPHP($values) {
    $type = $values['type'] ?? 'filled';
    $label = $values['label'] ?? 'Choose option';
    $optionsText = $values['options'] ?? 'Option 1\nOption 2\nOption 3';

    $code = "<?php\n";
    $code .= "require_once 'src/MD3Select.php';\n\n";
    $code .= "\$options = [\n";

    $lines = explode("\n", trim($optionsText));
    foreach ($lines as $i => $line) {
        $line = trim($line);
        if ($line) {
            $code .= "    'option_{$i}' => '" . addslashes($line) . "',\n";
        }
    }
    $code .= "];\n\n";

    $method = $type === 'outlined' ? 'outlined' : 'filled';
    $code .= "echo MD3Select::{$method}('demo_select', '" . addslashes($label) . "', \$options);";

    return $code;
}

function generateSwitch($values) {
    $label = $values['label'] ?? 'Enable notifications';
    $checked = $values['checked'] ?? false;

    return MD3Switch::withLabel('demo_switch', $label, '1', $checked);
}

function generateSwitchPHP($values) {
    $label = $values['label'] ?? 'Enable notifications';
    $checked = $values['checked'] ?? false;

    $code = "<?php\n";
    $code .= "require_once 'src/MD3Switch.php';\n\n";
    $code .= "echo MD3Switch::withLabel('demo_switch', '" . addslashes($label) . "', '1', " . ($checked ? 'true' : 'false') . ");";

    return $code;
}

function generateCheckbox($values) {
    $label = $values['label'] ?? 'I agree to the terms';
    $checked = $values['checked'] ?? false;

    return MD3Checkbox::withLabel('demo_checkbox', $label, '1', $checked);
}

function generateCheckboxPHP($values) {
    $label = $values['label'] ?? 'I agree to the terms';
    $checked = $values['checked'] ?? false;

    $code = "<?php\n";
    $code .= "require_once 'src/MD3Checkbox.php';\n\n";
    $code .= "echo MD3Checkbox::withLabel('demo_checkbox', '" . addslashes($label) . "', '1', " . ($checked ? 'true' : 'false') . ");";

    return $code;
}

function generateRadio($values) {
    $optionsText = $values['options'] ?? 'Option A\nOption B\nOption C';
    $selected = intval($values['selected'] ?? 0);

    $options = [];
    $lines = explode("\n", trim($optionsText));
    foreach ($lines as $i => $line) {
        $line = trim($line);
        if ($line) {
            $options[] = [
                'label' => $line,
                'value' => 'option_' . $i
            ];
        }
    }

    $selectedValue = isset($options[$selected]) ? $options[$selected]['value'] : '';

    return MD3Radio::group('demo_radio', $options, $selectedValue);
}

function generateRadioPHP($values) {
    $optionsText = $values['options'] ?? 'Option A\nOption B\nOption C';
    $selected = intval($values['selected'] ?? 0);

    $code = "<?php\n";
    $code .= "require_once 'src/MD3Radio.php';\n\n";
    $code .= "\$options = [\n";

    $lines = explode("\n", trim($optionsText));
    foreach ($lines as $i => $line) {
        $line = trim($line);
        if ($line) {
            $code .= "    ['label' => '" . addslashes($line) . "', 'value' => 'option_{$i}'],\n";
        }
    }
    $code .= "];\n\n";

    $selectedValue = isset($lines[$selected]) ? 'option_' . $selected : '';
    $code .= "echo MD3Radio::group('demo_radio', \$options, '{$selectedValue}');";

    return $code;
}

function generateList($values) {
    $type = $values['type'] ?? 'simple';
    $itemsText = $values['items'] ?? 'Inbox\nStarred\nSent mail\nDrafts';

    $items = [];
    $lines = explode("\n", trim($itemsText));
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line) {
            if ($type === 'withAvatars') {
                $initials = strtoupper(substr($line, 0, 2));
                $items[] = ['text' => $line, 'avatar' => $initials];
            } elseif ($type === 'twoLine') {
                $items[] = [
                    'title' => $line,
                    'subtitle' => 'Additional information for ' . $line,
                    'icon' => 'info'
                ];
            } else {
                $items[] = ['text' => $line, 'icon' => 'label'];
            }
        }
    }

    switch ($type) {
        case 'twoLine':
            return MD3List::twoLine($items);
        case 'withAvatars':
            return MD3List::withAvatars($items);
        default:
            return MD3List::simple($items);
    }
}

function generateListPHP($values) {
    $type = $values['type'] ?? 'simple';
    $itemsText = $values['items'] ?? 'Inbox\nStarred\nSent mail\nDrafts';

    $code = "<?php\n";
    $code .= "require_once 'src/MD3List.php';\n\n";
    $code .= "\$items = [\n";

    $lines = explode("\n", trim($itemsText));
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line) {
            if ($type === 'withAvatars') {
                $initials = strtoupper(substr($line, 0, 2));
                $code .= "    ['text' => '" . addslashes($line) . "', 'avatar' => '{$initials}'],\n";
            } elseif ($type === 'twoLine') {
                $code .= "    [\n";
                $code .= "        'title' => '" . addslashes($line) . "',\n";
                $code .= "        'subtitle' => 'Additional information for " . addslashes($line) . "',\n";
                $code .= "        'icon' => 'info'\n";
                $code .= "    ],\n";
            } else {
                $code .= "    ['text' => '" . addslashes($line) . "', 'icon' => 'label'],\n";
            }
        }
    }
    $code .= "];\n\n";

    switch ($type) {
        case 'twoLine':
            $code .= "echo MD3List::twoLine(\$items);";
            break;
        case 'withAvatars':
            $code .= "echo MD3List::withAvatars(\$items);";
            break;
        default:
            $code .= "echo MD3List::simple(\$items);";
    }

    return $code;
}

function generateChip($values) {
    $type = $values['type'] ?? 'assist';
    $labelsText = $values['labels'] ?? 'Design\nDevelopment\nTesting';

    $chips = [];
    $lines = explode("\n", trim($labelsText));

    foreach ($lines as $i => $line) {
        $line = trim($line);
        if ($line) {
            switch ($type) {
                case 'filter':
                    $chips[] = MD3Chip::filter($line, 'chip_' . $i, 'demo_chips[]', $i === 0);
                    break;
                case 'input':
                    $chips[] = MD3Chip::input($line, 'chip_' . $i, 'demo_chips[]');
                    break;
                default:
                    $chips[] = MD3Chip::assist($line);
            }
        }
    }

    return MD3Chip::set($chips, $type);
}

function generateChipPHP($values) {
    $type = $values['type'] ?? 'assist';
    $labelsText = $values['labels'] ?? 'Design\nDevelopment\nTesting';

    $code = "<?php\n";
    $code .= "require_once 'src/MD3Chip.php';\n\n";
    $code .= "\$chips = [];\n";

    $lines = explode("\n", trim($labelsText));
    foreach ($lines as $i => $line) {
        $line = trim($line);
        if ($line) {
            switch ($type) {
                case 'filter':
                    $checked = $i === 0 ? 'true' : 'false';
                    $code .= "\$chips[] = MD3Chip::filter('" . addslashes($line) . "', 'chip_{$i}', 'demo_chips[]', {$checked});\n";
                    break;
                case 'input':
                    $code .= "\$chips[] = MD3Chip::input('" . addslashes($line) . "', 'chip_{$i}', 'demo_chips[]');\n";
                    break;
                default:
                    $code .= "\$chips[] = MD3Chip::assist('" . addslashes($line) . "');\n";
            }
        }
    }

    $code .= "\necho MD3Chip::set(\$chips, '{$type}');";

    return $code;
}

function generateNavigation($values) {
    $type = $values['type'] ?? 'fixed';
    $itemsText = $values['items'] ?? 'home|Home|/\nsearch|Search|/search\nfavorite|Favorites|/favorites';
    $activeIndex = (int)($values['activeIndex'] ?? 0);

    // Parse items
    $items = [];
    $lines = explode("\n", trim($itemsText));
    foreach ($lines as $i => $line) {
        $line = trim($line);
        if ($line) {
            $parts = explode('|', $line);
            $items[] = [
                'icon' => $parts[0] ?? 'circle',
                'label' => $parts[1] ?? 'Item ' . ($i + 1),
                'href' => $parts[2] ?? '#',
                'active' => $i === $activeIndex
            ];
        }
    }

    switch ($type) {
        case 'floating':
            return MD3NavigationBar::floating($items);
        case 'icons-only':
            return MD3NavigationBar::iconsOnly($items);
        default:
            return MD3NavigationBar::create($items);
    }
}

function generateNavigationPHP($values) {
    $type = $values['type'] ?? 'fixed';
    $itemsText = $values['items'] ?? 'home|Home|/\nsearch|Search|/search\nfavorite|Favorites|/favorites';
    $activeIndex = (int)($values['activeIndex'] ?? 0);

    $code = "<?php\n";
    $code .= "require_once 'src/MD3NavigationBar.php';\n\n";
    $code .= "\$items = [\n";

    $lines = explode("\n", trim($itemsText));
    foreach ($lines as $i => $line) {
        $line = trim($line);
        if ($line) {
            $parts = explode('|', $line);
            $icon = addslashes($parts[0] ?? 'circle');
            $label = addslashes($parts[1] ?? 'Item ' . ($i + 1));
            $href = addslashes($parts[2] ?? '#');
            $active = $i === $activeIndex ? 'true' : 'false';
            $code .= "    ['icon' => '{$icon}', 'label' => '{$label}', 'href' => '{$href}', 'active' => {$active}],\n";
        }
    }
    $code .= "];\n\n";

    switch ($type) {
        case 'floating':
            $code .= "echo MD3NavigationBar::floating(\$items);";
            break;
        case 'icons-only':
            $code .= "echo MD3NavigationBar::iconsOnly(\$items);";
            break;
        default:
            $code .= "echo MD3NavigationBar::create(\$items);";
    }

    return $code;
}

function generateMenu($values) {
    $type = $values['type'] ?? 'dropdown';
    $trigger = $values['trigger'] ?? 'More Options';
    $itemsText = $values['items'] ?? 'Settings|settings|settings\nProfile|person|profile\n---\nLogout|logout|logout';
    $position = $values['position'] ?? 'bottom-start';

    // Parse items
    $items = [];
    $lines = explode("\n", trim($itemsText));
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '---') {
            $items[] = ['type' => 'divider'];
        } elseif ($line) {
            $parts = explode('|', $line);
            $items[] = [
                'text' => $parts[0] ?? 'Item',
                'icon' => $parts[1] ?? null,
                'onclick' => 'alert("' . ($parts[2] ?? 'action') . '")'
            ];
        }
    }

    $triggerButton = "<button class=\"md3-button md3-button--filled\">{$trigger}</button>";

    if ($type === 'context') {
        return MD3Menu::context($items, ['target' => '.preview-area']);
    } else {
        return MD3Menu::dropdown($triggerButton, $items, ['position' => $position]);
    }
}

function generateMenuPHP($values) {
    $type = $values['type'] ?? 'dropdown';
    $trigger = addslashes($values['trigger'] ?? 'More Options');
    $itemsText = $values['items'] ?? 'Settings|settings|settings\nProfile|person|profile\n---\nLogout|logout|logout';
    $position = $values['position'] ?? 'bottom-start';

    $code = "<?php\n";
    $code .= "require_once 'src/MD3Menu.php';\n\n";
    $code .= "\$items = [\n";

    $lines = explode("\n", trim($itemsText));
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '---') {
            $code .= "    ['type' => 'divider'],\n";
        } elseif ($line) {
            $parts = explode('|', $line);
            $text = addslashes($parts[0] ?? 'Item');
            $icon = !empty($parts[1]) ? "'" . addslashes($parts[1]) . "'" : 'null';
            $action = addslashes($parts[2] ?? 'action');
            $code .= "    ['text' => '{$text}', 'icon' => {$icon}, 'onclick' => 'alert(\"{$action}\")'],\n";
        }
    }
    $code .= "];\n\n";

    if ($type === 'context') {
        $code .= "echo MD3Menu::context(\$items, ['target' => '.preview-area']);";
    } else {
        $code .= "\$triggerButton = \"<button class='md3-button md3-button--filled'>{$trigger}</button>\";\n";
        $code .= "echo MD3Menu::dropdown(\$triggerButton, \$items, ['position' => '{$position}']);";
    }

    return $code;
}

function generateDialog($values) {
    $type = $values['type'] ?? 'basic';
    $title = $values['title'] ?? 'Dialog Title';
    $content = $values['content'] ?? 'This is the dialog content.';
    $confirmText = $values['confirmText'] ?? 'OK';
    $cancelText = $values['cancelText'] ?? 'Cancel';

    $id = 'demo-dialog';

    switch ($type) {
        case 'alert':
            $dialog = MD3Dialog::alert($id, $title, $content, ['confirmText' => $confirmText]);
            break;
        case 'confirm':
            $dialog = MD3Dialog::confirm($id, $title, $content, [
                'confirmText' => $confirmText,
                'cancelText' => $cancelText
            ]);
            break;
        case 'fullscreen':
            $dialog = MD3Dialog::fullscreen($id, $title, $content);
            break;
        case 'form':
            $formContent = '<div class="md3-dialog__form"><input type="text" placeholder="Enter your name" required></div>';
            $dialog = MD3Dialog::form($id, $title, $formContent, [
                'submitText' => $confirmText,
                'cancelText' => $cancelText
            ]);
            break;
        default:
            $dialog = MD3Dialog::basic($id, $title, $content);
    }

    $trigger = "<button class=\"md3-button md3-button--filled\" onclick=\"MD3Dialog.open('{$id}')\">Open {$title}</button>";

    return $trigger . $dialog;
}

function generateDialogPHP($values) {
    $type = $values['type'] ?? 'basic';
    $title = addslashes($values['title'] ?? 'Dialog Title');
    $content = addslashes($values['content'] ?? 'This is the dialog content.');
    $confirmText = addslashes($values['confirmText'] ?? 'OK');
    $cancelText = addslashes($values['cancelText'] ?? 'Cancel');

    $code = "<?php\n";
    $code .= "require_once 'src/MD3Dialog.php';\n\n";
    $code .= "\$id = 'demo-dialog';\n";
    $code .= "\$title = '{$title}';\n";
    $code .= "\$content = '{$content}';\n\n";

    switch ($type) {
        case 'alert':
            $code .= "\$dialog = MD3Dialog::alert(\$id, \$title, \$content, ['confirmText' => '{$confirmText}']);\n";
            break;
        case 'confirm':
            $code .= "\$dialog = MD3Dialog::confirm(\$id, \$title, \$content, [\n";
            $code .= "    'confirmText' => '{$confirmText}',\n";
            $code .= "    'cancelText' => '{$cancelText}'\n";
            $code .= "]);\n";
            break;
        case 'fullscreen':
            $code .= "\$dialog = MD3Dialog::fullscreen(\$id, \$title, \$content);\n";
            break;
        case 'form':
            $code .= "\$formContent = '<div class=\"md3-dialog__form\"><input type=\"text\" placeholder=\"Enter your name\" required></div>';\n";
            $code .= "\$dialog = MD3Dialog::form(\$id, \$title, \$formContent, [\n";
            $code .= "    'submitText' => '{$confirmText}',\n";
            $code .= "    'cancelText' => '{$cancelText}'\n";
            $code .= "]);\n";
            break;
        default:
            $code .= "\$dialog = MD3Dialog::basic(\$id, \$title, \$content);\n";
    }

    $code .= "\n\$trigger = \"<button class='md3-button md3-button--filled' onclick='MD3Dialog.open('{\$id}')'>Open {\$title}</button>\";\n";
    $code .= "echo \$trigger . \$dialog;";

    return $code;
}
?>