<?php
/**
 * Version Management Script for Material Design 3 PHP Library
 *
 * Usage:
 * php version.php patch   # Increment patch version (2.1.0 -> 2.1.1)
 * php version.php minor   # Increment minor version (2.1.0 -> 2.2.0)
 * php version.php major   # Increment major version (2.1.0 -> 3.0.0)
 * php version.php set X.Y.Z # Set specific version
 * php version.php show    # Show current version info
 */

require_once 'src/MD3.php';

class VersionManager
{
    private $versionFile;
    private $changelogFile;

    public function __construct()
    {
        $this->versionFile = __DIR__ . '/VERSION';
        $this->changelogFile = __DIR__ . '/CHANGELOG.md';
    }

    public function getCurrentVersion(): string
    {
        if (file_exists($this->versionFile)) {
            return trim(file_get_contents($this->versionFile));
        }
        return '1.0.0';
    }

    public function setVersion(string $version): bool
    {
        if (!$this->isValidVersion($version)) {
            echo "❌ Ungültige Version: {$version}\n";
            return false;
        }

        file_put_contents($this->versionFile, $version);
        echo "✅ Version gesetzt auf: {$version}\n";
        return true;
    }

    public function incrementVersion(string $type): bool
    {
        $currentVersion = $this->getCurrentVersion();
        $parts = explode('.', $currentVersion);

        if (count($parts) !== 3) {
            echo "❌ Ungültige aktuelle Version: {$currentVersion}\n";
            return false;
        }

        [$major, $minor, $patch] = array_map('intval', $parts);

        switch ($type) {
            case 'major':
                $major++;
                $minor = 0;
                $patch = 0;
                break;
            case 'minor':
                $minor++;
                $patch = 0;
                break;
            case 'patch':
                $patch++;
                break;
            default:
                echo "❌ Unbekannter Version-Typ: {$type}\n";
                return false;
        }

        $newVersion = "{$major}.{$minor}.{$patch}";
        return $this->setVersion($newVersion);
    }

    public function showVersionInfo(): void
    {
        echo "📋 Material Design 3 PHP Library - Version Information\n";
        echo str_repeat('=', 60) . "\n";

        $info = MD3::getVersionInfo();
        echo "Version: {$info['version']}\n";
        echo "Build Date: {$info['build_date']}\n";
        echo "PHP Version: {$info['php_version']}\n";
        echo "Offline Ready: " . ($info['offline_ready'] ? '✅' : '❌') . "\n";
        echo "CSS Only: " . ($info['css_only'] ? '✅' : '❌') . "\n";
        echo "Material Web Components: " . ($info['material_web_components'] ? '✅' : '❌') . "\n";
        echo "Components: " . count($info['components']) . "\n";

        echo "\n📦 Available Components:\n";
        foreach ($info['components'] as $component) {
            echo "  • {$component}\n";
        }

        // Show changelog for current version
        $changelog = MD3::getChangelog();
        if (isset($changelog['sections']) && !empty($changelog['sections'])) {
            echo "\n📝 Changelog v{$changelog['version']}:\n";
            foreach ($changelog['sections'] as $section => $items) {
                echo "\n  {$section}:\n";
                foreach ($items as $item) {
                    echo "    • {$item}\n";
                }
            }
        }
    }

    public function initializeChangelog(string $version): void
    {
        if (!file_exists($this->changelogFile)) {
            echo "❌ Changelog file not found: {$this->changelogFile}\n";
            return;
        }

        $changelog = file_get_contents($this->changelogFile);
        $date = date('Y-m-d');

        // Add new unreleased section
        $newSection = "\n## [Unveröffentlicht]\n\n## [{$version}] - {$date}\n";

        // Insert after the first "## [Unveröffentlicht]" line
        $pattern = '/^## \[Unveröffentlicht\]\s*$/m';
        if (preg_match($pattern, $changelog)) {
            $changelog = preg_replace($pattern, $newSection, $changelog, 1);
        } else {
            // If no unreleased section exists, add it after the header
            $headerEnd = strpos($changelog, "\n## ");
            if ($headerEnd !== false) {
                $changelog = substr_replace($changelog, $newSection . "\n", $headerEnd + 1, 0);
            }
        }

        file_put_contents($this->changelogFile, $changelog);
        echo "✅ Changelog initialisiert für Version {$version}\n";
    }

    private function isValidVersion(string $version): bool
    {
        return preg_match('/^\d+\.\d+\.\d+$/', $version) === 1;
    }
}

// CLI Interface
if (php_sapi_name() !== 'cli') {
    die("❌ Dieses Script muss über die Kommandozeile ausgeführt werden.\n");
}

$manager = new VersionManager();
$command = $argv[1] ?? 'show';

switch ($command) {
    case 'show':
        $manager->showVersionInfo();
        break;

    case 'major':
    case 'minor':
    case 'patch':
        $oldVersion = $manager->getCurrentVersion();
        if ($manager->incrementVersion($command)) {
            $newVersion = $manager->getCurrentVersion();
            echo "📈 Version aktualisiert: {$oldVersion} → {$newVersion}\n";
            echo "💡 Vergessen Sie nicht, die CHANGELOG.md zu aktualisieren!\n";
        }
        break;

    case 'set':
        if (!isset($argv[2])) {
            echo "❌ Verwendung: php version.php set X.Y.Z\n";
            exit(1);
        }
        $oldVersion = $manager->getCurrentVersion();
        if ($manager->setVersion($argv[2])) {
            echo "📝 Version geändert: {$oldVersion} → {$argv[2]}\n";
        }
        break;

    case 'init-changelog':
        $version = $argv[2] ?? $manager->getCurrentVersion();
        $manager->initializeChangelog($version);
        break;

    case 'help':
    default:
        echo "🔧 Material Design 3 PHP Library - Version Manager\n\n";
        echo "Verwendung:\n";
        echo "  php version.php show           Aktuelle Version-Info anzeigen\n";
        echo "  php version.php patch          Patch-Version erhöhen (2.1.0 → 2.1.1)\n";
        echo "  php version.php minor          Minor-Version erhöhen (2.1.0 → 2.2.0)\n";
        echo "  php version.php major          Major-Version erhöhen (2.1.0 → 3.0.0)\n";
        echo "  php version.php set X.Y.Z      Spezifische Version setzen\n";
        echo "  php version.php init-changelog Changelog für neue Version vorbereiten\n";
        echo "  php version.php help           Diese Hilfe anzeigen\n";
        break;
}