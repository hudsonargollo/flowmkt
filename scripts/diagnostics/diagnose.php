<?php
/**
 * FlowMkt Diagnostic Script
 * Upload this file to public_html/flow/ and access it via browser
 * URL: https://flow.clubemkt.digital/diagnose.php
 */

header('Content-Type: text/plain');

echo "=== FlowMkt Diagnostic Report ===\n\n";

// Check PHP version
echo "PHP Version: " . phpversion() . "\n";
echo "Required: 8.1+\n\n";

// Check if core directory exists
$coreDir = __DIR__ . '/core';
echo "Core Directory: " . ($coreDir) . "\n";
echo "Exists: " . (is_dir($coreDir) ? 'YES' : 'NO') . "\n\n";

// Check .env file
$envFile = $coreDir . '/.env';
echo ".env File: " . $envFile . "\n";
echo "Exists: " . (file_exists($envFile) ? 'YES' : 'NO') . "\n";
if (file_exists($envFile)) {
    echo "Readable: " . (is_readable($envFile) ? 'YES' : 'NO') . "\n";
    
    // Check for APP_KEY
    $envContent = file_get_contents($envFile);
    echo "Has APP_KEY: " . (strpos($envContent, 'APP_KEY=') !== false ? 'YES' : 'NO') . "\n";
    echo "Has APP_NAME: " . (strpos($envContent, 'APP_NAME=') !== false ? 'YES' : 'NO') . "\n";
}
echo "\n";

// Check storage directory permissions
$storageDir = $coreDir . '/storage';
echo "Storage Directory: " . $storageDir . "\n";
echo "Exists: " . (is_dir($storageDir) ? 'YES' : 'NO') . "\n";
if (is_dir($storageDir)) {
    echo "Writable: " . (is_writable($storageDir) ? 'YES' : 'NO') . "\n";
    echo "Permissions: " . substr(sprintf('%o', fileperms($storageDir)), -4) . "\n";
}
echo "\n";

// Check logs directory
$logsDir = $storageDir . '/logs';
echo "Logs Directory: " . $logsDir . "\n";
echo "Exists: " . (is_dir($logsDir) ? 'YES' : 'NO') . "\n";
if (is_dir($logsDir)) {
    echo "Writable: " . (is_writable($logsDir) ? 'YES' : 'NO') . "\n";
    
    // Find latest log file
    $logFiles = glob($logsDir . '/laravel*.log');
    if ($logFiles) {
        $latestLog = end($logFiles);
        echo "Latest Log: " . basename($latestLog) . "\n";
        echo "Log Size: " . filesize($latestLog) . " bytes\n";
        
        // Show last 20 lines of log
        echo "\n--- Last 20 Lines of Log ---\n";
        $lines = file($latestLog);
        $lastLines = array_slice($lines, -20);
        echo implode('', $lastLines);
        echo "\n--- End of Log ---\n\n";
    } else {
        echo "No log files found\n";
    }
}
echo "\n";

// Check bootstrap/cache
$bootstrapCache = $coreDir . '/bootstrap/cache';
echo "Bootstrap Cache: " . $bootstrapCache . "\n";
echo "Exists: " . (is_dir($bootstrapCache) ? 'YES' : 'NO') . "\n";
if (is_dir($bootstrapCache)) {
    echo "Writable: " . (is_writable($bootstrapCache) ? 'YES' : 'NO') . "\n";
    echo "Permissions: " . substr(sprintf('%o', fileperms($bootstrapCache)), -4) . "\n";
}
echo "\n";

// Check vendor directory
$vendorDir = $coreDir . '/vendor';
echo "Vendor Directory: " . $vendorDir . "\n";
echo "Exists: " . (is_dir($vendorDir) ? 'YES' : 'NO') . "\n";
if (is_dir($vendorDir)) {
    $autoload = $vendorDir . '/autoload.php';
    echo "Autoload exists: " . (file_exists($autoload) ? 'YES' : 'NO') . "\n";
}
echo "\n";

// Check required PHP extensions
echo "=== PHP Extensions ===\n";
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'json', 'curl', 'zip'];
foreach ($requiredExtensions as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? 'LOADED' : 'MISSING') . "\n";
}
echo "\n";

// Check file ownership
echo "=== File Ownership ===\n";
echo "Script owner: " . get_current_user() . "\n";
if (function_exists('posix_getpwuid')) {
    $fileOwner = posix_getpwuid(fileowner(__FILE__));
    echo "File owner: " . $fileOwner['name'] . "\n";
}
echo "\n";

// Recommendations
echo "=== Recommendations ===\n";

if (!file_exists($envFile)) {
    echo "❌ CRITICAL: .env file is missing!\n";
    echo "   Copy .env.example to .env and configure it.\n\n";
}

if (is_dir($storageDir) && !is_writable($storageDir)) {
    echo "❌ CRITICAL: storage directory is not writable!\n";
    echo "   Run: chmod -R 755 storage\n\n";
}

if (is_dir($bootstrapCache) && !is_writable($bootstrapCache)) {
    echo "❌ CRITICAL: bootstrap/cache is not writable!\n";
    echo "   Run: chmod -R 755 bootstrap/cache\n\n";
}

if (!is_dir($vendorDir)) {
    echo "❌ CRITICAL: vendor directory is missing!\n";
    echo "   Run: composer install\n\n";
}

echo "\n=== End of Diagnostic Report ===\n";
echo "\nDelete this file after diagnosis for security!\n";
