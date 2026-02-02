# Deploy no HostGator (cPanel) - IAGUS

## Pré-requisitos

- Conta de hospedagem HostGator
- Acesso ao cPanel
- PHP 8.2 ou superior
- MySQL 5.7 ou superior
- Composer instalado localmente
- Git (opcional, para controle de versão)

## Passo 1: Preparar o Projeto Localmente

### 1.1 Build do Projeto

```bash
# Instalar dependências
composer install --optimize-autoloader --no-dev

# Compilar assets
npm install
npm run build

# Gerar chave da aplicação (se necessário)
php artisan key:generate
```

### 1.2 Configurar .env

Crie um arquivo `.env` para produção:

```env
APP_NAME="IAGUS"
APP_ENV=production
APP_KEY=base64:...  # Copiar do .env local ou gerar novo
APP_DEBUG=false
APP_URL=https://seudominio.com.br

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

# Mercado Pago (PRODUÇÃO)
MP_ACCESS_TOKEN=APP-xxxxx  # Token de PRODUÇÃO
MP_PUBLIC_KEY=APP_USR-xxxxx  # Key de PRODUÇÃO
MP_NOTIFICATION_URL=https://seudominio.com.br/webhooks/mercadopago

# E-mail (configurar SMTP do HostGator)
MAIL_MAILER=smtp
MAIL_HOST=mail.seudominio.com.br
MAIL_PORT=587
MAIL_USERNAME=naoresponda@seudominio.com.br
MAIL_PASSWORD=sua_senha_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=naoresponda@seudominio.com.br
MAIL_FROM_NAME="${APP_NAME}"
```

## Passo 2: Configurar cPanel

### 2.1 Criar Banco de Dados MySQL

1. Acesse **MySQL Database Wizard** no cPanel
2. Criar novo banco: `seuusuario_iagus`
3. Criar usuário: `seuusuario_admin`
4. Definir senha forte
5. Dar **ALL PRIVILEGES** ao usuário

### 2.2 Configurar PHP

1. Acesse **Select PHP Version** no cPanel
2. Selecione **PHP 8.2** ou superior
3. Ative as extensões necessárias:
   - ✓ mbstring
   - ✓ openssl
   - ✓ pdo
   - ✓ pdo_mysql
   - ✓ tokenizer
   - ✓ xml
   - ✓ ctype
   - ✓ json
   - ✓ bcmath

## Passo 3: Estrutura de Pastas no Servidor

### 3.1 Estrutura Recomendada

```
/home/seuusuario/
├── laravel_app/              # Aplicação Laravel (fora do public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/              # Conteúdo que vai para public_html
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   ├── artisan
│   └── composer.json
│
└── public_html/             # Raiz pública do site
    ├── .htaccess
    ├── index.php
    ├── favicon.ico
    └── build/               # Assets compilados
```

### 3.2 Upload dos Arquivos

**Opção A: FTP/SFTP**
1. Use FileZilla ou similar
2. Upload da pasta do projeto para `/home/seuusuario/laravel_app`
3. Copie o conteúdo de `laravel_app/public/` para `public_html/`

**Opção B: cPanel File Manager**
1. Compacte o projeto em .zip
2. Upload via File Manager
3. Extraia no diretório correto

## Passo 4: Configurar public_html/index.php

Edite o arquivo `public_html/index.php`:

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Ajustar caminho para fora do public_html
require __DIR__.'/../laravel_app/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel_app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

## Passo 5: Configurar .htaccess

Crie/edite `public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Redirecionar HTTP para HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Passo 6: Permissões de Pastas

Execute via SSH ou Terminal no cPanel:

```bash
cd /home/seuusuario/laravel_app

# Storage e cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Se necessário, ajustar proprietário
chown -R seuusuario:seuusuario storage
chown -R seuusuario:seuusuario bootstrap/cache
```

## Passo 7: Executar Migrations

Via SSH:

```bash
cd /home/seuusuario/laravel_app

# Rodar migrations
php artisan migrate --force

# Rodar seeders
php artisan db:seed --force

# Otimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Passo 8: Configurar SSL (HTTPS)

1. Acesse **SSL/TLS** no cPanel
2. Use **AutoSSL** (gratuito) ou instale certificado próprio
3. Ative redirecionamento HTTP → HTTPS

## Passo 9: Configurar Webhooks do Mercado Pago

1. Acesse o Painel do Mercado Pago
2. Vá em **Suas integrações** > **Webhooks**
3. Configure a URL: `https://seudominio.com.br/webhooks/mercadopago`
4. Selecione eventos: **Pagamentos**
5. Salve e teste

## Passo 10: Criar Cronjob (Opcional)

Se usar filas ou tarefas agendadas:

1. Acesse **Cron Jobs** no cPanel
2. Adicione:
   ```
   * * * * * cd /home/seuusuario/laravel_app && php artisan schedule:run >> /dev/null 2>&1
   ```

## Passo 11: Configurar Backups

### Backup do Banco de Dados

1. Acesse **Backup Wizard** no cPanel
2. Configure backup automático diário
3. Ou use cron:
   ```bash
   0 2 * * * mysqldump -u usuario -psenha banco > /home/backup/db_$(date +\%Y\%m\%d).sql
   ```

### Backup de Arquivos

1. Use o backup do cPanel
2. Ou configure backup via FTP/rsync

## Verificações Pós-Deploy

### ✓ Checklist

- [ ] Site carrega em HTTPS
- [ ] Páginas públicas funcionam
- [ ] Login/Registro funciona
- [ ] Eventos aparecem corretamente
- [ ] Inscrição em evento gratuito funciona
- [ ] Criação de preferência Mercado Pago funciona
- [ ] Webhook recebe notificações (testar em sandbox primeiro)
- [ ] Área admin acessível apenas para admin
- [ ] Export CSV funciona
- [ ] E-mails sendo enviados
- [ ] Logs sem erros críticos

### Testar Mercado Pago

1. Use credenciais de teste primeiro
2. Faça inscrição em evento pago
3. Complete pagamento de teste
4. Verifique se webhook atualiza status
5. Quando OK, mude para credenciais de produção

## Troubleshooting

### Erro 500
- Verifique permissões de `storage/` e `bootstrap/cache/`
- Verifique logs em `storage/logs/laravel.log`
- Confirme que `.env` está configurado corretamente

### Página em branco
- Ative `APP_DEBUG=true` temporariamente para ver erro
- Verifique PHP version no cPanel

### Assets não carregam
- Verifique se `public/build/` existe
- Execute `npm run build` novamente

### Webhook não funciona
- Verifique URL no painel MP
- Teste manualmente com ferramentas como Postman
- Verifique logs em `storage/logs/`

## Manutenção

### Atualizar Código

```bash
# Upload novos arquivos
# Depois execute:
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Limpar Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Suporte

Para problemas técnicos:
1. Verifique logs em `storage/logs/laravel.log`
2. Consulte documentação Laravel: https://laravel.com/docs
3. Suporte HostGator para questões de servidor

---

**Última atualização:** Fevereiro 2026
