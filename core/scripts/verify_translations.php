#!/usr/bin/env php
<?php

/**
 * Translation Verification Script
 * 
 * This script identifies untranslated strings, checks for missing translation keys,
 * and generates a comprehensive report of translation completeness.
 * 
 * Usage: php core/scripts/verify_translations.php
 */

class TranslationVerifier
{
    private $basePath;
    private $translationFile;
    private $translations = [];
    private $usedKeys = [];
    private $missingKeys = [];
    private $emptyValues = [];
    private $untranslatedStrings = [];
    private $stats = [];

    public function __construct()
    {
        $this->basePath = dirname(__DIR__);
        $this->translationFile = $this->basePath . '/resources/lang/pt.json';
    }

    public function run()
    {
        echo "\n";
        echo "╔════════════════════════════════════════════════════════════════╗\n";
        echo "║         FlowMkt Translation Verification Report               ║\n";
        echo "╚════════════════════════════════════════════════════════════════╝\n";
        echo "\n";

        $this->loadTranslations();
        $this->extractKeysFromBladeTemplates();
        $this->extractKeysFromReactComponents();
        $this->extractKeysFromJavaScript();
        $this->checkMissingKeys();
        $this->checkEmptyValues();
        $this->generateReport();
    }

    private function loadTranslations()
    {
        echo "📂 Loading translation file...\n";
        
        if (!file_exists($this->translationFile)) {
            echo "❌ Error: Translation file not found at {$this->translationFile}\n";
            exit(1);
        }

        $content = file_get_contents($this->translationFile);
        $this->translations = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "❌ Error: Invalid JSON in translation file: " . json_last_error_msg() . "\n";
            exit(1);
        }

        echo "✅ Loaded " . count($this->translations) . " translation keys\n\n";
    }

    private function extractKeysFromBladeTemplates()
    {
        echo "🔍 Scanning Blade templates...\n";
        
        $viewsPath = $this->basePath . '/resources/views';
        $bladeFiles = $this->getFilesRecursive($viewsPath, '*.blade.php');
        
        $keyCount = 0;
        foreach ($bladeFiles as $file) {
            $content = file_get_contents($file);
            
            // Match __('key') and __("key")
            preg_match_all("/__\(['\"]([^'\"]+)['\"]\)/", $content, $matches1);
            
            // Match @lang('key') and @lang("key")
            preg_match_all("/@lang\(['\"]([^'\"]+)['\"]\)/", $content, $matches2);
            
            // Match {{ trans('key') }} and {{ trans("key") }}
            preg_match_all("/trans\(['\"]([^'\"]+)['\"]\)/", $content, $matches3);
            
            $keys = array_merge($matches1[1], $matches2[1], $matches3[1]);
            
            foreach ($keys as $key) {
                if (!isset($this->usedKeys[$key])) {
                    $this->usedKeys[$key] = [];
                }
                $this->usedKeys[$key][] = str_replace($this->basePath . '/', '', $file);
                $keyCount++;
            }
        }
        
        echo "✅ Found " . count($this->usedKeys) . " unique translation keys in " . count($bladeFiles) . " Blade files\n\n";
    }

    private function extractKeysFromReactComponents()
    {
        echo "🔍 Scanning React components...\n";
        
        $reactPath = $this->basePath . '/resources/js/flow_builder';
        
        if (!is_dir($reactPath)) {
            echo "⚠️  React components directory not found, skipping...\n\n";
            return;
        }
        
        $jsxFiles = $this->getFilesRecursive($reactPath, '*.jsx');
        $jsFiles = $this->getFilesRecursive($reactPath, '*.js');
        $allFiles = array_merge($jsxFiles, $jsFiles);
        
        $keyCount = 0;
        foreach ($allFiles as $file) {
            $content = file_get_contents($file);
            
            // Match t('key') and t("key") - translation function
            preg_match_all("/t\(['\"]([^'\"]+)['\"]\)/", $content, $matches);
            
            foreach ($matches[1] as $key) {
                if (!isset($this->usedKeys[$key])) {
                    $this->usedKeys[$key] = [];
                }
                $this->usedKeys[$key][] = str_replace($this->basePath . '/', '', $file);
                $keyCount++;
            }
        }
        
        echo "✅ Found translation keys in " . count($allFiles) . " React/JS files\n\n";
    }

    private function extractKeysFromJavaScript()
    {
        echo "🔍 Scanning JavaScript files...\n";
        
        $assetsPath = dirname($this->basePath) . '/assets';
        
        if (!is_dir($assetsPath)) {
            echo "⚠️  Assets directory not found, skipping...\n\n";
            return;
        }
        
        $jsFiles = $this->getFilesRecursive($assetsPath, '*.js');
        
        echo "✅ Scanned " . count($jsFiles) . " JavaScript files\n\n";
    }

    private function checkMissingKeys()
    {
        echo "🔍 Checking for missing translation keys...\n";
        
        foreach ($this->usedKeys as $key => $files) {
            if (!isset($this->translations[$key])) {
                $this->missingKeys[$key] = $files;
            }
        }
        
        if (count($this->missingKeys) > 0) {
            echo "⚠️  Found " . count($this->missingKeys) . " missing translation keys\n\n";
        } else {
            echo "✅ All used translation keys exist in pt.json\n\n";
        }
    }

    private function checkEmptyValues()
    {
        echo "🔍 Checking for empty translation values...\n";
        
        foreach ($this->translations as $key => $value) {
            if (empty(trim($value))) {
                $this->emptyValues[] = $key;
            }
        }
        
        if (count($this->emptyValues) > 0) {
            echo "⚠️  Found " . count($this->emptyValues) . " empty translation values\n\n";
        } else {
            echo "✅ All translation keys have non-empty values\n\n";
        }
    }

    private function generateReport()
    {
        echo "\n";
        echo "╔════════════════════════════════════════════════════════════════╗\n";
        echo "║                    VERIFICATION SUMMARY                        ║\n";
        echo "╚════════════════════════════════════════════════════════════════╝\n";
        echo "\n";

        // Statistics
        echo "📊 Statistics:\n";
        echo "   • Total translation keys in pt.json: " . count($this->translations) . "\n";
        echo "   • Unique keys used in templates: " . count($this->usedKeys) . "\n";
        echo "   • Missing translation keys: " . count($this->missingKeys) . "\n";
        echo "   • Empty translation values: " . count($this->emptyValues) . "\n";
        
        $coverage = count($this->usedKeys) > 0 
            ? round((1 - count($this->missingKeys) / count($this->usedKeys)) * 100, 2)
            : 100;
        echo "   • Translation coverage: " . $coverage . "%\n";
        echo "\n";

        // Missing keys details
        if (count($this->missingKeys) > 0) {
            echo "❌ Missing Translation Keys:\n";
            echo "   The following keys are used in templates but not defined in pt.json:\n\n";
            
            $count = 1;
            foreach ($this->missingKeys as $key => $files) {
                echo "   {$count}. \"{$key}\"\n";
                echo "      Used in:\n";
                foreach (array_unique($files) as $file) {
                    echo "      - {$file}\n";
                }
                echo "\n";
                $count++;
                
                // Limit output to first 20 missing keys
                if ($count > 20) {
                    $remaining = count($this->missingKeys) - 20;
                    echo "   ... and {$remaining} more missing keys\n\n";
                    break;
                }
            }
        }

        // Empty values details
        if (count($this->emptyValues) > 0) {
            echo "⚠️  Empty Translation Values:\n";
            echo "   The following keys have empty values in pt.json:\n\n";
            
            $count = 1;
            foreach ($this->emptyValues as $key) {
                echo "   {$count}. \"{$key}\"\n";
                $count++;
                
                // Limit output to first 20 empty values
                if ($count > 20) {
                    $remaining = count($this->emptyValues) - 20;
                    echo "   ... and {$remaining} more empty values\n\n";
                    break;
                }
            }
        }

        // Unused keys (keys in pt.json but not used anywhere)
        $unusedKeys = array_diff(array_keys($this->translations), array_keys($this->usedKeys));
        if (count($unusedKeys) > 0) {
            echo "ℹ️  Unused Translation Keys:\n";
            echo "   The following keys exist in pt.json but are not used in templates:\n";
            echo "   (This is not necessarily a problem - they may be used dynamically)\n\n";
            echo "   • Total unused keys: " . count($unusedKeys) . "\n\n";
        }

        // Final verdict
        echo "╔════════════════════════════════════════════════════════════════╗\n";
        if (count($this->missingKeys) === 0 && count($this->emptyValues) === 0) {
            echo "║  ✅ PASSED: Translation verification completed successfully!  ║\n";
        } else {
            echo "║  ⚠️  WARNINGS: Translation issues found (see details above)   ║\n";
        }
        echo "╚════════════════════════════════════════════════════════════════╝\n";
        echo "\n";

        // Save detailed report to file
        $this->saveDetailedReport();
    }

    private function saveDetailedReport()
    {
        $reportPath = $this->basePath . '/storage/logs/translation_verification_report.json';
        
        $report = [
            'timestamp' => date('Y-m-d H:i:s'),
            'statistics' => [
                'total_keys' => count($this->translations),
                'used_keys' => count($this->usedKeys),
                'missing_keys' => count($this->missingKeys),
                'empty_values' => count($this->emptyValues),
                'coverage_percentage' => count($this->usedKeys) > 0 
                    ? round((1 - count($this->missingKeys) / count($this->usedKeys)) * 100, 2)
                    : 100
            ],
            'missing_keys' => $this->missingKeys,
            'empty_values' => $this->emptyValues,
            'unused_keys' => array_diff(array_keys($this->translations), array_keys($this->usedKeys))
        ];

        file_put_contents($reportPath, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo "📄 Detailed report saved to: " . str_replace($this->basePath . '/', '', $reportPath) . "\n\n";
    }

    private function getFilesRecursive($directory, $pattern)
    {
        if (!is_dir($directory)) {
            return [];
        }

        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && fnmatch($pattern, $file->getFilename())) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }
}

// Run the verification
$verifier = new TranslationVerifier();
$verifier->run();
