<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Design 3 PHP Library - Interactive Playground</title>
    <?php
    require_once 'src/MD3.php';
    require_once 'src/MD3Button.php';
    require_once 'src/MD3TextField.php';
    require_once 'src/MD3Card.php';
    require_once 'src/MD3List.php';
    require_once 'src/MD3Switch.php';
    require_once 'src/MD3Checkbox.php';
    require_once 'src/MD3Radio.php';
    require_once 'src/MD3Select.php';
    require_once 'src/MD3Chip.php';
    require_once 'src/MD3Theme.php';

    // Get theme from URL parameter or default
    $currentTheme = $_GET['theme'] ?? 'default';

    echo MD3::init(true, true, $currentTheme);
    echo MD3Theme::getThemeCSS();
    echo MD3List::getListCSS();
    echo MD3::getVersionCSS();
    ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Google Sans', 'Roboto', system-ui, sans-serif;
            background: var(--md-sys-color-background);
            color: var(--md-sys-color-on-background);
            overflow-x: hidden;
        }

        /* Layout */
        .playground-container {
            display: grid;
            grid-template-areas:
                "header header"
                "sidebar content";
            grid-template-columns: 280px 1fr;
            grid-template-rows: 64px 1fr;
            min-height: 100vh;
        }

        .playground-header {
            grid-area: header;
            background: var(--md-sys-color-surface);
            border-bottom: 1px solid var(--md-sys-color-outline-variant);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
        }

        .playground-sidebar {
            grid-area: sidebar;
            background: var(--md-sys-color-surface);
            border-right: 1px solid var(--md-sys-color-outline-variant);
            overflow-y: auto;
            padding: 16px;
        }

        .playground-content {
            grid-area: content;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 0;
            min-height: calc(100vh - 64px);
        }

        .component-preview {
            padding: 24px;
            background: var(--md-sys-color-background);
            overflow-y: auto;
        }

        .component-controls {
            background: var(--md-sys-color-surface-container-lowest);
            border-left: 1px solid var(--md-sys-color-outline-variant);
            padding: 24px;
            overflow-y: auto;
        }

        /* Navigation */
        .nav-section {
            margin-bottom: 24px;
        }

        .nav-section h3 {
            font-size: 14px;
            font-weight: 600;
            color: var(--md-sys-color-primary);
            margin-bottom: 8px;
            padding: 0 16px;
        }

        .nav-item {
            display: block;
            padding: 12px 16px;
            border-radius: 24px;
            text-decoration: none;
            color: var(--md-sys-color-on-surface);
            font-size: 14px;
            margin-bottom: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: var(--md-sys-color-surface-container-high);
        }

        .nav-item.active {
            background: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            font-weight: 500;
        }

        /* Preview Area */
        .preview-area {
            background: var(--md-sys-color-surface);
            border-radius: 12px;
            padding: 32px;
            margin-bottom: 24px;
            border: 1px solid var(--md-sys-color-outline-variant);
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        /* Code Display */
        .code-section {
            background: var(--md-sys-color-surface-container);
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
            font-family: 'Roboto Mono', monospace;
            font-size: 13px;
            line-height: 1.4;
            overflow-x: auto;
        }

        .code-section h4 {
            margin-bottom: 12px;
            color: var(--md-sys-color-on-surface);
            font-family: inherit;
        }

        .code-section pre {
            background: var(--md-sys-color-surface-variant);
            padding: 12px;
            border-radius: 4px;
            color: var(--md-sys-color-on-surface-variant);
            white-space: pre-wrap;
            position: relative;
        }

        /* Controls */
        .control-group {
            margin-bottom: 24px;
        }

        .control-group h4 {
            font-size: 16px;
            margin-bottom: 12px;
            color: var(--md-sys-color-on-surface);
        }

        .control-item {
            margin-bottom: 16px;
        }

        .control-item label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--md-sys-color-on-surface-variant);
            margin-bottom: 8px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .playground-content {
                grid-template-columns: 1fr;
                grid-template-rows: 1fr auto;
            }

            .component-controls {
                border-left: none;
                border-top: 1px solid var(--md-sys-color-outline-variant);
            }
        }

        @media (max-width: 768px) {
            .playground-container {
                grid-template-areas:
                    "header"
                    "content";
                grid-template-columns: 1fr;
            }

            .playground-sidebar {
                display: none;
            }
        }

        /* Custom styling for form elements */
        .control-item select,
        .control-item input[type="text"],
        .control-item input[type="number"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--md-sys-color-outline);
            border-radius: 4px;
            background: var(--md-sys-color-surface);
            color: var(--md-sys-color-on-surface);
            font-size: 14px;
        }

        .theme-selector-playground {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 16px;
        }

        .theme-chip {
            padding: 6px 12px;
            border: 1px solid var(--md-sys-color-outline);
            border-radius: 16px;
            background: var(--md-sys-color-surface);
            color: var(--md-sys-color-on-surface);
            text-decoration: none;
            font-size: 12px;
            transition: all 0.2s ease;
        }

        .theme-chip.active {
            background: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
            border-color: var(--md-sys-color-primary);
        }

        .copy-button {
            position: absolute;
            top: 8px;
            right: 8px;
            background: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="playground-container">
        <!-- Header -->
        <header class="playground-header">
            <h1 style="font-size: 20px; font-weight: 500; color: var(--md-sys-color-primary);">
                <?php echo MD3::icon('play_arrow'); ?> Material Design 3 PHP Playground
            </h1>
            <div style="margin-left: auto; display: flex; gap: 12px;">
                <?php
                echo '<a href="index.php' . ($currentTheme !== 'default' ? '?theme=' . $currentTheme : '') . '" style="text-decoration: none;">' . MD3Button::text('← Zurück zur Demo') . '</a>';
                ?>
            </div>
        </header>

        <!-- Sidebar Navigation -->
        <nav class="playground-sidebar">
            <div class="theme-selector-playground">
                <?php
                $themes = MD3Theme::getAvailableThemes();
                foreach ($themes as $key => $theme) {
                    $isActive = $key === $currentTheme;
                    $url = 'playground.php?theme=' . $key . '&component=' . ($_GET['component'] ?? 'button');
                    echo '<a href="' . $url . '" class="theme-chip' . ($isActive ? ' active' : '') . '">';
                    echo MD3::icon($theme['icon']) . ' ' . $theme['name'];
                    echo '</a>';
                }
                ?>
            </div>

            <div class="nav-section">
                <h3>Basic Components</h3>
                <a href="?component=button&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? 'button') === 'button' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('smart_button'); ?> Button
                </a>
                <a href="?component=textfield&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'textfield' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('text_fields'); ?> TextField
                </a>
                <a href="?component=card&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'card' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('web_stories'); ?> Card
                </a>
            </div>

            <div class="nav-section">
                <h3>Form Controls</h3>
                <a href="?component=select&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'select' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('arrow_drop_down'); ?> Select
                </a>
                <a href="?component=switch&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'switch' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('toggle_on'); ?> Switch
                </a>
                <a href="?component=checkbox&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'checkbox' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('check_box'); ?> Checkbox
                </a>
                <a href="?component=radio&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'radio' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('radio_button_checked'); ?> Radio
                </a>
            </div>

            <div class="nav-section">
                <h3>Collections</h3>
                <a href="?component=list&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'list' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('list'); ?> List
                </a>
                <a href="?component=chip&theme=<?php echo $currentTheme; ?>" class="nav-item <?php echo ($_GET['component'] ?? '') === 'chip' ? 'active' : ''; ?>">
                    <?php echo MD3::icon('label'); ?> Chip
                </a>
            </div>

            <div class="nav-section">
                <h3>Information</h3>
                <div style="padding: 12px 16px; font-size: 12px; color: var(--md-sys-color-on-surface-variant);">
                    <div><strong>Version:</strong> <?php echo MD3::getVersion(); ?></div>
                    <div><strong>Komponenten:</strong> <?php echo count(MD3::getVersionInfo()['components']); ?></div>
                    <div><strong>Theme:</strong> <?php echo ucfirst($currentTheme); ?></div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="playground-content">
            <div class="component-preview">
                <div id="preview-area" class="preview-area">
                    <!-- Component will be rendered here -->
                </div>

                <div class="code-section">
                    <h4><?php echo MD3::icon('code'); ?> PHP Code</h4>
                    <pre id="php-code">
                        <button class="copy-button" onclick="copyCode('php')">Copy</button>
                        <code id="php-code-content">// PHP code will appear here</code>
                    </pre>
                </div>

                <div class="code-section">
                    <h4><?php echo MD3::icon('html'); ?> Generated HTML</h4>
                    <pre id="html-code">
                        <button class="copy-button" onclick="copyCode('html')">Copy</button>
                        <code id="html-code-content"><!-- HTML output will appear here --></code>
                    </pre>
                </div>
            </div>

            <div class="component-controls">
                <h3 style="margin-bottom: 20px; color: var(--md-sys-color-primary);">
                    <?php echo MD3::icon('tune'); ?> Component Controls
                </h3>

                <div id="component-controls">
                    <!-- Controls will be dynamically generated -->
                </div>

                <?php echo MD3::getVersionDisplay(); ?>
            </div>
        </main>
    </div>

    <?php echo MD3List::getListScript(); ?>
    <?php echo MD3Theme::getThemeScript(); ?>

    <script>
        // Component configurations
        const componentConfigs = {
            button: {
                name: 'Button',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Button Type',
                        options: {
                            'filled': 'Filled',
                            'outlined': 'Outlined',
                            'text': 'Text',
                            'elevated': 'Elevated',
                            'tonal': 'Tonal'
                        },
                        default: 'filled'
                    },
                    text: {
                        type: 'text',
                        label: 'Button Text',
                        default: 'Click me'
                    },
                    icon: {
                        type: 'text',
                        label: 'Icon (optional)',
                        default: '',
                        placeholder: 'e.g. favorite, add, delete'
                    },
                    disabled: {
                        type: 'checkbox',
                        label: 'Disabled',
                        default: false
                    }
                }
            },
            textfield: {
                name: 'TextField',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Field Type',
                        options: {
                            'filled': 'Filled',
                            'outlined': 'Outlined'
                        },
                        default: 'filled'
                    },
                    label: {
                        type: 'text',
                        label: 'Label Text',
                        default: 'Enter text'
                    },
                    placeholder: {
                        type: 'text',
                        label: 'Placeholder',
                        default: ''
                    },
                    leadingIcon: {
                        type: 'text',
                        label: 'Leading Icon',
                        default: '',
                        placeholder: 'e.g. person, search'
                    },
                    trailingIcon: {
                        type: 'text',
                        label: 'Trailing Icon',
                        default: '',
                        placeholder: 'e.g. visibility, clear'
                    }
                }
            },
            card: {
                name: 'Card',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Card Type',
                        options: {
                            'elevated': 'Elevated',
                            'filled': 'Filled',
                            'outlined': 'Outlined'
                        },
                        default: 'elevated'
                    },
                    title: {
                        type: 'text',
                        label: 'Title',
                        default: 'Card Title'
                    },
                    content: {
                        type: 'textarea',
                        label: 'Content',
                        default: 'This is the card content area where you can add descriptive text.'
                    },
                    icon: {
                        type: 'text',
                        label: 'Icon (optional)',
                        default: '',
                        placeholder: 'e.g. info, warning'
                    }
                }
            },
            select: {
                name: 'Select',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Select Type',
                        options: {
                            'filled': 'Filled',
                            'outlined': 'Outlined'
                        },
                        default: 'filled'
                    },
                    label: {
                        type: 'text',
                        label: 'Label',
                        default: 'Choose option'
                    },
                    options: {
                        type: 'textarea',
                        label: 'Options (one per line)',
                        default: 'Option 1\nOption 2\nOption 3'
                    }
                }
            },
            switch: {
                name: 'Switch',
                controls: {
                    label: {
                        type: 'text',
                        label: 'Label Text',
                        default: 'Enable notifications'
                    },
                    checked: {
                        type: 'checkbox',
                        label: 'Initially Checked',
                        default: false
                    }
                }
            },
            checkbox: {
                name: 'Checkbox',
                controls: {
                    label: {
                        type: 'text',
                        label: 'Label Text',
                        default: 'I agree to the terms'
                    },
                    checked: {
                        type: 'checkbox',
                        label: 'Initially Checked',
                        default: false
                    }
                }
            },
            radio: {
                name: 'Radio',
                controls: {
                    options: {
                        type: 'textarea',
                        label: 'Options (one per line)',
                        default: 'Option A\nOption B\nOption C'
                    },
                    selected: {
                        type: 'number',
                        label: 'Selected Option (0-based)',
                        default: 0
                    }
                }
            },
            list: {
                name: 'List',
                controls: {
                    type: {
                        type: 'select',
                        label: 'List Type',
                        options: {
                            'simple': 'Simple List',
                            'twoLine': 'Two Line',
                            'withAvatars': 'With Avatars'
                        },
                        default: 'simple'
                    },
                    items: {
                        type: 'textarea',
                        label: 'Items (one per line)',
                        default: 'Inbox\nStarred\nSent mail\nDrafts'
                    }
                }
            },
            chip: {
                name: 'Chip',
                controls: {
                    type: {
                        type: 'select',
                        label: 'Chip Type',
                        options: {
                            'assist': 'Assist Chip',
                            'filter': 'Filter Chip',
                            'input': 'Input Chip'
                        },
                        default: 'assist'
                    },
                    labels: {
                        type: 'textarea',
                        label: 'Chip Labels (one per line)',
                        default: 'Design\nDevelopment\nTesting'
                    }
                }
            }
        };

        // Current state
        let currentComponent = '<?php echo $_GET['component'] ?? 'button'; ?>';
        let currentValues = {};

        // Initialize playground
        document.addEventListener('DOMContentLoaded', function() {
            loadComponent(currentComponent);
        });

        function loadComponent(componentName) {
            currentComponent = componentName;
            const config = componentConfigs[componentName];

            if (!config) {
                console.error('Component not found:', componentName);
                return;
            }

            // Generate controls
            generateControls(config.controls);

            // Initial render
            updatePreview();
        }

        function generateControls(controls) {
            const container = document.getElementById('component-controls');
            container.innerHTML = '';

            Object.keys(controls).forEach(key => {
                const control = controls[key];
                currentValues[key] = control.default;

                const controlGroup = document.createElement('div');
                controlGroup.className = 'control-group';

                const label = document.createElement('label');
                label.textContent = control.label;
                controlGroup.appendChild(label);

                let input;

                switch (control.type) {
                    case 'select':
                        input = document.createElement('select');
                        Object.keys(control.options).forEach(optionKey => {
                            const option = document.createElement('option');
                            option.value = optionKey;
                            option.textContent = control.options[optionKey];
                            if (optionKey === control.default) option.selected = true;
                            input.appendChild(option);
                        });
                        break;

                    case 'textarea':
                        input = document.createElement('textarea');
                        input.value = control.default;
                        input.rows = 4;
                        break;

                    case 'checkbox':
                        input = document.createElement('input');
                        input.type = 'checkbox';
                        input.checked = control.default;
                        break;

                    case 'number':
                        input = document.createElement('input');
                        input.type = 'number';
                        input.value = control.default;
                        input.min = 0;
                        break;

                    default:
                        input = document.createElement('input');
                        input.type = 'text';
                        input.value = control.default;
                        if (control.placeholder) {
                            input.placeholder = control.placeholder;
                        }
                }

                input.addEventListener('change', function() {
                    currentValues[key] = input.type === 'checkbox' ? input.checked : input.value;
                    updatePreview();
                });

                controlGroup.appendChild(input);
                container.appendChild(controlGroup);
            });
        }

        function updatePreview() {
            // Generate component based on current values
            const data = {
                component: currentComponent,
                values: currentValues
            };

            // Make AJAX request to generate component
            fetch('playground-api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('preview-area').innerHTML = data.html;
                document.getElementById('php-code-content').textContent = data.php;
                document.getElementById('html-code-content').textContent = data.html;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('preview-area').innerHTML = '<div style="color: var(--md-sys-color-error);">Error generating component</div>';
            });
        }

        function copyCode(type) {
            const codeElement = document.getElementById(type + '-code-content');
            const text = codeElement.textContent;

            navigator.clipboard.writeText(text).then(function() {
                // Show success feedback
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.style.background = 'var(--md-sys-color-primary)';

                setTimeout(() => {
                    button.textContent = originalText;
                    button.style.background = 'var(--md-sys-color-primary)';
                }, 2000);
            });
        }

        // Load component from URL
        const urlParams = new URLSearchParams(window.location.search);
        const componentParam = urlParams.get('component');
        if (componentParam && componentConfigs[componentParam]) {
            currentComponent = componentParam;
        }
    </script>
</body>
</html>