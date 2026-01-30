<?php
// Final Complete Translation - Translate Everything
// Upload to: /home/clubemkt/flow.clubemkt.digital/translate_everything_final.php
// Visit: https://flow.clubemkt.digital/translate_everything_final.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<h1>Final Complete Translation</h1>";
echo "<pre>";

try {
    $host = '127.0.0.1';
    $db = 'clubemkt_zapflow';
    $user = 'clubemkt_zapflow';
    $pass = 'tF4s8*7KnB*2';
    
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connected\n\n";
    
    if (isset($_GET['inspect']) && $_GET['inspect'] == 'yes') {
        echo "=== INSPECTING CONTENT ===\n\n";
        
        // Check pricing section
        echo "--- Pricing Section ---\n";
        $stmt = $conn->query("SELECT * FROM frontends WHERE data_keys LIKE '%pricing%'");
        $pricing = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Found " . count($pricing) . " pricing records\n\n";
        
        foreach ($pricing as $p) {
            echo "ID: {$p['id']}, Key: {$p['data_keys']}\n";
            $values = json_decode($p['data_values'], true);
            if (isset($values['heading'])) echo "  Heading: {$values['heading']}\n";
            if (isset($values['title'])) echo "  Title: {$values['title']}\n";
            echo "\n";
        }
        
        // Check all frontend sections
        echo "\n--- All Frontend Sections ---\n";
        $stmt = $conn->query("SELECT DISTINCT data_keys FROM frontends ORDER BY data_keys");
        $sections = $stmt->fetchAll(PDO::FETCH_COLUMN);
        foreach ($sections as $section) {
            echo "  - $section\n";
        }
        
        echo "\n<a href='?' style='display: inline-block; background: blue; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;'>BACK</a>\n";
        
    } else if (isset($_GET['translate']) && $_GET['translate'] == 'yes') {
        echo "=== TRANSLATING EVERYTHING ===\n\n";
        
        // COMPREHENSIVE translation map - ALL phrases
        $translations = [
            // Hero/Banner
            'Grow Your Business with WhatsApp CRM and Marketing Tools' => 'Expanda Seu Negócio com CRM WhatsApp e Ferramentas de Marketing',
            'Expanda Seu Negócio com CRM WhatsApp e Ferramentas de Marketing' => 'Expanda Seu Negócio com CRM WhatsApp e Ferramentas de Marketing',
            'Create campaigns, automate chats, manage contacts—all from one powerful dashboard' => 'Crie campanhas, automatize conversas, gerencie contatos—tudo em um painel poderoso',
            'Get Started for Free' => 'Comece Gratuitamente',
            'Get Started Free' => 'Comece Gratuitamente',
            
            // How It Works
            'How It Works' => 'Como Funciona',
            'Como Funciona?' => 'Como Funciona?',
            'Understand the process from signup to campaign launch in just a few steps' => 'Entenda o processo desde o cadastro até o lançamento da campanha em apenas alguns passos',
            'few steps' => 'alguns passos',
            'a few steps' => 'alguns passos',
            
            // Step 1
            'Join to Platform' => 'Junte-se à Plataforma',
            'Join to Platparam' => 'Junte-se à Plataforma',
            'Sign up for free and unlock a full-featured Marketing and CRM platform in seconds' => 'Cadastre-se gratuitamente e desbloqueie uma plataforma completa de Marketing e CRM em segundos',
            'Cadastrar para free e unlock a full-featured Marketing e CRM platparam comin seconds' => 'Cadastre-se gratuitamente e desbloqueie uma plataforma completa de Marketing e CRM em segundos',
            'in seconds' => 'em segundos',
            'comin seconds' => 'em segundos',
            
            // Step 2
            'Explore our Features' => 'Explore Nossos Recursos',
            'Explore nosso Feature' => 'Explore Nossos Recursos',
            'Discover powerful tools like Automation, Campaign builders, and conversion boosters' => 'Descubra ferramentas poderosas como Automação, construtores de Campanha e impulsionadores de conversão',
            'Discover powerful tools like Automação, Campanha builders, e conversion boosters' => 'Descubra ferramentas poderosas como Automação, construtores de Campanha e impulsionadores de conversão',
            'Campaign builders' => 'construtores de Campanha',
            'Campanha builders' => 'construtores de Campanha',
            'conversion boosters' => 'impulsionadores de conversão',
            
            // Step 3
            'Add or Import your Contacts' => 'Adicionar ou Importar seus Contatos',
            'Adicionar or Importartar seu Contatos' => 'Adicionar ou Importar seus Contatos',
            'Add Contacts manually or bulk import from your CRM tools, spreadsheets, or integrations' => 'Adicione Contatos manualmente ou importe em massa de suas ferramentas CRM, planilhas ou integrações',
            'manually or bulk' => 'manualmente ou em massa',
            'manutodosoy or bulk' => 'manualmente ou em massa',
            'spreadsheets, or integrations' => 'planilhas ou integrações',
            
            // Step 4
            'Send Message or Create Campaign' => 'Enviar Mensagem ou Criar Campanha',
            'Launch personalized messages or smart campaigns with real-time insights' => 'Lance mensagens personalizadas ou campanhas inteligentes com insights em tempo real',
            'com-time insights' => 'com insights em tempo real',
            'real-time insights' => 'insights em tempo real',
            
            // Features Section
            "Here's What You Get" => 'Aqui Está o Que Você Recebe',
            'Aqui Está o Que Você Recebe' => 'Aqui Está o Que Você Recebe',
            'Everything you need to grow, automate, and connect with your audience' => 'Tudo que você precisa para crescer, automatizar e conectar com seu público',
            'automate, e connect com seu audience' => 'automatizar e conectar com seu público',
            
            // Pricing Section
            'Simple and Transparent Pricing' => 'Preços Simples e Transparentes',
            'Preços Simples e Transparentes' => 'Preços Simples e Transparentes',
            'Choose the plan that fits your needs' => 'Escolha o plano que atende suas necessidades',
            'Monthly' => 'Mensal',
            'Yearly' => 'Anual',
            'Per Month' => 'Por Mês',
            'Per Year' => 'Por Ano',
            'Subscribe Now' => 'Assinar Agora',
            'Get Started' => 'Começar',
            'Choose Plan' => 'Escolher Plano',
            'Popular' => 'Popular',
            'Best Value' => 'Melhor Valor',
            
            // Testimonials
            'Trusted by Thousands of Businesses' => 'Confiado por Milhares de Empresas',
            'Confiado por Milhares de Empresas' => 'Confiado por Milhares de Empresas',
            'Hear how FlowMkt is transforming customer engagement across industries' => 'Veja como o FlowMkt está transformando o engajamento de clientes em diversos setores',
            'FlowMkt has helped us scale our communication without losing the personal touch' => 'FlowMkt nos ajudou a escalar nossa comunicação sem perder o toque pessoal',
            'The Support team is responsive and the onboarding was smooth' => 'A equipe de suporte é responsiva e a integração foi tranquila',
            
            // Mobile App
            'Take Your Business Anywhere' => 'Leve Seu Negócio Para Qualquer Lugar',
            'Leve Seu Negócio Para Qualquer Lugar' => 'Leve Seu Negócio Para Qualquer Lugar',
            'Awesome Benefits of the App' => 'Benefícios Incríveis do Aplicativo',
            'Awsome Benefits of the App' => 'Benefícios Incríveis do Aplicativo',
            'Secure and fast performance' => 'Desempenho seguro e rápido',
            'Available on iOS and Android' => 'Disponível para iOS e Android',
            'Download Now' => 'Baixar Agora',
            
            // FAQ
            'Answers to Common Questions' => 'Respostas Para Perguntas Comuns',
            'Respostas Para Perguntas Comuns' => 'Respostas Para Perguntas Comuns',
            'Frequently Asked Questions' => 'Perguntas Frequentes',
            'Before reaching out, check our FAQs for quick solutions to your concerns' => 'Antes de entrar em contato, confira nossas Perguntas Frequentes para soluções rápidas',
            
            // Blog
            'Our Latest Blog' => 'Nosso Blog Mais Recente',
            'Nosso Blog Mais Recente' => 'Nosso Blog Mais Recente',
            'Explore our collection of articles' => 'Explore nossa coleção de artigos',
            'Read More' => 'Leia Mais',
            'View All Posts' => 'Ver Todos os Posts',
            
            // CTA
            'Get Started with FlowMkt' => 'Comece com FlowMkt',
            'Comece com FlowMkt' => 'Comece com FlowMkt',
            'Start My Free Trial' => 'Iniciar Meu Teste Grátis',
            'Start My Free Trail' => 'Iniciar Meu Teste Grátis',
            'No credit card required' => 'Não é necessário cartão de crédito',
            
            // Contact
            'Contact Us' => 'Fale Conosco',
            'Get in Touch' => 'Entre em Contato',
            'Send us an email' => 'Envie-nos um e-mail',
            'Whether you have a question' => 'Se você tem uma pergunta',
            'Send Message' => 'Enviar Mensagem',
            
            // Footer
            'FlowMkt turns WhatsApp into a powerful marketing platform' => 'FlowMkt transforma o WhatsApp em uma poderosa plataforma de marketing',
            'Stay up to date' => 'Mantenha-se atualizado',
            'Subscribe to our newsletter' => 'Assine nossa newsletter',
            'Quick Links' => 'Links Rápidos',
            'About Us' => 'Sobre Nós',
            'Privacy Policy' => 'Política de Privacidade',
            'Terms of Service' => 'Termos de Serviço',
            'Cookie Policy' => 'Política de Cookies',
            
            // Common UI elements
            'Home' => 'Início',
            'Features' => 'Recursos',
            'Pricing' => 'Preços',
            'Blog' => 'Blog',
            'Contact' => 'Contato',
            'Login' => 'Entrar',
            'Sign Up' => 'Cadastrar',
            'Dashboard' => 'Painel',
            'Learn More' => 'Saiba Mais',
            'View All' => 'Ver Tudo',
        ];
        
        // Get all frontend records
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Sort translations by length (longest first)
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
        
        echo "✓ Translated $count frontend records\n\n";
        
        if ($count > 0) {
            echo "Details:\n";
            foreach ($details as $detail) {
                echo "  - $detail\n";
            }
            echo "\n";
        } else {
            echo "ℹ️ No changes needed - all content already translated!\n\n";
        }
        
        // Clear ALL caches
        echo "=== CLEARING ALL CACHES ===\n\n";
        
        $cacheFiles = [
            __DIR__ . '/core/bootstrap/cache/config.php',
            __DIR__ . '/core/bootstrap/cache/routes-v7.php',
            __DIR__ . '/core/bootstrap/cache/services.php',
        ];
        
        foreach ($cacheFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
                echo "✓ Cleared " . basename($file) . "\n";
            }
        }
        
        $cacheDirs = [
            __DIR__ . '/core/storage/framework/views',
            __DIR__ . '/core/storage/framework/cache/data',
        ];
        
        foreach ($cacheDirs as $dir) {
            if (is_dir($dir)) {
                $files = glob($dir . '/*');
                $cleared = 0;
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                        $cleared++;
                    }
                }
                echo "✓ Cleared $cleared files from " . basename($dir) . "\n";
            }
        }
        
        echo "\n✅ COMPLETE TRANSLATION FINISHED!\n\n";
        echo "Visit: https://flow.clubemkt.digital\n";
        echo "(Hard refresh: Ctrl+Shift+R or Cmd+Shift+R)\n\n";
        echo "⚠️ DELETE THIS FILE NOW!\n";
        
    } else {
        echo "=== FINAL COMPLETE TRANSLATION ===\n\n";
        echo "This will translate ALL remaining content to Portuguese.\n\n";
        echo "Total translations: " . count($translations ?? []) . " phrases\n\n";
        echo "Sections covered:\n";
        echo "  ✓ Hero/Banner\n";
        echo "  ✓ How It Works (all 4 steps)\n";
        echo "  ✓ Features\n";
        echo "  ✓ Pricing\n";
        echo "  ✓ Testimonials\n";
        echo "  ✓ Mobile App\n";
        echo "  ✓ FAQ\n";
        echo "  ✓ Blog\n";
        echo "  ✓ CTA\n";
        echo "  ✓ Contact\n";
        echo "  ✓ Footer\n";
        echo "  ✓ Navigation\n\n";
        echo "<a href='?inspect=yes' style='display: inline-block; background: blue; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;'>INSPECT DATABASE</a>\n";
        echo "<a href='?translate=yes' style='display: inline-block; background: green; color: white; padding: 20px 40px; text-decoration: none; font-weight: bold; font-size: 18px; margin: 10px; border-radius: 5px;'>TRANSLATE EVERYTHING</a>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
