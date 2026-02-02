# 🐳 Executar com Docker (Recomendado!)

## ✨ Por que Docker?

Com Docker você **NÃO precisa instalar**:
- ❌ PHP
- ❌ Composer
- ❌ MySQL
- ❌ Node.js

Tudo roda dentro de containers isolados! ✅

---

## 📦 Instalação do Docker

### Windows:

1. **Baixe Docker Desktop:**
   - https://www.docker.com/products/docker-desktop

2. **Instale:**
   - Execute o instalador
   - Aceite as configurações padrão
   - Reinicie o computador quando solicitado

3. **Verifique:**
   ```bash
   docker --version
   docker-compose --version
   ```

---

## 🚀 Iniciar o Projeto

Depois de instalar o Docker, é super simples:

```bash
./start.sh
```

**É SÓ ISSO!** O script detecta automaticamente o Docker e:
- ✅ Cria os containers
- ✅ Instala todas as dependências
- ✅ Configura o banco de dados
- ✅ Inicia o servidor

---

## 📊 Comandos Úteis

### Ver logs em tempo real:
```bash
docker-compose logs -f
```

### Parar o servidor:
```bash
docker-compose down
```

### Reiniciar:
```bash
docker-compose restart
```

### Executar comandos Laravel:
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
```

### Executar comandos NPM:
```bash
docker-compose exec vite npm install
docker-compose exec vite npm run build
```

---

## 🌐 Acessar a Aplicação

Depois de executar `./start.sh`:

- **Site:** http://localhost:8000
- **Vite HMR:** http://localhost:5173

**Credenciais:**
- **Admin:** admin@iagus.org.br / iagus2026
- **User:** joao@example.com / password

---

## 🔧 Troubleshooting

### Porta já em uso?

```bash
docker-compose down
./start.sh
```

### Limpar tudo e recomeçar:

```bash
docker-compose down -v
docker system prune -a
./start.sh
```

### Ver containers rodando:

```bash
docker ps
```

---

## 💡 Vantagens do Docker

✅ **Portabilidade:** Funciona igual em qualquer computador  
✅ **Isolamento:** Não interfere com outras instalações  
✅ **Fácil:** Um comando para iniciar tudo  
✅ **Limpo:** Fácil de remover completamente  
✅ **Produção:** Mesmo ambiente em dev e produção  

---

## 🎯 Comparação

### Sem Docker:
1. Instalar PHP
2. Instalar Composer
3. Instalar Node.js
4. Instalar MySQL
5. Configurar tudo
6. Executar

### Com Docker:
1. Instalar Docker
2. Executar `./start.sh`

**Muito mais simples! 🚀**

---

## 📝 Arquivos Docker

- **Dockerfile** - Define o container da aplicação
- **docker-compose.yml** - Orquestra os containers
- **.dockerignore** - Arquivos ignorados no build

---

**Recomendação:** Use Docker! É a forma moderna e mais fácil de rodar projetos Laravel. 🐳
