# Material Design 3 PHP Library

Eine umfassende PHP-Library zur Generierung von Material Design 3 UI-Komponenten mit reinem CSS - ohne externe CDN-Abhängigkeiten.

## 🚀 Features

- **Vollständige Material Design 3 Unterstützung** - Implementiert alle wichtigen MD3 Komponenten
- **Pure CSS Implementation** - Keine CDN-Abhängigkeiten, funktioniert offline
- **Einfache PHP-API** - Intuitive statische Methoden für jede Komponente
- **15+ Komponententypen** - Buttons, Cards, Lists, Search, Chips, Tooltips uvm.
- **Produktionsbereit** - Sauberer, dokumentierter Code mit HTML-Escaping
- **Light/Dark Mode** - Automatische Theme-Unterstützung
- **Responsive Design** - Mobile-first Ansatz

## 📦 Installation

1. Klone das Repository oder lade die Dateien herunter
2. Kopiere den `src/` Ordner in dein PHP-Projekt
3. Binde die benötigten Klassen ein:

```php
<?php
require_once 'src/MD3.php';
require_once 'src/MD3Button.php';
// weitere Komponenten nach Bedarf
?>
```

## 🎯 Schnellstart

### Grundlegendes Setup

```php
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine App</title>
    <?php
    require_once 'src/MD3.php';
    echo MD3::init(); // Lädt CSS und JS
    ?>
</head>
<body>
    <!-- Deine Komponenten hier -->
</body>
</html>
```

### Buttons

```php
<?php
require_once 'src/MD3Button.php';

// Verschiedene Button-Typen
echo MD3Button::filled('Speichern');
echo MD3Button::outlined('Abbrechen');
echo MD3Button::text('Mehr erfahren');
echo MD3Button::elevated('Erhöht');
echo MD3Button::tonal('Tonal');

// Buttons mit Links
echo MD3Button::filled('Zum Dashboard', '/dashboard');

// Icon-Buttons
echo MD3Button::icon('favorite');
echo MD3Button::fab('add', 'Hinzufügen');
?>
```

### Text Fields

```php
<?php
require_once 'src/MD3TextField.php';

// Basic Fields
echo MD3TextField::filled('name', 'Name');
echo MD3TextField::outlined('email', 'E-Mail');

// Spezielle Field-Typen
echo MD3TextField::password('password', 'Passwort');
echo MD3TextField::email('email', 'E-Mail');
echo MD3TextField::number('age', 'Alter');
echo MD3TextField::textarea('message', 'Nachricht');

// Fields mit Icons
echo MD3TextField::withLeadingIcon('search', 'Suche', 'search');
echo MD3TextField::withTrailingIcon('phone', 'Telefon', 'phone');
?>
```

### Cards

```php
<?php
require_once 'src/MD3Card.php';

// Einfache Card
echo MD3Card::simple('Titel', 'Inhalt der Card');

// Card mit Actions
$actions = [
    MD3Button::text('Abbrechen'),
    MD3Button::filled('OK')
];
echo MD3Card::withActions('Titel', 'Inhalt', $actions);

// Card mit Icon
echo MD3Card::withIcon('settings', 'Einstellungen', 'Konfiguration');

// Media Card
echo MD3Card::media('/path/to/image.jpg', 'Titel', 'Beschreibung');
?>
```

### Breadcrumb Navigation

```php
<?php
require_once 'src/MD3Breadcrumb.php';

// Aus Array
$items = [
    ['label' => 'Start', 'href' => '/'],
    ['label' => 'Produkte', 'href' => '/products'],
    ['label' => 'Details']
];
echo MD3Breadcrumb::fromArray($items);

// Automatisch aus aktueller Route
echo MD3Breadcrumb::fromCurrentRoute('/dashboard/users/edit', '', [
    'dashboard' => 'Dashboard',
    'users' => 'Benutzer',
    'edit' => 'Bearbeiten'
]);

// Mit Icons
$itemsWithIcons = [
    ['label' => 'Start', 'href' => '/', 'icon' => 'home'],
    ['label' => 'Einstellungen', 'icon' => 'settings']
];
echo MD3Breadcrumb::withIcons($itemsWithIcons);
?>
```

### Dialogs

```php
<?php
require_once 'src/MD3Dialog.php';

// Alert Dialog
echo MD3Dialog::alert('alert-id', 'Hinweis', 'Operation erfolgreich!');

// Confirmation Dialog
echo MD3Dialog::confirm('confirm-id', 'Bestätigung', 'Wirklich löschen?');

// Dialog mit Trigger-Button
echo MD3Dialog::trigger('confirm-id', 'Löschen', 'outlined');

// Form Dialog
$formContent = MD3TextField::filled('name', 'Name') .
               MD3TextField::email('email', 'E-Mail');
echo MD3Dialog::form('form-id', 'Kontakt', $formContent);
?>
```

## 📁 Projektstruktur

```
material3php/
├── src/
│   ├── MD3.php              # Kern-Klasse und Ressourcen-Management
│   ├── MD3Button.php        # Button-Komponenten
│   ├── MD3TextField.php     # Text-Input-Felder
│   ├── MD3Card.php          # Card-Komponenten
│   ├── MD3Breadcrumb.php    # Breadcrumb-Navigation
│   └── MD3Dialog.php        # Dialog-Komponenten
├── index.php                # Demo-Seite
└── README.md                # Diese Dokumentation
```

## 🛠 Verfügbare Komponenten

### MD3 (Kern)
- `MD3::init()` - Lädt CSS/JS-Ressourcen
- `MD3::icon($icon)` - Material Icons
- `MD3::getVersion()` - Library-Version

### MD3Button
- `filled()`, `outlined()`, `text()`, `elevated()`, `tonal()`
- `icon()`, `iconFilled()`, `iconTonal()`, `iconOutlined()`
- `fab()` - Floating Action Button

### MD3TextField
- `filled()`, `outlined()` - Standard-Felder
- `password()`, `email()`, `number()`, `search()` - Typisierte Felder
- `textarea()` - Mehrzeilige Felder
- `withLeadingIcon()`, `withTrailingIcon()` - Felder mit Icons

### MD3Card
- `filled()`, `elevated()`, `outlined()` - Card-Typen
- `simple()` - Card mit Titel/Inhalt
- `withActions()` - Card mit Action-Buttons
- `media()` - Card mit Bild
- `withIcon()` - Card mit Icon

### MD3List
- `simple()` - Einfache Listen
- `withDividers()` - Listen mit Trennlinien
- `withIcons()` - Listen mit Icons
- `twoLine()`, `threeLine()` - Mehrzeilige Listen
- `selectable()` - Auswählbare Listen

### MD3Search
- `field()`, `fieldOutlined()` - Suchfelder
- `withSuggestions()` - Suche mit Vorschlägen
- `withFilters()` - Suche mit Filter-Chips
- `withResults()` - Suche mit Ergebnis-Dropdown
- `overlay()` - Vollbild-Suchoverlay

### MD3Chip
- `assist()` - Assist Chips
- `filter()` - Filter Chips (auswählbar)
- `input()` - Input Chips (entfernbar)
- `suggestion()` - Vorschlags-Chips
- `filterSet()`, `assistSet()` - Chip-Gruppen

### MD3Tooltip
- `basic()` - Einfache Tooltips
- `rich()` - Tooltips mit Titel/Beschreibung
- `withIcon()` - Tooltips mit Icons
- `positioned()` - Positionierte Tooltips
- `help()` - Hilfe-Tooltips mit Icon

### MD3Switch
- `basic()` - Basis Switch
- `withLabel()` - Switch mit Label
- `disabled()` - Deaktivierte Switches

### MD3Checkbox
- `basic()` - Basis Checkbox
- `withLabel()` - Checkbox mit Label

### MD3Radio
- `basic()` - Basis Radio Button
- `withLabel()` - Radio mit Label
- `group()` - Radio Button Gruppe

### MD3Breadcrumb
- `fromArray()` - Aus Array generieren
- `fromCurrentRoute()` - Automatisch aus URL
- `withIcons()` - Mit Icons
- `withSeparator()` - Custom Trennzeichen
- `simple()` - Einfache Text-Navigation

### MD3Dialog
- `basic()`, `alert()`, `confirm()` - Standard-Dialogs
- `form()` - Dialog mit Formular
- `withActions()` - Dialog mit Custom Actions
- `trigger()` - Button zum Öffnen
- `openScript()`, `closeScript()` - JavaScript-Helper

## 🎨 Anpassung

### Custom Styling
Nutze CSS-Variablen für Theming:

```css
:root {
  --md-sys-color-primary: #6750A4;
  --md-sys-color-on-primary: #FFFFFF;
  /* weitere Material Design Token */
}
```

### Erweiterte Attribute
Jede Komponente akzeptiert zusätzliche HTML-Attribute:

```php
echo MD3Button::filled('Button', '/link', [
    'class' => 'custom-class',
    'data-action' => 'save',
    'disabled' => true
]);
```

## 📋 Beispiele

- **Basis Demo**: `index.php` - Zeigt die grundlegenden Komponenten
- **Erweiterte Demo**: `demo-extended.php` - Alle neuen Komponenten (Lists, Search, Chips, etc.)
- **Test Seite**: `test.html` - Einfache HTML-Test-Seite für Custom Elements

### Neue Komponenten Beispiele

```php
// Listen
echo MD3List::twoLine([
    ['title' => 'E-Mail', 'subtitle' => 'Neue Nachricht von...', 'icon' => 'mail'],
    ['title' => 'Kalender', 'subtitle' => 'Meeting um 15:00', 'icon' => 'event']
]);

// Suchfeld mit Vorschlägen
echo MD3Search::withSuggestions('search', [
    'Material Design', 'PHP Library', 'Web Components'
]);

// Filter Chips
echo MD3Chip::filterSet([
    ['label' => 'Alle', 'value' => 'all', 'selected' => true],
    ['label' => 'Wichtig', 'value' => 'important', 'icon' => 'star']
], 'filters');

// Tooltip mit Hilfe
echo MD3Tooltip::help(
    'Dies ist ein Hilfe-Tooltip für komplexe Einstellungen.',
    'help-tooltip-1'
);

// Switch mit Label
echo MD3Switch::withLabel('notifications', 'Benachrichtigungen', '1', true);
```

## 🔧 Systemanforderungen

- **PHP**: 7.4 oder höher
- **Browser**: Moderne Browser mit ES6-Unterstützung
- **Internet**: CDN-Zugriff für Material Web Components

## 🚀 Erweiterung

Um neue Komponenten hinzuzufügen:

1. Erstelle eine neue Datei in `src/MD3ComponentName.php`
2. Folge dem bestehenden Muster mit statischen Methoden
3. Nutze `MD3::escapeAttributes()` für sichere HTML-Ausgabe
4. Dokumentiere alle öffentlichen Methoden

## 📝 Lizenz

Diese Library ist Open Source. Material Design ist ein Trademark von Google.

## 🤝 Beitragen

Contributions sind willkommen! Bitte:

1. Folge den bestehenden Code-Konventionen
2. Teste deine Änderungen gründlich
3. Dokumentiere neue Features
4. Stelle sicher, dass HTML sicher escaped wird

## 🔗 Ressourcen

- [Material Design 3](https://m3.material.io)
- [Material Web Components](https://github.com/material-components/material-web)
- [Material Design Guidelines](https://material.io/design)

---

**Check!!** - *DEVELOPMENT-GUIDELINES.md anpassen und erweitern für Web/Mobile Versionen*