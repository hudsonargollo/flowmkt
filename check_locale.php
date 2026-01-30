<?php
// Locale Diagnostic Script
// Upload to: /home/clubemkt/flow.clubemkt.digital/check_locale.php
// Visit: https://flow.clubemkt.digital/check_locale.php

echo "<h1>FlowMkt Locale Diagnostic</h1>";
echo "<pre>";

// Check if Laravel is accessible
$corePath = __DIR__ . '/core';
$bootstrapPath = $corePath . '/bootstrap/app.php';

if (file_exists($bootstrapPath)) {
    echo "✓ Laravel found\n\n";
    
    // Bootstrap Laravel
    require $bootstrapPath;
    $app = require_once $corePath . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "=== Configuration ===\n";
    echo "APP_LOCALE from .env: " . env('APP_LOCALE', 'not set') . "\n";
    echo "APP_FALLBACK_LOCALE from .env: " . env('APP_FALLBACK_LOCALE', 'not set') . "\n";
    echo "config('app.locale'): " . config('app.locale') . "\n";
    echo "config('app.fallback_locale'): " . config('app.fallback_locale') . "\n";
    echo "Current locale: " . app()->getLocale() . "\n\n";
    
    echo "=== Translation Files ===\n";
    $langPath = $corePath . '/resources/lang';
    if (is_dir($langPath)) {
        $dirs = scandir($langPath);
        foreach ($dirs as $dir) {
            if ($dir != '.' && $dir != '..') {
                echo "- $dir\n";
            }
        }
    }
    echo "\n";
    
    echo "=== Test Translation ===\n";
    echo "trans('Welcome'): " . trans('Welcome') . "\n";
    echo "trans('Dashboard'): " . trans('Dashboard') . "\n";
    echo "__(Welcome'): " . __('Welcome') . "\n\n";
    
    echo "=== Database Settings ===\n";
    try {
        $settings = DB::table('general_settings')->first();
        if ($settings) {
            echo "Language code from DB: " . ($settings->language_code ?? 'not set') . "\n";
            echo "System default language: " . ($settings->system_default_language ?? 'not set') . "\n";
        } else {
            echo "No general_settings found in database\n";
        }
    } catch (Exception $e) {
        echo "Error reading database: " . $e->getMessage() . "\n";
    }
    
} else {
    echo "❌ Laravel bootstrap not found at: $bootstrapPath\n";
}

echo "</pre>";
echo "<p><strong>Delete this file after diagnosis!</strong></p>";
?>
