<?php
// ============================================================================
// ENTRY POINT AND CONFIGURATION
// ============================================================================

// File: index.php (main entry point)
// Autoload core classes
spl_autoload_register(function ($class) {
    $paths = [
        'core/',
        'controllers/',
        'models/'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path . $class . '.php')) {
            require_once $path . $class . '.php';
            return;
        }
    }
});

// Start the application
$app = new App();