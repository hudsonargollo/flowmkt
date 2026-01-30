# Plano de Implementação: Integração Evolution API

## Visão Geral

Este plano detalha a implementação da integração Evolution API no FlowMkt, permitindo que a plataforma suporte tanto a Meta API quanto a Evolution API de forma paralela. A implementação seguirá uma abordagem incremental, começando pela infraestrutura de dados, seguida pelos componentes core, integração com APIs externas, e finalmente testes abrangentes.

## Tasks

- [ ] 1. Configurar infraestrutura de dados e migrations
  - Criar migration para adicionar campos Evolution API à tabela `whatsapp_accounts`
  - Adicionar campos: `api_type`, `instance_id`, `api_url`, `api_key`, `connection_status`, `qr_code_data`
  - Definir `api_type` com valor padrão 'meta' para compatibilidade retroativa
  - Adicionar índices para `api_type`, `instance_id`, `connection_status`
  - Testar migration (up/down) para garantir reversibilidade sem perda de dados
  - _Requirements: 12.1, 12.2, 12.6_

- [ ] 2. Atualizar Model WhatsappAccount
  - [ ] 2.1 Adicionar novos campos ao $fillable e $hidden
    - Incluir campos Evolution API em $fillable
    - Adicionar `api_key` ao array $hidden para nunca expor em JSON
    - _Requirements: 2.5, 9.1_
  
  - [ ] 2.2 Implementar accessors para api_key
    - Criar `getDecryptedApiKeyAttribute()` para uso interno
    - Criar `getMaskedApiKeyAttribute()` para exibição segura (****XXXX)
    - Implementar tratamento de exceções na descriptografia
    - _Requirements: 9.2, 9.4_
  
  - [ ] 2.3 Adicionar scopes de consulta
    - Implementar `scopeEvolution()` para filtrar contas Evolution
    - Implementar `scopeMeta()` para filtrar contas Meta
    - Implementar `scopeConnected()` para filtrar contas conectadas
    - _Requirements: 2.3_
  
  - [ ]* 2.4 Escrever testes unitários para Model
    - Testar accessors de api_key (descriptografada e mascarada)
    - Testar scopes de consulta
    - Testar que api_key não aparece em toArray()/toJson()
    - _Requirements: 9.2, 9.4_

- [ ] 3. Implementar EvolutionManager Trait
  - [ ] 3.1 Criar estrutura básica do trait
    - Criar arquivo `core/app/Traits/EvolutionManager.php`
    - Definir namespace e imports necessários (Http, Log, Crypt)
    - _Requirements: 8.1_
  
  - [ ] 3.2 Implementar sendEvolutionMessage()
    - Descriptografar api_key da conta
    - Construir URL: `{api_url}/message/sendText/{instance_id}`
    - Enviar requisição POST com headers (apikey) e body (number, text)
    - Implementar retry com backoff exponencial (3 tentativas)
    - Retornar array estruturado: ['success' => bool, 'data' => array, 'error' => string|null]
    - Registrar logs de requisição e resposta com contexto completo
    - _Requirements: 4.1, 4.3, 4.4, 4.5, 10.1, 10.2_
  
  - [ ] 3.3 Implementar getEvolutionQrCode()
    - Construir URL: `{api_url}/instance/connect/{instance_id}`
    - Enviar requisição GET com header apikey
    - Extrair campos: code, pairingCode, count
    - Retornar array estruturado com QR code data
    - _Requirements: 3.1, 3.2_
  
  - [ ] 3.4 Implementar checkEvolutionStatus()
    - Construir URL: `{api_url}/instance/connectionState/{instance_id}`
    - Enviar requisição GET com header apikey
    - Mapear estados da Evolution API para estados internos
    - Retornar array estruturado com status
    - _Requirements: 3.6_
  
  - [ ] 3.5 Implementar disconnectEvolutionInstance()
    - Construir URL: `{api_url}/instance/logout/{instance_id}`
    - Enviar requisição DELETE com header apikey
    - Retornar array estruturado indicando sucesso/falha
    - _Requirements: 6.1_
  
  - [ ] 3.6 Implementar setEvolutionWebhook()
    - Construir URL: `{api_url}/webhook/set/{instance_id}`
    - Enviar requisição POST com webhook URL e eventos desejados
    - Retornar array estruturado indicando sucesso/falha
    - _Requirements: 5.1_
  
  - [ ] 3.7 Implementar tratamento de erros HTTP
    - Mapear erro 401 para mensagem "API Key inválida"
    - Mapear erro 404 para mensagem "Instance ID não encontrado"
    - Tratar ConnectionException para "Servidor não está respondendo"
    - Implementar timeout de 30 segundos configurável
    - _Requirements: 11.1, 11.2, 11.3_
  
  - [ ]* 3.8 Escrever testes unitários para EvolutionManager
    - Mockar Http facade para testar requisições
    - Testar que api_key é descriptografada corretamente
    - Testar construção de URLs com parâmetros corretos
    - Testar mapeamento de erros HTTP
    - Testar retry com backoff exponencial
    - _Requirements: 4.3, 11.1, 11.2, 11.3_

- [ ] 4. Checkpoint - Verificar componentes base
  - Garantir que migrations funcionam corretamente
  - Verificar que Model e EvolutionManager estão implementados
  - Executar testes unitários existentes
  - Perguntar ao usuário se há dúvidas ou ajustes necessários

- [ ] 5. Modificar WhatsappManager Trait para roteamento
  - [ ] 5.1 Adicionar use EvolutionManager no trait
    - Importar EvolutionManager trait
    - _Requirements: 8.3_
  
  - [ ] 5.2 Implementar roteamento em sendWelcomeMessage()
    - Usar match() para rotear baseado em $account->api_type
    - Chamar sendEvolutionMessage() para 'evolution'
    - Manter lógica existente para 'meta'
    - Retornar erro para tipos desconhecidos
    - _Requirements: 4.1, 4.2, 7.2_
  
  - [ ] 5.3 Implementar roteamento em sendTestMessage()
    - Usar match() para rotear baseado em $account->api_type
    - Chamar sendEvolutionMessage() para 'evolution'
    - Manter lógica existente para 'meta'
    - _Requirements: 4.1, 4.2_
  
  - [ ]* 5.4 Escrever testes de propriedade para roteamento
    - **Property 7: Roteamento Baseado em Tipo de API**
    - **Validates: Requirements 4.1, 4.2, 8.3**
    - Gerar contas aleatórias de ambos os tipos
    - Verificar que mensagens são roteadas corretamente
    - Mockar ambas as APIs e verificar qual foi chamada
  
  - [ ]* 5.5 Escrever teste de propriedade para coexistência
    - **Property 19: Coexistência de Contas Meta e Evolution**
    - **Validates: Requirements 8.4**
    - Criar tenant com contas de ambos os tipos
    - Enviar mensagens através de cada conta
    - Verificar que funcionam independentemente

- [ ] 6. Modificar WhatsappAccountManager Trait
  - [ ] 6.1 Atualizar storeWhatsappAccount() para validação unificada
    - Implementar verificação de account_limit antes de criar conta
    - Contar total de contas (Meta + Evolution) do usuário
    - Retornar erro 403 se limite atingido
    - _Requirements: 1.1, 1.2_
  
  - [ ] 6.2 Implementar validação condicional por api_type
    - Adicionar regra de validação para api_type (required|in:meta,evolution)
    - Se api_type='evolution': validar instance_id, api_url, api_key
    - Se api_type='meta': validar campos Meta existentes
    - _Requirements: 2.2, 2.4_
  
  - [ ] 6.3 Implementar criação de conta Evolution
    - Criptografar api_key usando Crypt::encryptString()
    - Definir connection_status='qr_code_needed'
    - Salvar conta no banco de dados
    - Retornar resposta JSON estruturada
    - _Requirements: 2.3, 2.5, 2.6_
  
  - [ ] 6.4 Criar método connectEvolutionAccount()
    - Validar que conta é do tipo 'evolution'
    - Chamar getEvolutionQrCode() do EvolutionManager
    - Armazenar qr_code_data na conta
    - Retornar QR code e pairing code em JSON
    - _Requirements: 3.1, 3.2_
  
  - [ ] 6.5 Criar método checkEvolutionAccountStatus()
    - Validar que conta é do tipo 'evolution'
    - Chamar checkEvolutionStatus() do EvolutionManager
    - Atualizar connection_status se mudou
    - Retornar status atual em JSON
    - _Requirements: 3.6_
  
  - [ ] 6.6 Criar método disconnectEvolutionAccount()
    - Validar que conta é do tipo 'evolution'
    - Chamar disconnectEvolutionInstance() do EvolutionManager
    - Atualizar connection_status='disconnected'
    - Retornar resposta JSON
    - _Requirements: 6.1_
  
  - [ ] 6.7 Criar método updateEvolutionCredentials()
    - Validar novos valores de api_url e api_key
    - Testar conectividade antes de salvar
    - Criptografar nova api_key
    - Atualizar conta no banco
    - _Requirements: 6.5, 6.6_
  
  - [ ]* 6.8 Escrever testes de propriedade para limites
    - **Property 1: Limite Unificado de Contas**
    - **Validates: Requirements 1.1, 1.2**
    - Gerar account_limit aleatório
    - Criar contas mistas (Meta + Evolution)
    - Verificar que total nunca excede limite
  
  - [ ]* 6.9 Escrever teste de propriedade para liberação de limite
    - **Property 2: Liberação de Limite ao Remover Conta**
    - **Validates: Requirements 1.3, 6.2**
    - Preencher até o limite
    - Remover uma conta
    - Verificar que pode adicionar nova conta
  
  - [ ]* 6.10 Escrever testes de propriedade para validação
    - **Property 3: Validação Condicional de Campos Evolution**
    - **Validates: Requirements 2.2, 2.4**
    - Testar que campos Evolution são obrigatórios quando api_type='evolution'
    - Testar que campos Meta são opcionais quando api_type='evolution'
  
  - [ ]* 6.11 Escrever teste de propriedade para criptografia
    - **Property 5: Criptografia Round-Trip de API Key**
    - **Validates: Requirements 2.5, 9.1**
    - Gerar api_keys aleatórias
    - Salvar e recuperar do banco
    - Verificar que descriptografar retorna valor original
    - Verificar que valor no banco é diferente do original

- [ ] 7. Criar EvolutionWebhookController
  - [ ] 7.1 Criar controller e método handle()
    - Criar arquivo `core/app/Http/Controllers/EvolutionWebhookController.php`
    - Implementar método handle(Request $request)
    - _Requirements: 5.1_
  
  - [ ] 7.2 Implementar autenticação de webhook
    - Validar header X-Webhook-Secret contra config
    - Retornar 401 se chave inválida
    - Registrar tentativas não autorizadas com IP
    - _Requirements: 5.2, 9.3_
  
  - [ ] 7.3 Implementar validação de payload
    - Validar presença de campos: event, instance, data
    - Retornar 400 se payload malformado
    - Registrar erro com detalhes do payload
    - _Requirements: 5.5_
  
  - [ ] 7.4 Implementar dispatch de job assíncrono
    - Extrair event, instanceId, data do request
    - Despachar ProcessEvolutionWebhook job
    - Retornar 200 imediatamente
    - _Requirements: 5.6_
  
  - [ ]* 7.5 Escrever testes de propriedade para autenticação
    - **Property 11: Autenticação de Webhook**
    - **Validates: Requirements 5.2, 9.3**
    - Gerar payloads aleatórios
    - Testar com chave correta (deve processar)
    - Testar com chave incorreta (deve retornar 401)
  
  - [ ]* 7.6 Escrever testes unitários para webhook controller
    - Testar autenticação com chave válida/inválida
    - Testar validação de payload malformado
    - Testar que job é despachado corretamente
    - Testar resposta 200 para webhook válido

- [ ] 8. Criar ProcessEvolutionWebhook Job
  - [ ] 8.1 Criar job com estrutura básica
    - Criar arquivo `core/app/Jobs/ProcessEvolutionWebhook.php`
    - Implementar constructor com event, instanceId, data
    - Implementar ShouldQueue interface
    - _Requirements: 5.6_
  
  - [ ] 8.2 Implementar método handle() com roteamento de eventos
    - Buscar conta por instance_id
    - Usar match() para rotear eventos
    - Registrar warning se instância desconhecida
    - _Requirements: 5.3_
  
  - [ ] 8.3 Implementar handleConnectionUpdate()
    - Mapear estados Evolution para estados internos (open→connected, close→disconnected)
    - Atualizar connection_status da conta
    - Limpar qr_code_data quando status='connected'
    - Registrar log de atualização
    - _Requirements: 3.4, 3.5, 5.4_
  
  - [ ] 8.4 Implementar handleMessageReceived()
    - Extrair dados da mensagem do payload
    - Associar mensagem à conta usando instance_id
    - Integrar com sistema existente de mensagens do FlowMkt
    - Registrar log de mensagem recebida
    - _Requirements: 5.3_
  
  - [ ] 8.5 Implementar handleMessageUpdate()
    - Extrair status da mensagem do payload
    - Atualizar status da mensagem no sistema
    - Registrar log de atualização
    - _Requirements: 5.4_
  
  - [ ]* 8.6 Escrever testes de propriedade para webhook processing
    - **Property 6: Atualização de Status via Webhook**
    - **Validates: Requirements 3.4, 5.4**
    - Simular webhooks de connection.update
    - Verificar que status é atualizado corretamente
    - Verificar que qr_code_data é limpo quando conectado
  
  - [ ]* 8.7 Escrever testes unitários para job
    - Mockar conta e testar cada tipo de evento
    - Testar mapeamento de estados
    - Testar que instância desconhecida é logada
    - Testar integração com sistema de mensagens

- [ ] 9. Checkpoint - Verificar integração completa
  - Garantir que todos os componentes estão implementados
  - Executar testes unitários e de propriedade
  - Verificar que webhooks são processados corretamente
  - Perguntar ao usuário se há dúvidas ou ajustes necessários

- [ ] 10. Configurar rotas e middleware
  - [ ] 10.1 Adicionar rotas para gerenciamento de contas Evolution
    - POST /user/whatsapp/account/store (modificar existente)
    - GET /user/whatsapp/account/{id}/connect/evolution
    - GET /user/whatsapp/account/{id}/status/evolution
    - DELETE /user/whatsapp/account/{id}/disconnect/evolution
    - PUT /user/whatsapp/account/{id}/credentials/evolution
    - Aplicar middleware de autenticação
    - _Requirements: 2.1, 3.1, 3.6, 6.1, 6.5_
  
  - [ ] 10.2 Adicionar rota para webhook Evolution
    - POST /api/whatsapp/webhook/evolution
    - Sem middleware de autenticação (usa chave secreta)
    - _Requirements: 5.1_
  
  - [ ] 10.3 Implementar rate limiting para webhook
    - Configurar limite: 100 requisições por minuto por IP
    - Retornar 429 quando limite excedido
    - _Requirements: 9.5_
  
  - [ ] 10.4 Implementar bloqueio de IPs não autorizados
    - Detectar múltiplas tentativas não autorizadas (5 em 1 minuto)
    - Bloquear IP temporariamente (15 minutos)
    - Registrar evento de bloqueio
    - _Requirements: 9.6_
  
  - [ ]* 10.5 Escrever testes de integração para rotas
    - Testar fluxo completo de criação de conta Evolution
    - Testar conexão via QR code
    - Testar envio de mensagem
    - Testar recepção de webhook

- [ ] 11. Adicionar configurações e variáveis de ambiente
  - [ ] 11.1 Atualizar config/services.php
    - Adicionar seção 'evolution' com configurações
    - webhook_secret, default_timeout, retry_attempts, retry_delay
    - _Requirements: 5.2, 11.4_
  
  - [ ] 11.2 Documentar variáveis de ambiente no .env.example
    - EVOLUTION_WEBHOOK_SECRET
    - EVOLUTION_TIMEOUT
    - EVOLUTION_RETRY_ATTEMPTS
    - EVOLUTION_RETRY_DELAY
    - _Requirements: 5.2_
  
  - [ ] 11.3 Criar comando artisan para gerar webhook secret
    - php artisan evolution:generate-webhook-secret
    - Gerar string aleatória segura
    - Atualizar .env automaticamente
    - _Requirements: 9.3_

- [ ] 12. Implementar sistema de retry para mensagens falhadas
  - [ ] 12.1 Criar job RetryEvolutionMessage
    - Implementar job com backoff exponencial
    - Configurar delays: 1s, 2s, 4s
    - Limitar a 3 tentativas
    - _Requirements: 11.4_
  
  - [ ] 12.2 Modificar sendEvolutionMessage para usar retry job
    - Ao falhar, despachar RetryEvolutionMessage job
    - Passar tentativa atual como parâmetro
    - _Requirements: 11.4_
  
  - [ ] 12.3 Implementar notificação após falhas múltiplas
    - Após 3 falhas, enviar notificação ao tenant
    - Suportar email e notificação in-app
    - Incluir detalhes do erro na notificação
    - _Requirements: 11.5_
  
  - [ ]* 12.4 Escrever teste de propriedade para retry
    - **Property 28: Retry com Backoff Exponencial**
    - **Validates: Requirements 11.4**
    - Simular falhas de envio
    - Verificar que jobs de retry são criados
    - Verificar delays crescentes

- [ ] 13. Implementar logging e observabilidade
  - [ ] 13.1 Criar LogEvolutionRequest middleware/listener
    - Registrar URL, método, instance_id, timestamp
    - Registrar headers (exceto credenciais)
    - _Requirements: 10.1_
  
  - [ ] 13.2 Criar LogEvolutionResponse middleware/listener
    - Registrar código de status HTTP
    - Registrar tempo de resposta em millisegundos
    - Registrar corpo da resposta (truncado se grande)
    - _Requirements: 10.2_
  
  - [ ] 13.3 Implementar alertas de performance
    - Detectar respostas > 5000ms
    - Registrar alerta com detalhes da requisição
    - _Requirements: 10.5_
  
  - [ ] 13.4 Implementar métricas por tipo de API
    - Criar tabela ou cache para métricas
    - Rastrear taxa de sucesso/falha por api_type
    - Separar métricas Meta vs Evolution
    - _Requirements: 10.4_
  
  - [ ]* 13.5 Escrever testes de propriedade para logging
    - **Property 10: Logging de Erros com Contexto**
    - **Validates: Requirements 4.5, 8.5, 10.3**
    - Simular erros aleatórios
    - Verificar que logs contêm api_type, instance_id, timestamp
    - **Property 20: API Key Não Exposta em Logs**
    - **Validates: Requirements 9.2**
    - Verificar que logs não contêm api_key descriptografada

- [ ] 14. Criar factories para testes
  - [ ] 14.1 Atualizar WhatsappAccountFactory
    - Adicionar state evolution() com campos Evolution
    - Adicionar state meta() com campos Meta
    - Gerar valores aleatórios realistas
    - _Requirements: Testing_
  
  - [ ] 14.2 Criar seeders para desenvolvimento
    - Criar contas de exemplo de ambos os tipos
    - Popular com dados realistas
    - _Requirements: Testing_

- [ ] 15. Escrever testes de integração end-to-end
  - [ ]* 15.1 Testar fluxo completo de conta Evolution
    - Criar conta Evolution
    - Solicitar QR code
    - Simular webhook de conexão
    - Enviar mensagem de teste
    - Verificar que mensagem foi enviada
    - _Requirements: 2.3, 3.1, 3.4, 4.1_
  
  - [ ]* 15.2 Testar compatibilidade retroativa
    - **Property 31: Compatibilidade Retroativa de Contas Meta**
    - **Validates: Requirements 12.4**
    - Criar contas Meta antes da migration
    - Executar migration
    - Verificar que contas Meta continuam funcionando
  
  - [ ]* 15.3 Testar coexistência de APIs
    - Criar tenant com contas de ambos os tipos
    - Enviar mensagens através de cada conta
    - Verificar que não há interferência
    - _Requirements: 8.4_

- [ ] 16. Documentação e finalização
  - [ ] 16.1 Criar documentação de API
    - Documentar endpoints Evolution
    - Incluir exemplos de requisição/resposta
    - Documentar códigos de erro
    - _Requirements: All_
  
  - [ ] 16.2 Criar guia de migração
    - Documentar processo de migration
    - Incluir checklist de verificação
    - Documentar rollback se necessário
    - _Requirements: 12.1, 12.3_
  
  - [ ] 16.3 Atualizar README do projeto
    - Adicionar seção sobre Evolution API
    - Documentar configuração necessária
    - Incluir troubleshooting comum
    - _Requirements: All_

- [ ] 17. Checkpoint final - Validação completa
  - Executar todos os testes (unitários, propriedade, integração)
  - Verificar cobertura de código (mínimo 80%)
  - Validar que todas as 32 propriedades têm testes
  - Executar migration em ambiente de staging
  - Perguntar ao usuário se está pronto para deploy

## Notas

- Tasks marcadas com `*` são opcionais e focam em testes
- Cada task referencia os requisitos específicos que implementa
- Checkpoints permitem validação incremental com o usuário
- Property-based tests devem executar mínimo 100 iterações cada
- Manter compatibilidade retroativa com contas Meta existentes é crítico
