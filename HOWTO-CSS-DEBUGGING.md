# HOW-TO: CSS & Component Debugging für Material Design 3 PHP Library

> **Wichtige Erkenntnisse für zukünftige Debugging-Sessions**

## 🚨 **KRITISCHE REGEL #1: Immer von funktionierenden Seiten lernen**

### ✅ **Funktionierende Referenzen:**
- **index.php** - Basis-Implementation, immer funktionsfähig
- **playground.php** - Vollständige Component-Implementation mit allen CSS/JS-Includes

### ❌ **Häufiger Fehler:**
Komplizierte CSS-Überladungen und custom CSS schreiben, statt die vorhandenen Component-CSS-Includes zu nutzen.

---

## 🔧 **CSS-Loading Best Practices**

### **1. MD3::init() ist PFLICHT**
```php
echo MD3::init(true, true, $currentTheme);
```

### **2. Alle Component CSS in EINEM Style-Block (wie playground.php)**
```php
<style>
<?php
if (class_exists('MD3Theme')) {
    echo MD3Theme::getThemeCSS();
}
echo MD3::getVersionCSS();
// Alle Components:
echo MD3Header::getCSS();
echo MD3Button::getCSS();
echo MD3TextField::getCSS();
echo MD3Switch::getCSS();
echo MD3Checkbox::getCSS();
echo MD3Radio::getCSS();
echo MD3Select::getCSS();
echo MD3List::getCSS();
echo MD3Chip::getCSS();
echo MD3Tooltip::getCSS();
?>
</style>
```

### **3. JavaScript NACH dem HTML-Content**
```php
<script>
<?php
echo MD3Switch::getJS();
echo MD3Checkbox::getJS();
echo MD3Radio::getJS();
echo MD3Chip::getJS();
echo MD3List::getJS();
echo MD3Tooltip::getJS();
?>
</script>

<?php
echo MD3Search::getSearchScript();
echo MD3Tooltip::getTooltipScript();
echo MD3Select::getSelectScript();
echo MD3Theme::getThemeScript();
?>
```

---

## 🐛 **Debugging-Workflow bei CSS-Problemen**

### **Schritt 1: Funktionstest**
```bash
curl -s "http://localhost/material3php/demo-seite.php" | grep -c "</body>"
```
- Wenn `0` → PHP Fatal Error
- Wenn `1` → Seite lädt vollständig

### **Schritt 2: PHP Error Check**
```bash
curl -s "http://localhost/material3php/demo-seite.php" | grep -i "fatal\|parse error\|warning:" | head -5
```

### **Schritt 3: Playwright Visual Test**
```bash
node test-demo-functional.js
```

### **Schritt 4: Bei Problemen - Zurück zur Basis**
1. **ALLES rauswerfen** außer MD3::init()
2. **Schrittweise hinzufügen** wie in playground.php
3. **NIEMALS** custom CSS schreiben, sondern Component-CSS nutzen

---

## ⚠️ **Häufige Probleme & Lösungen**

### **Problem: Components sehen aus wie Standard-HTML**
**Ursache:** CSS-Includes funktionieren nicht
**Lösung:** Exakt wie playground.php strukturieren

### **Problem: PHP Fatal Error bei CSS-Output**
**Ursache:** Ein Component-CSS hat Syntax-Fehler
**Lösung:** CSS-Includes einzeln kommentieren bis Verursacher gefunden

### **Problem: "Method withLabel() expects 3 params, 4 given"**
**Ursache:** Falsche Parameter-Übergabe
**Lösung:**
```php
// ❌ Falsch:
MD3Switch::withLabel('name', 'label', 'value', true);

// ✅ Richtig:
MD3Switch::withLabel('name', 'label', ['value' => 'value', 'checked' => true]);
```

### **Problem: Seite lädt nur teilweise**
**Ursache:** CSS-Output bricht ab
**Lösung:** Try-catch um CSS-Includes oder Einzeln testen

---

## 📋 **Checklist für neue Demo-Seiten**

- [ ] **MD3::init()** eingebunden
- [ ] **Alle require_once** für verwendete Components
- [ ] **CSS-Block wie playground.php** strukturiert
- [ ] **JavaScript-Includes** nach HTML-Content
- [ ] **Component-Methoden** korrekt parametrisiert
- [ ] **Playwright-Test** erfolgreich
- [ ] **Curl-Test** zeigt vollständige Seite

---

## 🎯 **Golden Rules**

1. **"Don't reinvent the wheel"** - Nutze playground.php als Template
2. **"When in doubt, copy playground.php"** - Die Struktur funktioniert
3. **"Test early, test often"** - Immer curl + Playwright testen
4. **"Less is more"** - Keine custom CSS wenn Component-CSS existiert

---

## 🚀 **Erfolgreiche Patterns**

### **Header-Struktur (funktioniert immer):**
```php
<?php
require_once 'src/MD3.php';
require_once 'src/MD3Button.php';
// ... weitere requires

$currentTheme = $_GET['theme'] ?? 'default';
echo MD3::init(true, true, $currentTheme);
?>
```

### **CSS-Struktur (funktioniert immer):**
```php
<style>
<?php
if (class_exists('MD3Theme')) {
    echo MD3Theme::getThemeCSS();
}
echo MD3::getVersionCSS();
// Dann alle Component CSS
?>
</style>
```

---

**Letzte Aktualisierung:** 2025-09-28
**Status:** Production Ready ✅
**Getestet mit:** Material Design 3 PHP Library v0.2.40