<?php
// Enable Pricing Section on Landing Page
// Upload to: /home/clubemkt/flow.clubemkt.digital/enable_pricing_section.php
// Visit: https://flow.clubemkt.digital/enable_pricing_section.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<h1>Enable Pricing Section</h1>";
echo "<pre>";

try {
    $host = '127.0.0.1';
    $db = 'clubemkt_zapflow';
    $user = 'clubemkt_zapflow';
    $pass = 'tF4s8*7KnB*2';
    
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connected\n\n";
    
    if (isset($_GET['check']) && $_GET['check'] == 'yes') {
        echo "=== CHECKING FRONTEND SECTIONS ===\n\n";
        
        // Check all frontend sections and their status
        $stmt = $conn->query("SELECT DISTINCT data_keys FROM frontends ORDER BY data_keys");
        $sections = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "All available sections:\n";
        foreach ($sections as $section) {
            echo "  - $section\n";
        }
        
        // Check if there's a frontend_sections or similar table
        $tables = $conn->query("SHOW TABLES LIKE '%frontend%'")->fetchAll(PDO::FETCH_COLUMN);
        echo "\nFrontend-related tables:\n";
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
        
        // Check pricing specifically
        echo "\n--- Pricing Section Details ---\n";
        $stmt = $conn->query("SELECT * FROM frontends WHERE data_keys LIKE '%pricing%'");
        $pricing = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($pricing as $p) {
            echo "\nID: {$p['id']}\n";
            echo "Key: {$p['data_keys']}\n";
            echo "Template: {$p['template_name']}\n";
            $values = json_decode($p['data_values'], true);
            echo "Content: " . json_encode($values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        }
        
        echo "\n<a href='?' style='display: inline-block; background: blue; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;'>BACK</a>\n";
        
    } else if (isset($_GET['show_template']) && $_GET['show_template'] == 'yes') {
        echo "=== CHECKING TEMPLATE FILES ===\n\n";
        
        // Check if pricing template exists
        $templatePath = __DIR__ . '/core/resources/views/templates/basic/sections/pricing.blade.php';
        if (file_exists($templatePath)) {
            echo "✓ Pricing template exists at:\n";
            echo "  $templatePath\n\n";
        } else {
            echo "❌ Pricing template NOT found at:\n";
            echo "  $templatePath\n\n";
            
            // Check what templates exist
            $sectionsDir = __DIR__ . '/core/resources/views/templates/basic/sections';
            if (is_dir($sectionsDir)) {
                echo "Available section templates:\n";
                $files = scandir($sectionsDir);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        echo "  - $file\n";
                    }
                }
            }
        }
        
        // Check home page template
        $homePath = __DIR__ . '/core/resources/views/templates/basic/home.blade.php';
        if (file_exists($homePath)) {
            echo "\n--- Checking home.blade.php for pricing section ---\n";
            $content = file_get_contents($homePath);
            if (strpos($content, 'pricing') !== false) {
                echo "✓ Pricing section IS referenced in home template\n";
                // Extract the pricing section code
                preg_match('/@include.*pricing.*/', $content, $matches);
                if (!empty($matches)) {
                    echo "Found: {$matches[0]}\n";
                }
            } else {
                echo "❌ Pricing section NOT referenced in home template\n";
                echo "The pricing section may need to be added to the home page template\n";
            }
        }
        
        echo "\n<a href='?' style='display: inline-block; background: blue; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;'>BACK</a>\n";
        
    } else if (isset($_GET['enable']) && $_GET['enable'] == 'yes') {
        echo "=== ENABLING PRICING SECTION ===\n\n";
        
        // Check if pricing content exists
        $stmt = $conn->query("SELECT COUNT(*) FROM frontends WHERE data_keys = 'pricing.content'");
        $hasContent = $stmt->fetchColumn() > 0;
        
        if (!$hasContent) {
            echo "Creating pricing content section...\n";
            
            $pricingContent = [
                'heading' => 'Preços Simples e Transparentes',
                'subheading' => 'Escolha o plano que atende suas necessidades'
            ];
            
            $stmt = $conn->prepare("INSERT INTO frontends (template_name, data_keys, data_values, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $stmt->execute([
                'basic',
                'pricing.content',
                json_encode($pricingContent, JSON_UNESCAPED_UNICODE)
            ]);
            
            echo "✓ Created pricing.content\n";
        } else {
            echo "✓ Pricing content already exists\n";
        }
        
        // Check if pricing elements exist
        $stmt = $conn->query("SELECT COUNT(*) FROM frontends WHERE data_keys = 'pricing.element'");
        $elementCount = $stmt->fetchColumn();
        
        echo "Found $elementCount pricing plan(s)\n";
        
        if ($elementCount == 0) {
            echo "\n⚠️ No pricing plans found!\n";
            echo "You need to create pricing plans in the admin panel:\n";
            echo "Admin Panel → Frontend Management → Manage Section → Pricing\n\n";
        }
        
        echo "\n✅ PRICING SECTION CHECK COMPLETE!\n\n";
        echo "If pricing plans exist but aren't showing:\n";
        echo "1. Go to Admin Panel → Frontend Management → Manage Section\n";
        echo "2. Find the 'Pricing' section\n";
        echo "3. Make sure it's enabled/active\n";
        echo "4. Check that pricing plans are created\n\n";
        echo "Visit: https://flow.clubemkt.digital/admin/frontend/sections\n\n";
        echo "⚠️ DELETE THIS FILE NOW!\n";
        
    } else {
        echo "=== PRICING SECTION DIAGNOSTIC TOOL ===\n\n";
        echo "This tool will help diagnose why pricing cards aren't showing.\n\n";
        echo "Choose an action:\n\n";
        echo "<a href='?check=yes' style='display: inline-block; background: blue; color: white; padding: 15px 30px; text-decoration: none; font-weight: bold; margin: 10px; border-radius: 5px;'>CHECK DATABASE</a>\n";
        echo "<a href='?show_template=yes' style='display: inline-block; background: purple; color: white; padding: 15px 30px; text-decoration: none; font-weight: bold; margin: 10px; border-radius: 5px;'>CHECK TEMPLATES</a>\n";
        echo "<a href='?enable=yes' style='display: inline-block; background: green; color: white; padding: 15px 30px; text-decoration: none; font-weight: bold; margin: 10px; border-radius: 5px;'>ENABLE PRICING</a>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
?>
