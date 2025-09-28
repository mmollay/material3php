# Material3PHP Development Workflow

## 🔄 Automatische CSS-Updates

Material3PHP hat mehrere Automatisierungsstufen für CSS-Updates:

### 1. 🤖 Vollautomatisch (Empfohlen)

#### Git Pre-Commit Hook
```bash
# Einmalige Einrichtung (bereits gemacht!)
chmod +x .git/hooks/pre-commit
```

**Was passiert automatisch:**
- ✅ Erkennt Änderungen an `src/MD3*.php` Dateien
- ✅ Baut automatisch `dist/material3php.css` neu
- ✅ Fügt CSS-Dateien zum Commit hinzu
- ✅ Verhindert veraltete CSS im Repository

#### GitHub Actions
```yaml
# Läuft automatisch bei Push/PR (bereits konfiguriert!)
on:
  push:
    paths: ['src/MD3*.php']
```

**Was passiert automatisch:**
- ✅ Baut CSS in der Cloud
- ✅ Committet Updates zurück ins Repository
- ✅ Stellt CSS als Artifacts bereit

### 2. 🔍 Manuell prüfen

```bash
# Prüft ob CSS aktuell ist
php check-css-sync.php

# Beispiel Output:
# ✅ CSS is up-to-date!
# 📊 CSS built: 2025-01-26 18:30:45
# 📦 Version: 0.3.6
# 📦 Components: 25
```

### 3. 🛠️ Manuell rebuilden

```bash
# Einfacher Build
./build.sh

# Oder direkt
php build-css.php

# Mit VS Code
# Ctrl+Shift+P → "Tasks: Run Task" → "Material3PHP: Rebuild CSS"
```

## 🚨 Wann Updates nötig sind

### Automatisch erkannt:
- ✅ Änderungen in `src/MD3*.php` Dateien
- ✅ Neue `getCSS()` Methoden
- ✅ Geänderte Design Tokens
- ✅ Build-Script Updates

### Manuell triggern bei:
- 🔄 Theme-Änderungen
- 🔄 Responsive Breakpoint-Updates
- 🔄 Version-Bumps
- 🔄 Deployment auf CDN

## 🎯 Workflow für verschiedene Szenarien

### Szenario 1: Neue Komponente hinzufügen
```bash
# 1. Erstelle src/MD3NewComponent.php mit getCSS() Methode
# 2. Teste die Komponente
# 3. Git commit (CSS wird automatisch mit rebuilt!)
git add .
git commit -m "Add MD3NewComponent"
# 4. CSS ist automatisch aktuell! ✅
```

### Szenario 2: Bestehende Komponente ändern
```bash
# 1. Ändere z.B. src/MD3Button.php
# 2. Git commit (Pre-commit hook rebuildet CSS!)
git add .
git commit -m "Update MD3Button styling"
# 3. CSS ist automatisch updated! ✅
```

### Szenario 3: Theme-System updaten
```bash
# 1. Ändere src/MD3.php oder MD3Theme.php
# 2. Manuell rebuilden (falls Pre-commit nicht triggert)
php build-css.php
# 3. Committen
git add .
git commit -m "Update theme system"
```

### Szenario 4: Production Deployment
```bash
# 1. Prüfe CSS-Status
php check-css-sync.php
# 2. Bei Bedarf rebuilden
./build.sh
# 3. Kopiere zur CDN
cp dist/material3php.min.css /path/to/cdn/
```

## 🔧 Troubleshooting

### CSS wird nicht rebuilt
```bash
# Prüfe Hook-Permissions
ls -la .git/hooks/pre-commit
# Sollte: -rwxr-xr-x anzeigen

# Manuell ausführen
php build-css.php
```

### Unterschiede zwischen Local/CI
```bash
# Lokaler Build
php build-css.php

# Vergleiche mit CI
git diff dist/material3php.css
```

### Performance bei großen Repositories
```bash
# Nur bei Änderungen rebuilden
php check-css-sync.php && echo "CSS up-to-date" || php build-css.php
```

## 🎯 Best Practices

### ✅ Empfohlener Workflow:
1. **Entwickeln**: Ändere MD3-Komponenten
2. **Committen**: Git macht CSS-Update automatisch
3. **Pushen**: GitHub Actions validiert Build
4. **Deployen**: Kopiere `dist/material3php.min.css` zur CDN

### ❌ Vermeiden:
- Manuelle Änderungen in `dist/material3php.css`
- Commits ohne CSS-Update bei Component-Änderungen
- Vergessen von `php build-css.php` nach Theme-Änderungen

## 📊 Monitoring

### Build-Status prüfen
```bash
# Letzte Build-Info
cat dist/build-info.json

# Größe vergleichen
ls -lh dist/material3php*.css
```

### Automation-Status
```bash
# Pre-commit Hook aktiv?
test -x .git/hooks/pre-commit && echo "✅ Pre-commit active" || echo "❌ Pre-commit inactive"

# GitHub Actions logs
# Siehe: https://github.com/mmollay/material3php/actions
```

---

**🚀 Mit diesem System bleiben CSS und PHP-Komponenten immer synchron!**