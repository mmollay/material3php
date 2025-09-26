# Changelog

Alle wichtigen Änderungen an diesem Projekt werden in dieser Datei dokumentiert.

Das Format basiert auf [Keep a Changelog](https://keepachangelog.com/de/1.0.0/),
und dieses Projekt folgt [Semantic Versioning](https://semver.org/lang/de/).

## [Unveröffentlicht]

## [0.2.1] - 2025-09-26

### 🐛 Bug Fixes
- **JavaScript:** Escape-Sequenzen in Playground-Komponenten-Konfiguration behoben
  - Alle `\n` Zeichen in JavaScript-Strings korrekt escaped (`\\n`)
  - "Uncaught SyntaxError: invalid escape sequence" Error behoben

### 🎨 UI Verbesserungen
- **🧭 Playground-Optimierung:** Kompakte und aufgeräumte Benutzeroberfläche
  - Theme-Auswahl: Kompakter Dropdown-Button statt große Theme-Chips
  - Sidebar: Reduziert von 280px auf 240px Breite für mehr Platzausnutzung
  - Spacing: Kompaktere Paddings und Margins durchgehend optimiert
  - Navigation: Kleinere Font-Größen (13px) und reduzierte Button-Paddings
  - Controls: Effizientere Platznutzung bei Form-Elementen

### 🔧 Technische Details
- **Enhanced UX:** Bessere Bildschirmplatz-Ausnutzung bei beibehaltener Usability
- **CSS-Optimierung:** Durchgehend kompakteres Design ohne Funktionalitätsverlust
- **JavaScript-Stabilität:** Eliminierung aller Syntax-Fehler durch korrekte String-Escaping

---

## [0.2.0] - 2025-09-26

### 🚀 Neue Komponenten
- **🧭 MD3NavigationBar:** Vollständige Bottom Navigation Bar implementiert
  - Fixed und Floating Varianten
  - Icons mit Labels oder Icons-Only Modus
  - Badge-Support für Notifications
  - Active State Highlighting mit Indicators
  - Ripple-Effekte bei Interaktionen
  - Responsive Design (Mobile → Desktop Navigation Rail)
  - Accessibility Features (ARIA, Keyboard Navigation)

- **📋 MD3Menu:** Vollständiges Menu-System implementiert
  - Dropdown Menus mit verschiedenen Positionen
  - Context Menus (Right-Click)
  - Sub-Menu Support
  - Menu Items mit Icons, Dividers, Headers
  - Selection States und Destructive Actions
  - Keyboard Navigation (Arrow Keys, Enter, Escape)
  - Viewport-aware Positioning

- **💬 MD3Dialog:** Komplett überarbeitetes Dialog-System
  - Basic, Alert, Confirmation, Form und Fullscreen Dialogs
  - Native CSS/HTML Implementation (ersetzt Material Web Components)
  - Backdrop Click und Escape Key Support
  - Focus Management für Accessibility
  - Form Submit Handling mit Custom Events
  - Responsive Mobile Adaptierung
  - Smooth Animations mit CSS Transforms

### 🎨 Playground Erweiterungen
- **Navigation & Overlays Kategorien:** Neue Komponenten im Playground verfügbar
- **Enhanced Navigation:** Strukturierte Komponentenkategorien (Basic, Navigation, Overlays, Form Controls)
- **Playground CSS:** Verbesserte Form Controls mit Material Design 3 Styling

### 🔧 Verbesserungen
- **Enhanced CSS:** Color-mix Support für moderne Browser
- **JavaScript Events:** Custom Events für alle Komponenten-Interaktionen
- **Accessibility:** Vollständige ARIA-Unterstützung und Keyboard Navigation
- **Responsive Design:** Mobile-First Approach für alle neuen Komponenten

### Technische Details
- **Neue Dateien:** MD3NavigationBar.php, MD3Menu.php, MD3Dialog.php (überarbeitet)
- **Playground Integration:** Alle Komponenten verfügbar unter entsprechenden URLs
- **CSS Animations:** Cubic-bezier Transitions für flüssige Bewegungen
- **Event System:** Standardisierte Custom Events für alle Komponenten

---

## [0.1.0] - 2025-09-26

### 🚀 Entwicklungsstart
- **Versionierung:** Projekt auf Entwicklungsversion v0.1.0 zurückgesetzt
- **📋 Interactive Playground:** Vollständiges Material Design 3 Playground implementiert
  - Live-Komponenten-Vorschau mit Theme-Switching
  - Dynamische PHP-Code-Generierung
  - Material Design Controls mit Radio Buttons, TextFields und Checkboxes
  - Responsive 3-Panel Layout (Navigation, Controls, Preview)
  - AJAX-basierte Komponenten-Updates
  - Debug-Tools für Entwicklung
- **🎨 Enhanced UI Controls:** Material Design 3 styled Form-Controls
  - Custom Radio Buttons mit Hover/Active States
  - Improved Select Dropdowns mit Custom Arrow
  - Enhanced Checkbox Containers
  - Focus/Hover States mit Primary Color Integration
- **🔧 Bug Fixes:**
  - MD3List Class Loading Error behoben
  - Doppelte getVersion() Methoden-Deklaration entfernt
  - PHP 500 Errors im Playground debugged
- **📖 Documentation:** Git Workflow in CLAUDE.md dokumentiert
- **⚙️ Development Setup:** Debug-Tools und vereinfachte Playground-Version

### Technische Details
- **Playground-Dateien:** playground.php, playground-simple.php, playground-debug.php, playground-api.php
- **CSS-Verbesserungen:** Enhanced Material Design 3 Form Controls
- **JavaScript:** Dynamische Code-Generierung und State Management
- **PHP-Integration:** Vollständige MD3-Komponenten-Bibliothek Integration

### Nächste Schritte für v0.2.0
- AJAX-Live-Preview Funktionalität vervollständigen
- Weitere Komponenten (Switch, Radio, Select) ins Playground integrieren
- Mobile-responsive Verbesserungen
- Performance-Optimierungen

---

## [2.1.0] - 2025-09-26 [ARCHIVIERT]

### Hinzugefügt
- **🎨 Theme-System:** 5 vordefinierte Material Design 3 Themes (Default, Ocean, Forest, Sunset, Minimal)
- **📋 MD3List Funktional:** Vollständig überarbeitete Liste mit echten HTML-Elementen
  - Navigation Lists mit Active-State Highlighting
  - Avatar Lists mit Initialen-Avatars
  - Action Lists mit destructive Actions
  - Badge und Meta-Info Support
  - Ripple-Effekte für Interaktivität
  - Echte Form-Integration für Selectable Lists
- **🎯 Theme-Auswahl UI:** Toggle-Chips auf allen Demo-Seiten
- **⚡ JavaScript Interaktivität:**
  - Theme-Wechsel mit localStorage Persistierung
  - List-Events und Custom Events für Form-Integration
  - Ripple-Animationen für Material Design Feedback
- **📱 Demo-Verbesserungen:**
  - Erweiterte Demo mit 8 verschiedenen List-Typen
  - Funktionale Demo mit praktischen Anwendungsbeispielen
  - Theme-Parameter in URLs für Navigation

### Geändert
- **MD3List:** Umgestellt von Custom Elements auf echte `<ul>`/`<li>` HTML-Struktur
- **Theme-Unterstützung:** Dynamische Theme-Farben in MD3.php integriert
- **Form-Kompatibilität:** Theme-Parameter in Formularen beibehalten
- **CSS-Architektur:** Modulare CSS-Struktur für bessere Wartbarkeit

### Behoben
- **Navigation:** Alle Demo-Seiten Links funktionieren korrekt
- **Form-Integration:** POST-Daten werden korrekt mit Theme-Parameter verarbeitet
- **Accessibility:** Proper ARIA-Rollen für Lists und Navigation

## [2.0.1] - 2025-09-25

### Hinzugefügt
- **MD3Select:** Vollständige Select/Dropdown Implementierung
- **MD3Switch, MD3Checkbox, MD3Radio:** Funktionale Form-Kontrollen
- **MD3Chip:** Filter Chips mit echten Hidden Inputs
- **demo-functional.php:** Neue Seite für Form-Integration Testing
- **Echte HTML Form-Elemente:** Alle Komponenten submittieren korrekt

### Geändert
- **Komponenten-Architektur:** Von Custom Elements zu echten HTML Form-Elementen
- **Form-Kompatibilität:** Alle Inputs funktionieren mit POST/GET Requests

### Behoben
- **Form-Submission:** Komponenten senden echte Formulardaten
- **CORS-Probleme:** Entfernung aller CDN-Abhängigkeiten

## [2.0.0] - 2025-09-24

### Hinzugefügt
- **Pure CSS Implementation:** Vollständig eigenständig ohne CDN-Abhängigkeiten
- **MD3List:** Listen-Komponente mit verschiedenen Varianten
- **MD3Search:** Such-Komponente mit Vorschlägen und Filtern
- **MD3Chip:** Chip-Komponente für Tags und Filter
- **MD3Tooltip:** Tooltip-System mit verschiedenen Stilen
- **demo-extended.php:** Erweiterte Demo-Seite

### Geändert
- **CSS-System:** Komplett überarbeitet mit Material Design 3 Tokens
- **Architektur:** Modular aufgebaute Komponenten-Struktur

### Entfernt
- **CDN-Abhängigkeiten:** Alle externen Material Web Components entfernt

## [1.0.0] - 2025-09-23

### Hinzugefügt
- **Initiale Version:** Material Design 3 PHP Library
- **Kern-Komponenten:**
  - MD3Button: Alle Button-Varianten (Filled, Outlined, Text, Elevated, Tonal, FAB)
  - MD3TextField: Text-Eingabefelder (Filled, Outlined, mit Icons)
  - MD3Card: Card-Komponenten (Simple, mit Icon, mit Actions)
  - MD3Breadcrumb: Navigationspfade
  - MD3Dialog: Modal-Dialoge (Alert, Confirm, Form)
- **MD3 Kern-Klasse:** Zentrale Ressourcenverwaltung
- **Demo-Seiten:** index.php mit umfangreichen Beispielen
- **Dokumentation:** Umfangreiche README mit Beispielen

### Technische Details
- **PHP 7.4+:** Minimum PHP-Version
- **Material Design 3:** Basiert auf offizieller Spezifikation
- **Responsive Design:** Mobile-first Ansatz
- **Erweiterbar:** Plugin-ähnliche Architektur

---

## Versions-Schema (Semantic Versioning)

- **MAJOR** (X.0.0): Breaking Changes, Inkompatible API-Änderungen
- **MINOR** (0.X.0): Neue Features, rückwärtskompatibel
- **PATCH** (0.0.X): Bug-Fixes, rückwärtskompatibel

## Material Web Components Referenz

Diese Library ist **nicht** direkt von https://github.com/material-components/material-web/ abhängig, sondern implementiert Material Design 3 als **pure CSS/PHP Lösung**.

**Warum keine direkte Material Web Components Nutzung:**
- ❌ **CORS-Probleme** mit CDN-Ressourcen
- ✅ **Offline-Fähigkeit** für Produktionsumgebungen
- ✅ **Vollständige Kontrolle** über Styling und Verhalten
- ✅ **PHP-Integration** statt JavaScript-Framework
- ✅ **Server-Side Rendering** für bessere Performance

**Material Design 3 Konformität:**
- ✅ **Design Tokens:** Alle offiziellen MD3 Farb- und Größen-Token
- ✅ **Komponenten-Verhalten:** Entspricht MD3 Spezifikation
- ✅ **Accessibility:** ARIA-Standards und Keyboard Navigation
- ✅ **Responsive Design:** Mobile-first Ansatz
- ✅ **Theme-System:** Light/Dark Mode Support

[Unveröffentlicht]: https://github.com/mmollay/material3php/compare/v2.1.0...HEAD
[2.1.0]: https://github.com/mmollay/material3php/compare/v2.0.1...v2.1.0
[2.0.1]: https://github.com/mmollay/material3php/compare/v2.0.0...v2.0.1
[2.0.0]: https://github.com/mmollay/material3php/compare/v1.0.0...v2.0.0
[1.0.0]: https://github.com/mmollay/material3php/releases/tag/v1.0.0