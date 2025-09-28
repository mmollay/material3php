<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material3PHP - Global CSS Demo</title>

    <!-- Single CSS file like Fomantic-UI -->
    <link rel="stylesheet" href="dist/material3php.css">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <style>
        .demo-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
        }

        .hero {
            text-align: center;
            padding: 48px 0;
            background: var(--md-sys-color-primary-container);
            border-radius: 12px;
            margin-bottom: 32px;
            color: var(--md-sys-color-on-primary-container);
        }

        .demo-section {
            margin: 32px 0;
            padding: 24px;
            background: var(--md-sys-color-surface-container-low);
            border-radius: 12px;
        }

        .demo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin: 16px 0;
        }

        .demo-item {
            background: var(--md-sys-color-surface);
            padding: 16px;
            border-radius: 8px;
            border: 1px solid var(--md-sys-color-outline-variant);
        }
    </style>
</head>
<body>
    <div class="demo-container">
        <!-- Hero Section -->
        <div class="hero">
            <h1><span class="material-symbols-outlined">rocket_launch</span> Material3PHP Global CSS</h1>
            <p>Like Fomantic-UI but for Material Design 3 - Single CSS file approach!</p>
        </div>

        <!-- Buttons Demo -->
        <div class="demo-section">
            <h2><span class="material-symbols-outlined">smart_button</span> Buttons</h2>
            <div class="demo-grid">
                <div class="demo-item">
                    <h3>Standard Buttons</h3>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <md-filled-button>Filled</md-filled-button>
                        <md-outlined-button>Outlined</md-outlined-button>
                        <md-text-button>Text</md-text-button>
                        <md-elevated-button>Elevated</md-elevated-button>
                        <md-filled-tonal-button>Tonal</md-filled-tonal-button>
                    </div>
                </div>

                <div class="demo-item">
                    <h3>Icon Buttons</h3>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <md-icon-button><span class="material-symbols-outlined">favorite</span></md-icon-button>
                        <md-filled-icon-button><span class="material-symbols-outlined">add</span></md-filled-icon-button>
                        <md-filled-tonal-icon-button><span class="material-symbols-outlined">edit</span></md-filled-tonal-icon-button>
                        <md-outlined-icon-button><span class="material-symbols-outlined">share</span></md-outlined-icon-button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Text Fields Demo -->
        <div class="demo-section">
            <h2><span class="material-symbols-outlined">edit</span> Text Fields</h2>
            <div class="demo-grid">
                <div class="demo-item">
                    <h3>Filled Text Field</h3>
                    <md-filled-text-field label="Your Name">
                        <input type="text" placeholder="Enter your name">
                    </md-filled-text-field>
                </div>

                <div class="demo-item">
                    <h3>Outlined Text Field</h3>
                    <md-outlined-text-field label="Email Address">
                        <input type="email" placeholder="Enter your email">
                    </md-outlined-text-field>
                </div>
            </div>
        </div>

        <!-- Lists Demo -->
        <div class="demo-section">
            <h2><span class="material-symbols-outlined">list</span> Lists</h2>
            <div class="demo-grid">
                <div class="demo-item">
                    <h3>Navigation List</h3>
                    <ul class="md3-list">
                        <li class="md3-list-item md3-list-nav-active">
                            <div class="md3-list-item-start">
                                <span class="md3-list-icon">
                                    <span class="material-symbols-outlined">dashboard</span>
                                </span>
                            </div>
                            <div class="md3-list-item-content">
                                <div class="md3-list-item-text">Dashboard</div>
                            </div>
                            <div class="md3-list-item-end">
                                <span class="md3-list-badge">3</span>
                            </div>
                        </li>
                        <li class="md3-list-item">
                            <div class="md3-list-item-start">
                                <span class="md3-list-icon">
                                    <span class="material-symbols-outlined">settings</span>
                                </span>
                            </div>
                            <div class="md3-list-item-content">
                                <div class="md3-list-item-text">Settings</div>
                            </div>
                        </li>
                        <li class="md3-list-item">
                            <div class="md3-list-item-start">
                                <span class="md3-list-icon">
                                    <span class="material-symbols-outlined">help</span>
                                </span>
                            </div>
                            <div class="md3-list-item-content">
                                <div class="md3-list-item-text">Help</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="demo-item">
                    <h3>List with Avatars</h3>
                    <ul class="md3-list">
                        <li class="md3-list-item">
                            <div class="md3-list-item-start">
                                <div class="md3-list-avatar">JD</div>
                            </div>
                            <div class="md3-list-item-content">
                                <div class="md3-list-item-text">John Doe</div>
                                <div class="md3-list-item-subtext">Online now</div>
                            </div>
                        </li>
                        <li class="md3-list-item">
                            <div class="md3-list-item-start">
                                <div class="md3-list-avatar">AS</div>
                            </div>
                            <div class="md3-list-item-content">
                                <div class="md3-list-item-text">Anna Smith</div>
                                <div class="md3-list-item-subtext">2 min ago</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Cards Demo -->
        <div class="demo-section">
            <h2><span class="material-symbols-outlined">credit_card</span> Cards</h2>
            <div class="demo-grid">
                <md-elevated-card>
                    <h3>Elevated Card</h3>
                    <p>This is an elevated card with shadow and Material Design 3 styling.</p>
                    <md-filled-button>Action</md-filled-button>
                </md-elevated-card>

                <md-outlined-card>
                    <h3>Outlined Card</h3>
                    <p>This is an outlined card with a border and clean look.</p>
                    <md-outlined-button>Learn More</md-outlined-button>
                </md-outlined-card>
            </div>
        </div>

        <!-- Chips Demo -->
        <div class="demo-section">
            <h2><span class="material-symbols-outlined">label</span> Chips</h2>
            <div class="demo-item">
                <h3>Filter Chips</h3>
                <md-chip-set>
                    <md-filter-chip selected>All</md-filter-chip>
                    <md-filter-chip>Photos</md-filter-chip>
                    <md-filter-chip>Videos</md-filter-chip>
                    <md-filter-chip>Documents</md-filter-chip>
                </md-chip-set>
            </div>
        </div>

        <!-- FAB Demo -->
        <div class="demo-section">
            <h2><span class="material-symbols-outlined">add_circle</span> Floating Action Button</h2>
            <div class="demo-item">
                <p>Floating Action Button for primary actions:</p>
                <md-fab>
                    <span class="material-symbols-outlined">add</span>
                </md-fab>
            </div>
        </div>

        <!-- Theme Toggle -->
        <div class="demo-section">
            <h2><span class="material-symbols-outlined">dark_mode</span> Theme Toggle</h2>
            <div class="demo-item">
                <p>Toggle between light and dark themes:</p>
                <md-outlined-button onclick="toggleTheme()">
                    <span class="material-symbols-outlined">palette</span>
                    Toggle Theme
                </md-outlined-button>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: center; margin-top: 48px; padding: 24px; border-top: 1px solid var(--md-sys-color-outline-variant);">
            <p style="color: var(--md-sys-color-on-surface-variant);">
                <span class="material-symbols-outlined">favorite</span> Made with Material3PHP Global CSS •
                <strong>Single file approach like Fomantic-UI</strong>
            </p>
        </div>
    </div>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            html.setAttribute('data-theme', currentTheme === 'dark' ? 'light' : 'dark');
        }
    </script>
</body>
</html>