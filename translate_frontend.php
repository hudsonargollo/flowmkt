<?php
// Translate Frontend Content to Portuguese
// Upload to: /home/clubemkt/flow.clubemkt.digital/translate_frontend.php
// Visit: https://flow.clubemkt.digital/translate_frontend.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<h1>Translate Frontend to Portuguese</h1>";
echo "<pre>";

try {
    $host = '127.0.0.1';
    $db = 'clubemkt_zapflow';
    $user = 'clubemkt_zapflow';
    $pass = 'tF4s8*7KnB*2';
    
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connected\n\n";
    
    // Translation map for common phrases
    $translations = [
        // Main headings - EXACT matches from screenshot
        'Grow Your Business with WhatsApp CRM and Marketing Tools' => 'Expanda Seu Negócio com CRM WhatsApp e Ferramentas de Marketing',
        'How It Works?' => 'Como Funciona?',
        'How it Works?' => 'Como Funciona?',
        'Como Funciona?' => 'Como Funciona?',
        "Here's What You Get" => 'Aqui Está o Que Você Recebe',
        'Simple and Transparent Pricing' => 'Preços Simples e Transparentes',
        'Trusted Thousands of Businesses' => 'Confiado por Milhares de Empresas',
        'Trusted by Thousands of Businesses' => 'Confiado por Milhares de Empresas',
        'Take Your Business Anywhere' => 'Leve Seu Negócio Para Qualquer Lugar',
        'Answers to Common Questions' => 'Respostas Para Perguntas Comuns',
        'Get Started with FlowMkt' => 'Comece com FlowMkt',
        'Our Latest Blog' => 'Nosso Blog Mais Recente',
        
        // Sections visible in screenshot
        'About FlowMkt and What We Offer' => 'Sobre o FlowMkt e O Que Oferecemos',
        'Connect with Millions of Customers' => 'Conecte-se com Milhões de Clientes',
        'Take Your Business to the Next Level' => 'Leve Seu Negócio Para o Próximo Nível',
        'Grow Your Business' => 'Expanda Seu Negócio',
        'Connect with FlowMkt Today' => 'Conecte-se com FlowMkt Hoje',
        'Get Started Today' => 'Comece Hoje',
        
        // Common words and phrases
        'Create campaigns, automate chats, manage contacts—all from one powerful dashboard.' => 'Crie campanhas, automatize conversas, gerencie contatos—tudo em um painel poderoso.',
        'Manage all your WhatsApp conversations in one place' => 'Gerencie todas as suas conversas do WhatsApp em um só lugar',
        'Send bulk messages to thousands of contacts instantly' => 'Envie mensagens em massa para milhares de contatos instantaneamente',
        'Track your campaign performance with detailed analytics' => 'Acompanhe o desempenho de suas campanhas com análises detalhadas',
        'Automate responses and save time' => 'Automatize respostas e economize tempo',
        'Build custom chatbots without coding' => 'Crie chatbots personalizados sem programação',
        'Organize contacts with tags and segments' => 'Organize contatos com tags e segmentos',
        'Schedule messages for optimal delivery times' => 'Agende mensagens para horários ideais de entrega',
        'Get real-time notifications and alerts' => 'Receba notificações e alertas em tempo real',
        
        // Button text
        'Get Started for Free' => 'Comece Gratuitamente',
        'Get Started Free' => 'Comece Gratuitamente',
        'Start Free Trial' => 'Iniciar Teste Grátis',
        'Try It Free' => 'Experimente Grátis',
        'Login' => 'Entrar',
        'Create Free Account' => 'Criar Conta Grátis',
        'Create Account' => 'Criar Conta',
        'Sign Up Free' => 'Cadastre-se Grátis',
        'Home' => 'Início',
        'Features' => 'Recursos',
        'Pricing' => 'Preços',
        'Blog' => 'Blog',
        'Contact' => 'Contato',
        'Dashboard' => 'Painel',
        'Sign In' => 'Entrar',
        'Sign Up' => 'Cadastrar',
        'Learn More' => 'Saiba Mais',
        'Read More' => 'Leia Mais',
        'View All' => 'Ver Tudo',
        'Subscribe' => 'Inscrever-se',
        'Submit' => 'Enviar',
        
        // Additional common phrases
        'Welcome' => 'Bem-vindo',
        'About' => 'Sobre',
        'About Us' => 'Sobre Nós',
        'Services' => 'Serviços',
        'Contact Us' => 'Fale Conosco',
        'Get in Touch' => 'Entre em Contato',
        'Send Message' => 'Enviar Mensagem',
        'Our Team' => 'Nossa Equipe',
        'Testimonials' => 'Depoimentos',
        'FAQ' => 'Perguntas Frequentes',
        'Privacy Policy' => 'Política de Privacidade',
        'Terms of Service' => 'Termos de Serviço',
        'Cookie Policy' => 'Política de Cookies',
        
        // Business/Marketing terms
        'WhatsApp Marketing' => 'Marketing no WhatsApp',
        'CRM System' => 'Sistema CRM',
        'Automation' => 'Automação',
        'Campaign' => 'Campanha',
        'Campaigns' => 'Campanhas',
        'Contact Management' => 'Gestão de Contatos',
        'Analytics' => 'Análises',
        'Reports' => 'Relatórios',
        'Templates' => 'Modelos',
        'Broadcast' => 'Transmissão',
        'Chat' => 'Conversa',
        'Chats' => 'Conversas',
        'Message' => 'Mensagem',
        'Messages' => 'Mensagens',
        'Customer' => 'Cliente',
        'Customers' => 'Clientes',
        'Business' => 'Negócio',
        'Marketing' => 'Marketing',
        'Sales' => 'Vendas',
        'Support' => 'Suporte',
        
        // Action words
        'Start Now' => 'Comece Agora',
        'Try Free' => 'Experimente Grátis',
        'Free Trial' => 'Teste Grátis',
        'Sign Up Now' => 'Cadastre-se Agora',
        'Get Started' => 'Começar',
        'Download' => 'Baixar',
        'Upload' => 'Enviar',
        'Save' => 'Salvar',
        'Cancel' => 'Cancelar',
        'Delete' => 'Excluir',
        'Edit' => 'Editar',
        'Update' => 'Atualizar',
        'Create' => 'Criar',
        'Add' => 'Adicionar',
        'Remove' => 'Remover',
        'Search' => 'Buscar',
        'Filter' => 'Filtrar',
        'Export' => 'Exportar',
        'Import' => 'Importar',
        
        // Time/Date
        'Today' => 'Hoje',
        'Yesterday' => 'Ontem',
        'Tomorrow' => 'Amanhã',
        'This Week' => 'Esta Semana',
        'This Month' => 'Este Mês',
        'Last Month' => 'Mês Passado',
        'This Year' => 'Este Ano',
        
        // Status
        'Active' => 'Ativo',
        'Inactive' => 'Inativo',
        'Pending' => 'Pendente',
        'Completed' => 'Concluído',
        'Failed' => 'Falhou',
        'Success' => 'Sucesso',
        'Error' => 'Erro',
        'Warning' => 'Aviso',
        
        // OvoWpp specific
        'OvoWpp' => 'FlowMkt',
        'ovowpp' => 'flowmkt',
        'OVOWPP' => 'FLOWMKT',
        'Ovo Wpp' => 'FlowMkt',
        'OvoZap' => 'FlowMkt',
        'ovozap' => 'flowmkt',
    ];
    
    if (isset($_GET['inspect']) && $_GET['inspect'] == 'yes') {
        echo "=== INSPECTING FRONTEND CONTENT ===\n\n";
        
        // Get all frontend records
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends LIMIT 5");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($frontends as $frontend) {
            echo "ID: {$frontend['id']}\n";
            echo "Key: {$frontend['data_keys']}\n";
            echo "Values: " . substr($frontend['data_values'], 0, 200) . "...\n\n";
        }
        
        echo "<a href='?' style='display: inline-block; background: blue; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;'>BACK</a>\n";
        
    } else if (isset($_GET['translate']) && $_GET['translate'] == 'yes') {
        echo "=== TRANSLATING FRONTEND CONTENT ===\n\n";
        
        // Get all frontend records
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $count = 0;
        $details = [];
        
        foreach ($frontends as $frontend) {
            $dataValues = json_decode($frontend['data_values'], true);
            $originalJson = json_encode($dataValues, JSON_UNESCAPED_UNICODE);
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
        
        echo "✓ Translated $count frontend records\n\n";
        
        if ($count > 0) {
            echo "Details:\n";
            foreach ($details as $detail) {
                echo "  - $detail\n";
            }
            echo "\n";
        }
        
        // Show remaining English content
        echo "=== CHECKING FOR REMAINING ENGLISH CONTENT ===\n\n";
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $englishPatterns = [
            '/\b(the|and|with|for|your|our|get|all|from|what|how|why|when|where|who)\b/i',
            '/\b(business|marketing|customer|message|campaign|contact|chat|feature|pricing|blog)\b/i',
            '/\b(started|create|manage|send|track|automate|build|organize|schedule)\b/i'
        ];
        
        $remainingEnglish = [];
        foreach ($frontends as $frontend) {
            $content = $frontend['data_values'];
            foreach ($englishPatterns as $pattern) {
                if (preg_match($pattern, $content)) {
                    // Extract a sample of English text
                    preg_match_all('/[A-Z][a-z]+(?: [A-Z]?[a-z]+){2,10}/', $content, $matches);
                    if (!empty($matches[0])) {
                        $samples = array_slice(array_unique($matches[0]), 0, 3);
                        $remainingEnglish[$frontend['data_keys']] = $samples;
                    }
                    break;
                }
            }
        }
        
        if (!empty($remainingEnglish)) {
            echo "⚠️ Found English content in " . count($remainingEnglish) . " sections:\n\n";
            foreach ($remainingEnglish as $key => $samples) {
                echo "Section: $key\n";
                foreach ($samples as $sample) {
                    echo "  - \"$sample\"\n";
                }
                echo "\n";
            }
            echo "You may need to add these phrases to the translation map.\n\n";
        } else {
            echo "✓ No obvious English patterns detected\n\n";
        }
        
        // Clear ALL caches aggressively
        echo "=== CLEARING CACHES ===\n\n";
        
        $cacheFile = __DIR__ . '/core/bootstrap/cache/config.php';
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
            echo "✓ Cleared config cache\n";
        }
        
        $routeCache = __DIR__ . '/core/bootstrap/cache/routes-v7.php';
        if (file_exists($routeCache)) {
            unlink($routeCache);
            echo "✓ Cleared route cache\n";
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
        
        echo "\n✅ TRANSLATION COMPLETE!\n\n";
        echo "Visit: https://flow.clubemkt.digital\n";
        echo "(Hard refresh: Ctrl+Shift+R or Cmd+Shift+R)\n\n";
        echo "⚠️ DELETE THIS FILE NOW!\n";
        
    } else {
        echo "=== Preview Translations ===\n\n";
        echo "This will translate " . count($translations) . " phrases including:\n\n";
        foreach (array_slice($translations, 0, 15) as $en => $pt) {
            echo "\"$en\"\n  → \"$pt\"\n\n";
        }
        echo "...and " . (count($translations) - 15) . " more translations\n\n";
        echo "<a href='?inspect=yes' style='display: inline-block; background: blue; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;'>INSPECT DATABASE</a>\n";
        echo "<a href='?translate=yes' style='display: inline-block; background: green; color: white; padding: 15px 30px; text-decoration: none; font-weight: bold; margin: 10px; border-radius: 5px;'>TRANSLATE NOW</a>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
