<?php
// Fix Remaining English Content
// Upload to: /home/clubemkt/flow.clubemkt.digital/fix_remaining_english.php
// Visit: https://flow.clubemkt.digital/fix_remaining_english.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<h1>Fix Remaining English Content</h1>";
echo "<pre>";

try {
    $host = '127.0.0.1';
    $db = 'clubemkt_zapflow';
    $user = 'clubemkt_zapflow';
    $pass = 'tF4s8*7KnB*2';
    
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connected\n\n";
    
    // Targeted translations for remaining English content
    $translations = [
        // "Como Funciona" section fixes
        'Entenda o processo desde o cadastro até o lançamento da campanha em apenas few steps' => 'Entenda o processo desde o cadastro até o lançamento da campanha em apenas alguns passos',
        'few steps' => 'alguns passos',
        'a few steps' => 'alguns passos',
        'in just a few steps' => 'em apenas alguns passos',
        
        // Step 1: Join/Register
        'Join to Platparam' => 'Junte-se à Plataforma',
        'Join to Platform' => 'Junte-se à Plataforma',
        'Cadastrar para free e unlock a full-featured Marketing e CRM platparam comin seconds' => 'Cadastre-se gratuitamente e desbloqueie uma plataforma completa de Marketing e CRM em segundos',
        'Cadastrar para free' => 'Cadastre-se gratuitamente',
        'unlock a full-featured' => 'desbloqueie uma plataforma completa',
        'Marketing e CRM platparam' => 'Marketing e CRM',
        'comin seconds' => 'em segundos',
        'in seconds' => 'em segundos',
        
        // Step 2: Explore Features
        'Explore nosso Feature' => 'Explore Nossos Recursos',
        'Explore our Feature' => 'Explore Nossos Recursos',
        'Explore our Features' => 'Explore Nossos Recursos',
        'Discover powerful tools like Automação, Campanha builders, e conversion boosters' => 'Descubra ferramentas poderosas como Automação, construtores de Campanha e impulsionadores de conversão',
        'Discover powerful tools like Automação' => 'Descubra ferramentas poderosas como Automação',
        'Campanha builders' => 'construtores de Campanha',
        'Campaign builders' => 'construtores de Campanha',
        'e conversion boosters' => 'e impulsionadores de conversão',
        'and conversion boosters' => 'e impulsionadores de conversão',
        'conversion boosters' => 'impulsionadores de conversão',
        
        // Step 3: Add/Import Contacts
        'Adicionar or Importartar seu Contatos' => 'Adicionar ou Importar seus Contatos',
        'Adicionar or Importar seu Contatos' => 'Adicionar ou Importar seus Contatos',
        'Add or Import your Contacts' => 'Adicionar ou Importar seus Contatos',
        'Adicionar Contatos manutodosoy or bulk' => 'Adicionar Contatos manualmente ou em massa',
        'Adicionar Contatos manually or bulk' => 'Adicionar Contatos manualmente ou em massa',
        'manually or bulk' => 'manualmente ou em massa',
        'manutodosoy or bulk' => 'manualmente ou em massa',
        'Importartar de seu CRM tools, spreadsheets, or integrations' => 'Importar de suas ferramentas CRM, planilhas ou integrações',
        'Importar de seu CRM tools' => 'Importar de suas ferramentas CRM',
        'spreadsheets, or integrations' => 'planilhas ou integrações',
        'or integrations' => 'ou integrações',
        
        // Step 4: Send Messages/Create Campaigns
        'Enviar Mensagem ou Criar Campanha' => 'Enviar Mensagem ou Criar Campanha',
        'Send Message or Create Campaign' => 'Enviar Mensagem ou Criar Campanha',
        'Lance mensagems personalizadas ou campanhas inteligentes com-time insights' => 'Lance mensagens personalizadas ou campanhas inteligentes com insights em tempo real',
        'Lance mensagens personalizadas ou campanhas inteligentes com-time insights' => 'Lance mensagens personalizadas ou campanhas inteligentes com insights em tempo real',
        'com-time insights' => 'com insights em tempo real',
        'real-time insights' => 'insights em tempo real',
        'with real-time insights' => 'com insights em tempo real',
        
        // "Aqui Está o Que Você Recebe" section
        'Aqui Está o Que Você Recebe' => 'Aqui Está o Que Você Recebe',
        'Here\'s What You Get' => 'Aqui Está o Que Você Recebe',
        'Tudo que você precisa para crescer, automate, e connect com seu audience' => 'Tudo que você precisa para crescer, automatizar e conectar com seu público',
        'automate, e connect com seu audience' => 'automatizar e conectar com seu público',
        'automate and connect with your audience' => 'automatizar e conectar com seu público',
        'connect com seu audience' => 'conectar com seu público',
        'with your audience' => 'com seu público',
        
        // Common mixed phrases
        'powerful tools' => 'ferramentas poderosas',
        'full-featured' => 'completo',
        'real-time' => 'tempo real',
        'bulk import' => 'importação em massa',
        'CRM tools' => 'ferramentas CRM',
        'your audience' => 'seu público',
    ];
    
    if (isset($_GET['fix']) && $_GET['fix'] == 'yes') {
        echo "=== FIXING REMAINING ENGLISH CONTENT ===\n\n";
        
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Sort by length (longest first) to avoid partial replacements
        uksort($translations, function($a, $b) {
            return strlen($b) - strlen($a);
        });
        
        $count = 0;
        $details = [];
        
        foreach ($frontends as $frontend) {
            $originalJson = $frontend['data_values'];
            $updatedJson = $originalJson;
            
            // Apply translations
            foreach ($translations as $english => $portuguese) {
                if (stripos($updatedJson, $english) !== false) {
                    $updatedJson = str_ireplace($english, $portuguese, $updatedJson);
                }
            }
            
            if ($originalJson !== $updatedJson) {
                $stmt = $conn->prepare("UPDATE frontends SET data_values = ? WHERE id = ?");
                $stmt->execute([$updatedJson, $frontend['id']]);
                $count++;
                $details[] = "Updated: {$frontend['data_keys']} (ID: {$frontend['id']})";
            }
        }
        
        echo "✓ Fixed $count frontend records\n\n";
        
        if ($count > 0) {
            echo "Details:\n";
            foreach ($details as $detail) {
                echo "  - $detail\n";
            }
            echo "\n";
        } else {
            echo "ℹ️ No changes needed - content already correct!\n\n";
        }
        
        // Clear caches
        echo "=== CLEARING CACHES ===\n\n";
        
        $cacheFiles = [
            __DIR__ . '/core/bootstrap/cache/config.php',
            __DIR__ . '/core/bootstrap/cache/routes-v7.php',
        ];
        
        foreach ($cacheFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
                echo "✓ Cleared " . basename($file) . "\n";
            }
        }
        
        $viewPath = __DIR__ . '/core/storage/framework/views';
        if (is_dir($viewPath)) {
            $files = glob($viewPath . '/*');
            $cleared = 0;
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $cleared++;
                }
            }
            echo "✓ Cleared $cleared view cache files\n";
        }
        
        $cachePath = __DIR__ . '/core/storage/framework/cache/data';
        if (is_dir($cachePath)) {
            $files = glob($cachePath . '/*');
            $cleared = 0;
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $cleared++;
                }
            }
            echo "✓ Cleared $cleared cache data files\n";
        }
        
        echo "\n✅ REMAINING ENGLISH FIXED!\n\n";
        echo "Visit: https://flow.clubemkt.digital\n";
        echo "(Hard refresh: Ctrl+Shift+R or Cmd+Shift+R)\n\n";
        echo "⚠️ DELETE THIS FILE NOW!\n";
        
    } else {
        echo "=== FIX REMAINING ENGLISH CONTENT ===\n\n";
        echo "This will fix the remaining English/mixed content:\n\n";
        echo "  - 'Join to Platparam' → 'Junte-se à Plataforma'\n";
        echo "  - 'Explore nosso Feature' → 'Explore Nossos Recursos'\n";
        echo "  - 'few steps' → 'alguns passos'\n";
        echo "  - 'Campanha builders' → 'construtores de Campanha'\n";
        echo "  - 'conversion boosters' → 'impulsionadores de conversão'\n";
        echo "  - 'manually or bulk' → 'manualmente ou em massa'\n";
        echo "  - 'spreadsheets, or integrations' → 'planilhas ou integrações'\n";
        echo "  - 'com-time insights' → 'com insights em tempo real'\n";
        echo "  - And more...\n\n";
        echo "Total translations: " . count($translations) . " phrases\n\n";
        echo "<a href='?fix=yes' style='display: inline-block; background: green; color: white; padding: 20px 40px; text-decoration: none; font-weight: bold; font-size: 18px; margin: 20px; border-radius: 5px;'>FIX NOW</a>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
