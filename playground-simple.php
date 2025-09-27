<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Design 3 PHP Library - Simple Playground</title>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Basic includes only
    require_once 'src/MD3.php';
    require_once 'src/MD3Button.php';
    require_once 'src/MD3TextField.php';
    require_once 'src/MD3Theme.php';

    // Get theme and component
    $currentTheme = $_GET['theme'] ?? 'default';
    $currentComponent = $_GET['component'] ?? 'button';

    // Initialize with error handling
    try {
        echo MD3::init(true, true, $currentTheme);
    } catch (Exception $e) {
        echo "<!-- Error: " . $e->getMessage() . " -->";
    }
    ?>
    <style>
    <?php
    if (class_exists('MD3Theme')) {
        echo MD3Theme::getThemeCSS();
    }
    ?>
        body {
            font-family: 'Roboto', system-ui, sans-serif;
            background: var(--md-sys-color-background);
            color: var(--md-sys-color-on-background);
            padding: 24px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .playground-header {
            background: var(--md-sys-color-surface);
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            border: 1px solid var(--md-sys-color-outline-variant);
        }

        .playground-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 24px;
        }

        .component-controls {
            background: var(--md-sys-color-surface);
            padding: 24px;
            border-radius: 12px;
            border: 1px solid var(--md-sys-color-outline-variant);
        }

        .component-preview {
            background: var(--md-sys-color-surface);
            padding: 24px;
            border-radius: 12px;
            border: 1px solid var(--md-sys-color-outline-variant);
        }

        .preview-area {
            background: var(--md-sys-color-background);
            padding: 32px;
            border-radius: 8px;
            border: 1px solid var(--md-sys-color-outline-variant);
            margin-bottom: 24px;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .nav-item {
            display: block;
            padding: 12px 16px;
            margin: 4px 0;
            border-radius: 24px;
            text-decoration: none;
            color: var(--md-sys-color-on-surface);
            transition: background-color 0.2s;
        }

        .nav-item:hover {
            background: var(--md-sys-color-surface-container-high);
        }

        .nav-item.active {
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
        }

        .control-group {
            margin-bottom: 16px;
        }

        .control-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--md-sys-color-on-surface);
        }

        .control-group select,
        .control-group input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--md-sys-color-outline);
            border-radius: 4px;
            background: var(--md-sys-color-background);
            color: var(--md-sys-color-on-background);
        }

        code {
            background: var(--md-sys-color-surface-variant);
            padding: 16px;
            border-radius: 8px;
            display: block;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            white-space: pre-wrap;
            color: var(--md-sys-color-on-surface-variant);
            margin-top: 16px;
        }

        /* Enhanced Radio Button Styling */
        .control-group label:has(input[type="radio"]):hover {
            background: var(--md-sys-color-surface-container-high);
            border-color: var(--md-sys-color-primary);
        }

        .control-group label:has(input[type="radio"]:checked) {
            background: var(--md-sys-color-primary-container);
            border-color: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary-container);
        }

        .control-group label:has(input[type="checkbox"]):hover {
            background: var(--md-sys-color-surface-container-high);
            border-color: var(--md-sys-color-primary);
        }

        /* Enhanced input styling */
        input[type="radio"] {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid var(--md-sys-color-outline);
            border-radius: 50%;
            position: relative;
            margin-right: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        input[type="radio"]:checked {
            border-color: var(--md-sys-color-primary);
            background: var(--md-sys-color-primary-container);
        }

        input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--md-sys-color-primary);
        }

        @media (max-width: 768px) {
            .playground-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="playground-header">
        <h1 style="margin: 0 0 16px 0; color: var(--md-sys-color-primary);">
            🎮 Material Design 3 PHP Playground
        </h1>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <?php
            try {
                $themes = ['default' => 'Standard', 'ocean' => 'Ocean', 'forest' => 'Forest', 'sunset' => 'Sunset', 'minimal' => 'Minimal'];
                foreach ($themes as $key => $name) {
                    $active = $key === $currentTheme ? ' active' : '';
                    $url = "playground-simple.php?theme={$key}&component={$currentComponent}";
                    echo "<a href=\"{$url}\" class=\"nav-item{$active}\">{$name}</a>";
                }
            } catch (Exception $e) {
                echo "<!-- Theme error: " . $e->getMessage() . " -->";
            }
            ?>
        </div>
    </header>

    <div class="playground-content">
        <nav class="component-controls">
            <h3 style="margin: 0 0 16px 0; color: var(--md-sys-color-primary);">Components</h3>

            <a href="?component=button&theme=<?php echo $currentTheme; ?>"
               class="nav-item <?php echo $currentComponent === 'button' ? 'active' : ''; ?>">
                Button
            </a>

            <a href="?component=textfield&theme=<?php echo $currentTheme; ?>"
               class="nav-item <?php echo $currentComponent === 'textfield' ? 'active' : ''; ?>">
                TextField
            </a>

            <div style="margin-top: 32px;">
                <h4 style="color: var(--md-sys-color-primary); margin-bottom: 12px;">Quick Controls</h4>

                <?php if ($currentComponent === 'button'): ?>
                    <div class="control-group">
                        <?php echo MD3TextField::outlined('button_type_select', 'Button Type', 'filled', ['readonly' => true]); ?>
                        <div style="margin-top: 8px; display: grid; gap: 8px;">
                            <label style="display: flex; align-items: center; padding: 8px 12px; border-radius: 20px; border: 1px solid var(--md-sys-color-outline); cursor: pointer; transition: all 0.2s;">
                                <input type="radio" name="button_type" value="filled" checked onchange="updateButtonType(this.value)" style="margin-right: 8px;">
                                <span>Filled Button</span>
                            </label>
                            <label style="display: flex; align-items: center; padding: 8px 12px; border-radius: 20px; border: 1px solid var(--md-sys-color-outline); cursor: pointer; transition: all 0.2s;">
                                <input type="radio" name="button_type" value="outlined" onchange="updateButtonType(this.value)" style="margin-right: 8px;">
                                <span>Outlined Button</span>
                            </label>
                            <label style="display: flex; align-items: center; padding: 8px 12px; border-radius: 20px; border: 1px solid var(--md-sys-color-outline); cursor: pointer; transition: all 0.2s;">
                                <input type="radio" name="button_type" value="text" onchange="updateButtonType(this.value)" style="margin-right: 8px;">
                                <span>Text Button</span>
                            </label>
                            <label style="display: flex; align-items: center; padding: 8px 12px; border-radius: 20px; border: 1px solid var(--md-sys-color-outline); cursor: pointer; transition: all 0.2s;">
                                <input type="radio" name="button_type" value="elevated" onchange="updateButtonType(this.value)" style="margin-right: 8px;">
                                <span>Elevated Button</span>
                            </label>
                            <label style="display: flex; align-items: center; padding: 8px 12px; border-radius: 20px; border: 1px solid var(--md-sys-color-outline); cursor: pointer; transition: all 0.2s;">
                                <input type="radio" name="button_type" value="tonal" onchange="updateButtonType(this.value)" style="margin-right: 8px;">
                                <span>Tonal Button</span>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo MD3TextField::outlined('button_text', 'Button Text', 'Click me', ['oninput' => 'updateButtonText(this.value)']); ?>
                    </div>

                    <div class="control-group">
                        <?php echo MD3TextField::outlined('button_icon', 'Icon (optional)', '', ['placeholder' => 'z.B. home, settings, favorite', 'oninput' => 'updateButtonIcon(this.value)']); ?>
                        <div style="font-size: 12px; color: var(--md-sys-color-on-surface-variant); margin-top: 4px;">
                            Material Symbols Name eingeben
                        </div>
                    </div>

                    <div class="control-group">
                        <label style="display: flex; align-items: center; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--md-sys-color-outline); cursor: pointer; transition: all 0.2s; background: var(--md-sys-color-surface);">
                            <input type="checkbox" onchange="updateButtonDisabled(this.checked)" style="margin-right: 12px; width: 18px; height: 18px; accent-color: var(--md-sys-color-primary);">
                            <div>
                                <div style="font-weight: 500; color: var(--md-sys-color-on-surface);">Disabled State</div>
                                <div style="font-size: 12px; color: var(--md-sys-color-on-surface-variant);">Button ist nicht klickbar</div>
                            </div>
                        </label>
                    </div>
                <?php endif; ?>

                <?php if ($currentComponent === 'textfield'): ?>
                    <div class="control-group">
                        <label>Field Type:</label>
                        <select onchange="updateFieldType(this.value)">
                            <option value="filled">Filled</option>
                            <option value="outlined">Outlined</option>
                        </select>
                    </div>
                    <div class="control-group">
                        <label>Label:</label>
                        <input type="text" value="Enter text" onchange="updateFieldLabel(this.value)">
                    </div>
                <?php endif; ?>
            </div>

            <div style="margin-top: 32px; padding-top: 16px; border-top: 1px solid var(--md-sys-color-outline-variant);">
                <p style="font-size: 12px; color: var(--md-sys-color-on-surface-variant); margin: 0;">
                    <strong>Version:</strong> <?php echo MD3::getVersion(); ?><br>
                    <strong>Theme:</strong> <?php echo ucfirst($currentTheme); ?>
                </p>
            </div>
        </nav>

        <main class="component-preview">
            <div id="preview-area" class="preview-area">
                <?php
                try {
                    // Generate component based on current component
                    switch ($currentComponent) {
                        case 'button':
                            echo MD3Button::filled('Click me');
                            echo MD3Button::outlined('Outlined');
                            echo MD3Button::text('Text Button');
                            break;

                        case 'textfield':
                            echo MD3TextField::filled('demo_field', 'Enter text');
                            echo '<div style="height: 16px;"></div>';
                            echo MD3TextField::outlined('demo_field2', 'Outlined field');
                            break;

                        default:
                            echo '<p style="color: var(--md-sys-color-on-surface-variant);">Select a component from the sidebar</p>';
                    }
                } catch (Exception $e) {
                    echo '<p style="color: var(--md-sys-color-error);">Error: ' . $e->getMessage() . '</p>';
                }
                ?>
            </div>

            <div>
                <h4 style="color: var(--md-sys-color-primary); margin-bottom: 12px;">PHP Code:</h4>
                <code id="php-code">
<?php
// Generate code example
try {
    switch ($currentComponent) {
        case 'button':
            echo "echo MD3Button::filled('Click me');\n";
            echo "echo MD3Button::outlined('Outlined');\n";
            echo "echo MD3Button::text('Text Button');";
            break;

        case 'textfield':
            echo "echo MD3TextField::filled('demo_field', 'Enter text');\n";
            echo "echo MD3TextField::outlined('demo_field2', 'Outlined field');";
            break;

        default:
            echo "// Select a component to see code";
    }
} catch (Exception $e) {
    echo "// Error generating code: " . $e->getMessage();
}
?>
                </code>
            </div>
        </main>
    </div>

    <script>
        // Button control state
        let buttonState = {
            type: 'filled',
            text: 'Click me',
            icon: '',
            disabled: false
        };

        function updateButtonType(type) {
            buttonState.type = type;
            console.log('Button type changed to:', type);
            updateButtonPreview();
            updateButtonCode();
        }

        function updateButtonText(text) {
            buttonState.text = text;
            console.log('Button text changed to:', text);
            updateButtonPreview();
            updateButtonCode();
        }

        function updateButtonIcon(icon) {
            buttonState.icon = icon;
            console.log('Button icon changed to:', icon);
            updateButtonPreview();
            updateButtonCode();
        }

        function updateButtonDisabled(disabled) {
            buttonState.disabled = disabled;
            console.log('Button disabled changed to:', disabled);
            updateButtonPreview();
            updateButtonCode();
        }

        function updateButtonPreview() {
            // This would require AJAX call to generate new HTML
            // For now just log the state
            console.log('Current button state:', buttonState);
        }

        function updateButtonCode() {
            const codeElement = document.getElementById('php-code');
            if (codeElement && buttonState) {
                let code = '';
                const options = [];

                if (buttonState.icon) {
                    options.push(`'icon' => '${buttonState.icon}'`);
                }
                if (buttonState.disabled) {
                    options.push(`'disabled' => true`);
                }

                const optionsStr = options.length > 0 ? `, [${options.join(', ')}]` : '';

                switch (buttonState.type) {
                    case 'filled':
                        code = `echo MD3Button::filled('${buttonState.text}'${optionsStr});`;
                        break;
                    case 'outlined':
                        code = `echo MD3Button::outlined('${buttonState.text}'${optionsStr});`;
                        break;
                    case 'text':
                        code = `echo MD3Button::text('${buttonState.text}'${optionsStr});`;
                        break;
                    case 'elevated':
                        code = `echo MD3Button::elevated('${buttonState.text}'${optionsStr});`;
                        break;
                    case 'tonal':
                        code = `echo MD3Button::tonal('${buttonState.text}'${optionsStr});`;
                        break;
                }

                codeElement.textContent = code;
            }
        }

        function updateFieldType(type) {
            console.log('Field type changed to:', type);
        }

        function updateFieldLabel(label) {
            console.log('Field label changed to:', label);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateButtonCode();
        });
    </script>
</body>
</html>