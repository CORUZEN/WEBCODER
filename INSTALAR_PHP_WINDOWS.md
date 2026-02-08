# 🚀 Instalar PHP no Windows - GUIA RÁPIDO

## ⚡ OPÇÃO 1: Laravel Herd (MAIS FÁCIL - RECOMENDADO!)

### O que é?
Laravel Herd é um ambiente PHP completo para Windows - instala PHP, Composer, Node.js tudo de uma vez!

### Instalação (3 minutos):

1. **Baixe o Herd:**
   - Acesse: https://herd.laravel.com/windows
   - Clique em "Download for Windows"
   - Execute o instalador

2. **Instale:**
   - Siga o assistente (Next, Next, Install)
   - Aguarde a instalação (2-3 minutos)
   - Reinicie o computador quando solicitado

3. **Adicione o projeto:**
   - Abra o Herd (ícone na bandeja)
   - Clique em "Add Path"
   - Selecione: `D:\CORUZEN\WEBCODER`
   - Pronto! O projeto já está rodando!

4. **Acesse:**
   - http://webcoder.test (criado automaticamente pelo Herd!)
   - Ou: http://localhost:8000

### ✅ Vantagens:
- Instala tudo de uma vez (PHP 8.2, Composer, Node.js)
- Cria URLs automáticas (.test)
- Interface gráfica simples
- Não precisa configurar PATH

---

## 💻 OPÇÃO 2: Laragon (Alternativa - Também Fácil!)

### Instalação:

1. **Baixe:**
   - https://laragon.org/download/
   - Versão: Laragon Full (inclui PHP, MySQL, Node)

2. **Instale:**
   - Execute o instalador
   - Instale em: `C:\laragon`
   - Deixe todas as opções marcadas

3. **Configure:**
   - Abra o Laragon
   - Menu > PHP > Version > 8.2 (ou superior)
   - Menu > Apache > Start

4. **Adicione o projeto:**
   - Clique com botão direito no ícone do Laragon
   - Quick add > webcoder > Selecione `D:\CORUZEN\WEBCODER`

5. **Acesse:**
   - http://webcoder.test

---

## 🔧 OPÇÃO 3: PHP Manual (Para Usuários Avançados)

### Passo 1: Baixar PHP

1. Acesse: https://windows.php.net/download/
2. Baixe: **PHP 8.2 VC15 x64 Thread Safe** (ZIP)
3. Extraia para: `C:\php`

### Passo 2: Configurar PHP

1. Copie `C:\php\php.ini-development` para `C:\php\php.ini`
2. Edite `php.ini` e descomente (remova `;`):
   ```ini
   extension=openssl
   extension=pdo_mysql
   extension=mbstring
   extension=fileinfo
   extension=curl
   ```

### Passo 3: Adicionar ao PATH

1. Pressione `Win + X` → "Sistema"
2. "Configurações avançadas do sistema"
3. "Variáveis de ambiente"
4. Em "Variáveis do sistema", selecione "Path" → "Editar"
5. "Novo" → Digite: `C:\php`
6. "OK", "OK", "OK"
7. **REINICIE O COMPUTADOR**

### Passo 4: Instalar Composer

1. Baixe: https://getcomposer.org/Composer-Setup.exe
2. Execute e siga o assistente
3. Ele detectará o PHP automaticamente

### Passo 5: Testar

Abra novo PowerShell:
```powershell
php -v
composer -v
```

---

## 🐳 OPÇÃO 4: Docker Desktop

### Instalação:

1. **Baixe:**
   - https://www.docker.com/products/docker-desktop/

2. **Instale:**
   - Execute o instalador
   - Reinicie o computador

3. **Configure WSL2:**
   - Docker Desktop irá instalar automaticamente

4. **Use o script:**
   ```bash
   ./start.sh  # Funcionará com Docker
   ```

---

## ✅ DEPOIS DE INSTALAR

### Se você instalou Herd:
```powershell
cd D:\CORUZEN\WEBCODER
herd link
herd open
```

### Se você instalou Laragon:
- Apenas abra: http://webcoder.test

### Se você instalou PHP manual:
```powershell
cd D:\CORUZEN\WEBCODER
php artisan serve
```
Em outra janela:
```powershell
npm run dev
```

### Se você instalou Docker:
```bash
./start.sh
```

---

## 🆘 PROBLEMAS?

### "php não é reconhecido como comando"
- Você não adicionou ao PATH ou não reiniciou
- **SOLUÇÃO:** Reinicie o computador!

### "Port 8000 already in use"
- Outra aplicação está usando a porta
- **SOLUÇÃO:** 
  ```powershell
  netstat -ano | findstr :8000
  taskkill /PID <número> /F
  ```

### "Class not found"
- Dependências não instaladas
- **SOLUÇÃO:**
  ```bash
  composer install
  npm install
  ```

---

## 🎯 RECOMENDAÇÃO FINAL

**Use Laravel Herd!** É a opção mais simples e rápida:
- ✅ 1 instalador, tudo pronto
- ✅ Sem configurar PATH
- ✅ Interface gráfica
- ✅ Atualiza automaticamente

**Link:** https://herd.laravel.com/windows

---

Após instalar, volte para: **COMO_TESTAR.md**
