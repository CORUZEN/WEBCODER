# 🚀 Como Iniciar o Servidor IAGUS

## ⚠️ Importante: PHP não encontrado no PATH

O script detectou que o PHP não está no PATH do sistema. 

## 📋 Soluções:

### Opção 1: Usar PowerShell ou CMD (Recomendado)

Abra o **PowerShell** ou **CMD** (não Git Bash) e execute:

```bash
start.bat
```

✅ Este é o método mais simples e confiável no Windows!

---

### Opção 2: Adicionar PHP ao PATH

1. Localize onde o PHP está instalado:
   - Laragon: `C:\laragon\bin\php\php-8.x`
   - XAMPP: `C:\xampp\php`
   - WAMP: `C:\wamp64\bin\php\php8.x`

2. Adicione ao PATH do sistema:
   - Windows + R → `sysdm.cpl`
   - Avançado → Variáveis de Ambiente
   - PATH → Editar → Novo → Cole o caminho do PHP
   - OK → OK → Reinicie o terminal

---

### Opção 3: Instalar Laravel Herd (Mais Fácil!)

Laravel Herd configura tudo automaticamente:

1. Baixe: https://herd.laravel.com/windows
2. Instale
3. Reinicie o terminal
4. Execute: `start.bat`

✅ Herd inclui PHP, Composer, Node e muito mais!

---

## 🎯 Iniciar Agora (Sem configurar PATH)

### Use o CMD ou PowerShell:

```bash
# Abra CMD ou PowerShell nesta pasta
start.bat
```

O `.bat` funciona perfeitamente no Windows sem precisar do Git Bash!

---

## 🌐 Acessar Aplicação

Depois de iniciar:

- **Site:** http://localhost:8000
- **Admin:** admin@iagus.org.br / iagus2026
- **User:** joao@example.com / password

---

## 💾 Banco de Dados

Já está configurado com **SQLite** (não precisa instalar MySQL)!

O script `start.bat` cria automaticamente:
- ✅ Arquivo do banco
- ✅ Tabelas
- ✅ Dados iniciais

---

## 🆘 Precisa de Ajuda?

Se o `start.bat` não funcionar, execute manualmente:

```bash
# 1. Criar banco SQLite
type nul > database\database.sqlite

# 2. Executar migrations
php artisan migrate --seed

# 3. Iniciar servidor
php artisan serve
```

Em outra janela:
```bash
npm run dev
```

---

**Recomendação:** Use **PowerShell** ou **CMD** no Windows, não Git Bash! 🎯
