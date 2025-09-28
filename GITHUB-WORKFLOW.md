# GitHub Workflow & Version Management Checklist

## 📋 Systematic Development Workflow

### 🔄 Development Cycle Checklist

**Bei jeder Änderung/Entwicklung:**

- [ ] **1. Code Development**
  - [ ] Neue Features ausschließlich mit Material3PHP Components entwickeln
  - [ ] Bestehende Components anpassen, falls neue Funktionalität benötigt wird
  - [ ] Keine externen Dependencies ohne Abstimmung hinzufügen
  - [ ] Code in englischer Sprache (Kommentare, Variablen, Funktionen)

- [ ] **2. Testing & Quality**
  - [ ] Autoloader-System verwenden (nie manuelle require_once)
  - [ ] Nur sichere CSS/JS Methods verwenden (MD3Theme::getThemeCSS(), MD3Card::getCSS(), MD3Theme::getThemeScript())
  - [ ] Responsive Design auf allen Geräten testen
  - [ ] Cross-browser Kompatibilität prüfen

- [ ] **3. Version Management**
  - [ ] VERSION-Datei aktualisieren (Semantic Versioning: MAJOR.MINOR.PATCH)
  - [ ] CHANGELOG.md vollständig dokumentieren
  - [ ] Git commit mit aussagekräftiger Message
  - [ ] Git tag erstellen mit Versionsnummer (v0.x.x Format)

- [ ] **4. GitHub Backup**
  - [ ] Alle Änderungen committen
  - [ ] Tags mit pushen (git push --tags)
  - [ ] Main branch für Library-Code
  - [ ] Website branch für Demo-Website
  - [ ] Release notes auf GitHub erstellen

---

## 🏗️ Repository Structure

### **Zwei-Versionen-System:**

#### **Main Branch (Library)**
```
material3php/
├── src/                    # Core MD3 PHP Components
├── autoload.php           # PSR-4 Autoloader
├── composer.json          # Package Definition
├── VERSION                # Current Version Number
├── CHANGELOG.md           # Version History
├── README.md              # Library Documentation
└── LICENSE               # MIT License
```

#### **Website Branch (Demo)**
```
material3php-website/
├── src/                   # Core MD3 PHP Components (same as main)
├── includes/              # Website-specific includes
├── index.php             # Homepage
├── demo-extended.php     # Component Gallery
├── playground.php        # Interactive Playground
├── contact.php           # Contact Page
├── impressum.php         # Legal Notice
├── privacy-policy.php    # Privacy Policy
├── autoload.php          # Autoloader
└── assets/               # Website assets
```

---

## 🌍 Language & Internationalization

### **Current Setup:**
- [x] **Primary Language:** English (Operation & Website)
- [x] **Code Language:** English (variables, functions, comments)
- [x] **Documentation:** English
- [x] **Website Content:** English

### **Prepared for Multilingual:**
- [ ] **Language Files Structure:** `/lang/en.json`, `/lang/de.json`, etc.
- [ ] **Translation System:** Ready for implementation
- [ ] **Locale Detection:** Browser language detection ready
- [ ] **RTL Support:** CSS structure prepared

---

## 📝 Version Numbering System

### **Semantic Versioning (MAJOR.MINOR.PATCH):**

- **MAJOR** (v1.0.0): Breaking changes, API changes
- **MINOR** (v0.x.0): New features, new components
- **PATCH** (v0.x.x): Bug fixes, improvements

### **Current Development Phase:**
- **v0.x.x**: Development phase
- **v1.0.0-beta.x**: Beta testing phase
- **v1.0.0+**: Production ready

### **Tag Format:**
```bash
v0.2.43  # Current development
v0.3.0   # Next minor release
v1.0.0   # Production release
```

---

## 🔧 Development Standards

### **Material3PHP Ecosystem Rules:**

1. **🎯 Component First Approach**
   - Alle UI-Elemente MÜSSEN MD3 Components verwenden
   - Neue Funktionalität = neue/erweiterte MD3 Components
   - Keine HTML/CSS außerhalb des MD3-Systems

2. **🏗️ Architecture Standards**
   - PSR-4 Autoloading
   - Single Responsibility Principle
   - Material Design 3 Compliance
   - Accessibility (a11y) Standards

3. **📦 Dependency Management**
   - Nur PHP >= 8.0
   - Keine externen CSS/JS Frameworks
   - Vanilla JavaScript ES6+
   - CSS Custom Properties nur

4. **🌐 International Standards**
   - English as primary language
   - UTF-8 encoding
   - ISO date formats
   - Metric units

---

## ✅ Pre-Commit Checklist

**Vor jedem Git Commit:**

- [ ] **Code Quality**
  - [ ] Alle PHP-Dateien verwenden Autoloader
  - [ ] Keine manual require_once Statements
  - [ ] Nur sichere MD3 Methods verwendet
  - [ ] Englische Sprache durchgehend

- [ ] **Documentation**
  - [ ] VERSION-Datei aktualisiert
  - [ ] CHANGELOG.md erweitert
  - [ ] Code-Kommentare in Englisch
  - [ ] README.md bei Bedarf aktualisiert

- [ ] **Testing**
  - [ ] Playground funktioniert
  - [ ] Demo-Extended lädt ohne Fehler
  - [ ] Alle Themes funktionieren
  - [ ] Mobile Responsiveness geprüft

- [ ] **Git Workflow**
  - [ ] Aussagekräftige Commit Message
  - [ ] Tag mit Versionsnummer erstellt
  - [ ] GitHub Push mit Tags
  - [ ] Release Notes erstellt (bei Major/Minor)

---

## 🚀 Release Process

### **Standard Release:**
1. Code fertigstellen
2. VERSION erhöhen
3. CHANGELOG aktualisieren
4. Git commit & tag
5. GitHub push mit tags
6. Release notes erstellen

### **Hotfix Release:**
1. Bug fix implementieren
2. PATCH Version erhöhen (v0.2.43 → v0.2.44)
3. CHANGELOG aktualisieren
4. Git commit & tag
5. Sofortiger GitHub push

### **Feature Release:**
1. Feature vollständig implementieren
2. MINOR Version erhöhen (v0.2.43 → v0.3.0)
3. Ausführliche CHANGELOG Dokumentation
4. Git commit & tag
5. GitHub push mit detailed release notes

---

## 📊 Quality Metrics

**Kontinuierliche Überwachung:**

- [ ] **Performance:** Page load < 2s
- [ ] **Accessibility:** WCAG 2.1 AA compliance
- [ ] **Mobile:** 100% responsive design
- [ ] **Browser:** Chrome, Firefox, Safari, Edge support
- [ ] **Code:** 0 PHP errors, warnings minimiert
- [ ] **MD3 Compliance:** 100% Material Design 3 konform

---

**Last Updated:** $(date +'%Y-%m-%d')
**Workflow Version:** 1.0
**Maintained by:** Material3PHP Development Team

---

> **🤖 Generated with [Claude Code](https://claude.ai/code)**
> **📖 Based on Material Design 3 Standards**