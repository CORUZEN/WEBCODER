# IAGUS — Instruções do Projeto

> **Igreja Anglicana de Garanhuns**  
> Sistema de gerenciamento de eventos com pagamento online  
> Desenvolvido por [Coruzen](https://coruzen.com)

---

## Índice

1. [Visão Geral](#1-visão-geral)
2. [Stack Tecnológico](#2-stack-tecnológico)
3. [Ambientes](#3-ambientes)
4. [Estrutura do Projeto](#4-estrutura-do-projeto)
5. [Como Iniciar o Desenvolvimento](#5-como-iniciar-o-desenvolvimento)
6. [Fluxo de Deploy](#6-fluxo-de-deploy)
7. [Regras do Git](#7-regras-do-git)
8. [Erros Conhecidos e Como Evitar](#8-erros-conhecidos-e-como-evitar)
9. [Banco de Dados](#9-banco-de-dados)
10. [Pagamentos — Mercado Pago](#10-pagamentos--mercado-pago)
11. [Painel Admin](#11-painel-admin)
12. [Rotas do Sistema](#12-rotas-do-sistema)
13. [Design System](#13-design-system)
14. [O Que Falta Desenvolver](#14-o-que-falta-desenvolver)
15. [Boas Práticas para Este Projeto](#15-boas-práticas-para-este-projeto)

---

## 1. Visão Geral

O IAGUS é um sistema web para a Igreja Anglicana de Garanhuns (PE) com os seguintes objetivos:

- Divulgação de eventos da igreja
- Inscrição de membros e visitantes nos eventos
- Cobrança online via Mercado Pago (PIX, cartão)
- Painel administrativo para gestão de eventos e inscrições
- Área do usuário para acompanhamento de inscrições

**URL de produção:** https://iagus.com.br  
**URL local:** http://localhost:3001

---

## 2. Stack Tecnológico

| Componente        | Versão / Tecnologia                     |
|-------------------|-----------------------------------------|
| Framework         | Laravel 11                              |
| PHP local         | 8.4 (via Laravel Herd)                  |
| PHP produção      | 8.3 (HostGator ea-php83)               |
| Banco local       | SQLite                                  |
| Banco produção    | MySQL (`abdonc73_iagus`)               |
| CSS               | Tailwind CSS + classes customizadas     |
| JS Build          | Vite                                    |
| Pagamento         | Mercado Pago SDK PHP                    |
| Servidor          | Apache (HostGator Shared Hosting)       |
| Deploy            | GitHub Actions + cPanel Git             |

---

## 3. Ambientes

### Local (Desenvolvimento)

```
APP_ENV=local
APP_URL=http://webcoder.test (ou localhost:3001)
DB_CONNECTION=sqlite
APP_DEBUG=true
```

**Iniciar:**
```bash
# Servidor Laravel
php artisan serve --port=3001

# Assets Vite (em outro terminal)
npm run dev
```

### Produção (HostGator)

```
APP_ENV=production
APP_URL=https://iagus.com.br
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=abdonc73_iagus
DB_USERNAME=abdonc73_iagus
DB_PASSWORD=WTDrzXteBxRL
APP_DEBUG=false
APP_KEY=base64:FxqtGWq4NE1o171bs2Dj99FlIM63IlZnVXqb65bAB2U=
```

**Importante:** O arquivo `.env` de produção está no servidor em `/home1/abdonc73/iagus.com.br/.env` e **NÃO está no Git** (está no `.gitignore`). Nunca commitar o `.env` com dados de produção.

---

## 4. Estrutura do Projeto

```
iagus/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # DashboardController, EventController, RegistrationController
│   │   │   ├── Auth/           # AuthController (login, register, logout)
│   │   │   ├── EventController.php         # Área pública de eventos
│   │   │   ├── HomeController.php          # Páginas estáticas
│   │   │   ├── PaymentController.php       # Checkout Mercado Pago
│   │   │   ├── RegistrationController.php  # Inscrições
│   │   │   ├── UserDashboardController.php # Área do usuário
│   │   │   └── WebhookController.php       # Webhook Mercado Pago
│   │   └── Middleware/
│   │       └── EnsureUserIsAdmin.php
│   └── Models/
│       ├── Event.php           # Evento com slots, preço, status
│       ├── Payment.php         # Pagamento vinculado à inscrição
│       ├── Registration.php    # Inscrição do usuário no evento
│       ├── User.php            # Usuário com campo is_admin
│       └── WebhookEvent.php    # Log de webhooks recebidos
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php       # Layout principal com navbar + footer
│   │   └── navbar.blade.php
│   │   └── footer.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── admin/                  # Views do painel admin
│   ├── events/                 # Listagem e detalhe de eventos
│   ├── user/                   # Dashboard do usuário
│   └── home/                   # Páginas do site (index, about, worship...)
├── routes/web.php
├── public/
│   ├── build/                  # Tailwind + JS compilados (gerado pelo Vite)
│   └── .htaccess               # Apache config (HTTPS, segurança, Laravel routing)
├── .cpanel.yml                 # Tarefas de deploy no servidor HostGator
└── .github/workflows/deploy.yml   # Pipeline GitHub Actions
```

---

## 5. Como Iniciar o Desenvolvimento

### Primeira vez

```bash
git clone https://github.com/CORUZEN/IAGUS.git
cd IAGUS
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

### Dia a dia

```bash
# Terminal 1 — servidor
php artisan serve --port=3001

# Terminal 2 — assets com hot reload
npm run dev
```

### Testar se está funcionando

- http://localhost:3001 → página inicial
- http://localhost:3001/entrar → login
- http://localhost:3001/admin → painel admin (requer usuário com `is_admin=true`)

---

## 6. Fluxo de Deploy

```
Desenvolvedor → git push origin main
                        ↓
              GitHub Actions (.github/workflows/deploy.yml)
                        ↓
     1. composer install --no-dev
     2. npm ci && npm run build
     3. git pull --rebase origin main
     4. git push vendor/ e public/build/ de volta ao GitHub
     5. cPanel API: pull do repositório
     6. cPanel executa .cpanel.yml:
              rsync repo → iagus.com.br/
              chmod corretos
              php artisan optimize:clear
              php artisan migrate --force
              php artisan storage:link
              php artisan optimize
```

### Servidor de produção (HostGator)

| Item | Valor |
|------|-------|
| Host | sh00180.hostgator.com.br |
| Usuário cPanel | abdonc73 |
| DocumentRoot | `/home1/abdonc73/iagus.com.br/public` |
| Repositório Git | `/home1/abdonc73/repositories/IAGUS` |
| PHP artisan | `/opt/cpanel/ea-php83/root/usr/bin/php` |

### Secrets necessários no GitHub

```
FTP_SERVER   = sh00180.hostgator.com.br
FTP_USERNAME = abdonc73
FTP_PASSWORD = (senha do cPanel)
```

---

## 7. Regras do Git

### Nunca commitar

- `.env` (qualquer ambiente)
- `storage/logs/*`
- `node_modules/`
- Arquivos de diagnóstico temporários (diagnostico.php, fix-servidor.php, etc.)

### Fluxo correto de push

```bash
git pull --rebase origin main   # SEMPRE antes de push
git add .
git commit -m "tipo: descrição clara"
git push origin main
```

### Tipos de commit (convenção)

| Prefixo | Uso |
|---------|-----|
| `feat:` | Nova funcionalidade |
| `fix:` | Correção de bug |
| `style:` | Mudanças de CSS/UI sem lógica |
| `refactor:` | Refatoração sem mudança de comportamento |
| `chore:` | Tarefas de manutenção (deps, build) |
| `docs:` | Atualização de documentação |

### Por que `--rebase` é obrigatório

O GitHub Actions faz commits automáticos de `vendor/` e `public/build/` no repositório. Se você fizer push localmente sem rebase, o Git cria commits de `Merge branch 'main'...` que bagunçam o histórico e podem atrasar ou duplicar deploys no cPanel.

---

## 8. Erros Conhecidos e Como Evitar

### ❌ Erro 403 no site após deploy

**Causa:** A pasta `iagus.com.br/` recebe permissão `0700` em vez de `0755` após rsync.  
**Solução:** Já corrigido no `.cpanel.yml` com `chmod 755 /home1/abdonc73/iagus.com.br`.  
**Se acontecer manualmente:** No cPanel → Gerenciador de Arquivo → selecionar pasta → Permissões → `0755`.

### ❌ Deploy não atualiza o site

**Causa 1:** O cPanel ainda está no commit antigo. O GitHub Actions cria um commit de assets e o cPanel pode ficar apontando para o commit anterior.  
**Solução:** Abrir cPanel → Git → "Atualizar do remoto" → "Implementar comprometimento de HEAD" manualmente.

**Causa 2:** Push local rejeitado com "non-fast-forward". O Actions commitou antes de você.  
**Solução:** `git pull --rebase origin main` primeiro.

### ❌ .htaccess sumindo após deploy

**Causa:** rsync com `--delete` apagava o `.htaccess` que não estava no Git.  
**Solução:** O `.htaccess` está agora commitado em `public/.htaccess`. Nunca adicionar `.htaccess` ao `.gitignore`.

### ❌ Assets CSS/JS não atualizando em produção

**Causa:** Tailwind não foi recompilado antes do deploy.  
**Solução:** O GitHub Actions compila automaticamente. Se precisar forçar: rodar o Actions manualmente via GitHub → Actions → "Run workflow".

### ❌ 500 Error em produção

**Causa mais comum:** `.env` de produção incorreto ou `APP_KEY` errada.  
**Verificar:** `storage/logs/laravel.log` no servidor.  
**Limpar cache:** `php artisan optimize:clear` via SSH ou terminal cPanel.

### ❌ Merge commits de "Merge branch 'main'..." no histórico

**Causa:** Push sem rebase quando o remote está à frente.  
**Solução:** Sempre usar `git pull --rebase origin main` antes de qualquer push.

### ❌ cPanel "The system cannot deploy"

**Causa:** Arquivos não commitados bloqueando o deploy (ex: `.env`, `.htaccess-BACKUP`).  
**Solução:** Remover ou commitar todos os arquivos modificados no repositório do servidor. O rsync resolve isso automaticamente nos próximos deploys.

---

## 9. Banco de Dados

### Migrations (ordem)

1. `create_users_tables` — Usuários com `is_admin` boolean
2. `create_events_table` — Eventos com slug, datas, capacidade, preço em centavos
3. `create_registrations_table` — Inscrições (user → event)
4. `create_payments_table` — Pagamentos via Mercado Pago
5. `create_webhook_events_table` — Log de webhooks

### Modelo Event — campos importantes

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `price_cents` | integer | Preço em centavos (R$50,00 = 5000) |
| `status` | enum | `draft`, `published`, `cancelled`, `finished` |
| `capacity` | integer | Vagas totais (null = ilimitado) |
| `slug` | string | URL amigável gerada automaticamente |
| `registration_open_at` | datetime | Abertura das inscrições |
| `registration_close_at` | datetime | Encerramento das inscrições |

### Seeders disponíveis

```bash
php artisan db:seed                    # Todos
php artisan db:seed --class=UserSeeder # Usuário admin padrão
```

---

## 10. Pagamentos — Mercado Pago

### Configuração necessária (`.env` de produção)

```env
MP_ACCESS_TOKEN=APP_USR-...
MP_PUBLIC_KEY=APP_USR-...
MP_WEBHOOK_SECRET=...
MP_NOTIFICATION_URL=https://iagus.com.br/webhooks/mercadopago
```

### Fluxo de pagamento

```
Usuário → se inscreve no evento
        → cria Registration (status: pending)
        → redirecionado para /pagamento/{code}
        → PaymentController cria preferência no Mercado Pago
        → usuário paga no Mercado Pago
        → Mercado Pago chama webhook POST /webhooks/mercadopago
        → WebhookController atualiza Registration (status: paid)
        → usuário recebe confirmação
```

### Webhook — Importante

- O endpoint `/webhooks/mercadopago` está **fora do CSRF** (necessário para receber callbacks externos)
- Tem throttle de 60 requisições/minuto como proteção
- Todos os eventos recebidos são logados em `webhook_events`

### Status de inscrição

| Status | Descrição |
|--------|-----------|
| `pending` | Aguardando pagamento |
| `paid` | Pago e confirmado |
| `cancelled` | Cancelado |
| `refunded` | Reembolsado |

---

## 11. Painel Admin

**URL:** `/admin`  
**Acesso:** Usuário com `is_admin = true` no banco

### Funcionalidades

- **Dashboard:** Resumo de eventos, inscrições, receita
- **Eventos:** CRUD completo + exportação de lista de inscritos
- **Inscrições:** Listagem global + cancelamento individual

### Como promover usuário a admin

```sql
UPDATE users SET is_admin = 1 WHERE email = 'seu@email.com';
```

Ou via tinker:
```bash
php artisan tinker
>>> App\Models\User::where('email', 'seu@email.com')->update(['is_admin' => true]);
```

---

## 12. Rotas do Sistema

| Rota | Middleware | Descrição |
|------|-----------|-----------|
| `GET /` | — | Página inicial |
| `GET /eventos` | — | Listagem de eventos |
| `GET /eventos/{slug}` | — | Detalhe do evento |
| `GET /entrar` | guest | Login |
| `GET /cadastrar` | guest | Cadastro |
| `POST /sair` | auth | Logout |
| `GET /minha-conta` | auth | Dashboard do usuário |
| `POST /eventos/{event}/inscrever` | auth | Fazer inscrição |
| `GET /pagamento/{code}` | auth | Checkout |
| `POST /webhooks/mercadopago` | throttle | Webhook MP |
| `GET /admin` | auth + admin | Painel admin |
| `GET /admin/eventos` | auth + admin | CRUD eventos |
| `GET /admin/inscricoes` | auth + admin | Inscrições |

---

## 13. Design System

### Layout das páginas de autenticação (Login / Cadastro)

- Fundo escuro com gradientes radiais em azul/índigo
- Card branco com `box-shadow` em camadas (efeito de elevação)
- Sem footer, sem ícone da cruz, sem subtítulo "Igreja Anglicana de Garanhuns"
- Rodapé: `POWERED BY CORUZEN` sutil (uppercase, tracking-widest, text-white/30)
- `html` e `body` com `h-full overflow-hidden` para evitar scroll da página
- Container com `min-h-full flex flex-col` — se a tela for pequena, scroll acontece dentro do `<main>`, não na página

### Classes CSS customizadas (`resources/css/app.css`)

| Classe | Uso |
|--------|-----|
| `.btn-primary` | Botão azul principal |
| `.btn` | Botão base |
| `.card` | Card branco com borda suave |
| `.input` | Campo de formulário padrão |
| `.label` | Label de formulário |
| `.alert` | Mensagem de alerta |
| `.auth-bg` | Fundo das telas de auth |
| `.auth-card` | Card das telas de auth |
| `.auth-input` | Input das telas de auth |
| `.auth-btn` | Botão das telas de auth |

### Cores principais (Tailwind)

- `blue-800` / `primary-600` — azul principal IAGUS
- `gray-900` — títulos
- `gray-500` / `gray-400` — textos secundários/placeholders

### Como o layout suporta override por página

O `layouts/app.blade.php` aceita `@section` opcionais:

```blade
@section('html_class', 'h-full')          {{-- trava altura no viewport --}}
@section('body_class', 'h-full overflow-hidden')  {{-- bloqueia scroll --}}
@section('main_class', 'overflow-y-auto')         {{-- scroll interno --}}
@section('hide_footer', true)             {{-- oculta o footer --}}
```

---

## 14. O Que Falta Desenvolver

### Alta prioridade

- [ ] **Recuperação de senha** — `/esqueci-senha` com envio de e-mail
- [ ] **E-mails transacionais** — confirmação de inscrição, lembrete de evento, confirmação de pagamento
- [ ] **Upload de imagem** nos eventos (campo `image_url` existe mas não tem upload)
- [ ] **Página de evento** — design da view pública `/eventos/{slug}`
- [ ] **Dashboard do usuário** — listar inscrições com status de pagamento

### Média prioridade

- [ ] **Exportação de inscritos** por evento (CSV/Excel) — rota já existe (`/admin/eventos/{event}/export`), implementar o controller
- [ ] **Paginação** na listagem de eventos e inscrições admin
- [ ] **Filtros** no admin (por status, data, evento)
- [ ] **Geração de QR Code** para check-in nos eventos

### Baixa prioridade / Futuro

- [ ] **Notificações push** ou SMS para lembrete de eventos
- [ ] **Integração com calendário** (Google Calendar export)
- [ ] **Galeria de fotos** por evento (após o evento)
- [ ] **Área de membros** — perfil, histórico completo
- [ ] **Relatórios financeiros** no admin com gráficos
- [ ] **Multi-idioma** (PT/EN para eventos missionários)

---

## 15. Boas Práticas para Este Projeto

### Antes de qualquer push

```bash
git pull --rebase origin main
# testar localmente
git add .
git commit -m "tipo: descrição"
git push origin main
```

### Depois de qualquer push

- Monitorar GitHub Actions (deve completar em ~35s)
- Se falhar: ver logs em GitHub → Actions → job "deploy"
- Se o cPanel não atualizar: "Atualizar do remoto" + "Implementar HEAD" manualmente

### Nunca fazer em produção

- `php artisan migrate:fresh` (apaga todos os dados)
- `php artisan db:seed` sem `--class` específica (recria dados dummy)
- Editar arquivos diretamente no servidor pelo Gerenciador de Arquivo (sempre usar o fluxo Git)

### Segurança

- `APP_DEBUG=false` em produção (já configurado)
- `.env` nunca no Git
- Arquivos diagnóstico/setup nunca no Git (bloqueados no `.htaccess` e no `rsync --exclude`)
- Webhook com assinatura verificada (`MP_WEBHOOK_SECRET`)

### Se o site quebrar em produção

1. Ver `storage/logs/laravel.log` (cPanel → Gerenciador de Arquivo)
2. Testar se é erro de cache: executar `php artisan optimize:clear` via terminal SSH
3. Testar se é o `.env`: verificar se `APP_KEY` e `DB_*` estão corretos
4. Testar se é permissão: `chmod 755 iagus.com.br` e `chmod 755 iagus.com.br/public`
5. Se nada funcionar: `Implementar comprometimento de HEAD` no cPanel para re-rodar o `.cpanel.yml`

### Controle de qualidade

- Testar login, cadastro, inscrição e pagamento após cada deploy significativo
- Verificar tela mobile e desktop antes de commitar mudanças de UI
- Assets precisam ser recompilados para CSS/JS novo chegar em produção (o Actions faz isso automaticamente)

---

*Última atualização: Fevereiro 2026 — Coruzen*
