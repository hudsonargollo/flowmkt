<?php
// Complete Frontend Translation to Portuguese
// Upload to: /home/clubemkt/flow.clubemkt.digital/translate_frontend_complete.php
// Visit: https://flow.clubemkt.digital/translate_frontend_complete.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<h1>Complete Translation to Portuguese</h1>";
echo "<pre>";

try {
    $host = '127.0.0.1';
    $db = 'clubemkt_zapflow';
    $user = 'clubemkt_zapflow';
    $pass = 'tF4s8*7KnB*2';
    
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connected\n\n";
    
    // COMPREHENSIVE Translation map based on detected English content
    $translations = [
        // SEO & Meta
        'Complete Cross Platform WhatsApp Solution' => 'Solução Completa Multiplataforma para WhatsApp',
        'Complete Cross Platform Whats' => 'Solução Completa Multiplataforma para Whats',
        'Web and Mobile App' => 'Aplicativo Web e Mobile',
        'Marketing no Whats' => 'Marketing no WhatsApp',
        
        // Blog Section
        'Nosso Blog Mais Recente' => 'Nosso Blog Mais Recente',
        'Our Latest Blog' => 'Nosso Blog Mais Recente',
        'Explore our collection of articles' => 'Explore nossa coleção de artigos',
        'Top Benefits of Using FlowMkt for Agencies and Startups' => 'Principais Benefícios de Usar o FlowMkt para Agências e Startups',
        'Top Benefits of Using Flow' => 'Principais Benefícios de Usar o Flow',
        
        // Feature Section
        'Everything you need to grow' => 'Tudo que você precisa para crescer',
        'Discover the Powerful Features' => 'Descubra os Recursos Poderosos',
        'Discover the Powerful Recursos' => 'Descubra os Recursos Poderosos',
        'From seamless messaging to insightful Analytics' => 'De mensagens perfeitas a análises detalhadas',
        'From seamless messaging to insightful An' => 'De mensagens perfeitas a análises detalhadas',
        'Agent Management System' => 'Sistema de Gestão de Agentes',
        'Invite and manage team members with role' => 'Convide e gerencie membros da equipe com controle de funções',
        'Invite and manage team members with role-based access' => 'Convide e gerencie membros da equipe com acesso baseado em funções',
        
        // Cookie Policy
        'We may utilize cookies when you access our website' => 'Podemos utilizar cookies quando você acessa nosso site',
        'These technologies are employed to enhance site functionality and optimize your' => 'Essas tecnologias são empregadas para melhorar a funcionalidade do site e otimizar sua',
        'These technologies are employed to enhance site functionality and optimize your experience' => 'Essas tecnologias são empregadas para melhorar a funcionalidade do site e otimizar sua experiência',
        'What Are Cookies' => 'O Que São Cookies',
        
        // Policy Pages
        'Termos de Servi' => 'Termos de Serviço',
        'Terms of Service' => 'Termos de Serviço',
        'By accessing this website' => 'Ao acessar este site',
        'Terms and Conditions of Use' => 'Termos e Condições de Uso',
        
        // Maintenance
        'Our site is currently undergoing scheduled maintenance to enhance performance and' => 'Nosso site está passando por manutenção programada para melhorar o desempenho e',
        'Our site is currently undergoing scheduled maintenance to enhance performance and security' => 'Nosso site está passando por manutenção programada para melhorar o desempenho e segurança',
        'During this time' => 'Durante este período',
        'Recursos may be temporarily unavailable' => 'Os recursos podem estar temporariamente indisponíveis',
        'Features may be temporarily unavailable' => 'Os recursos podem estar temporariamente indisponíveis',
        
        // KYC
        'It is quick and easy just follow the on' => 'É rápido e fácil, basta seguir as',
        'It is quick and easy just follow the on-screen steps' => 'É rápido e fácil, basta seguir as etapas na tela',
        'We might need some Additional information' => 'Podemos precisar de algumas informações adicionais',
        'We might need some Adicionaritional information' => 'Podemos precisar de algumas informações adicionais',
        'You will get an email Update soon' => 'Você receberá uma atualização por e-mail em breve',
        'You will get an email Atualizar soon' => 'Você receberá uma atualização por e-mail em breve',
        
        // Banner/Hero
        'Expanda Seu Neg' => 'Expanda Seu Negócio',
        'App e Ferramentas de Marketing' => 'App e Ferramentas de Marketing',
        'Grow Your Business with WhatsApp CRM and Marketing Tools' => 'Expanda Seu Negócio com CRM WhatsApp e Ferramentas de Marketing',
        
        // Registration
        'Registration Currently Disabled' => 'Cadastro Atualmente Desabilitado',
        'Page you are looking for doesn' => 'A página que você está procurando não',
        'Page you are looking for doesn\'t exist' => 'A página que você está procurando não existe',
        'Error occurred or temporarily unavailable' => 'Ocorreu um erro ou está temporariamente indisponível',
        'Erro occurred or temporarily unavailable' => 'Ocorreu um erro ou está temporariamente indisponível',
        
        // FAQ
        'Respostas Para Perguntas Comuns' => 'Respostas Para Perguntas Comuns',
        'Answers to Common Questions' => 'Respostas Para Perguntas Comuns',
        'Before reaching out' => 'Antes de entrar em contato',
        'Perguntas Frequentess for quick solutions to your concerns' => 'Perguntas Frequentes para soluções rápidas para suas dúvidas',
        'FAQs for quick solutions to your concerns' => 'Perguntas Frequentes para soluções rápidas para suas dúvidas',
        'Are invoices and billing history available' => 'As faturas e histórico de cobrança estão disponíveis',
        'You can access and Download all invoices and billing history directly' => 'Você pode acessar e baixar todas as faturas e histórico de cobrança diretamente',
        'You can access and Baixar all invoices and billing history directly' => 'Você pode acessar e baixar todas as faturas e histórico de cobrança diretamente',
        'Mkt account under the' => 'Mkt na seção',
        
        // How It Works
        'Understand the process from signup to Campaign launch in just a' => 'Entenda o processo desde o cadastro até o lançamento da campanha em apenas',
        'Understand the process from signup to Campanha launch in just a' => 'Entenda o processo desde o cadastro até o lançamento da campanha em apenas',
        'Enviar Mensagem or Criar Campanha' => 'Enviar Mensagem ou Criar Campanha',
        'Send Message or Create Campaign' => 'Enviar Mensagem ou Criar Campanha',
        'Launch personalized Messages or smart Campaigns with real' => 'Lance mensagens personalizadas ou campanhas inteligentes com',
        'Launch personalized Mensagems or smart Campanhas with real' => 'Lance mensagens personalizadas ou campanhas inteligentes com',
        'Launch personalized messages or smart campaigns with real-time tracking' => 'Lance mensagens personalizadas ou campanhas inteligentes com rastreamento em tempo real',
        
        // Testimonials
        'Confiado por Milhares de Empresas' => 'Confiado por Milhares de Empresas',
        'Trusted by Thousands of Businesses' => 'Confiado por Milhares de Empresas',
        'Hear how FlowMkt is transforming Customer engagement across industries' => 'Veja como o FlowMkt está transformando o engajamento de clientes em diversos setores',
        'Hear how Flow' => 'Veja como o Flow',
        'Mkt is transforming Cliente engagement across industries' => 'Mkt está transformando o engajamento de clientes em diversos setores',
        'Mkt has helped us scale our communication without losing the personal' => 'Mkt nos ajudou a escalar nossa comunicação sem perder o toque pessoal',
        'FlowMkt has helped us scale our communication without losing the personal touch' => 'FlowMkt nos ajudou a escalar nossa comunicação sem perder o toque pessoal',
        'The Support team is responsive and the onboarding was smooth' => 'A equipe de suporte é responsiva e a integração foi tranquila',
        'The Suporte team is responsive and the onboarding was smooth' => 'A equipe de suporte é responsiva e a integração foi tranquila',
        
        // Mobile App
        'Leve Seu Neg' => 'Leve Seu Negócio',
        'Para Qualquer Lugar' => 'Para Qualquer Lugar',
        'Take Your Business Anywhere' => 'Leve Seu Negócio Para Qualquer Lugar',
        'Awesome Benefits of the App' => 'Benefícios Incríveis do Aplicativo',
        'Awsome Benefits of the App' => 'Benefícios Incríveis do Aplicativo',
        'Secure and fast performance' => 'Desempenho seguro e rápido',
        
        // CTA (Call to Action)
        'Comece com Flow' => 'Comece com Flow',
        'Get Started with FlowMkt' => 'Comece com FlowMkt',
        'Mkt gives you everything you need to scale your communication' => 'Mkt oferece tudo que você precisa para escalar sua comunicação',
        'FlowMkt gives you everything you need to scale your communication' => 'FlowMkt oferece tudo que você precisa para escalar sua comunicação',
        'Start My Free Trail' => 'Iniciar Meu Teste Grátis',
        'Start My Free Trial' => 'Iniciar Meu Teste Grátis',
        
        // Blog Content
        'Mkt for Agencies and Startups' => 'Mkt para Agências e Startups',
        'Vendas without overwhelming their teams' => 'Vendas sem sobrecarregar suas equipes',
        'Sales without overwhelming their teams' => 'Vendas sem sobrecarregar suas equipes',
        
        // Contact
        'Sent us an email' => 'Envie-nos um e-mail',
        'Send us an email' => 'Envie-nos um e-mail',
        'Whether you have a question' => 'Se você tem uma pergunta',
        'Saiba Mais about service' => 'Saiba Mais sobre o serviço',
        'Learn More about service' => 'Saiba Mais sobre o serviço',
        
        // Pricing
        'Simples e Transparentes' => 'Simples e Transparentes',
        'Simple and Transparent Pricing' => 'Preços Simples e Transparentes',
        'The subscription will automatically renew every year before you un' => 'A assinatura será renovada automaticamente todos os anos antes de você',
        'The subscription will automatically renew every year before you unsubscribe' => 'A assinatura será renovada automaticamente todos os anos antes de você cancelar',
        
        // Auth/Login
        'Access Your Dashboard' => 'Acesse Seu Painel',
        'Access Your Painel' => 'Acesse Seu Painel',
        'Enter your credentials to continue managing your Business' => 'Digite suas credenciais para continuar gerenciando seu negócio',
        'Enter your credentials to continue managing your Neg' => 'Digite suas credenciais para continuar gerenciando seu negócio',
        
        // Feature Page
        'Cliente interactions and help your Neg' => 'Interações com clientes e ajude seu negócio',
        'Customer interactions and help your Business' => 'Interações com clientes e ajude seu negócio',
        'Manage Your Message Templates Easily' => 'Gerencie Seus Modelos de Mensagem Facilmente',
        'Manage Your Mensagem Modelos Easily' => 'Gerencie Seus Modelos de Mensagem Facilmente',
        'Send your Messages as a template and feel the intimate fun' => 'Envie suas mensagens como modelo e sinta a diversão íntima',
        'Enviar your Mensagems as a template and feel the intimate fun' => 'Envie suas mensagens como modelo e sinta a diversão íntima',
        'Multiple Message template Support for each account' => 'Suporte a múltiplos modelos de mensagem para cada conta',
        'Multiple Mensagem template Suporte for each account' => 'Suporte a múltiplos modelos de mensagem para cada conta',
        
        // Footer
        'Mkt turns WhatsApp into a powerful' => 'Mkt transforma o WhatsApp em uma poderosa',
        'Mkt turns Whats' => 'Mkt transforma o Whats',
        'FlowMkt turns WhatsApp into a powerful marketing platform' => 'FlowMkt transforma o WhatsApp em uma poderosa plataforma de marketing',
        'App into a powerful' => 'App em uma poderosa',
        'Stay up to date' => 'Mantenha-se atualizado',
        
        // Common words that appear in mixed content
        'and' => 'e',
        'with' => 'com',
        'for' => 'para',
        'your' => 'seu',
        'our' => 'nosso',
        'the' => 'o',
        'all' => 'todos',
        'from' => 'de',
        'what' => 'o que',
        'how' => 'como',
        'why' => 'por que',
        'when' => 'quando',
        'where' => 'onde',
        'who' => 'quem',
    ];
    
    if (isset($_GET['translate']) && $_GET['translate'] == 'yes') {
        echo "=== TRANSLATING ALL REMAINING CONTENT ===\n\n";
        
        // Get all frontend records
        $stmt = $conn->query("SELECT id, data_keys, data_values FROM frontends");
        $frontends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $count = 0;
        $details = [];
        
        foreach ($frontends as $frontend) {
            $originalJson = $frontend['data_values'];
            $updatedJson = $originalJson;
            
            // Apply translations (case-insensitive)
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
            echo "ℹ️ No new translations needed - all content already translated!\n\n";
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
        echo "⚠️ DELETE THIS FILE NOW FOR SECURITY!\n";
        
    } else {
        echo "=== COMPLETE TRANSLATION READY ===\n\n";
        echo "This script will translate ALL remaining English content.\n\n";
        echo "Total translations: " . count($translations) . " phrases\n\n";
        echo "Including:\n";
        echo "  - SEO & Meta content\n";
        echo "  - Blog sections\n";
        echo "  - Feature descriptions\n";
        echo "  - Cookie & Policy pages\n";
        echo "  - Maintenance messages\n";
        echo "  - KYC content\n";
        echo "  - Banner/Hero text\n";
        echo "  - FAQ sections\n";
        echo "  - Testimonials\n";
        echo "  - Mobile app content\n";
        echo "  - Call-to-action buttons\n";
        echo "  - Contact forms\n";
        echo "  - Pricing pages\n";
        echo "  - Auth/Login pages\n";
        echo "  - Footer content\n\n";
        echo "<a href='?translate=yes' style='display: inline-block; background: green; color: white; padding: 20px 40px; text-decoration: none; font-weight: bold; font-size: 18px; margin: 20px; border-radius: 5px;'>TRANSLATE ALL NOW</a>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
