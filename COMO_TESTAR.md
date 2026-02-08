# 🚀 TESTAR O SISTEMA AGORA

## ⚠️ PRIMEIRO: Você tem PHP instalado?

Se aparecer erro **"PHP não encontrado"**, veja: **[INSTALAR_PHP_WINDOWS.md](INSTALAR_PHP_WINDOWS.md)**

## ⚡ Início Rápido (2 minutos)

### 1️⃣ Iniciar o Servidor

**Windows (sem Docker):**
```bash
start-simples.bat
```

**Windows (com Docker):**
```bash
start.bat
```

**Linux/Mac:**
```bash
./start.sh
```

### 2️⃣ Acessar o Sistema

🌐 **Site:** http://localhost:8000

---

## 👤 CREDENCIAIS DE ACESSO

### Admin (acesso total)
- **URL:** http://localhost:8000/admin
- **Email:** admin@iagus.org.br
- **Senha:** iagus2026

### Usuário Comum (para testar inscrições)
- **URL:** http://localhost:8000/entrar
- **Email:** joao@example.com
- **Senha:** password

---

## ✅ CHECKLIST DE TESTES

### 1. Painel Administrativo

#### Dashboard
- [ ] Acesse `/admin`
- [ ] Veja as estatísticas gerais
- [ ] Clique nos cards de navegação

#### Criar Evento
- [ ] Vá para `/admin/eventos/create`
- [ ] Preencha o formulário
- [ ] **Teste 1:** Evento gratuito (price_cents = 0)
- [ ] **Teste 2:** Evento pago (price_cents = 5000 = R$ 50)
- [ ] Defina vagas (ex: 20)
- [ ] Status: "Publicado"
- [ ] Clique em "Criar Evento"

#### Visualizar Evento
- [ ] Vá para `/admin/eventos`
- [ ] Clique em "Ver" em um evento
- [ ] Veja as estatísticas
- [ ] Veja a lista de inscritos
- [ ] Teste o botão "Exportar CSV"

#### Editar Evento
- [ ] Na tela do evento, clique em "Editar"
- [ ] Altere algum campo
- [ ] Salve as alterações

#### Gerenciar Inscrições
- [ ] Vá para `/admin/inscricoes`
- [ ] **Teste filtro por evento**
- [ ] **Teste filtro por status**
- [ ] **Teste busca** (digite um nome ou email)
- [ ] Clique em "Ver detalhes" de uma inscrição
- [ ] Veja todas as informações

---

### 2. Área Pública (como visitante)

#### Navegação
- [ ] Acesse http://localhost:8000
- [ ] Navegue pelas páginas: Home, Conheça, Cultos, Juventude, Contato
- [ ] Vá para `/eventos`
- [ ] Clique em um evento

#### Páginas de Eventos
- [ ] Veja os detalhes do evento
- [ ] Verifique se o botão de inscrição aparece
- [ ] Tente se inscrever sem login (deve redirecionar)

---

### 3. Sistema de Inscrições (como usuário)

#### Fazer Login
- [ ] Clique em "Entrar"
- [ ] Use: joao@example.com / password
- [ ] Faça login com sucesso

#### Inscrever em Evento Gratuito
- [ ] Vá para `/eventos`
- [ ] Clique em um evento **gratuito**
- [ ] Clique em "Inscrever-se"
- [ ] Confirme a inscrição
- [ ] Veja a mensagem de sucesso

#### Inscrever em Evento Pago
- [ ] Vá para um evento **pago**
- [ ] Clique em "Inscrever-se"
- [ ] Status deve ficar: "Pendente de Pagamento"
- [ ] Veja o link para pagar (Mercado Pago)

#### Minha Conta
- [ ] Vá para `/minha-conta`
- [ ] Veja suas inscrições
- [ ] Clique em uma inscrição
- [ ] Veja os detalhes completos

---

### 4. Testar Fluxo Completo

#### Cenário: Admin cria evento → Usuário se inscreve → Admin visualiza

1. **Como Admin:**
   - [ ] Crie um novo evento (Use criatividade!)
   - [ ] Coloque 10 vagas
   - [ ] Preço: R$ 30,00 (3000 centavos)
   - [ ] Publique o evento

2. **Como Usuário (joao@example.com):**
   - [ ] Faça logout do admin
   - [ ] Faça login como usuário
   - [ ] Vá para eventos
   - [ ] Inscreva-se no evento criado
   - [ ] Veja em "Minha Conta"

3. **Como Admin novamente:**
   - [ ] Faça logout
   - [ ] Faça login como admin
   - [ ] Vá para o evento criado
   - [ ] Veja que há 1 inscrição
   - [ ] Veja vagas: 1/10
   - [ ] Exporte o CSV
   - [ ] Vá para `/admin/inscricoes`
   - [ ] Veja a nova inscrição na lista

---

## 🎨 VERIFICAR DESIGN

### Responsividade
- [ ] Abra em tela cheia (desktop)
- [ ] Reduza a janela (tablet)
- [ ] Reduza mais (mobile)
- [ ] Menu deve colapsar em mobile
- [ ] Tabelas devem ter scroll horizontal

### Componentes
- [ ] Badges coloridos (Pago, Pendente, etc.)
- [ ] Botões com hover effect
- [ ] Cards com sombra
- [ ] Formulários bem espaçados
- [ ] Erros em vermelho

---

## 📊 TESTAR FILTROS E BUSCA

### Na página de inscrições admin
1. **Busca:**
   - [ ] Digite "joão" → deve encontrar
   - [ ] Digite um email → deve encontrar
   - [ ] Digite código de inscrição → deve encontrar

2. **Filtro por Evento:**
   - [ ] Selecione um evento específico
   - [ ] Clique em Filtrar
   - [ ] Veja apenas inscrições desse evento

3. **Filtro por Status:**
   - [ ] Selecione "Pendente de Pagamento"
   - [ ] Veja apenas pendentes
   - [ ] Limpe os filtros

---

## 🐛 PROBLEMAS COMUNS

### Porta 8000 em uso
```bash
# Execute novamente, o script mata o processo:
start.bat
```

### Banco de dados vazio
```bash
php artisan migrate --seed
```

### Assets não carregam
```bash
npm run build
```

### Erro 404 no admin
- Verifique se está logado como admin
- Email: admin@iagus.org.br

---

## 📸 O QUE VOCÊ DEVE VER

### No Dashboard Admin:
✅ 4 cards com números (eventos, inscrições, receita)  
✅ 3 cards de navegação rápida  
✅ Tabela de próximos eventos  

### Na tela de criar evento:
✅ Formulário organizado em cards  
✅ Campos com labels claros  
✅ Textos de ajuda cinza  
✅ Botão azul "Criar Evento"  

### Na tela de detalhes do evento:
✅ 5 cards coloridos no topo (estatísticas)  
✅ Informações do evento (esquerda)  
✅ Tabela de inscritos  
✅ Barra lateral com resumo e ações  

### Na tela de inscrições:
✅ Filtros no topo  
✅ Tabela com badges coloridos  
✅ Paginação no rodapé  

---

## ✅ TUDO FUNCIONANDO?

Se você viu tudo isso, **PARABÉNS!** 🎉

O sistema está **100% operacional** e pronto para:
- ✅ Testes finais
- ✅ Configuração do Mercado Pago
- ✅ Deploy em produção

---

## 🚀 PRÓXIMO PASSO

Configure o Mercado Pago para testar pagamentos reais:

1. Crie conta em: https://www.mercadopago.com.br/developers
2. Pegue as credenciais de teste
3. Configure no `.env`:
```env
MP_ACCESS_TOKEN=TEST-xxxxx
MP_PUBLIC_KEY=TEST-xxxxx
```
4. Teste uma inscrição paga!

---

## 📚 DOCS ÚTEIS

- **Início Rápido:** START_HERE.md
- **Instalação:** INSTALACAO.md
- **Deploy:** docs/DEPLOY_HOSTGATOR.md
- **Desenvolvimento:** DESENVOLVIMENTO_COMPLETO.md

---

**Bons testes! 🚀**
