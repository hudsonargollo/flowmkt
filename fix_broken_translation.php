<?php
// Fix Broken Translation
// Upload to: /home/clubemkt/flow.clubemkt.digital/fix_broken_translation.php
// Visit: https://flow.clubemkt.digital/fix_broken_translation.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<h1>Fix Broken Translation</h1>";
echo "<pre>";

try {
    $host = '127.0.0.1';
    $db = 'clubemkt_zapflow';
    $user = 'clubemkt_zapflow';
    $pass = 'tF4s8*7KnB*2';
    
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connected\n\n";
    
    // Fix broken translations - these are COMPLETE PHRASES ONLY
    $fixes = [
        // Fix the broken hero text
        'Expea Seu Negócioócio com CRM o quesApp e Ferramentas de Marketing' => 'Expanda Seu Negócio com CRM WhatsApp e Ferramentas de Marketing',
        'Expea Seu Negócioócio' => 'Expanda Seu Negócio',
        'o quesApp' => 'WhatsApp',
        'quesApp' => 'WhatsApp',
        
        // Fix other potential broken words
        'Criar Campanhas, automate Conversas, manage Contatos' => 'Criar Campanhas, automatizar Conversas, gerenciar Contatos',
        'Criar Campanhas, automate Conversas' => 'Criar Campanhas, automatizar Conversas',
        'manage Contatos' => 'gerenciar Contatos',
        'todos de one powerful Painel' => 'todos em um Painel poderoso',
        'de one' => 'em um',
        'powerful Painel' => 'Painel poderoso',
        
        // Fix common broken patterns
        'Comece Gratuitamente' => 'Comece Gratuitamente',
        'Começar' => 'Começar',
        'Entrar' => 'Entrar',
        'Cadastrar' => 'Cadastrar',
    ];
    
    // Proper complete translations (PHRASES ONLY, NO SINGLE WORDS)
    $properTranslations = [
        // Hero section
        'Grow Your Business with WhatsApp CRM and Marketing Tools' => 'Expanda Seu Negócio com CRM WhatsApp e Ferramentas de Marketing',
        'Create campaigns, automate chats, manage contacts—all from one powerful dashboard' => 'Crie campanhas, automatize conversas, gerencie contatos—tudo em um painel poderoso',
        'Create campaigns, automate chats, manage contacts' => 'Crie campanhas, automatize conversas, gerencie contatos',
        
        // Buttons
        'Get Started for Free' => 'Comece Gratuitamente',
        'Get Started Free' => 'Comece Gratuitamente',
        'Start Free Trial' => 'Iniciar Teste Grátis',
        'Create Free Account' => 'Criar Conta Grátis',
        'Sign Up Free' => 'Cadastre-se Grátis',
        
        // Sections
        'How It Works' => 'Como Funciona',
        'Our Latest Blog' => 'Nosso Blog Mais Recente',
        'Explore our collection of articles' => 'Explore nossa coleção de artigos',
        'Everything you need to grow' => 'Tudo que você precisa para crescer',
        'Discover the Powerful Features' => 'Descubra os Recursos Poderosos',
        'Agent Management System' => 'Sistema de Gestão de Agentes',
        'Invite and manage team members with role-based access' => 'Convide e gerencie membros da equipe com acesso baseado em funções',
        
        // Cookie & Policy
        'We may utilize cookies when you access our website' => 'Podemos utilizar cookies quando você acessa nosso site',
        'What Are Cookies' => 'O Que São Cookies',
        'Terms of Service' => 'Termos de Serviço',
        'Privacy Policy' => 'Política de Privacidade',
        'Cookie Policy' => 'Política de Cookies',
        
        // Testimonials
        'Trusted by Thousands of Businesses' => 'Confiado por Milhares de Empresas',
        'FlowMkt has helped us scale our communication without losing the personal touch' => 'FlowMkt nos ajudou a escalar nossa comunicação sem perder o toque pessoal',
        'The Support team is responsive and the onboarding was smooth' => 'A equipe de suporte é responsiva e a integração foi tranquila',
        
        // Mobile App
        'Take Your Business Anywhere' => 'Leve Seu Negócio Para Qualquer Lugar',
        'Awesome Benefits of the App' => 'Benefícios Incríveis do Aplicativo',
        'Secure and fast performance' => 'Desempenho seguro e rápido',
        
        // CTA
        'Get Started with FlowMkt' => 'Comece com FlowMkt',
        'Start My Free Trial' => 'Iniciar Meu Teste Grátis',
        
        // Contact
        'Send us an email' => 'Envie-nos um e-mail',
        'Whether you have a question' => 'Se você tem uma pergunta',
        
        // Pricing
        'Simple and Transparent Pricing' => 'Preços Simples e Transparentes',
        
        // FAQ
        'Answers to Common Questions' => 'Respostas Para Perguntas Comuns',
        'Are invoices and billing history available' => 'As faturas e histórico de cobrança estão disponíveis',
    ];
    
    if (isset($_GET['fix']) && $_GET['fix'] == 'yes') {
        echo "=== FIXING BROKEN TRANSLATIONS ===\n\n";
        
        // First, fix the broken content
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $fixCount = 0;
        foreach ($frontends as $frontend) {
            $originalJson = $frontend['data_values'];
            $updatedJson = $originalJson;
            
            // Apply fixes
            foreach ($fixes as $broken => $fixed) {
                if (stripos($updatedJson, $broken) !== false) {
                    $updatedJson = str_ireplace($broken, $fixed, $updatedJson);
                }
            }
            
            if ($originalJson !== $updatedJson) {
                $stmt = $conn->prepare("UPDATE frontends SET data_values = ? WHERE id = ?");
                $stmt->execute([$updatedJson, $frontend['id']]);
                $fixCount++;
                echo "Fixed: {$frontend['data_keys']} (ID: {$frontend['id']})\n";
            }
        }
        
        echo "\n✓ Fixed $fixCount broken records\n\n";
        
        // Now apply proper translations (PHRASES ONLY)
        echo "=== APPLYING PROPER TRANSLATIONS ===\n\n";
        
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $translateCount = 0;
        foreach ($frontends as $frontend) {
            $originalJson = $frontend['data_values'];
            $updatedJson = $originalJson;
            
            // Apply proper translations (longest first to avoid partial matches)
            $sortedTranslations = $properTranslations;
            uksort($sortedTranslations, function($a, $b) {
                return strlen($b) - strlen($a);
            });
            
            foreach ($sortedTranslations as $english => $portuguese) {
                if (stripos($updatedJson, $english) !== false) {
                    $updatedJson = str_ireplace($english, $portuguese, $updatedJson);
                }
            }
            
            if ($originalJson !== $updatedJson) {
                $stmt = $conn->prepare("UPDATE frontends SET data_values = ? WHERE id = ?");
                $stmt->execute([$updatedJson, $frontend['id']]);
                $translateCount++;
                echo "Translated: {$frontend['data_keys']} (ID: {$frontend['id']})\n";
            }
        }
        
        echo "\n✓ Translated $translateCount records\n\n";
        
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
        
        echo "\n✅ TRANSLATION FIXED!\n\n";
        echo "Visit: https://flow.clubemkt.digital\n";
        echo "(Hard refresh: Ctrl+Shift+R or Cmd+Shift+R)\n\n";
        echo "⚠️ DELETE THIS FILE NOW!\n";
        
    } else {
        echo "=== FIX BROKEN TRANSLATION ===\n\n";
        echo "This will:\n";
        echo "1. Fix broken/doubled words (like 'Expea Seu Negócioócio')\n";
        echo "2. Apply proper phrase-based translations\n";
        echo "3. Clear all caches\n\n";
        echo "<a href='?fix=yes' style='display: inline-block; background: red; color: white; padding: 20px 40px; text-decoration: none; font-weight: bold; font-size: 18px; margin: 20px; border-radius: 5px;'>FIX NOW</a>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
