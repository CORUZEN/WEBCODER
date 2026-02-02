#!/bin/bash

# Caminho do PHP do Herd
PHP="C:/Users/Jucelio-PC/.config/herd/bin/php84/php.exe"
COMPOSER="C:/Users/Jucelio-PC/.config/herd/bin/composer.bat"

echo "=========================================="
echo "  IAGUS - Iniciando Servidor"
echo "=========================================="
echo ""

# Verificar se PHP existe
if [ ! -f "$PHP" ]; then
    echo "ERRO: PHP do Herd não encontrado!"
    echo ""
    echo "Verifique se o Herd está instalado em:"
    echo "C:/Users/Jucelio-PC/.config/herd/"
    echo ""
    read -p "Pressione Enter para sair..."
    exit 1
fi

echo "✓ PHP encontrado"
echo ""

# Limpar cache
echo "Limpando cache..."
"$PHP" artisan config:clear 2>/dev/null
"$PHP" artisan cache:clear 2>/dev/null
"$PHP" artisan route:clear 2>/dev/null
echo "✓ Cache limpo"
echo ""

# Criar banco SQLite
if [ ! -f "database/database.sqlite" ]; then
    echo "Criando banco SQLite..."
    touch database/database.sqlite
    echo "✓ Banco criado"
    echo ""
fi

# Executar migrations
echo "Configurando banco de dados..."
"$PHP" artisan migrate --seed --force 2>&1 | grep -E "(Migrating|Seeding|Database|✓)" || echo "Migrações já executadas"
echo "✓ Banco configurado"
echo ""

# Iniciar servidor
echo "=========================================="
echo "  Servidor Iniciando..."
echo "=========================================="
echo ""
echo "Acesse: http://localhost:8000"
echo ""
echo "Admin: admin@iagus.org.br / iagus2026"
echo "User:  joao@example.com / password"
echo ""
echo "Pressione Ctrl+C para parar"
echo ""

# Tentar com artisan primeiro, se falhar usar PHP built-in
"$PHP" artisan serve --host=127.0.0.1 --port=8000 2>/dev/null || "$PHP" -S localhost:8000 -t public
