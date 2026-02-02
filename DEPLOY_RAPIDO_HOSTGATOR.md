# 🚀 DEPLOY IAGUS - HostGator (Guia Rápido)

## ✅ PASSO 1: Compactar Arquivos

Execute no seu computador:

```bash
cd D:\CORUZEN\WEBCODER
zip -r iagus-site.zip . -x "node_modules/*" ".git/*" "storage/logs/*" "storage/framework/cache/*"
```

Ou use WinRAR/7-Zip para compactar excluindo:
- `node_modules/`
- `.git/`
- `storage/logs/*`
- `storage/framework/cache/*`

---

## ✅ PASSO 2: Upload via cPanel

1. **Acesse o cPanel do HostGator**
2. **Gerenciador de Arquivos**
3. **Vá para `public_html`** (ou pasta do domínio)
4. **Upload do arquivo `iagus-site.zip`**
5. **Extrair arquivo** (clique com botão direito → Extract)

---

## ✅ PASSO 3: Ajustar Estrutura

**No cPanel File Manager:**

1. Mova TODO conteúdo da pasta `public/` para `public_html/`
2. Mova as outras pastas (app, bootstrap, config, etc) para FORA de `public_html/`
   - Sugestão: criar pasta `/home/usuario/laravel/` e colocar lá

3. Edite `public_html/index.php`:

```php
<?php

// Ajustar caminho
require __DIR__.'/../laravel/bootstrap/app.php';
```

---

## ✅ PASSO 4: Criar Banco MySQL

**No cPanel → MySQL Databases:**

1. **Criar banco:** `usuario_iagus`
2. **Criar usuário:** `usuario_iagus_user`
3. **Senha forte** (anotar!)
4. **Adicionar usuário ao banco** (ALL PRIVILEGES)

---

## ✅ PASSO 5: Configurar .env

**Editar `public_html/.env` (ou `/home/usuario/laravel/.env`):**

```env
APP_NAME="IAGUS"
APP_ENV=production
APP_KEY=base64:47DEQpj8HBSa+/TImW+5JCeuQeRkm5NMpJWZG3hSuFU=
APP_DEBUG=false
APP_URL=https://seudominio.com.br

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=usuario_iagus
DB_USERNAME=usuario_iagus_user
DB_PASSWORD=SUA_SENHA_AQUI

# Mercado Pago
MP_PUBLIC_KEY=SEU_PUBLIC_KEY
MP_ACCESS_TOKEN=SEU_ACCESS_TOKEN
```

---

## ✅ PASSO 6: Executar Migrations

**Terminal SSH (ou criar arquivo PHP temporário):**

### Opção A: SSH
```bash
cd /home/usuario/laravel
php artisan migrate --seed --force
```

### Opção B: Criar arquivo `setup.php` em `public_html`:

```php
<?php
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

// Executar migrations via PDO
$pdo = new PDO(
    'mysql:host=localhost;dbname=usuario_iagus',
    'usuario_iagus_user',
    'SUA_SENHA'
);

// Cole o conteúdo do setup-database.php aqui...
```

Acesse: `https://seudominio.com.br/setup.php`

**DEPOIS DELETE O ARQUIVO `setup.php`!**

---

## ✅ PASSO 7: Configurar Permissões

**No Terminal SSH ou File Manager:**

```bash
chmod -R 755 /home/usuario/laravel/storage
chmod -R 755 /home/usuario/laravel/bootstrap/cache
```

---

## ✅ PASSO 8: Testar!

Acesse: **https://seudominio.com.br**

**Login Admin:**
- Email: `admin@iagus.org.br`
- Senha: `iagus2026`

---

## 🔥 DEPLOY ULTRA-RÁPIDO (Alternativa)

Se você tem SSH:

```bash
# No seu computador
git init
git add .
git commit -m "Initial commit"

# No HostGator (SSH)
cd /home/usuario
git clone https://github.com/seu-usuario/iagus-site.git laravel
cd laravel
composer install --no-dev --optimize-autoloader
php artisan migrate --seed --force
```

---

## 📞 Precisa de Ajuda?

Me passe:
1. URL do site
2. Acesso SSH (se tiver)
3. Print do erro (se houver)

**Vamos fazer funcionar!** 🚀
