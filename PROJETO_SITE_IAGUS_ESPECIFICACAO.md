# Projeto do Site da IAGUS (Igreja Anglicana de Garanhuns) — Especificação Completa (MVP + Pagamentos Mercado Pago)

**Objetivo:** publicar um site moderno, rápido e seguro (hospedagem compartilhada HostGator/cPanel), onde visitantes conhecem a igreja, visualizam eventos e realizam inscrições; inscritos acessam uma área para acompanhar suas inscrições; e um responsável (admin) gerencia eventos, inscritos e pagamentos (via Mercado Pago).

> **Foco do projeto:** simplicidade + confiabilidade + conversão (visita presencial) + gestão eficiente de eventos.

---

## 1) Visão do produto

### 1.1 Público-alvo
- Visitantes que querem conhecer a igreja (primeira visita, curiosos, pessoas voltando à fé).
- Membros e participantes que se inscrevem em eventos (retiros, encontros, cursos, conferências).
- Jovens e famílias (com linguagem acolhedora, sem “parecer burocrático”).

### 1.2 Proposta de valor (mensagem do site)
- **Acolhimento:** “Uma família para pertencer”.
- **Clareza:** “Veja horários, eventos e como participar”.
- **Facilidade:** inscrição rápida e pagamento simples (quando pago).
- **Confiança:** transparência e segurança.

---

## 2) Escopo funcional (MVP)

### 2.1 Área pública (sem login)
**Páginas**
1. **Home** (convite + próximos passos)
2. **Conheça a Igreja** (história e identidade em linguagem simples)
3. **Cultos e Agenda** (horários fixos + calendário/lista)
4. **Eventos** (lista + detalhes)
5. **Juventude / Ministérios** (convite e formas de participar)
6. **Contato** (WhatsApp, mapa, redes)

**Componentes essenciais**
- CTA fixo no topo: **“Quero visitar”** e **“Ver eventos”**
- Sessão “O que esperar na sua visita”
- Sessão “Próximos eventos” (cards)

### 2.2 Inscrições em eventos
- Evento pode ser:
  - **Gratuito** (confirmação imediata)
  - **Pago** (cria pagamento Mercado Pago e acompanha status via Webhook)
- Vagas (opcional): limite e bloqueio quando lotado
- Inscrição com validação + confirmação por e-mail
- Regras:
  - Evitar inscrições duplicadas (mesmo e-mail + mesmo evento)
  - Prazo de inscrição (abre/fecha)

### 2.3 Área do inscrito (login)
- Login por e-mail + senha
- “Minhas inscrições”
- Detalhes da inscrição:
  - status (pendente/pago/cancelado)
  - instruções do evento (o que levar, horário etc.)
  - link do pagamento (se aplicável)

### 2.4 Painel do responsável (admin)
- Dashboard por evento:
  - inscritos total
  - pagos / pendentes
  - taxa de conversão (pagos ÷ inscritos)
- Lista de inscrições com filtros:
  - evento / status / nome / e-mail / data
- Gestão de eventos (CRUD)
- Exportar CSV (inscritos do evento)
- Ferramenta de suporte:
  - reenviar e-mail de confirmação
  - cancelar inscrição (com registro)

---

## 3) Integração de Pagamentos — Mercado Pago (pagos)

### 3.1 Estratégia recomendada (segura e simples)
**Checkout Pro**: você cria uma “preferência” no servidor e redireciona o usuário para pagar no Mercado Pago.  
- Vantagens: menor risco (sem lidar diretamente com dados sensíveis), fluxo bem testado, fácil de operar.
- Confirmação real do pagamento deve vir por **Webhooks** (não confiar apenas no “retorno do navegador”).

### 3.2 Fluxo de pagamento (alto nível)
1. Usuário escolhe evento pago → clica “Inscrever-se”.
2. Sistema cria a inscrição com status `pending_payment`.
3. Sistema cria uma **preferência de pagamento** no Mercado Pago vinculada à inscrição.
4. Usuário é redirecionado para o checkout do Mercado Pago.
5. Mercado Pago envia **Webhook** quando o status do pagamento muda.
6. Seu sistema consulta/verifica o pagamento e atualiza:
   - inscrição: `paid`
   - pagamento: `approved`
7. Usuário vê na área “Minhas inscrições” que está **Pago**.

### 3.3 Webhooks (obrigatório em produção)
- Configure um endpoint no seu site para receber Webhooks.
- Valide assinatura/segredo do Webhook para evitar fraude.
- A aplicação deve responder rápido (HTTP 200) e processar a atualização com segurança.

### 3.4 Status de pagamento (o que salvar e como interpretar)
Armazenar pelo menos:
- `payment_id` / referência
- `status` (ex.: `approved`, `pending`, `rejected`, `refunded`, etc.)
- `status_detail`
- valor, método, timestamps
- `external_reference` (o seu ID de inscrição)

Atualizações mais comuns:
- **approved** → marcar inscrição como `paid`
- **pending / in_process** → manter `pending_payment`
- **rejected / cancelled** → `payment_failed` e permitir tentar de novo
- **refunded / charged_back** → tratar com cuidado (reverter acesso, registrar auditoria)

> Importante: sempre trate o pagamento como “confirmado” apenas via Webhook/consulta de status, não por redirecionamento.

### 3.5 Política de reembolso/cancelamento (sistema)
- MVP: admin registra manualmente (e, se necessário, executa reembolso no painel do Mercado Pago).
- Evolução: endpoint/admin para iniciar cancelamento/reembolso via API (quando permitido pelo status).

---

## 4) Requisitos não-funcionais (segurança, performance, manutenção)

### 4.1 Segurança mínima
- HTTPS obrigatório (redirect HTTP → HTTPS)
- CSRF em formulários
- Rate limit para login e formulários de inscrição
- Validação no servidor (sempre)
- Proteção anti-spam (honeypot + opcional reCAPTCHA quando necessário)
- Segredos em `.env` (fora do public_html)
- Logs sem dados sensíveis

### 4.2 LGPD (prática)
- Coletar **somente dados necessários** para o evento
- Consentimento explícito no formulário
- Política de privacidade / termos (página simples)
- Permitir exclusão/anônimização sob demanda (processo administrativo)

### 4.3 Performance
- Front leve (Tailwind + Blade)
- Cache de rotas/config/views
- Paginação no admin
- Índices no banco para consultas frequentes

### 4.4 Observabilidade
- Logs estruturados (erro + auditoria de ações admin)
- Registro de:
  - criação de inscrição
  - criação de pagamento
  - recebimento de webhook
  - mudança de status

---

## 5) Stack recomendada para HostGator (cPanel)

### 5.1 Opção principal (recomendada): Laravel + MySQL
- **Back-end:** PHP 8.2+ + Laravel
- **Front:** Blade + Tailwind (sem build complexo, rápido de publicar)
- **DB:** MySQL (padrão HostGator)
- **Env:** Composer no servidor ou build local + upload

> Por compatibilidade e segurança, manter PHP atualizado é essencial.

### 5.2 SDK do Mercado Pago (PHP)
- Usar o **SDK oficial PHP** (compatível com PHP 8.2+).
- Evitar pacotes abandonados/antigos no Packagist.
- Instalação por Composer.

---

## 6) Estrutura de dados (banco)

### 6.1 Tabelas principais
**users**
- id
- name
- email (unique)
- phone (nullable)
- password_hash
- role (`user`, `admin`)
- created_at, updated_at

**events**
- id
- title
- slug (unique)
- description (text/HTML sanitizado)
- start_at (datetime)
- end_at (nullable)
- location_name
- location_address
- capacity (nullable)
- price_cents (0 para gratuito)
- currency (`BRL`)
- registration_open_at (nullable)
- registration_close_at (nullable)
- status (`draft`, `published`, `closed`)
- created_at, updated_at

**registrations**
- id
- user_id
- event_id
- code (unique, ex.: `IAGUS-2026-000123`)
- status (`registered`, `pending_payment`, `paid`, `cancelled`, `refunded`)
- notes (nullable)
- created_at, updated_at
- unique (user_id, event_id) para evitar duplicidade

**payments**
- id
- registration_id
- provider (`mercadopago`)
- mp_preference_id (nullable)
- mp_payment_id (nullable)
- external_reference (string) = registration code/id
- amount_cents
- currency
- status (`created`, `pending`, `approved`, `rejected`, `cancelled`, `refunded`, `charged_back`)
- status_detail (nullable)
- payload_json (nullable, para auditoria mínima)
- created_at, updated_at

**webhook_events** (recomendado)
- id
- provider
- event_type
- request_id/header_id (nullable)
- received_at
- payload_json
- processed_at (nullable)
- processing_status (`received`, `processed`, `failed`)
- error_message (nullable)

> Essa tabela de webhook evita “perder” eventos e facilita auditoria e reprocessamento.

---

## 7) Rotas e endpoints (proposta)

### 7.1 Público
- `GET /` Home
- `GET /conheca` Sobre
- `GET /cultos` Cultos e agenda
- `GET /eventos` Lista de eventos
- `GET /eventos/{slug}` Detalhe do evento
- `GET /contato` Contato

### 7.2 Autenticação
- `GET /entrar` / `POST /entrar`
- `POST /sair`
- `GET /cadastrar` / `POST /cadastrar`
- `GET /recuperar-senha` (opcional no MVP)

### 7.3 Inscrições
- `POST /eventos/{id}/inscrever`
- `GET /minha-conta` (dashboard)
- `GET /minha-conta/inscricoes`
- `GET /minha-conta/inscricoes/{code}`

### 7.4 Pagamentos
- `POST /pagamentos/mercadopago/preference` (criar preferência para uma inscrição)
- `GET /pagamentos/retorno` (landing page; não confirma pagamento)
- `POST /webhooks/mercadopago` (recebe notificações; confirma via consulta/status)

### 7.5 Admin (prefixo + middleware role=admin)
- `GET /admin` dashboard
- `GET /admin/eventos` list
- `POST /admin/eventos` create
- `PUT /admin/eventos/{id}` update
- `DELETE /admin/eventos/{id}` delete (ou soft delete)
- `GET /admin/eventos/{id}/inscritos`
- `GET /admin/inscricoes` (filtros)
- `POST /admin/inscricoes/{id}/cancelar`
- `GET /admin/export/evento/{id}.csv`

---

## 8) Implementação do Mercado Pago — detalhes práticos

### 8.1 Credenciais e ambiente
- Usar credenciais de **teste** no desenvolvimento e **produção** no deploy.
- Salvar em `.env`:
  - `MP_ACCESS_TOKEN`
  - `MP_WEBHOOK_SECRET` (se aplicável)
  - `MP_NOTIFICATION_URL`
  - `APP_URL` (domínio final)

### 8.2 Criação de preferência (Checkout Pro)
Ao criar preferência, enviar:
- item: nome do evento, descrição curta, valor
- `external_reference`: código/id da inscrição
- URLs:
  - `success`, `failure`, `pending` (para UX)
- `notification_url`: seu endpoint de webhook

### 8.3 Webhook: regras de ouro
- Validar assinatura/segredo (se habilitado no MP).
- Não confiar em dados “crus” do POST: use o payload para identificar recurso e **consultar** o pagamento.
- Tornar idempotente:
  - mesma notificação pode chegar mais de uma vez
  - o processamento deve ser seguro para reexecução
- Registrar em `webhook_events`.

### 8.4 Reprocessamento de webhook (robustez)
- Se `processing_status=failed`, permitir reprocessar via admin (botão “reprocessar”).
- Se HostGator limitar execução longa, processar rápido e, se necessário:
  - gravar em fila (DB queue)
  - cron rodando a cada 1-5 min para processar fila

---

## 9) Conteúdo do site (copys prontos e estrutura)

### 9.1 Home (modelo)
**Hero**
- Título: “Uma família para pertencer.”
- Subtítulo: “Conheça a IAGUS e participe dos nossos cultos e eventos em Garanhuns.”
- Botões: “Quero visitar” | “Ver próximos eventos”

**O que esperar na sua visita**
- Recepção e acolhimento
- Louvor e oração
- Mensagem bíblica
- Ambiente para famílias e jovens

**Próximos eventos**
- Cards com data, título, vagas e botão “Detalhes”

**Juventude**
- “Um lugar seguro para pertencer, crescer e servir.”
- Botão: “Falar com a juventude” (WhatsApp)

### 9.2 Página “Conheça a Igreja”
Seções:
- Quem somos
- Missão e valores
- Como funcionam cultos e encontros
- Convite: “Venha como você está”

### 9.3 Página “Juventude”
- Encontros (dia/horário)
- Grupos e discipulado
- Voluntariado
- “Se você está recomeçando, buscando fé ou só quer conversar: você é bem-vindo.”

---

## 10) SEO e atração local (Garanhuns)
- Títulos e descrições com termos locais:
  - “Igreja em Garanhuns”
  - “Culto em Garanhuns”
  - “Encontro de jovens em Garanhuns”
- Schema básico:
  - LocalBusiness/Organization
  - Event para páginas de eventos
- Google Business Profile (fora do site, mas recomendado)
- Página de contato com mapa e “Como chegar”

---

## 11) Deploy na HostGator (checklist)

### 11.1 Pré-requisitos
- PHP 8.2+ habilitado no domínio
- Extensões comuns (openssl, mbstring, pdo_mysql etc.)
- MySQL criado (usuário e senha)
- SSL ativo (AutoSSL/cPanel)

### 11.2 Estratégia de deploy (Laravel em hospedagem compartilhada)
- `public_html/` contém apenas o conteúdo do diretório `public/` do Laravel
- o restante do projeto fica fora de `public_html` (ex.: `/home/USER/laravel_app`)
- `public_html/index.php` aponta para o bootstrap do app
- Configurar permissões para `storage/` e `bootstrap/cache/`

### 11.3 Pós-deploy
- `APP_ENV=production`
- `APP_DEBUG=false`
- `php artisan migrate --force`
- `php artisan config:cache`
- `php artisan route:cache`
- `php artisan view:cache`

### 11.4 Backups
- Backup diário do MySQL
- Backup semanal de arquivos (storage/uploads)
- Testar restore pelo menos 1x

---

## 12) Plano de execução (etapas e entregáveis)

### Etapa A — Blueprint (1 dia)
**Entregáveis**
- Mapa do site
- Modelagem do banco final
- Wireframe (Home + Eventos + Login + Admin)

### Etapa B — MVP funcional (3–7 dias)
**Entregáveis**
- Site público completo
- Eventos (CRUD admin)
- Inscrição + área do inscrito
- Mercado Pago: Checkout Pro + Webhook + atualização de status
- Export CSV

### Etapa C — Hardening (2–3 dias)
**Entregáveis**
- Rate limit, logs, auditoria
- Idempotência de webhook
- Melhorias de UX (mensagens, e-mails, layout responsivo)
- Política de privacidade + termos

### Etapa D — Evoluções (backlog)
- Check-in com QR Code
- Lista de presença
- Reembolso/cancelamento via API (quando aplicável)
- Notificações WhatsApp (opcional)

---

## 13) Critérios de aceitação (para dizer “está pronto”)

### Público
- [ ] Home carrega rápido no celular
- [ ] Eventos listam e exibem detalhes
- [ ] Formulário de inscrição valida e confirma no e-mail

### Inscrito
- [ ] Login funciona
- [ ] “Minhas inscrições” mostra status correto
- [ ] Para evento pago: o usuário consegue pagar via Mercado Pago

### Admin
- [ ] Admin vê inscritos por evento
- [ ] Admin filtra por status e exporta CSV
- [ ] Pagamento aprovado via webhook altera status automaticamente

### Segurança
- [ ] HTTPS obrigatório
- [ ] APP_DEBUG desativado
- [ ] Segredos em `.env` fora do público
- [ ] Endpoint de webhook valida autenticidade e é idempotente

---

## 14) Referências técnicas (URLs em bloco de código)
> Observação: coloquei os links aqui somente como referência técnica para implementação e verificação.

### Mercado Pago — Webhooks/Notificações/Checkout
```text
https://www.mercadopago.com.br/developers/en/docs/your-integrations/notifications/webhooks
https://www.mercadopago.com.br/developers/pt/docs/checkout-pro/additional-content/notifications/webhooks
https://www.mercadopago.com.br/developers/en/docs/checkout-pro/overview
https://www.mercadopago.com.br/developers/en/docs/checkout-api-payments/response-handling/query-results
```

### SDK PHP oficial
```text
https://github.com/mercadopago/sdk-php
```

### HostGator — PHP (versões e configuração)
```text
https://suporte.hostgator.com.br/hc/pt-br/articles/30807998885395-Como-alterar-a-vers%C3%A3o-do-PHP-na-hospedagem
https://suporte.hostgator.com.br/hc/pt-br/articles/30811513908115-Quais-as-vers%C3%B5es-PHP-descontinuadas-na-HostGator
```

---

## 15) Próximas decisões rápidas (para fechar o blueprint)
Para o projeto sair perfeito sem retrabalho, defina:
1. **Campos da inscrição** (mínimo recomendado: nome, e-mail, telefone; extras só se necessário)
2. **Capacidade e lista de espera** (vai existir? sim/não)
3. **Comprovantes** (precisa PDF/QR no MVP? geralmente pode ficar para fase 2)
4. **Tipos de evento** (retiro/encontro/curso) para categorias e filtros

---

**Fim do documento.**
