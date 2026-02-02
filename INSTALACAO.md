# Instalação Local - IAGUS

## Requisitos do Sistema

- PHP 8.2 ou superior
- Composer
- Node.js 18+ e NPM
- MySQL 5.7+ ou MariaDB 10.3+
- Git (opcional)

## Passo a Passo

### 1. Clone ou extraia o projeto

```bash
cd d:\CORUZEN\WEBCODER
```

### 2. Instale as dependências PHP

```bash
composer install
```

### 3. Instale as dependências Node

```bash
npm install
```

### 4. Configure o ambiente

```bash
# Copie o arquivo de exemplo
copy .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 5. Configure o banco de dados

Edite o arquivo `.env` com suas credenciais MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iagus_site
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Crie o banco de dados

No MySQL:

```sql
CREATE DATABASE iagus_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Execute as migrations e seeders

```bash
php artisan migrate --seed
```

Isso criará:
- Todas as tabelas necessárias
- Usuário admin: `admin@iagus.org.br` / senha: `iagus2026`
- Usuário teste: `joao@example.com` / senha: `password`
- 4 eventos de exemplo

### 8. Compile os assets

```bash
# Desenvolvimento (com hot reload)
npm run dev

# Ou para produção
npm run build
```

### 9. Inicie o servidor

```bash
php artisan serve
```

O site estará disponível em: http://localhost:8000

## Configuração do Mercado Pago (Opcional)

### Ambiente de Testes

1. Crie uma conta no Mercado Pago Developers: https://www.mercadopago.com.br/developers
2. Obtenha as credenciais de teste
3. Configure no `.env`:

```env
MP_ACCESS_TOKEN=TEST-xxxxx
MP_PUBLIC_KEY=TEST-xxxxx
MP_WEBHOOK_SECRET=
MP_NOTIFICATION_URL=http://localhost:8000/webhooks/mercadopago
```

### Testar Webhooks Localmente

Use **ngrok** ou **Expose** para expor seu servidor local:

```bash
# Com ngrok
ngrok http 8000

# Atualize a MP_NOTIFICATION_URL no .env com a URL do ngrok
MP_NOTIFICATION_URL=https://xxxx.ngrok.io/webhooks/mercadopago
```

## Acessos Padrão

### Área Pública
- **Home:** http://localhost:8000
- **Eventos:** http://localhost:8000/eventos
- **Login:** http://localhost:8000/entrar

### Admin
- **URL:** http://localhost:8000/admin
- **E-mail:** admin@iagus.org.br
- **Senha:** iagus2026

### Usuário Teste
- **E-mail:** joao@example.com
- **Senha:** password

## Comandos Úteis

### Limpar cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Recompilar cache (produção)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Resetar banco de dados
```bash
php artisan migrate:fresh --seed
```

### Ver logs
```bash
tail -f storage/logs/laravel.log
```

### Rodar testes (quando implementados)
```bash
php artisan test
```

## Estrutura do Projeto

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controllers do painel admin
│   │   │   ├── Auth/           # Autenticação
│   │   │   └── ...             # Controllers públicos
│   │   └── Middleware/
│   └── Models/                  # Models Eloquent
├── database/
│   ├── migrations/              # Migrations do banco
│   └── seeders/                 # Seeders
├── resources/
│   ├── css/                     # CSS (Tailwind)
│   ├── js/                      # JavaScript
│   └── views/                   # Views Blade
├── routes/
│   └── web.php                  # Rotas da aplicação
└── public/                      # Arquivos públicos
```

## Problemas Comuns

### Erro: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Erro: "SQLSTATE[HY000] [1045] Access denied"
Verifique as credenciais do banco de dados no `.env`

### Assets não carregam
```bash
npm run build
```

### Erro de permissões (Windows)
Execute o terminal como Administrador

## Próximos Passos

1. ✅ Sistema está funcionando localmente
2. Personalize os conteúdos das páginas
3. Configure e-mail SMTP
4. Teste o fluxo completo de inscrição
5. Configure Mercado Pago
6. Faça deploy seguindo `docs/DEPLOY_HOSTGATOR.md`

## Suporte

Para questões técnicas:
- Documentação Laravel: https://laravel.com/docs
- Documentação Tailwind: https://tailwindcss.com/docs
- Documentação Mercado Pago: https://www.mercadopago.com.br/developers

---

Desenvolvido para IAGUS - Igreja Anglicana de Garanhuns
