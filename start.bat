@echo off
echo ==========================================
echo  IAGUS - Iniciando Servidor
echo ==========================================
echo.
echo Executando via PowerShell...
echo.

powershell.exe -ExecutionPolicy Bypass -File "%~dp0start-powershell.ps1"

if errorlevel 1 (
    echo.
    echo Erro ao executar. Pressione qualquer tecla para sair.
    pause >nul
)

REM Verificar e matar processos na porta 8000 (Laravel)
echo 📡 Verificando porta 8000...
for /f "tokens=5" %%a in ('netstat -ano ^| findstr :8000') do (
    echo Encerrando processo %%a...
    taskkill /F /PID %%a >nul 2>&1
)

REM Verificar e matar processos na porta 5173 (Vite)
echo 📡 Verificando porta 5173...
for /f "tokens=5" %%a in ('netstat -ano ^| findstr :5173') do (
    echo Encerrando processo %%a...
    taskkill /F /PID %%a >nul 2>&1
)

timeout /t 2 /nobreak >nul

echo.
echo ✓ Portas liberadas
echo.

REM Criar banco SQLite se não existir
if not exist "database\database.sqlite" (
    echo 💾 Criando banco SQLite...
    type nul > database\database.sqlite
    echo ✓ Banco criado!
    echo.
)

REM Limpar cache
echo 🧹 Limpando cache...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo.
echo ✓ Cache limpo
echo.

REM Executar migrations
echo 📊 Verificando banco de dados...
php artisan migrate --seed --force >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo ✓ Banco de dados atualizado
) else (
    echo ℹ️  Banco já configurado
)
echo.

REM Verificar .env
if not exist .env (
    echo ⚙️  Criando arquivo .env...
    copy .env.example .env
    php artisan key:generate
    echo.
    echo ⚠️  IMPORTANTE: Configure o banco de dados no arquivo .env
    echo.
)

REM Otimizar autoloader
echo ⚡ Otimizando autoloader...
composer dump-autoload -o >nul 2>&1

echo.
echo 🎨 Iniciando Vite em segundo plano...
start /B npm run dev > storage\logs\vite.log 2>&1

timeout /t 3 /nobreak >nul

echo.
echo 💾 Banco: SQLite (local)
echo    No HostGator: trocar para MySQL no .env
echo.
echo ==========================================
echo ✅ SERVIDOR PRONTO!
echo ==========================================
echo.
echo 📱 Aplicação: http://localhost:8000
echo 🎨 Vite HMR:  http://localhost:5173
echo.
echo 👤 Admin: admin@iagus.org.br / iagus2026
echo 👤 User:  joao@example.com / password
echo.
echo ==========================================
echo Pressione Ctrl+C para parar o servidor
echo ==========================================
echo.

REM Iniciar Laravel
php artisan serve
