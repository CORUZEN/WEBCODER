# 🙏 IAGUS - Site Institucional

> Site da Igreja Anglicana de Garanhuns com sistema de eventos, inscrições e pagamentos via Mercado Pago

[![Laravel](https://img.shields.io/badge/Laravel-11-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.2-38B2AC.svg)](https://tailwindcss.com)

---

## 🚀 Início Rápido

### Desenvolvedor Experiente? 
👉 **[QUICK_START.md](QUICK_START.md)** - Setup em 60 segundos

### Método Recomendado: Laravel Herd

```bash
# 1. Instalar Herd: https://herd.laravel.com/windows
# 2. Setup
herd link webcoder
npm install && npm run build
touch database/database.sqlite
php artisan migrate:fresh --seed

# 3. Acessar: http://webcoder.test
```

👤 **Admin:** admin@iagus.org.br / iagus2026  
👤 **User:** joao@example.com / password

### Método Alternativo

Ver instruções completas: **[INSTRUCOES_INICIAR.md](INSTRUCOES_INICIAR.md)**

---

## 📚 Documentação Completa

### 🎯 Início Rápido
- ⚡ **[QUICK_START.md](QUICK_START.md)** - Setup em 60 segundos (dev experiente)
- 🚀 **[INSTRUCOES_INICIAR.md](INSTRUCOES_INICIAR.md)** - Como iniciar servidor
- 📖 **[START_HERE.md](START_HERE.md)** - Guia passo a passo detalhado

### 🔧 Configuração e Instalação
- 🗄️ **[DATABASE_SETUP.md](DATABASE_SETUP.md)** - Configuração do banco de dados
- 💾 **[INSTALACAO.md](INSTALACAO.md)** - Instalação completa do zero

### 🛠️ Desenvolvimento
- 📝 **[CHANGELOG.md](CHANGELOG.md)** - Histórico de mudanças e melhorias
- 🔧 **[TROUBLESHOOTING.md](TROUBLESHOOTING.md)** - Solução de problemas comuns
- ✅ **[PROJETO_CONCLUIDO.md](PROJETO_CONCLUIDO.md)** - Status e funcionalidades

### 🚀 Deploy
- 🌐 **[docs/DEPLOY_HOSTGATOR.md](docs/DEPLOY_HOSTGATOR.md)** - Deploy em produção

---

## ✨ Funcionalidades

### Área Pública
- ✅ Site institucional moderno e responsivo
- ✅ Páginas: Home, Sobre, Cultos, Juventude, Contato
- ✅ Listagem de eventos
- ✅ Sistema de inscrições

### Sistema de Eventos
- ✅ CRUD completo de eventos
- ✅ Eventos gratuitos e pagos
- ✅ Controle de vagas
- ✅ Janela de inscrição (abertura/fechamento)

### Pagamentos
- ✅ Integração completa com Mercado Pago
- ✅ Checkout Pro (redirecionamento seguro)
- ✅ Webhooks para confirmação automática
- ✅ Tratamento de todos os status de pagamento

### Painel Administrativo
- ✅ Dashboard com estatísticas
- ✅ Gerenciamento de eventos
- ✅ Gerenciamento de inscrições
- ✅ Export CSV
- ✅ Filtros e buscas

### Área do Usuário
- ✅ Dashboard pessoal
- ✅ Visualizar inscrições
- ✅ Acompanhar status de pagamento
- ✅ Acesso a instruções dos eventos

### Segurança
- ✅ CSRF Protection
- ✅ Rate Limiting
- ✅ Autenticação completa
- ✅ Sistema de roles (user/admin)
- ✅ Validações server-side

---

## 🛠️ Stack Tecnológica

- **Backend:** Laravel 11 (PHP 8.2)
- **Frontend:** Blade + Tailwind CSS 3
- **Database:** MySQL 5.7+
- **Build:** Vite
- **Pagamentos:** Mercado Pago SDK PHP
- **Deploy:** HostGator (cPanel)

---

## 📦 Estrutura do Projeto

```
├── app/
│   ├── Http/Controllers/     # Controllers (Public, Admin, Auth)
│   ├── Models/               # Eloquent Models
│   └── Http/Middleware/      # Middleware customizado
├── database/
│   ├── migrations/           # Migrations do banco
│   └── seeders/              # Seeders (dados iniciais)
├── resources/
│   ├── views/                # Views Blade
│   ├── css/                  # Tailwind CSS
│   └── js/                   # JavaScript
├── routes/
│   └── web.php               # Rotas da aplicação
└── public/                   # Arquivos públicos
```

---

## 🎯 Scripts Disponíveis

```bash
# Iniciar servidor (com auto-restart)
./start.sh         # Linux/Mac
start.bat          # Windows

# Comandos Laravel
php artisan migrate --seed           # Criar tabelas e dados
php artisan migrate:fresh --seed     # Resetar banco
php artisan cache:clear              # Limpar cache

# Comandos NPM
npm run dev        # Desenvolvimento (com hot reload)
npm run build      # Build para produção
```

---

## 🐛 Troubleshooting

**Porta 8000 já em uso?**
- Execute `start.bat` ou `start.sh` - ele mata automaticamente

**Erro de banco de dados?**
- Veja **[DATABASE_SETUP.md](DATABASE_SETUP.md)**

**Assets não carregam?**
- Execute `npm run build`

**Erro de permissões?**
- Windows: Execute terminal como Administrador
- Linux/Mac: `chmod -R 775 storage bootstrap/cache`

---

## 📄 Licença

© 2026 IAGUS - Igreja Anglicana de Garanhuns. Todos os direitos reservados.

---

## 💡 Suporte

Para questões técnicas:
- 📧 Email: contato@iagus.org.br
- 📱 WhatsApp: (87) 9 9999-9999

---

**Desenvolvido com ❤️ para a IAGUS**
