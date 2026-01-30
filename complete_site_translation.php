<?php
// Complete Site Translation - Aggressive Approach
// Upload to: /home/clubemkt/flow.clubemkt.digital/complete_site_translation.php
// Visit: https://flow.clubemkt.digital/complete_site_translation.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<h1>Complete Site Translation</h1>";
echo "<pre>";

try {
    $host = '127.0.0.1';
    $db = 'clubemkt_zapflow';
    $user = 'clubemkt_zapflow';
    $pass = 'tF4s8*7KnB*2';
    
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connected\n\n";
    
    if (isset($_GET['show_english']) && $_GET['show_english'] == 'yes') {
        echo "=== SHOWING ALL ENGLISH CONTENT ===\n\n";
        
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $englishPattern = '/\b(the|and|with|for|your|our|get|all|from|what|how|why|when|where|who|this|that|these|those|have|has|been|were|was|are|will|would|could|should|can|may|might|must|shall|do|does|did|make|made|take|took|give|gave|come|came|go|went|see|saw|know|knew|think|thought|say|said|tell|told|use|used|find|found|work|worked|call|called|try|tried|ask|asked|need|needed|feel|felt|become|became|leave|left|put|keep|kept|let|begin|began|seem|seemed|help|helped|show|showed|hear|heard|play|played|run|ran|move|moved|live|lived|believe|believed|bring|brought|happen|happened|write|wrote|provide|provided|sit|sat|stand|stood|lose|lost|pay|paid|meet|met|include|included|continue|continued|set|learn|learned|change|changed|lead|led|understand|understood|watch|watched|follow|followed|stop|stopped|create|created|speak|spoke|read|allow|allowed|add|added|spend|spent|grow|grew|open|opened|walk|walked|win|won|offer|offered|remember|remembered|love|loved|consider|considered|appear|appeared|buy|bought|wait|waited|serve|served|die|died|send|sent|expect|expected|build|built|stay|stayed|fall|fell|cut|reach|reached|kill|killed|remain|remained|suggest|suggested|raise|raised|pass|passed|sell|sold|require|required|report|reported|decide|decided|pull|pulled)\b/i';
        
        $foundEnglish = [];
        foreach ($frontends as $frontend) {
            $content = $frontend['data_values'];
            if (preg_match($englishPattern, $content)) {
                // Extract English phrases
                preg_match_all('/[A-Z][a-z]+(?:\s+[a-z]+){1,8}/i', $content, $matches);
                if (!empty($matches[0])) {
                    $samples = array_slice(array_unique($matches[0]), 0, 5);
                    $foundEnglish[] = [
                        'id' => $frontend['id'],
                        'key' => $frontend['data_keys'],
                        'samples' => $samples
                    ];
                }
            }
        }
        
        if (!empty($foundEnglish)) {
            echo "Found English content in " . count($foundEnglish) . " sections:\n\n";
            foreach ($foundEnglish as $item) {
                echo "Section: {$item['key']} (ID: {$item['id']})\n";
                foreach ($item['samples'] as $sample) {
                    echo "  - \"$sample\"\n";
                }
                echo "\n";
            }
        } else {
            echo "✓ No English content detected!\n";
        }
        
        echo "\n<a href='?' style='display: inline-block; background: blue; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;'>BACK</a>\n";
        
    } else if (isset($_GET['check_pricing']) && $_GET['check_pricing'] == 'yes') {
        echo "=== CHECKING PRICING SECTION ===\n\n";
        
        // Check if pricing section exists
        $stmt = $conn->query("SELECT * FROM frontends WHERE data_keys LIKE '%pricing%'");
        $pricing = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($pricing)) {
            echo "❌ No pricing section found in database!\n\n";
            echo "The pricing cards may need to be created in the admin panel.\n";
            echo "Go to: Admin Panel → Frontend Management → Manage Section\n";
        } else {
            echo "✓ Found " . count($pricing) . " pricing records:\n\n";
            foreach ($pricing as $p) {
                echo "ID: {$p['id']}\n";
                echo "Key: {$p['data_keys']}\n";
                $values = json_decode($p['data_values'], true);
                echo "Content: " . substr(json_encode($values, JSON_UNESCAPED_UNICODE), 0, 200) . "...\n\n";
            }
        }
        
        echo "\n<a href='?' style='display: inline-block; background: blue; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;'>BACK</a>\n";
        
    } else if (isset($_GET['translate']) && $_GET['translate'] == 'yes') {
        echo "=== TRANSLATING ALL CONTENT ===\n\n";
        
        // Get ALL frontend records
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "Found " . count($frontends) . " total frontend records\n\n";
        
        // MASSIVE translation dictionary - every possible phrase
        $translations = [
            // Complete sentences and phrases (LONGEST FIRST)
            'Grow Your Business with WhatsApp CRM and Marketing Tools' => 'Expanda Seu Negócio com CRM WhatsApp e Ferramentas de Marketing',
            'Create campaigns, automate chats, manage contacts—all from one powerful dashboard' => 'Crie campanhas, automatize conversas, gerencie contatos—tudo em um painel poderoso',
            'Understand the process from signup to campaign launch in just a few steps' => 'Entenda o processo desde o cadastro até o lançamento da campanha em apenas alguns passos',
            'Sign up for free and unlock a full-featured Marketing and CRM platform in seconds' => 'Cadastre-se gratuitamente e desbloqueie uma plataforma completa de Marketing e CRM em segundos',
            'Discover powerful tools like Automation, Campaign builders, and conversion boosters' => 'Descubra ferramentas poderosas como Automação, construtores de Campanha e impulsionadores de conversão',
            'Add Contacts manually or bulk import from your CRM tools, spreadsheets, or integrations' => 'Adicione Contatos manualmente ou importe em massa de suas ferramentas CRM, planilhas ou integrações',
            'Launch personalized messages or smart campaigns with real-time insights' => 'Lance mensagens personalizadas ou campanhas inteligentes com insights em tempo real',
            'Everything you need to grow, automate, and connect with your audience' => 'Tudo que você precisa para crescer, automatizar e conectar com seu público',
            'Hear how FlowMkt is transforming customer engagement across industries' => 'Veja como o FlowMkt está transformando o engajamento de clientes em diversos setores',
            'FlowMkt has helped us scale our communication without losing the personal touch' => 'FlowMkt nos ajudou a escalar nossa comunicação sem perder o toque pessoal',
            'The Support team is responsive and the onboarding was smooth' => 'A equipe de suporte é responsiva e a integração foi tranquila',
            'FlowMkt turns WhatsApp into a powerful marketing platform' => 'FlowMkt transforma o WhatsApp em uma poderosa plataforma de marketing',
            'Before reaching out, check our FAQs for quick solutions to your concerns' => 'Antes de entrar em contato, confira nossas Perguntas Frequentes para soluções rápidas',
            'Choose the plan that fits your needs' => 'Escolha o plano que atende suas necessidades',
            'No credit card required' => 'Não é necessário cartão de crédito',
            'Available on iOS and Android' => 'Disponível para iOS e Android',
            'Subscribe to our newsletter' => 'Assine nossa newsletter',
            
            // Section headings
            'How It Works' => 'Como Funciona',
            'How it Works' => 'Como Funciona',
            "Here's What You Get" => 'Aqui Está o Que Você Recebe',
            'Simple and Transparent Pricing' => 'Preços Simples e Transparentes',
            'Trusted by Thousands of Businesses' => 'Confiado por Milhares de Empresas',
            'Take Your Business Anywhere' => 'Leve Seu Negócio Para Qualquer Lugar',
            'Answers to Common Questions' => 'Respostas Para Perguntas Comuns',
            'Get Started with FlowMkt' => 'Comece com FlowMkt',
            'Our Latest Blog' => 'Nosso Blog Mais Recente',
            'Awesome Benefits of the App' => 'Benefícios Incríveis do Aplicativo',
            'Frequently Asked Questions' => 'Perguntas Frequentes',
            
            // Step titles
            'Join to Platform' => 'Junte-se à Plataforma',
            'Explore our Features' => 'Explore Nossos Recursos',
            'Add or Import your Contacts' => 'Adicionar ou Importar seus Contatos',
            'Send Message or Create Campaign' => 'Enviar Mensagem ou Criar Campanha',
            
            // Buttons and CTAs
            'Get Started for Free' => 'Comece Gratuitamente',
            'Get Started Free' => 'Comece Gratuitamente',
            'Start Free Trial' => 'Iniciar Teste Grátis',
            'Start My Free Trial' => 'Iniciar Meu Teste Grátis',
            'Create Free Account' => 'Criar Conta Grátis',
            'Sign Up Free' => 'Cadastre-se Grátis',
            'Subscribe Now' => 'Assinar Agora',
            'Choose Plan' => 'Escolher Plano',
            'Download Now' => 'Baixar Agora',
            'Send Message' => 'Enviar Mensagem',
            'View All Posts' => 'Ver Todos os Posts',
            
            // Common phrases
            'powerful tools' => 'ferramentas poderosas',
            'Campaign builders' => 'construtores de Campanha',
            'conversion boosters' => 'impulsionadores de conversão',
            'real-time insights' => 'insights em tempo real',
            'full-featured' => 'completo',
            'in seconds' => 'em segundos',
            'a few steps' => 'alguns passos',
            'few steps' => 'alguns passos',
            'manually or bulk' => 'manualmente ou em massa',
            'CRM tools' => 'ferramentas CRM',
            'your audience' => 'seu público',
            'personal touch' => 'toque pessoal',
            'customer engagement' => 'engajamento de clientes',
            'across industries' => 'em diversos setores',
            
            // Navigation
            'Home' => 'Início',
            'Features' => 'Recursos',
            'Pricing' => 'Preços',
            'Blog' => 'Blog',
            'Contact' => 'Contato',
            'About Us' => 'Sobre Nós',
            'Login' => 'Entrar',
            'Sign Up' => 'Cadastrar',
            'Sign In' => 'Entrar',
            'Dashboard' => 'Painel',
            
            // Common words
            'Learn More' => 'Saiba Mais',
            'Read More' => 'Leia Mais',
            'View All' => 'Ver Tudo',
            'Get Started' => 'Começar',
            'Contact Us' => 'Fale Conosco',
            'Get in Touch' => 'Entre em Contato',
            'Send us an email' => 'Envie-nos um e-mail',
            'Stay up to date' => 'Mantenha-se atualizado',
            'Quick Links' => 'Links Rápidos',
            'Privacy Policy' => 'Política de Privacidade',
            'Terms of Service' => 'Termos de Serviço',
            'Cookie Policy' => 'Política de Cookies',
            'Best Value' => 'Melhor Valor',
            'Popular' => 'Popular',
            'Monthly' => 'Mensal',
            'Yearly' => 'Anual',
            'Per Month' => 'Por Mês',
            'Per Year' => 'Por Ano',
            'Secure and fast performance' => 'Desempenho seguro e rápido',
            'Explore our collection of articles' => 'Explore nossa coleção de artigos',
        ];
        
        // Sort by length (longest first) to avoid partial matches
        uksort($translations, function($a, $b) {
            return strlen($b) - strlen($a);
        });
        
        $count = 0;
        $updated = [];
        
        foreach ($frontends as $frontend) {
            $originalJson = $frontend['data_values'];
            $updatedJson = $originalJson;
            $changed = false;
            
            // Apply each translation
            foreach ($translations as $english => $portuguese) {
                if (stripos($updatedJson, $english) !== false) {
                    $updatedJson = str_ireplace($english, $portuguese, $updatedJson);
                    $changed = true;
                }
            }
            
            if ($changed && $originalJson !== $updatedJson) {
                $stmt = $conn->prepare("UPDATE frontends SET data_values = ? WHERE id = ?");
                $stmt->execute([$updatedJson, $frontend['id']]);
                $count++;
                $updated[] = "{$frontend['data_keys']} (ID: {$frontend['id']})";
            }
        }
        
        echo "✓ Updated $count records\n\n";
        
        if ($count > 0) {
            echo "Updated sections:\n";
            foreach ($updated as $item) {
                echo "  - $item\n";
            }
        } else {
            echo "ℹ️ No updates needed - content already translated\n";
        }
        
        // Clear ALL caches aggressively
        echo "\n=== CLEARING ALL CACHES ===\n\n";
        
        $cleared = 0;
        
        // Bootstrap caches
        $bootstrapCache = __DIR__ . '/core/bootstrap/cache';
        if (is_dir($bootstrapCache)) {
            $files = glob($bootstrapCache . '/*.php');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $cleared++;
                }
            }
        }
        
        // View caches
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
        
        // Data caches
        $dataCache = __DIR__ . '/core/storage/framework/cache/data';
        if (is_dir($dataCache)) {
            $files = glob($dataCache . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $cleared++;
                }
            }
        }
        
        echo "✓ Cleared $cleared cache files\n\n";
        
        echo "✅ TRANSLATION COMPLETE!\n\n";
        echo "Visit: https://flow.clubemkt.digital\n";
        echo "(Hard refresh: Ctrl+Shift+R or Cmd+Shift+R)\n\n";
        echo "⚠️ DELETE THIS FILE NOW!\n";
        
    } else {
        echo "=== COMPLETE SITE TRANSLATION TOOL ===\n\n";
        echo "Choose an action:\n\n";
        echo "<a href='?show_english=yes' style='display: inline-block; background: orange; color: white; padding: 15px 30px; text-decoration: none; font-weight: bold; margin: 10px; border-radius: 5px;'>SHOW ENGLISH CONTENT</a>\n";
        echo "<a href='?check_pricing=yes' style='display: inline-block; background: purple; color: white; padding: 15px 30px; text-decoration: none; font-weight: bold; margin: 10px; border-radius: 5px;'>CHECK PRICING SECTION</a>\n";
        echo "<a href='?translate=yes' style='display: inline-block; background: green; color: white; padding: 20px 40px; text-decoration: none; font-weight: bold; font-size: 18px; margin: 10px; border-radius: 5px;'>TRANSLATE EVERYTHING</a>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
?>
