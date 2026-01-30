# Documento de Requisitos - Integração Evolution API

## Introdução

O FlowMkt é uma plataforma SaaS baseada em Laravel que atualmente utiliza a API oficial do WhatsApp da Meta. Esta especificação define os requisitos para adicionar suporte à Evolution API (API não oficial do WhatsApp) como uma alternativa paralela e de baixo custo, mantendo a integração existente com a Meta API.

A Evolution API permitirá que os clientes do FlowMkt reduzam custos operacionais enquanto mantêm funcionalidades essenciais de mensageria. O sistema deve suportar ambas as APIs de forma transparente, com controle unificado de limites por plano.

## Glossário

- **Sistema**: A plataforma FlowMkt
- **Meta_API**: API oficial do WhatsApp fornecida pela Meta (Facebook)
- **Evolution_API**: API não oficial do WhatsApp baseada em WhatsApp Web
- **Conta_WhatsApp**: Registro de uma conexão do WhatsApp no sistema (pode ser Meta ou Evolution)
- **Tenant**: Cliente/usuário da plataforma SaaS
- **Plano**: Configuração de limites e recursos disponíveis para um tenant
- **Instância**: Sessão individual do WhatsApp na Evolution API
- **QR_Code**: Código QR usado para autenticar uma instância do WhatsApp
- **Connection_Status**: Estado atual da conexão de uma conta (connected, disconnected, qr_code_needed)
- **Roteador_API**: Componente que direciona requisições para a API apropriada baseado no tipo
- **WhatsappManager**: Trait responsável pelo envio de mensagens
- **EvolutionManager**: Trait responsável pela comunicação com a Evolution API
- **WhatsappAccountManager**: Trait responsável pelo gerenciamento do ciclo de vida das contas

## Requisitos

### Requisito 1: Controle Unificado de Limites de Contas

**User Story:** Como administrador do sistema, eu quero que o limite de contas WhatsApp definido no plano se aplique a qualquer tipo de API (Meta ou Evolution), para manter a monetização consistente da plataforma SaaS.

#### Acceptance Criteria

1. WHEN um tenant tenta adicionar uma nova conta WhatsApp, THE Sistema SHALL verificar o limite total de contas (`account_limit`) do plano independentemente do tipo de API
2. WHEN o número total de contas (Meta + Evolution) atinge o `account_limit` do plano, THE Sistema SHALL rejeitar tentativas de adicionar novas contas de qualquer tipo
3. WHEN uma conta é removida, THE Sistema SHALL decrementar o contador de contas utilizadas e permitir a adição de novas contas até o limite
4. THE Sistema SHALL retornar uma mensagem de erro clara indicando que o limite do plano foi atingido quando uma tentativa de adição falhar

### Requisito 2: Adição de Contas Evolution API

**User Story:** Como tenant, eu quero adicionar uma nova conta WhatsApp usando credenciais da Evolution API (Instance ID, API URL, API Key), para ter uma alternativa de baixo custo à Meta API.

#### Acceptance Criteria

1. WHEN um tenant acessa a interface de adicionar conta, THE Sistema SHALL exibir opções para selecionar entre Meta API e Evolution API
2. WHERE Evolution API é selecionada, THE Sistema SHALL solicitar os campos obrigatórios: Instance ID, API URL e API Key
3. WHEN o tenant submete o formulário com credenciais Evolution API válidas, THE Sistema SHALL criar um registro em `whatsapp_accounts` com `api_type` = 'evolution'
4. WHEN o tenant submete o formulário com campos obrigatórios vazios, THE Sistema SHALL retornar erros de validação específicos para cada campo
5. THE Sistema SHALL armazenar a `api_key` de forma criptografada no banco de dados
6. WHEN uma conta Evolution é criada com sucesso, THE Sistema SHALL definir `connection_status` como 'qr_code_needed'

### Requisito 3: Conexão e Autenticação via QR Code

**User Story:** Como tenant, eu quero visualizar o QR Code para conectar minha conta Evolution API e ver o status de conexão atualizado em tempo real, para completar a autenticação do WhatsApp.

#### Acceptance Criteria

1. WHEN um tenant acessa os detalhes de uma conta Evolution com status 'qr_code_needed', THE Sistema SHALL solicitar o QR Code à Evolution API
2. WHEN a Evolution API retorna o QR Code, THE Sistema SHALL armazenar os dados em `qr_code_data` e exibir o código na interface
3. WHEN o tenant escaneia o QR Code com o WhatsApp, THE Sistema SHALL receber notificação da Evolution API via webhook
4. WHEN a conexão é estabelecida, THE Sistema SHALL atualizar `connection_status` para 'connected' e limpar `qr_code_data`
5. WHEN a conexão falha ou expira, THE Sistema SHALL atualizar `connection_status` para 'disconnected'
6. THE Sistema SHALL fornecer um endpoint para verificar o status atual da conexão sob demanda

### Requisito 4: Roteamento de Envio de Mensagens

**User Story:** Como tenant, eu quero que mensagens enviadas através de uma conta Evolution API utilizem a lógica de comunicação correta para essa API, para garantir entrega bem-sucedida.

#### Acceptance Criteria

1. WHEN uma mensagem é disparada para uma conta com `api_type` = 'evolution', THE Sistema SHALL rotear a requisição para o EvolutionManager
2. WHEN uma mensagem é disparada para uma conta com `api_type` = 'meta', THE Sistema SHALL rotear a requisição para a lógica existente da Meta API
3. WHEN o EvolutionManager envia uma mensagem, THE Sistema SHALL usar o `api_url`, `instance_id` e `api_key` da conta
4. WHEN o envio via Evolution API é bem-sucedido, THE Sistema SHALL retornar uma resposta de sucesso com dados da mensagem
5. WHEN o envio via Evolution API falha, THE Sistema SHALL registrar o erro com `instance_id` e `api_type` para diagnóstico
6. THE Sistema SHALL manter a mesma interface de envio independentemente do tipo de API

### Requisito 5: Recepção de Mensagens e Webhooks

**User Story:** Como tenant, eu quero receber mensagens e atualizações de status da Evolution API através de webhooks, para manter sincronização em tempo real.

#### Acceptance Criteria

1. THE Sistema SHALL expor um endpoint público `/api/whatsapp/webhook/evolution` para receber eventos da Evolution API
2. WHEN um webhook da Evolution API é recebido, THE Sistema SHALL validar a autenticidade usando uma chave secreta
3. WHEN um evento de mensagem recebida chega via webhook, THE Sistema SHALL processar a mensagem e associá-la à conta correta usando `instance_id`
4. WHEN um evento de mudança de status chega via webhook, THE Sistema SHALL atualizar o `connection_status` da conta correspondente
5. WHEN um webhook contém dados inválidos ou malformados, THE Sistema SHALL registrar o erro e retornar código HTTP 400
6. THE Sistema SHALL responder aos webhooks com código HTTP 200 para confirmar recebimento

### Requisito 6: Gerenciamento do Ciclo de Vida das Contas

**User Story:** Como tenant, eu quero gerenciar o ciclo de vida completo das minhas contas Evolution API (criar, conectar, desconectar, remover), para ter controle total sobre minhas integrações.

#### Acceptance Criteria

1. WHEN um tenant solicita desconexão de uma conta Evolution, THE Sistema SHALL enviar comando de logout à Evolution API e atualizar `connection_status` para 'disconnected'
2. WHEN um tenant remove uma conta Evolution, THE Sistema SHALL deletar o registro do banco de dados e liberar o slot no `account_limit`
3. WHEN um tenant solicita reconexão de uma conta desconectada, THE Sistema SHALL gerar novo QR Code e atualizar `connection_status` para 'qr_code_needed'
4. WHEN uma conta Evolution perde conexão inesperadamente, THE Sistema SHALL detectar via webhook e atualizar o status automaticamente
5. THE Sistema SHALL permitir edição dos campos `api_url` e `api_key` de uma conta Evolution existente
6. WHEN credenciais são atualizadas, THE Sistema SHALL validar a conectividade antes de salvar as alterações

### Requisito 7: Envio de Mensagens de Teste e Boas-Vindas

**User Story:** Como tenant, eu quero enviar mensagens de teste e boas-vindas através de contas Evolution API, para verificar que a integração está funcionando corretamente.

#### Acceptance Criteria

1. WHEN um tenant solicita envio de mensagem de teste para uma conta Evolution, THE Sistema SHALL rotear através do EvolutionManager
2. WHEN uma conta Evolution é conectada com sucesso, THE Sistema SHALL enviar automaticamente uma mensagem de boas-vindas se configurado
3. WHEN o envio de mensagem de teste é bem-sucedido, THE Sistema SHALL exibir confirmação visual ao tenant
4. WHEN o envio de mensagem de teste falha, THE Sistema SHALL exibir mensagem de erro detalhada ao tenant
5. THE Sistema SHALL usar o mesmo formato de mensagem para testes independentemente do tipo de API
6. WHEN uma mensagem de boas-vindas é enviada, THE Sistema SHALL registrar o evento no log de atividades da conta

### Requisito 8: Separação e Coexistência de APIs

**User Story:** Como desenvolvedor do sistema, eu quero que a lógica da Meta API e da Evolution API seja estritamente separada em componentes distintos, para facilitar manutenção e extensibilidade.

#### Acceptance Criteria

1. THE Sistema SHALL implementar toda lógica de comunicação com Evolution API no trait EvolutionManager
2. THE Sistema SHALL manter toda lógica existente da Meta API isolada e inalterada
3. WHEN o WhatsappManager precisa enviar mensagens, THE Sistema SHALL usar o padrão Strategy para selecionar o gerenciador apropriado
4. THE Sistema SHALL permitir que contas Meta e Evolution coexistam no mesmo tenant sem interferência
5. WHEN erros ocorrem, THE Sistema SHALL incluir `api_type` nos logs para facilitar diagnóstico
6. THE Sistema SHALL garantir que alterações na lógica de uma API não afetem a outra

### Requisito 9: Segurança e Criptografia de Credenciais

**User Story:** Como administrador de segurança, eu quero que todas as credenciais sensíveis da Evolution API sejam armazenadas de forma segura, para proteger contra acessos não autorizados.

#### Acceptance Criteria

1. WHEN uma `api_key` da Evolution API é salva, THE Sistema SHALL criptografá-la usando o sistema de criptografia do Laravel
2. WHEN uma `api_key` precisa ser usada, THE Sistema SHALL descriptografá-la em memória sem expô-la em logs
3. THE Sistema SHALL validar que webhooks da Evolution API incluem uma chave secreta válida antes de processar
4. WHEN credenciais são exibidas na interface, THE Sistema SHALL mascarar a `api_key` mostrando apenas os últimos 4 caracteres
5. THE Sistema SHALL implementar rate limiting nos endpoints de webhook para prevenir abuso
6. WHEN tentativas de acesso não autorizado são detectadas, THE Sistema SHALL registrar o evento e bloquear o IP temporariamente

### Requisito 10: Observabilidade e Diagnóstico

**User Story:** Como desenvolvedor de suporte, eu quero ter visibilidade completa das operações da Evolution API através de logs estruturados, para diagnosticar problemas rapidamente.

#### Acceptance Criteria

1. WHEN uma requisição é enviada à Evolution API, THE Sistema SHALL registrar a URL, método, `instance_id` e timestamp
2. WHEN uma resposta é recebida da Evolution API, THE Sistema SHALL registrar o código de status, tempo de resposta e corpo da resposta
3. WHEN um erro ocorre na comunicação com Evolution API, THE Sistema SHALL registrar o erro com contexto completo incluindo `api_type` e `instance_id`
4. THE Sistema SHALL manter métricas de taxa de sucesso/falha separadas por tipo de API
5. WHEN o tempo de resposta da Evolution API excede 5 segundos, THE Sistema SHALL registrar um alerta de performance
6. THE Sistema SHALL fornecer um dashboard com estatísticas de uso por tipo de API

### Requisito 11: Validação e Tratamento de Erros

**User Story:** Como tenant, eu quero receber mensagens de erro claras e acionáveis quando problemas ocorrem com minha conta Evolution API, para poder resolver rapidamente.

#### Acceptance Criteria

1. WHEN a Evolution API retorna erro 401 (não autorizado), THE Sistema SHALL informar que a `api_key` é inválida
2. WHEN a Evolution API retorna erro 404 (não encontrado), THE Sistema SHALL informar que o `instance_id` não existe
3. WHEN a Evolution API está inacessível, THE Sistema SHALL informar que o servidor não está respondendo e sugerir verificar a `api_url`
4. WHEN uma mensagem falha ao enviar, THE Sistema SHALL armazenar na fila de retry com backoff exponencial
5. WHEN múltiplas tentativas de envio falham, THE Sistema SHALL notificar o tenant via email ou notificação in-app
6. THE Sistema SHALL validar formato de `api_url` (deve ser URL válida) e `instance_id` (não vazio) antes de salvar

### Requisito 12: Migração de Dados e Compatibilidade

**User Story:** Como administrador do sistema, eu quero que contas WhatsApp existentes continuem funcionando após a implementação da Evolution API, para garantir zero downtime.

#### Acceptance Criteria

1. WHEN a migration é executada, THE Sistema SHALL adicionar novos campos à tabela `whatsapp_accounts` sem afetar dados existentes
2. WHEN contas existentes não têm `api_type` definido, THE Sistema SHALL assumir 'meta' como padrão
3. THE Sistema SHALL permitir rollback da migration sem perda de dados
4. WHEN a aplicação é atualizada, THE Sistema SHALL continuar processando mensagens de contas Meta sem interrupção
5. THE Sistema SHALL validar integridade dos dados após migration usando testes automatizados
6. WHEN novos campos são adicionados, THE Sistema SHALL definir valores padrão apropriados (NULL para campos Evolution)
