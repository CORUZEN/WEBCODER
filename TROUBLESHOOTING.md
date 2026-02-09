# 🔧 TROUBLESHOOTING - IAGUS

Guia completo de solução de problemas e como evitar erros comuns.

---

## 🚨 Problemas Críticos Resolvidos

### 1. "Target class [files] does not exist"

#### 🔍 Sintoma
```
Illuminate\Contracts\Container\BindingResolutionException
Target class [files] does not exist.
```

#### ❌ Causa
Arquivo `config/app.php` com seções vazias:
```php
'providers' => [
    // ...
],
'aliases' => [
    // ...
],
```

#### ✅ Solução
**Laravel 11 não precisa dessas seções!** Remova-as completamente:

```php
<?php
return [
    'name' => env('APP_NAME', 'Laravel'),
    // ... outras configs
    'maintenance' => [
        'driver' => 'file',
    ],
];
```

#### 💡 Como Evitar
- Não adicione providers/aliases manualmente no Laravel 11
- Use auto-discovery (composer.json)
- Mantenha `config/app.php` limpo

---

### 2. Site Carrega mas Fica em "Loading Infinito"

#### 🔍 Sintoma
- Página HTML carrega
- Spinner/loading infinito
- Erros CORS no console do navegador
- Assets tentam carregar de `localhost:5173`

#### ❌ Causa
Arquivo `public/hot` existe, fazendo Laravel buscar servidor de desenvolvimento Vite que não está rodando.

#### ✅ Solução Rápida
```bash
# 1. Remover arquivo hot
rm -f public/hot

# 2. Compilar assets
npm run build

# 3. Reiniciar navegador
```

#### ✅ Solução Permanente
Adicionar ao `.gitignore`:
```gitignore
/public/hot
/public/build
```

#### 💡 Como Evitar
- Sempre executar `npm run build` antes de testar
- Nunca commitar `public/hot`
- Para desenvolvimento: `npm run dev` em terminal separado
- Para produção: sempre usar `npm run build`

---

### 3. Vendor Corrompido / Dependências Faltando

#### 🔍 Sintoma
- Classes não encontradas
- Erros aleatórios de namespace
- "Class X does not exist"

#### ✅ Solução
```bash
# 1. Remover vendor e lock
rm -rf vendor composer.lock

# 2. Reinstalar (sem scripts para evitar erros)
composer install --no-scripts

# 3. Executar scripts depois
composer dump-autoload
```

#### 💡 Como Evitar
- Não editar manualmente arquivos do vendor
- Usar versões específicas no `composer.json`
- Sempre rodar `composer dump-autoload` após mudanças

---

### 4. Arquivos Temporários no Git

#### 🔍 Sintoma
- Centenas de arquivos no stage do Git
- `storage/framework/sessions/*`
- `storage/framework/views/*`
- `storage/logs/laravel.log`

#### ✅ Solução
```bash
# 1. Atualizar .gitignore
cat >> .gitignore << 'EOF'
/storage/framework/sessions/*
/storage/framework/views/*
/storage/framework/cache/*
/storage/logs/*
*.sqlite
*.sqlite-journal
/public/hot
yarn.lock
package-lock.json
EOF

# 2. Remover do Git (sem deletar)
git rm --cached -r storage/framework/sessions
git rm --cached -r storage/framework/views
git rm --cached storage/logs/laravel.log
git rm --cached database/database.sqlite

# 3. Commit
git commit -m "chore: atualizar .gitignore"
```

#### 💡 Como Evitar
- Manter `.gitignore` atualizado desde o início
- Revisar arquivos antes de commitar
- Usar `git status` frequentemente

---

## ⚠️ Avisos CSS no VS Code

### 🔍 Sintoma
```
'border-gray-300' applies the same CSS properties as 'border-red-500'
```

### ❌ Causa Raiz
VS Code CSS IntelliSense não entende diretivas Blade `@error()`.

### ✅ Solução Elegante
Use classes customizadas com `!important`:

```html
<!-- ❌ ANTES (140+ avisos) -->
<input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('field') border-red-500 @enderror">

<!-- ✅ DEPOIS (0 avisos) -->
<input class="input @error('field') !border-red-500 @enderror">
```

Defina em `resources/css/app.css`:
```css
.input {
    @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent;
}
```

### 💡 Benefícios
- Código mais limpo
- Mais fácil de manter
- 0 avisos CSS
- Classes reutilizáveis

---

## 🗄️ Problemas de Banco de Dados

### Migration: "Table already exists"

#### ✅ Solução
```bash
# Resetar banco completamente
php artisan migrate:fresh --seed
```

⚠️ **ATENÇÃO:** Isso apaga todos os dados!

### SQLite: "Database not found"

#### ✅ Solução
```bash
# Criar arquivo vazio
touch database/database.sqlite

# Executar migrations
php artisan migrate --seed
```

### Seed: Dados não aparecem

#### ✅ Verificar
```bash
# Confirmar que seed rodou
php artisan migrate:fresh --seed

# Verificar manualmente
php artisan tinker
>>> \App\Models\User::count()
>>> \App\Models\Event::count()
```

---

## 🔐 Problemas de Autenticação

### "Unauthenticated" ao acessar rotas protegidas

#### ✅ Verificar Middleware
```php
// routes/web.php
Route::middleware('auth')->group(function () {
    // Suas rotas protegidas
});
```

### Session não persiste

#### ✅ Verificar .env
```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

#### ✅ Limpar cache de sessão
```bash
rm -rf storage/framework/sessions/*
php artisan cache:clear
```

---

## 🎨 Problemas com Tailwind CSS

### Classes não funcionam

#### ✅ Verificar configuração
```javascript
// tailwind.config.js
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    // ...
}
```

#### ✅ Recompilar
```bash
npm run build
```

### Purge remove classes necessárias

#### ✅ Adicionar ao safelist
```javascript
// tailwind.config.js
export default {
    safelist: [
        'border-red-500',
        'bg-green-100',
        // classes dinâmicas
    ],
}
```

---

## 🚀 Problemas de Deploy

### Assets 404 em Produção

#### ✅ Solução
```bash
# 1. Compilar assets
npm run build

# 2. Subir pasta public/build
git add public/build -f
git commit -m "build: adicionar assets compilados"
```

### Permissões no Servidor

#### ✅ Configurar corretamente
```bash
# No servidor
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🌐 Problemas com Herd (Laravel)

### "Herd Desktop application is not running"

#### ✅ Solução
1. Abrir aplicativo Herd (ícone na bandeja)
2. Verificar se está rodando
3. Reiniciar se necessário

### Site não aparece em `webcoder.test`

#### ✅ Verificar link
```bash
# Ver sites linkados
herd links

# Relinkar se necessário
herd link webcoder
```

---

## 📝 Checklist Antes de Commitar

```bash
✓ npm run build              # Assets compilados
✓ php artisan test           # Testes passando
✓ git status                 # Apenas arquivos necessários
✓ .env não está no stage     # Nunca commitar .env
✓ vendor/ ignorado           # Sempre no .gitignore
✓ storage/logs/ ignorado     # Logs temporários
```

---

## 🔄 Comandos de Manutenção

### Limpar Cache Completo
```bash
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
rm -rf bootstrap/cache/*.php
```

### Recompilar Tudo
```bash
composer dump-autoload
php artisan optimize
npm run build
```

### Verificar Saúde do Sistema
```bash
php artisan about
php artisan route:list
php artisan migrate:status
```

---

## 🆘 Emergency Reset

Se tudo falhar, resetar ambiente completo:

```bash
# 1. Limpar tudo
rm -rf vendor node_modules public/build
rm -f composer.lock package-lock.json yarn.lock
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
rm -rf storage/framework/cache/*
rm -rf bootstrap/cache/*.php

# 2. Reinstalar
composer install
npm install
npm run build

# 3. Reconfigurar
cp .env.example .env
php artisan key:generate

# 4. Banco de dados
php artisan migrate:fresh --seed

# 5. Testar
php artisan serve
```

---

## 📞 Recursos Adicionais

- **Laravel Docs:** https://laravel.com/docs/11.x
- **Tailwind Docs:** https://tailwindcss.com/docs
- **Vite Laravel Plugin:** https://laravel.com/docs/11.x/vite
- **Herd Docs:** https://herd.laravel.com/docs

---

**Atualizado:** 08/02/2026  
**Versão:** 1.0.0
