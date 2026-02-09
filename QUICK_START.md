# ⚡ QUICK START - IAGUS

Guia ultra-rápido para desenvolvedores experientes.

---

## 🏃 Start em 60 segundos

```bash
# 1. Instalar Herd (se não tiver)
# https://herd.laravel.com/windows

# 2. Setup
herd link webcoder
npm install && npm run build
touch database/database.sqlite
php artisan migrate:fresh --seed

# 3. Acessar
# http://webcoder.test
```

**Credenciais:**
- Admin: `admin@iagus.org.br` / `iagus2026`
- User: `joao@example.com` / `password`

---

## 📦 Stack

- Laravel 11 + PHP 8.2+
- Tailwind CSS 3 + Vite
- SQLite (dev) / MySQL (prod)
- Mercado Pago SDK

---

## 🛠️ Dev Commands

```bash
# Servidor
php artisan serve              # localhost:8000
herd link webcoder             # webcoder.test

# Assets
npm run dev                    # watch mode
npm run build                  # production

# Database
php artisan migrate:fresh --seed
php artisan migrate:status

# Cache
php artisan optimize:clear
```

---

## 📁 Estrutura

```
app/
├── Http/Controllers/          # Public, Admin, Auth
├── Models/                    # Event, Registration, Payment, User
└── Http/Middleware/           # EnsureUserIsAdmin

resources/
├── views/                     # Blade templates
│   ├── auth/                  # Login, Register
│   ├── admin/                 # Dashboard, Events, Registrations
│   ├── events/                # Public events
│   └── layouts/               # App, Navbar, Footer
├── css/app.css               # Tailwind + Custom
└── js/app.js                 # Alpine.js helpers

routes/web.php                 # 34 rotas
```

---

## 🔥 Hot Tips

### Assets não carregam?
```bash
rm -f public/hot && npm run build
```

### Database reset
```bash
php artisan migrate:fresh --seed
```

### Limpar tudo
```bash
php artisan optimize:clear && npm run build
```

### Emergency reset
```bash
rm -rf vendor node_modules public/build
composer install && npm install && npm run build
php artisan migrate:fresh --seed
```

---

## 🎯 Rotas Principais

```
GET  /                         # Home
GET  /eventos                  # Lista eventos
GET  /eventos/{slug}           # Detalhe evento
POST /eventos/{id}/inscrever   # Criar inscrição (auth)

GET  /admin                    # Dashboard admin (auth, admin)
GET  /admin/eventos            # Lista eventos admin
POST /admin/eventos            # Criar evento

GET  /minha-conta              # Dashboard user (auth)
```

---

## ⚙️ Configuração

### .env Essencial
```env
APP_NAME="IAGUS"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://webcoder.test

DB_CONNECTION=sqlite

# Mercado Pago (prod)
MP_ACCESS_TOKEN=
MP_PUBLIC_KEY=
```

### Tailwind Config
Classes customizadas em `resources/css/app.css`:
- `.btn`, `.btn-primary`, `.btn-secondary`
- `.card`, `.input`, `.label`
- `.alert`, `.badge`

---

## 🚨 Problemas Comuns

| Erro | Solução |
|------|---------|
| "Target class [files] does not exist" | Ver [TROUBLESHOOTING.md](TROUBLESHOOTING.md#1-target-class-files-does-not-exist) |
| Site loading infinito | `rm -f public/hot && npm run build` |
| 404 em assets | `npm run build` |
| Permissões negadas | `chmod -R 775 storage bootstrap/cache` |

---

## 📚 Docs Completas

- [README.md](README.md) - Overview
- [INSTRUCOES_INICIAR.md](INSTRUCOES_INICIAR.md) - Setup detalhado  
- [TROUBLESHOOTING.md](TROUBLESHOOTING.md) - Solução problemas
- [CHANGELOG.md](CHANGELOG.md) - Histórico

---

**Versão:** 1.0.0 | **Status:** ✅ Production Ready
