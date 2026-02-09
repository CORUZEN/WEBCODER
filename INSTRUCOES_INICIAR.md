# 🚀 Como Iniciar o Servidor IAGUS

## ✅ Método Recomendado: Laravel Herd

### O que é Herd?
Laravel Herd é a solução oficial Laravel para Windows que inclui:
- ✅ PHP 8.4
- ✅ Composer
- ✅ Node.js & NPM
- ✅ Servidor web integrado
- ✅ Configuração zero

### Instalar Herd (Uma vez)

1. **Baixar:** https://herd.laravel.com/windows
2. **Instalar** (próximo → próximo → concluir)
3. **Aguardar** ícone aparecer na bandeja do sistema
4. **Pronto!** Pode usar imediatamente

### Iniciar Projeto com Herd

```bash
# 1. Abrir terminal nesta pasta (Git Bash, PowerShell ou CMD)

# 2. Linkar projeto ao Herd (apenas primeira vez)
herd link webcoder

# 3. Compilar assets (apenas primeira vez ou após mudanças)
npm install
npm run build

# 4. Configurar banco de dados (apenas primeira vez)
touch database/database.sqlite
php artisan migrate:fresh --seed

# 5. Acessar site
# http://webcoder.test  (via Herd)
# ou
# http://localhost:8000  (via artisan serve)
```

### Servidor Via Herd
Quando você usa `herd link`, o site fica **sempre disponível** em:
- 🌐 **http://webcoder.test**

Não precisa iniciar servidor! 🎉

### Servidor Via Artisan (Alternativa)
Se preferir controlar manualmente:
```bash
php artisan serve
```
Acesse: http://localhost:8000

---

## 📋 Alternativas (Sem Herd)

### Opção 1: Usar start.bat (Windows)

```bash
# Abra CMD ou PowerShell
start.bat
```

✅ Detecta automaticamente PHP instalado  
✅ Inicia servidor Laravel  
✅ Compila assets se necessário

### Opção 2: Adicionar PHP ao PATH

1. Localize onde o PHP está instalado:
   - **Laragon:** `C:\laragon\bin\php\php-8.x`
   - **XAMPP:** `C:\xampp\php`
   - **WAMP:** `C:\wamp64\bin\php\php8.x`

2. Adicione ao PATH:
   - Windows + R → `sysdm.cpl`
   - Avançado → Variáveis de Ambiente
   - PATH → Editar → Novo → Cole o caminho do PHP
   - OK → OK → **Reinicie o terminal**

3. Teste:
```bash
php -v
# Deve mostrar versão do PHP
```

---

## 🌐 Acessar Aplicação

### URLs Disponíveis
- **Site (Herd):** http://webcoder.test
- **Site (Artisan):** http://localhost:8000
- **Admin:** /admin
- **Login:** /entrar
- **Cadastro:** /cadastrar

### Credenciais de Teste

**Administrador:**
- Email: `admin@iagus.org.br`
- Senha: `iagus2026`

**Usuário Normal:**
- Email: `joao@example.com`
- Senha: `password`

---

## ⚠️ Problemas Comuns

### 1. "Target class [files] does not exist"

**Solução:**
```bash
# Verificar se config/app.php NÃO tem providers/aliases vazios
# Ver TROUBLESHOOTING.md para detalhes
```

### 2. Site carrega mas fica em "loading infinito"

**Solução:**
```bash
# Remover arquivo hot e compilar assets
rm -f public/hot
npm run build
# Recarregar navegador (Ctrl+Shift+R)
```

### 3. "No application encryption key has been set"

**Solução:**
```bash
php artisan key:generate
```

### 4. Permissões negadas (storage/logs)

**Solução:**
```bash
# Windows (PowerShell como Admin)
icacls storage /grant Everyone:(OI)(CI)F /T
icacls bootstrap\cache /grant Everyone:(OI)(CI)F /T

# Linux/Mac
chmod -R 775 storage bootstrap/cache
```

### 5. Banco de dados vazio

**Solução:**
```bash
# Criar tabelas e dados de teste
php artisan migrate:fresh --seed
```

---

## 💾 Banco de Dados

### SQLite (Padrão - Recomendado para desenvolvimento)
Já configurado! O arquivo `database/database.sqlite` é criado automaticamente.

**Vantagens:**
- ✅ Não precisa instalar MySQL
- ✅ Arquivo único e portável
- ✅ Rápido para desenvolvimento

### MySQL (Opcional - Para produção)
Edite `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iagus_site
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

Crie o banco:
```bash
mysql -u root -p
CREATE DATABASE iagus_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

php artisan migrate:fresh --seed
```

---

## 🔧 Comandos Úteis

### Iniciar Desenvolvimento
```bash
# Terminal 1: Servidor Laravel
php artisan serve

# Terminal 2: Watch de Assets (opcional)
npm run dev
```

### Verificar Status
```bash
# Info do sistema
php artisan about

# Listar rotas
php artisan route:list

# Status das migrations
php artisan migrate:status
```

### Limpar Cache
```bash
# Limpar tudo
php artisan optimize:clear

# Ou individual
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Recompilar Assets
```bash
# Produção (minificado)
npm run build

# Desenvolvimento (com watch)
npm run dev
```

---

## 📚 Próximos Passos

1. ✅ Servidor rodando
2. ✅ Acessar site em http://webcoder.test ou http://localhost:8000
3. ✅ Fazer login como admin
4. ✅ Explorar painel administrativo em /admin
5. ✅ Criar eventos de teste
6. ✅ Testar inscrições
7. 📖 Ler [TROUBLESHOOTING.md](TROUBLESHOOTING.md) para evitar problemas
8. 📖 Consultar [CHANGELOG.md](CHANGELOG.md) para ver todas as melhorias

---

## 🆘 Precisa de Ajuda?

### Documentação Completa
- 📖 **[TROUBLESHOOTING.md](TROUBLESHOOTING.md)** - Solução de problemas
- 📖 **[CHANGELOG.md](CHANGELOG.md)** - Histórico de mudanças
- 📖 **[README.md](README.md)** - Visão geral do projeto
- 📖 **[DATABASE_SETUP.md](DATABASE_SETUP.md)** - Configuração de banco

### Reset Completo (Último Recurso)
```bash
# Limpar tudo
rm -rf vendor node_modules public/build
rm -f composer.lock package-lock.json

# Reinstalar
composer install
npm install
npm run build

# Recriar banco
php artisan migrate:fresh --seed

# Testar
php artisan serve
```

---

**Atualizado:** 08/02/2026  
**Versão:** 1.0.0


---

**Recomendação:** Use **PowerShell** ou **CMD** no Windows, não Git Bash! 🎯
