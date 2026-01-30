<?php
// Simple Locale Check
// Upload to: /home/clubemkt/flow.clubemkt.digital/locale_check_simple.php
// Visit: https://flow.clubemkt.digital/locale_check_simple.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>FlowMkt Locale Check</h1>";
echo "<pre>";

try {
    // Bootstrap Laravel
    require __DIR__ . '/core/bootstrap/app.php';
    $app = require_once __DIR__ . '/core/bootstrap/app.php';
    
    echo "✓ Laravel loaded\n\n";
    
    // Get kernel and bootstrap
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    
    echo "=== Locale Settings ===\n";
    echo "Current locale: " . app()->getLocale() . "\n";
    echo "Fallback locale: " . config('app.fallback_locale') . "\n";
    echo "APP_LOCALE env: " . env('APP_LOCALE') . "\n\n";
    
    echo "=== Available Languages ===\n";
    $langPath = __DIR__ . '/core/resources/lang';
    $languages = array_diff(scandir($langPath), ['.', '..']);
    foreach ($languages as $lang) {
        echo "- $lang\n";
    }
    echo "\n";
    
    echo "=== Test Translations ===\n";
    echo "__('Welcome'): " . __('Welcome') . "\n";
    echo "__('Dashboard'): " . __('Dashboard') . "\n";
    echo "__('Login'): " . __('Login') . "\n\n";
    
    echo "=== Check pt.json ===\n";
    $ptJsonPath = __DIR__ . '/core/resources/lang/pt.json';
    if (file_exists($ptJsonPath)) {
        echo "✓ pt.json exists\n";
        $ptJson = json_decode(file_get_contents($ptJsonPath), true);
        echo "Number of translations: " . count($ptJson) . "\n";
        echo "Sample translations:\n";
        $sample = array_slice($ptJson, 0, 5, true);
        foreach ($sample as $key => $value) {
            echo "  '$key' => '$value'\n";
        }
    } else {
        echo "❌ pt.json not found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "</pre>";
echo "<p><strong>Delete this file after checking!</strong></p>";
?>
