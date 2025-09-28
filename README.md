# Material Design 3 PHP Library

![Material Design 3](https://img.shields.io/badge/Material%20Design-3-blue)
![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.0-777BB4)
![License](https://img.shields.io/badge/License-MIT-green)
![Version](https://img.shields.io/badge/Version-0.2.43-orange)

A **pure PHP implementation** of Google's Material Design 3 system. No JavaScript dependencies, no build tools required - just include and use!

## ✨ Features

- 🎨 **31+ Material Design 3 Components**
- 🎭 **5 Built-in Themes** (Default, Ocean, Forest, Sunset, Monochrome)
- 📱 **Fully Responsive** - Mobile-first design
- 🌙 **Dark/Light Mode** - Automatic theme switching
- 🚀 **Zero Dependencies** - Pure PHP & CSS
- 🎯 **Easy Integration** - Drop-in components
- ♿ **Accessible** - ARIA compliant
- 🌐 **i18n Ready** - Multi-language support

## 🚀 Quick Start

### Composer Installation (Recommended)

```bash
composer require mmollay/material3php
```

### Manual Installation

```bash
git clone https://github.com/mmollay/material3php.git
```

### Basic Usage

```php
<?php
require_once 'vendor/autoload.php'; // or manual include
use Material3PHP\MD3;

// Initialize Material Design 3
echo MD3::init();

// Create components
echo MD3Button::filled('Click Me');
echo MD3TextField::filled('name', 'Your Name');
echo MD3Card::elevated('Card Content');
?>
```

## 📦 Available Components

### Buttons & Actions
- `MD3Button` - Filled, Outlined, Text, Tonal buttons
- `MD3FloatingActionButton` - Primary, Secondary, Tertiary FABs
- `MD3IconButton` - Standard, Filled, Outlined icon buttons

### Input & Forms
- `MD3TextField` - Filled, Outlined text fields
- `MD3Select` - Dropdown selections
- `MD3Checkbox` - Material checkboxes
- `MD3Switch` - Toggle switches
- `MD3Slider` - Range sliders
- `MD3RadioButton` - Radio button groups

### Layout & Containers
- `MD3Card` - Elevated, Filled, Outlined cards
- `MD3List` - Single, Multi-line lists
- `MD3NavigationBar` - Bottom navigation
- `MD3NavigationDrawer` - Side navigation
- `MD3NavigationRail` - Rail navigation
- `MD3Divider` - Full-width, Inset dividers

### Feedback & Information
- `MD3Snackbar` - Toast notifications
- `MD3Dialog` - Modal dialogs
- `MD3Tooltip` - Contextual tooltips
- `MD3Progress` - Linear, Circular progress
- `MD3Badge` - Notification badges

### Advanced Components
- `MD3BottomSheet` - Modal bottom sheets
- `MD3Breadcrumb` - Navigation breadcrumbs
- `MD3Header` - App headers
- `MD3Theme` - Theme management

## 🎨 Theming

```php
// Initialize with theme
echo MD3::init(true, true, 'ocean');

// Available themes
$themes = MD3Theme::getAvailableThemes();
// 'default', 'ocean', 'forest', 'sunset', 'monochrome'

// Get theme CSS
echo MD3Theme::getThemeCSS();
```

## 🌙 Dark/Light Mode

```php
// Auto-detect system preference
echo MD3::init(true, true, 'default'); // Enables dark mode support

// JavaScript toggle (included)
echo MD3Theme::getThemeScript();
```

## 📱 Responsive Design

All components are mobile-first and responsive:

```php
// Responsive breakpoints automatically applied
echo MD3Card::elevated('
    <h3>Responsive Card</h3>
    <p>Adapts to all screen sizes</p>
');
```

## 🎯 Integration Examples

### Laravel Integration

```php
// In your Blade template
@php
    echo MD3::init(true, true, 'ocean');
@endphp

<div class="container">
    @php
        echo MD3Button::filled('Laravel + MD3');
        echo MD3TextField::filled('email', 'Email Address');
    @endphp
</div>
```

### WordPress Integration

```php
// In your theme functions.php
function enqueue_material3_php() {
    require_once get_template_directory() . '/vendor/autoload.php';
    echo MD3::init();
}
add_action('wp_head', 'enqueue_material3_php');

// In your templates
echo MD3Card::elevated(get_the_content());
```

### Vanilla PHP

```php
<!DOCTYPE html>
<html>
<head>
    <?php
    require_once 'vendor/autoload.php';
    echo MD3::init(true, true, 'ocean');
    ?>
</head>
<body>
    <?php
    echo MD3Button::filled('Hello World');
    echo MD3TextField::filled('name', 'Your Name');
    ?>
</body>
</html>
```

## 🔧 Advanced Configuration

### Custom Themes

```php
// Create custom theme colors
$customTheme = [
    'primary' => '#6750A4',
    'secondary' => '#625B71',
    'tertiary' => '#7D5260'
];

echo MD3Theme::generateCustomCSS($customTheme);
```

### Component Customization

```php
// Add custom attributes
echo MD3Button::filled('Submit', [
    'onclick' => 'submitForm()',
    'class' => 'custom-class',
    'id' => 'submit-btn'
]);

// Custom styling
echo MD3Card::elevated('Content', [
    'style' => 'max-width: 400px; margin: 0 auto;'
]);
```

## 📋 Requirements

- **PHP 8.0+**
- **No JavaScript dependencies**
- **No build process required**
- **Works with any PHP framework**

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **Google Material Design Team** - For the amazing Material Design 3 specifications
- **Claude Code** - Development assistance and code generation
- **PHP Community** - For continuous inspiration and support

## 📞 Support

- 📧 **Email**: office@ssi.at
- 🐛 **Issues**: [GitHub Issues](https://github.com/mmollay/material3php/issues)
- 💬 **Discussions**: [GitHub Discussions](https://github.com/mmollay/material3php/discussions)
- 🌐 **Website**: [www.ssi.at](https://www.ssi.at)

---

**Built with ❤️ by [SSI - Service Support Internet](https://www.ssi.at)**

🤖 *Developed with [Claude Code](https://claude.ai/code)*