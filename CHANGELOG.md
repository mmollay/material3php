# Changelog

Alle wichtigen Änderungen an diesem Projekt werden in dieser Datei dokumentiert.

Das Format basiert auf [Keep a Changelog](https://keepachangelog.com/de/1.0.0/),
und dieses Projekt folgt [Semantic Versioning](https://semver.org/lang/de/).

## [Unveröffentlicht]

## [2.1.0] - 2025-09-26

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