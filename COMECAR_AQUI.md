# 🎯 COMEÇAR AQUI - IAGUS

## 👋 Bem-vindo ao Sistema IAGUS!

Este é o guia definitivo para iniciar o projeto.

---

## ⚡ INÍCIO RÁPIDO (3 passos)

### 1️⃣ Você tem PHP instalado?

Abra o PowerShell e digite:
```powershell
php -v
```

#### ✅ Se mostrou a versão do PHP:
Vá para o **Passo 2**

#### ❌ Se mostrou erro "não reconhecido":
1. Abra: **[INSTALAR_PHP_WINDOWS.md](INSTALAR_PHP_WINDOWS.md)**
2. **Recomendado:** Instale o Laravel Herd (3 minutos)
3. Reinicie o computador
4. Volte aqui e continue no **Passo 2**

---

### 2️⃣ Configurar Banco de Dados

1. Crie um banco MySQL chamado `iagus_site`
2. Abra o arquivo `.env` (na raiz do projeto)
3. Configure suas credenciais:
   ```env
   DB_DATABASE=iagus_site
   DB_USERNAME=root
   DB_PASSWORD=sua_senha
   ```
4. Execute no terminal:
   ```bash
   php artisan migrate --seed
   ```

**Detalhes:** [DATABASE_SETUP.md](DATABASE_SETUP.md)

---

### 3️⃣ Iniciar o Servidor

Dê um duplo clique em:
```
start-simples.bat
```

Ou no terminal:
```bash
start-simples.bat
```

**Aguarde abrir:** http://localhost:8000

---

## 🎉 PRONTO! 

### Acesse o sistema:

🌐 **Site:** http://localhost:8000

👤 **Login Admin:**
- URL: http://localhost:8000/admin
- Email: admin@iagus.org.br
- Senha: iagus2026

👤 **Login Usuário (para testes):**
- Email: joao@example.com
- Senha: password

---

## 📚 GUIAS DISPONÍVEIS

| Guia | Descrição |
|------|-----------|
| **[INSTALAR_PHP_WINDOWS.md](INSTALAR_PHP_WINDOWS.md)** | Como instalar PHP no Windows |
| **[DATABASE_SETUP.md](DATABASE_SETUP.md)** | Configurar banco de dados |
| **[COMO_TESTAR.md](COMO_TESTAR.md)** | Checklist completo de testes |
| **[DESENVOLVIMENTO_COMPLETO.md](DESENVOLVIMENTO_COMPLETO.md)** | Documentação técnica |
| **[AVISOS_CSS.md](AVISOS_CSS.md)** | Sobre os avisos CSS no editor |
| **[RESOLUCAO_PROBLEMAS.md](RESOLUCAO_PROBLEMAS.md)** | Problemas resolvidos |

---

## 🐛 PROBLEMAS COMUNS

### "PHP não é reconhecido"
➡️ Instale o PHP: [INSTALAR_PHP_WINDOWS.md](INSTALAR_PHP_WINDOWS.md)

### "Banco de dados não conecta"
➡️ Configure o .env: [DATABASE_SETUP.md](DATABASE_SETUP.md)

### "Porta 8000 em uso"
```bash
# Execute novamente, o script mata automaticamente:
start-simples.bat
```

### Avisos amarelos no editor (CSS)
➡️ São normais! Leia: [AVISOS_CSS.md](AVISOS_CSS.md)

---

## 🚀 O QUE FAZER DEPOIS

1. **Explore o Admin:**
   - Crie um evento de teste
   - Veja as estatísticas
   - Teste os filtros

2. **Teste como Usuário:**
   - Faça login como usuário comum
   - Inscreva-se em um evento
   - Veja "Minha Conta"

3. **Configure Mercado Pago:**
   - Quando estiver pronto para testar pagamentos
   - Veja o `.env` (seção MP_*)

4. **Deploy em Produção:**
   - [docs/DEPLOY_HOSTGATOR.md](docs/DEPLOY_HOSTGATOR.md)

---

## ✅ CHECKLIST

- [ ] PHP instalado
- [ ] Banco de dados criado  
- [ ] `.env` configurado
- [ ] Migrations executadas (`php artisan migrate --seed`)
- [ ] Servidor iniciado (`start-simples.bat`)
- [ ] Site abrindo no navegador
- [ ] Login admin funcionando

---

## 📞 SUPORTE

Problema não listado? Veja:
- **[RESOLUCAO_PROBLEMAS.md](RESOLUCAO_PROBLEMAS.md)**
- **[COMO_TESTAR.md](COMO_TESTAR.md)**

---

**Desenvolvido com ❤️ para IAGUS - Igreja Anglicana de Garanhuns**

*Sistema 100% funcional e pronto para uso!*
