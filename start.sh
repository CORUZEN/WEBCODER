#!/bin/bash

echo "=========================================="
echo "🚀 IAGUS - Iniciando Servidor Local"
echo "=========================================="
echo ""

# Cores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Verificar se Docker está disponível
if command -v docker &> /dev/null && command -v docker-compose &> /dev/null; then
    echo -e "${BLUE}🐳 Docker detectado! Iniciando com Docker...${NC}"
    echo ""
    
    # Parar containers antigos
    echo -e "${YELLOW}📦 Parando containers antigos...${NC}"
    docker-compose down 2>/dev/null
    
    # Criar banco SQLite se não existir
    if [ ! -f "database/database.sqlite" ]; then
        echo -e "${YELLOW}💾 Criando banco SQLite...${NC}"
        touch database/database.sqlite
    fi
    
    # Iniciar containers
    echo -e "${YELLOW}🚀 Iniciando containers...${NC}"
    docker-compose up -d
    
    echo ""
    echo -e "${GREEN}==========================================${NC}"
    echo -e "${GREEN}  ✅ SERVIDOR RODANDO COM DOCKER!${NC}"
    echo -e "${GREEN}==========================================${NC}"
    echo ""
    echo -e "${BLUE}📱 Aplicação:${NC} http://localhost:8000"
    echo -e "${BLUE}🎨 Vite HMR:${NC}  http://localhost:5173"
    echo ""
    echo -e "${YELLOW}👤 Admin:${NC} admin@iagus.org.br / iagus2026"
    echo -e "${YELLOW}👤 User:${NC}  joao@example.com / password"
    echo ""
    echo -e "${GREEN}==========================================${NC}"
    echo ""
    echo -e "${BLUE}📊 Ver logs:${NC}       docker-compose logs -f"
    echo -e "${BLUE}🛑 Parar servidor:${NC} docker-compose down"
    echo ""
    
    exit 0
fi

# Se Docker não está disponível, usar método tradicional
echo -e "${YELLOW}⚠️  Docker não encontrado. Usando modo tradicional...${NC}"
echo ""

# Detectar PHP no Windows (Git Bash)
PHP_CMD="php"

if [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "win32" ]]; then
    echo -e "${YELLOW}🔍 Detectando PHP no Windows...${NC}"
    
    # Tentar encontrar PHP usando o comando Windows
    PHP_PATH=$(cmd.exe //c "where php.exe 2>nul" | head -1 | tr -d '\r')
    
    if [ -z "$PHP_PATH" ]; then
        # Procurar em locais comuns
        COMMON_PATHS=(
            "/c/laragon/bin/php/php-8.3.0/php.exe"
            "/c/laragon/bin/php/php-8.2.12/php.exe"
            "/c/laragon/bin/php/php-8.2.0/php.exe"
            "/c/laragon/bin/php/php-8.1.0/php.exe"
            "/c/xampp/php/php.exe"
            "/c/wamp64/bin/php/php8.3.0/php.exe"
            "/c/wamp64/bin/php/php8.2.0/php.exe"
            "/c/wamp/bin/php/php8.2.0/php.exe"
        )
        
        for path in "${COMMON_PATHS[@]}"; do
            if [ -f "$path" ]; then
                PHP_PATH="$path"
                break
            fi
        done
    fi
    
    if [ ! -z "$PHP_PATH" ]; then
        PHP_CMD="$PHP_PATH"
        echo -e "${GREEN}✓ PHP encontrado: $PHP_PATH${NC}"
    else
        echo -e "${RED}✗ PHP não encontrado!${NC}"
        echo ""
        echo -e "${BLUE}💡 SOLUÇÃO MAIS FÁCIL: Use Docker!${NC}"
        echo ""
        echo "1. Instale Docker Desktop:"
        echo "   https://www.docker.com/products/docker-desktop"
        echo ""
        echo "2. Execute este script novamente"
        echo ""
        echo -e "${YELLOW}Ou instale PHP manualmente:${NC}"
        echo "  - Laravel Herd: https://herd.laravel.com/windows"
        echo "  - Laragon: https://laragon.org/download/"
        echo ""
        exit 1
    fi
    echo ""
fi

# Detectar Composer
COMPOSER_CMD="composer"
if [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "win32" ]]; then
    COMPOSER_PATH=$(cmd.exe //c "where composer.bat 2>nul" | head -1 | tr -d '\r')
    if [ ! -z "$COMPOSER_PATH" ]; then
        COMPOSER_CMD="$COMPOSER_PATH"
    fi
fi

# Função para matar processos na porta
kill_port() {
    local port=$1
    echo -e "${YELLOW}Verificando porta $port...${NC}"
    
    # Para Windows (Git Bash/WSL)
    if [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "win32" ]]; then
        local pid=$(netstat -ano | findstr ":$port" | awk '{print $5}' | head -n 1)
        if [ ! -z "$pid" ]; then
            echo -e "${RED}Processo encontrado na porta $port (PID: $pid). Encerrando...${NC}"
            taskkill //PID $pid //F 2>/dev/null
            sleep 1
        fi
    else
        # Para Linux/Mac
        local pid=$(lsof -ti:$port)
        if [ ! -z "$pid" ]; then
            echo -e "${RED}Processo encontrado na porta $port (PID: $pid). Encerrando...${NC}"
            kill -9 $pid 2>/dev/null
            sleep 1
        fi
    fi
}

# Verificar e matar processos nas portas 8000 (Laravel) e 5173 (Vite)
echo -e "${YELLOW}📡 Verificando portas em uso...${NC}"
kill_port 8000
kill_port 5173

echo ""
echo -e "${GREEN}✓ Portas liberadas${NC}"
echo ""

# Limpar cache do Laravel
echo -e "${YELLOW}🧹 Limpando cache...${NC}"
"$PHP_CMD" artisan cache:clear 2>/dev/null || echo "  Cache já limpo"
"$PHP_CMD" artisan config:clear 2>/dev/null || echo "  Config já limpo"
"$PHP_CMD" artisan route:clear 2>/dev/null || echo "  Routes já limpas"
"$PHP_CMD" artisan view:clear 2>/dev/null || echo "  Views já limpas"

echo ""
echo -e "${GREEN}✓ Cache limpo${NC}"
echo ""

# Criar banco SQLite se não existir
if [ ! -f "database/database.sqlite" ]; then
    echo -e "${YELLOW}💾 Criando banco SQLite...${NC}"
    touch database/database.sqlite
    echo -e "${GREEN}✓ Banco criado!${NC}"
    echo ""
fi

# Verificar se o .env existe
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚙️  Arquivo .env não encontrado. Criando...${NC}"
    cp .env.example .env
    "$PHP_CMD" artisan key:generate
    echo -e "${GREEN}✓ Arquivo .env criado${NC}"
    echo ""
    echo -e "${RED}⚠️  IMPORTANTE: Configure o banco de dados no arquivo .env${NC}"
    echo ""
fi

# Verificar se as tabelas existem
echo -e "${YELLOW}📊 Verificando banco de dados...${NC}"
"$PHP_CMD" artisan migrate:status > /dev/null 2>&1
if [ $? -ne 0 ]; then
    echo -e "${YELLOW}⚠️  Executando migrations...${NC}"
    "$PHP_CMD" artisan migrate --seed --force
    echo -e "${GREEN}✓ Banco configurado!${NC}"
    echo ""
else
    echo -e "${GREEN}✓ Banco já configurado${NC}"
    echo ""
fi

# Otimizar autoloader
echo -e "${YELLOW}⚡ Otimizando autoloader...${NC}"
"$COMPOSER_CMD" dump-autoload -o > /dev/null 2>&1
echo -e "${GREEN}✓ Autoloader otimizado${NC}"
echo ""

# Iniciar Vite em background
echo -e "${YELLOW}🎨 Iniciando Vite (frontend)...${NC}"
npm run dev > storage/logs/vite.log 2>&1 &
VITE_PID=$!
echo -e "${GREEN}✓ Vite iniciado (PID: $VITE_PID)${NC}"
echo ""

# Aguardar Vite iniciar
sleep 3

# Iniciar servidor Laravel
echo -e "${YELLOW}⚙️  Iniciando servidor Laravel...${NC}"
echo ""
echo "=========================================="
echo -e "${GREEN}✅ SERVIDOR PRONTO!${NC}"
echo "=========================================="
echo ""
echo -e "📱 Aplicação: ${GREEN}http://localhost:8000${NC}"
echo -e "🎨 Vite HMR:  ${GREEN}http://localhost:5173${NC}"
echo ""
echo -e "👤 Admin: ${YELLOW}admin@iagus.org.br${NC} / ${YELLOW}iagus2026${NC}"
echo -e "👤 User:  ${YELLOW}joao@example.com${NC} / ${YELLOW}password${NC}"
echo ""
echo "=========================================="
echo -e "${YELLOW}Pressione Ctrl+C para parar o servidor${NC}"
echo "=========================================="
echo ""

# Iniciar Laravel (este fica em foreground)
"$PHP_CMD" artisan serve

# Quando Laravel é encerrado, matar o Vite também
kill $VITE_PID 2>/dev/null
