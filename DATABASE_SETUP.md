# 🗄️ Configuração do Banco de Dados

## Passo 1: Criar o Banco de Dados

### Opção A: Via Linha de Comando MySQL

```bash
mysql -u root -p
```

Depois execute:

```sql
CREATE DATABASE iagus_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### Opção B: Via phpMyAdmin

1. Acesse http://localhost/phpmyadmin
2. Clique em "Novo" ou "New"
3. Nome do banco: `iagus_site`
4. Collation: `utf8mb4_unicode_ci`
5. Clique em "Criar"

## Passo 2: Configurar o .env

Edite o arquivo `.env` na raiz do projeto:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iagus_site
DB_USERNAME=root
DB_PASSWORD=          # Coloque sua senha aqui (ou deixe vazio se não tiver)
```

## Passo 3: Executar as Migrations

```bash
php artisan migrate --seed
```

Isso irá:
- ✅ Criar todas as tabelas (users, events, registrations, payments, webhook_events)
- ✅ Criar usuário admin: `admin@iagus.org.br` / senha: `iagus2026`
- ✅ Criar usuário teste: `joao@example.com` / senha: `password`
- ✅ Criar 4 eventos de exemplo

## Verificar se está tudo OK

```bash
php artisan migrate:status
```

Deve mostrar todas as migrations com status "Ran".

## Resetar o Banco (se necessário)

```bash
# Apaga tudo e recria do zero
php artisan migrate:fresh --seed
```

## Problemas Comuns

### Erro: "SQLSTATE[HY000] [1045] Access denied"
- Verifique usuário e senha no `.env`
- Verifique se o MySQL está rodando

### Erro: "SQLSTATE[HY000] [1049] Unknown database"
- O banco `iagus_site` não foi criado
- Execute o Passo 1 novamente

### Erro: "SQLSTATE[42000]: Syntax error or access violation: 1071"
- Problema de charset
- Certifique-se que criou o banco com `utf8mb4_unicode_ci`

---

**Pronto! Banco configurado! 🎉**

Agora execute `start.bat` (Windows) ou `./start.sh` (Linux/Mac) para iniciar o servidor.
