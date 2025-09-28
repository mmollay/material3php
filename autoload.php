<?php
/**
 * Material Design 3 PHP Library - Autoloader
 *
 * This autoloader provides automatic class loading for all MD3 components
 * without requiring manual require_once statements.
 *
 * Usage:
 *   require_once 'autoload.php';
 *   echo MD3Button::filled('Hello World');
 *
 * @version 0.2.43
 * @author Martin Mollay <office@ssi.at>
 */

class MD3Autoloader {

    private static $instance = null;
    private static $basePath = '';
    private static $classes = [];

    /**
     * Get singleton instance
     */
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialize autoloader
     */
    private function __construct() {
        self::$basePath = __DIR__ . '/src/';
        $this->registerClasses();
        spl_autoload_register([$this, 'autoload']);
    }

    /**
     * Register all available MD3 classes
     */
    private function registerClasses(): void {
        $srcDir = self::$basePath;

        if (!is_dir($srcDir)) {
            return;
        }

        // Scan for all MD3*.php files
        $files = glob($srcDir . 'MD3*.php');

        foreach ($files as $file) {
            $className = basename($file, '.php');
            self::$classes[$className] = $file;
        }
    }

    /**
     * Autoload MD3 classes
     */
    public function autoload(string $className): void {
        // Only handle MD3 classes
        if (strpos($className, 'MD3') !== 0) {
            return;
        }

        // Check if we have this class registered
        if (isset(self::$classes[$className])) {
            $file = self::$classes[$className];

            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }

        // Fallback: try direct file mapping
        $file = self::$basePath . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }

    /**
     * Get list of available classes
     */
    public static function getAvailableClasses(): array {
        return array_keys(self::$classes);
    }

    /**
     * Check if a class is available
     */
    public static function hasClass(string $className): bool {
        return isset(self::$classes[$className]);
    }

    /**
     * Get component count
     */
    public static function getComponentCount(): int {
        return count(self::$classes);
    }

    /**
     * Initialize Material Design 3 system
     * This replaces the need for MD3::init() in simple cases
     */
    public static function init(bool $includeFonts = true, bool $includeCSS = true, string $theme = 'default'): string {
        // Ensure MD3 main class is loaded
        if (!class_exists('MD3')) {
            $md3File = self::$basePath . 'MD3.php';
            if (file_exists($md3File)) {
                require_once $md3File;
            }
        }

        // Call MD3::init if available
        if (class_exists('MD3') && method_exists('MD3', 'init')) {
            return MD3::init($includeFonts, $includeCSS, $theme);
        }

        return '';
    }
}

// Auto-initialize the autoloader
MD3Autoloader::getInstance();

// Convenience functions for backwards compatibility
if (!function_exists('md3_init')) {
    function md3_init(bool $includeFonts = true, bool $includeCSS = true, string $theme = 'default'): string {
        return MD3Autoloader::init($includeFonts, $includeCSS, $theme);
    }
}

if (!function_exists('md3_component_count')) {
    function md3_component_count(): int {
        return MD3Autoloader::getComponentCount();
    }
}

if (!function_exists('md3_available_classes')) {
    function md3_available_classes(): array {
        return MD3Autoloader::getAvailableClasses();
    }
}