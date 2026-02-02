# 🚀 Instalação Rápida do PHP para o Projeto IAGUS

## ⚡ Opção 1: Laravel Herd (RECOMENDADO - Mais Fácil!)

Laravel Herd é **GRATUITO** e instala tudo automaticamente em 2 minutos!

### ✅ O que o Herd instala:
- ✅ PHP 8.3
- ✅ Composer
- ✅ Node.js & NPM
- ✅ Nginx
- ✅ Tudo configurado automaticamente!

### 📥 Como Instalar:

1. **Baixe o Herd:**
   - Acesse: https://herd.laravel.com/windows
   - Clique em "Download for Windows"

2. **Instale:**
   - Execute o instalador baixado
   - Clique em "Next, Next, Install"
   - Aguarde 2-3 minutos

3. **Reinicie o terminal:**
   - Feche o Git Bash
   - Abra novamente

4. **Execute o projeto:**
   ```bash
   cd /d/CORUZEN/WEBCODER
   ./start.sh
   ```

**Pronto! ✅**

---

## 📦 Opção 2: Laragon (Alternativa Completa)

### Vantagens:
- Ambiente completo (Apache, MySQL, PHP, Node)
- Interface gráfica
- Múltiplas versões de PHP

### Como Instalar:

1. **Baixe:**
   - https://laragon.org/download/
   - Escolha "Laragon Full"

2. **Instale:**
   - Execute o instalador
   - Deixe as opções padrão
   - Aguarde a instalação

3. **Adicione ao PATH:**
   - Abra o Laragon
   - Menu → Tools → Path → Add Laragon to Path
   - Reinicie o terminal

4. **Teste:**
   ```bash
   php -v
   ```

---

## 🔧 Opção 3: XAMPP (Tradicional)

### Como Instalar:

1. **Baixe:**
   - https://www.apachefriends.org/download.html
   - Escolha PHP 8.2 ou superior

2. **Instale:**
   - Execute o instalador
   - Instale em `C:\xampp`

3. **Adicione ao PATH:**
   - Pressione `Windows + R`
   - Digite: `sysdm.cpl`
   - Avançado → Variáveis de Ambiente
   - Selecione "Path" → Editar
   - Novo → `C:\xampp\php`
   - OK → OK

4. **Reinicie o terminal e teste:**
   ```bash
   php -v
   ```

---

## ✅ Depois da Instalação

Execute no projeto:

```bash
cd /d/CORUZEN/WEBCODER
./start.sh
```

O script vai:
- ✅ Detectar o PHP automaticamente
- ✅ Criar o banco SQLite
- ✅ Executar migrations
- ✅ Iniciar o servidor

---

## 🆘 Ainda com Problemas?

### Verificar se o PHP foi instalado:

```bash
php -v
```

Se aparecer a versão do PHP, está OK!

### Verificar se o Composer foi instalado:

```bash
composer -v
```

### Se ainda não funcionar:

1. **Feche TODOS os terminais**
2. **Reinicie o computador**
3. **Abra um NOVO Git Bash**
4. **Teste novamente**

---

## 💡 Recomendação Final

**Use o Laravel Herd!** É de longe a opção mais fácil:
- ✅ Instalação automática
- ✅ Já vem com tudo
- ✅ Totalmente gratuito
- ✅ Feito especialmente para Laravel

**Download:** https://herd.laravel.com/windows

---

Após instalar, execute:
```bash
./start.sh
```

🎉 **Seu servidor vai iniciar automaticamente!**
