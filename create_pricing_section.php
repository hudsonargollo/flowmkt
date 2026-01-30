<?php
// Create Pricing Section and Plans
// Upload to: /home/clubemkt/flow.clubemkt.digital/create_pricing_section.php
// Visit: https://flow.clubemkt.digital/create_pricing_section.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<h1>Create Pricing Section</h1>";
echo "<pre>";

try {
    $host = '127.0.0.1';
    $db = 'clubemkt_zapflow';
    $user = 'clubemkt_zapflow';
    $pass = 'tF4s8*7KnB*2';
    
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connected\n\n";
    
    if (isset($_GET['create']) && $_GET['create'] == 'yes') {
        echo "=== CREATING PRICING SECTION ===\n\n";
        
        // Step 1: Check if pricing plans already exist
        $stmt = $conn->query("SELECT COUNT(*) FROM frontends WHERE data_keys = 'pricing.element'");
        $existingPlans = $stmt->fetchColumn();
        
        if ($existingPlans > 0) {
            echo "⚠️ Found $existingPlans existing pricing plan(s)\n";
            echo "Skipping plan creation to avoid duplicates\n\n";
        } else {
            echo "--- Creating Pricing Plans ---\n\n";
            
            // Create 3 pricing plans
            $plans = [
                [
                    'name' => 'Básico',
                    'price' => '49.90',
                    'duration' => 'Mensal',
                    'features' => [
                        'Até 1.000 contatos',
                        '5.000 mensagens/mês',
                        'Suporte por email',
                        'Campanhas básicas',
                        'Relatórios simples'
                    ],
                    'button_text' => 'Começar Agora',
                    'button_url' => '/register',
                    'popular' => false
                ],
                [
                    'name' => 'Profissional',
                    'price' => '99.90',
                    'duration' => 'Mensal',
                    'features' => [
                        'Até 10.000 contatos',
                        '50.000 mensagens/mês',
                        'Suporte prioritário',
                        'Campanhas avançadas',
                        'Automação de fluxos',
                        'Relatórios detalhados',
                        'API de integração'
                    ],
                    'button_text' => 'Começar Agora',
                    'button_url' => '/register',
                    'popular' => true
                ],
                [
                    'name' => 'Empresarial',
                    'price' => '199.90',
                    'duration' => 'Mensal',
                    'features' => [
                        'Contatos ilimitados',
                        'Mensagens ilimitadas',
                        'Suporte 24/7',
                        'Campanhas ilimitadas',
                        'Automação avançada',
                        'Relatórios personalizados',
                        'API completa',
                        'Gerente de conta dedicado',
                        'Treinamento personalizado'
                    ],
                    'button_text' => 'Falar com Vendas',
                    'button_url' => '/contact',
                    'popular' => false
                ]
            ];
            
            foreach ($plans as $index => $plan) {
                $planData = [
                    'name' => $plan['name'],
                    'price' => $plan['price'],
                    'duration' => $plan['duration'],
                    'features' => $plan['features'],
                    'button_text' => $plan['button_text'],
                    'button_url' => $plan['button_url'],
                    'popular' => $plan['popular'] ? '1' : '0'
                ];
                
                $stmt = $conn->prepare("INSERT INTO frontends (data_keys, data_values, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
                $stmt->execute([
                    'pricing.element',
                    json_encode($planData, JSON_UNESCAPED_UNICODE)
                ]);
                
                echo "✓ Created plan: {$plan['name']} - R$ {$plan['price']}/{$plan['duration']}\n";
            }
            
            echo "\n✓ Created 3 pricing plans\n\n";
        }
        
        // Step 2: Add pricing section to home page template
        echo "--- Adding Pricing to Home Page ---\n\n";
        
        $homePath = __DIR__ . '/core/resources/views/templates/basic/home.blade.php';
        
        if (!file_exists($homePath)) {
            echo "❌ Home template not found at: $homePath\n";
        } else {
            $homeContent = file_get_contents($homePath);
            
            // Check if pricing is already included
            if (strpos($homeContent, 'pricing') !== false) {
                echo "✓ Pricing section already included in home template\n";
            } else {
                echo "Adding pricing section to home template...\n";
                
                // Find where to insert pricing (before testimonials or CTA)
                $pricingInclude = "\n@if(\$sections->where('data_keys','pricing.content')->first())\n    @include(\$activeTemplate.'sections.pricing')\n@endif\n";
                
                // Try to insert before testimonials
                if (strpos($homeContent, 'testimonial.content') !== false) {
                    $homeContent = str_replace(
                        "@if(\$sections->where('data_keys','testimonial.content')->first())",
                        $pricingInclude . "@if(\$sections->where('data_keys','testimonial.content')->first())",
                        $homeContent
                    );
                    echo "✓ Inserted pricing section before testimonials\n";
                }
                // Or try to insert before CTA
                elseif (strpos($homeContent, 'cta.content') !== false) {
                    $homeContent = str_replace(
                        "@if(\$sections->where('data_keys','cta.content')->first())",
                        $pricingInclude . "@if(\$sections->where('data_keys','cta.content')->first())",
                        $homeContent
                    );
                    echo "✓ Inserted pricing section before CTA\n";
                }
                // Or insert before FAQ
                elseif (strpos($homeContent, 'faq.content') !== false) {
                    $homeContent = str_replace(
                        "@if(\$sections->where('data_keys','faq.content')->first())",
                        $pricingInclude . "@if(\$sections->where('data_keys','faq.content')->first())",
                        $homeContent
                    );
                    echo "✓ Inserted pricing section before FAQ\n";
                } else {
                    echo "⚠️ Could not find suitable insertion point\n";
                    echo "You may need to manually add the pricing section to the home template\n";
                }
                
                // Backup original file
                $backupPath = $homePath . '.backup.' . date('YmdHis');
                copy($homePath, $backupPath);
                echo "✓ Created backup at: " . basename($backupPath) . "\n";
                
                // Write updated content
                file_put_contents($homePath, $homeContent);
                echo "✓ Updated home.blade.php\n";
            }
        }
        
        // Step 3: Clear caches
        echo "\n--- Clearing Caches ---\n\n";
        
        $cleared = 0;
        
        $cacheFiles = [
            __DIR__ . '/core/bootstrap/cache/config.php',
            __DIR__ . '/core/bootstrap/cache/routes-v7.php',
        ];
        
        foreach ($cacheFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
                $cleared++;
            }
        }
        
        $viewCache = __DIR__ . '/core/storage/framework/views';
        if (is_dir($viewCache)) {
            $files = glob($viewCache . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $cleared++;
                }
            }
        }
        
        echo "✓ Cleared $cleared cache files\n\n";
        
        echo "✅ PRICING SECTION CREATED!\n\n";
        echo "Created:\n";
        echo "  - 3 pricing plans (Básico, Profissional, Empresarial)\n";
        echo "  - Added pricing section to home page\n";
        echo "  - Cleared all caches\n\n";
        echo "Visit: https://flow.clubemkt.digital\n";
        echo "(Hard refresh: Ctrl+Shift+R or Cmd+Shift+R)\n\n";
        echo "You can edit the pricing plans in:\n";
        echo "Admin Panel → Frontend Management → Manage Section → Pricing\n\n";
        echo "⚠️ DELETE THIS FILE NOW!\n";
        
    } else {
        echo "=== CREATE PRICING SECTION ===\n\n";
        echo "This will:\n\n";
        echo "1. Create 3 pricing plans:\n";
        echo "   - Básico: R$ 49,90/mês\n";
        echo "     • Até 1.000 contatos\n";
        echo "     • 5.000 mensagens/mês\n";
        echo "     • Suporte por email\n\n";
        echo "   - Profissional: R$ 99,90/mês (POPULAR)\n";
        echo "     • Até 10.000 contatos\n";
        echo "     • 50.000 mensagens/mês\n";
        echo "     • Suporte prioritário\n";
        echo "     • Automação de fluxos\n\n";
        echo "   - Empresarial: R$ 199,90/mês\n";
        echo "     • Contatos ilimitados\n";
        echo "     • Mensagens ilimitadas\n";
        echo "     • Suporte 24/7\n";
        echo "     • Gerente de conta dedicado\n\n";
        echo "2. Add pricing section to home page template\n";
        echo "3. Clear all caches\n\n";
        echo "Note: You can edit these plans later in the admin panel.\n\n";
        echo "<a href='?create=yes' style='display: inline-block; background: green; color: white; padding: 20px 40px; text-decoration: none; font-weight: bold; font-size: 18px; margin: 20px; border-radius: 5px;'>CREATE PRICING SECTION</a>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
?>
