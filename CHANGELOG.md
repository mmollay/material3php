# Changelog

Alle wichtigen Änderungen an diesem Projekt werden in dieser Datei dokumentiert.

Das Format basiert auf [Keep a Changelog](https://keepachangelog.com/de/1.0.0/),
und dieses Projekt folgt [Semantic Versioning](https://semver.org/lang/de/).

## [Unveröffentlicht]

## [0.2.9] - 2025-09-26

### 🐛 Fehlerbehebung
- **JavaScript Template String Fix:** Weitere Template-String-Syntax-Probleme in MD3List.php behoben
  - Fehlerhafte String-Concatenation in CSS-Keyframes Animation
  - Template-Literal-Syntax für CSS-Injection korrekt implementiert
  - Playground JavaScript-Fehler "expected expression, got '}'" at line 2730 behoben
- **MD3List Ripple Animation:** CSS-Animation für Ripple-Effekte funktioniert wieder einwandfrei

### 🔧 Technische Verbesserungen
- Konsistente Template-String-Verwendung in JavaScript-generierten Komponenten
- Verbesserte CSS-Injection für dynamische Animationen

## [0.2.8] - 2025-09-26

### 🐛 Fehlerbehebung
- **JavaScript Template String Fix:** Reparatur der fehlerhaften Template-String-Syntax in MD3Snackbar.php:848
  - Gemischte Quote-Escaping verursachte Parse-Error im Playground API
  - Korrekte Template-String-Syntax für onclick-Attribute implementiert
- **Playground API 500 Error:** API-Endpoint funktioniert wieder einwandfrei
  - Alle Komponenten-Generatoren vollständig funktional
  - Error-Reporting temporär aktiviert für Debugging

### 🔧 Technische Verbesserungen
- Playground API Error-Handling verbessert
- Debug-Modus für Entwicklung verfügbar (auskommentiert)

## [0.2.7] - 2025-09-26

### 🚀 Neue Komponenten - Komplexe Interactive Components
- **🏷️ Chip Component:** Moderne Tag/Label-Elemente
  - Assist Chips: Hilfe-Aktionen und Shortcuts
  - Filter Chips: Selektierbare Filteroptionen mit States
  - Input Chips: Eingabe-Tags mit Dismiss-Funktionalität
  - Suggestion Chips: Smart Vorschläge für User Input
  - Chip Sets: Organisierte Gruppen mit flexiblem Layout

## [0.2.6] - 2025-09-26

### 🚀 Neue Komponenten - Navigation System Komplett
- **🧭 Navigation Drawer:** Side Navigation Panel für Desktop/Tablet
  - Standard (immer sichtbar) und Modal (mit Overlay) Varianten
  - Header mit Titel/Subtitle, Navigation Items mit Active States
  - Dividers, Subheader und Badge Support
  - Responsive Overlay für Mobile mit Escape/Click-to-close
  - Material Design 3 konforme Slide-in Animation

- **🧭 Navigation Rail:** Kompakte vertikale Navigation für mittlere Geräte
  - Standard, With-Header (mit FAB), Compact (nur Icons) Varianten
  - Vertikale Navigation Items mit Icons, Labels und Active States
  - Optional Header-Bereich mit Floating Action Button
  - Responsive für Tablet-Größen (1024px+) mit automatischem Body-Padding

### 🎨 Design Updates
- **🧭 Navigation Bar:** Komplett redesignt nach Material Design 3 Spezifikation
  - Neue kompakte Höhe: 64px statt 80px für moderneres Design
  - Active State: Schwarze Unterlinie statt violetter Pill-Form
  - Flex Layout: Items nehmen gleichmäßig vollen verfügbaren Raum ein
  - Kleinere Icons (24px) und Labels (10px) für kompakteres Design
  - Entspricht jetzt exakt der offiziellen MD3 Navigation Bar Spezifikation

### 🔧 Bug Fixes & Verbesserungen
- **📄 Index.php:** Fatal Error durch fehlende MD3List Include behoben
- **🧬 Playground Integration:** Navigation Drawer und Rail vollständig konfigurierbar
- **📱 Responsive Design:** Alle Navigation Komponenten arbeiten nahtlos zusammen
- **🎛️ Controls:** Vollständige Playground-Konfiguration für alle Navigation-Typen

### 📊 Navigation System Übersicht (4/6 - 67% vollständig)
- ✅ **Navigation Bar** - Bottom Navigation für Smartphones (redesignt)
- ✅ **Navigation Drawer** - Side Panel für Desktop/Laptop (NEU)
- ✅ **Navigation Rail** - Kompakte vertikale Navigation für Tablets (NEU)
- ✅ **Menu** - Dropdown und Context Menus
- ❌ **Tabs** - Horizontal Tab Navigation
- ❌ **Top App Bar** - Header mit Actions

### 🎯 Gesamtfortschritt
**17/33 Komponenten implementiert (52% vollständig)**

---

## [0.2.5] - 2025-09-26

### 🐛 Bug Fixes
- **🧭 Navigation Bar:** Active State Indicator repariert
  - Z-Index Problem behoben - Indicator jetzt sichtbar hinter Icon und Label
  - Pill-Form Positionierung korrigiert (top: 4px, width: 64px, height: 32px)
  - Material Design 3 konforme Darstellung wie in offizieller Spezifikation
  - Padding angepasst für bessere Icon/Label Balance

- **📋 Context Menu:** Preview-Problem gelöst
  - Context Menu Demo-Bereich mit "Right-click here" Hinweis hinzugefügt
  - Material Design Icon und deutsche/englische Beschriftung
  - Proper Target-Selector `.context-demo-hint` statt `.preview-area`
  - Context Menu Generator für PHP-Code ebenfalls korrigiert

### 🔧 Technische Verbesserungen
- **playground-api.php:** Context Menu Generator mit visueller Demo-Area
- **MD3NavigationBar.php:** CSS Indicator Styling nach MD3 Guide korrigiert
- **Z-Index Management:** Proper Layering für Navigation Bar Komponenten

---

## [0.2.4] - 2025-09-26

### 🚀 Neue Komponenten
- **🎯 Icon Button:** Vollständige MD3-konforme Implementierung
  - Standard, Filled, Outlined, Tonal Varianten
  - Toggle-Funktionalität mit separaten Icons für selected/unselected Zustände
  - Interactive States (Hover, Focus, Pressed) und Disabled Support
  - ARIA-Labels und Keyboard Navigation für Accessibility
  - Material Design 3 konforme Farben und Ripple-Effekte
  - Integration in Playground mit vollständigen Controls

### 📋 Roadmap Updates
- **🎯 Actions Kategorie:** 75% vollständig (3/4 Komponenten implementiert)
  - Button ✅, FAB ✅, Icon Button ✅, Segmented Button ❌
- **📊 Gesamtfortschritt:** 15/33 Komponenten implementiert (45% Fortschritt)
- **🚀 Phase 1 Prioritäten:** Badge ✅, Icon Button ✅ abgeschlossen

### 🔧 Technische Verbesserungen
- **Component-Integration:** Icon Button vollständig in playground-api.php integriert
- **CSS-Architektur:** MD3-konforme Color-Token und State-Layers
- **JavaScript-Funktionalität:** Toggle-Events und Custom Event Dispatching
- **Playground-Enhancement:** Icon Button Konfiguration mit allen Optionen

### 📊 Aktuelle Komponenten-Übersicht
**Actions:** Button ✅, FAB ✅, Icon Button ✅ | **Communication:** Badge ✅
**Containment:** Card ✅, Dialog ✅ | **Navigation:** Navigation Bar ✅, Menu ✅
**Selection:** Checkbox ✅, Radio ✅, Switch ✅, Select ✅ | **Text Inputs:** TextField ✅
**Display:** Lists ✅, Chip ✅

### 🎯 Nächste Prioritäten (Phase 1)
- Progress Indicator (Linear & Circular Loading States)
- Snackbar (User Feedback System)
- Tabs (Navigation System erweitern)

---

## [0.2.3] - 2025-09-26

### 🚀 Neue Komponenten
- **🎯 FAB (Floating Action Button):** Vollständige MD3-konforme Implementierung
  - Standard, Small, Large und Extended FAB Varianten
  - Hover-States, Ripple-Effekte und Accessibility Support
  - Flexible Positionierung (fixed, bottom-right, bottom-left, center)
  - Integration in Playground mit vollständigen Controls

- **🎖️ Badge-System:** Notification Badge-Komponente implementiert
  - Small (Dot) und Large (Text/Number) Badge-Typen
  - Verschiedene Farben (Error, Primary, Secondary, Surface)
  - Attachment-System für Icons, Navigation und beliebige Elemente
  - JavaScript Management-System mit Auto-Formatting (99+ für große Zahlen)
  - Positionierungs-Optionen (top-right, top-left, bottom-right, bottom-left)

### 🌙 Dark/Light Mode System
- **🔧 Dark Mode Toggle repariert:** Vollständig funktionaler Light/Dark Mode Wechsel
  - CSS-Selektoren vereinfacht: Direkte `[data-theme="dark"]` Regeln
  - JavaScript-Konflikte beseitigt: Einheitliches Toggle-System
  - System-Präferenz Integration: Respektiert `prefers-color-scheme`
  - Sanfte Transitions: 0.3s ease Übergänge zwischen Modi
  - LocalStorage Persistierung: Einstellungen werden gespeichert
  - Debug-Logging: Console-Ausgaben für Problemdiagnose

### 📋 Roadmap & Organisation
- **🗺️ ROADMAP.md erstellt:** Vollständige MD3 Komponenten-Analyse
  - 13/33 Komponenten implementiert (39% Fortschritt)
  - Prioritäts-basierte Implementierungsphasen
  - Material Design konforme Kategorisierung
  - Detaillierte Feature-Matrix und Zielplanung

### 🔧 Technische Verbesserungen
- **CSS-Architektur:** Vereinfachte Dark Mode Selektoren ohne komplexe `:not()` Regeln
- **JavaScript-Stabilität:** Eliminierung von Event-Listener Konflikten
- **Component-Integration:** FAB und Badge vollständig in playground-api.php integriert
- **Debug-Tools:** Enhanced Console-Logging für Theme-System Debugging

### 📊 Aktuelle Komponenten-Übersicht
**Actions:** Button ✅, FAB ✅ | **Communication:** Badge ✅
**Containment:** Card ✅, Dialog ✅ | **Navigation:** Navigation Bar ✅, Menu ✅
**Selection:** Checkbox ✅, Radio ✅, Switch ✅, Select ✅ | **Text Inputs:** TextField ✅
**Display:** Lists ✅, Chip ✅

### 🎯 Nächste Prioritäten (Phase 1)
- Icon Button (Actions vervollständigen)
- Progress Indicator (Communication erweitern)
- Tabs (Navigation erweitern)
- Search Component (Text Inputs erweitern)

---

## [0.2.2] - 2025-09-26

### 🚀 Neue Features
- **🌙 Light/Dark Mode Toggle:** Vollständiger Theme-Wechsler implementiert
  - Toggle-Button in Header-Leiste mit dynamischen Icons (light_mode/dark_mode)
  - LocalStorage-Persistierung der Benutzer-Einstellung
  - CSS data-theme Attribut für nahtlose Theme-Umschaltung
  - Automatische Icon-Updates basierend auf gewähltem Modus

### 🔧 Menu-System Verbesserungen
- **📋 Context Menu Funktionalität:** Vollständig funktionale Rechtsklick-Menüs
  - Event-Handler Integration in globale `initializeMenus()` Funktion
  - Intelligent Positioning mit Viewport-Anpassung
  - `data-context-target` Attribut-System für flexible Zielsteuerung
  - Automatisches Schließen bei Außenklicks

- **🎯 Menu JavaScript Fix:** Dynamische Menü-Initialisierung repariert
  - Global verfügbare `initializeMenus()` Funktion für AJAX-Content
  - Event-Handler für Dropdown und Context Menus nach Component-Updates
  - Keyboard Navigation (Arrow Keys, Enter, Escape) vollständig unterstützt
  - Viewport-aware Menü-Positionierung implementiert

### 🎨 UI/UX Verbesserungen
- **📝 Multiline Input Fix:** Alle Komponenten-Parser repariert
  - Select, Radio, List, Chip, Navigation, Menu: `\\n` Parsing behoben
  - Konsistente Behandlung von Escape-Sequenzen in JavaScript und PHP
  - Korrekte Generierung multiline-basierter Komponenten

- **📋 Naming Update:** "List" zu "Lists" umbenannt (Material Design konform)

### 🔧 Technische Details
- **Event System:** Verbesserte Event-Delegation für dynamische Inhalte
- **Memory Management:** Proper Event-Listener Cleanup und Re-Initialization
- **Cross-Browser Support:** LocalStorage mit Fallback-Mechanismen
- **Performance:** Optimierte Menu-Initialisierung ohne UI-Blocking

---

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