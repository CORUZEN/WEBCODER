@echo off
chcp 65001 > nul
cls

echo.
echo ============================================
echo   🚀 IAGUS - Iniciando Servidor
echo ============================================
echo.

REM Verificar se PHP está instalado
where php >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ❌ PHP não encontrado!
    echo.
    echo ⚠️  VOCÊ PRECISA INSTALAR PHP PRIMEIRO
    echo.
    echo 📖 Abra o arquivo: INSTALAR_PHP_WINDOWS.md
    echo.
    echo 💡 OPÇÃO MAIS FÁCIL: Laravel Herd
    echo    https://herd.laravel.com/windows
    echo.
    pause
    exit /b 1
)

echo ✅ PHP encontrado!
php -v | findstr /C:"PHP"
echo.

REM Verificar se Composer está instalado
where composer >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Composer não encontrado!
    echo.
    echo Instale em: https://getcomposer.org/
    echo.
    pause
    exit /b 1
)

echo ✅ Composer encontrado!
echo.

REM Verificar se Node/NPM está instalado
where npm >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ⚠️  NPM não encontrado - Vite não será iniciado
    echo.
    set SKIP_NPM=1
) else (
    echo ✅ NPM encontrado!
    echo.
)

REM Verificar se o .env existe
if not exist ".env" (
    echo 📝 Criando arquivo .env...
    copy .env.example .env >nul 2>&1
    php artisan key:generate
    echo.
)

REM Limpar cache
echo 🧹 Limpando cache...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo ✅ Cache limpo!
echo.

REM Otimizar autoloader
echo ⚡ Otimizando autoloader...
composer dump-autoload -o >nul 2>&1
echo ✅ Otimizado!
echo.

REM Verificar banco de dados
echo 🗄️  Verificando banco de dados...
php artisan migrate:status >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ⚠️  BANCO DE DADOS NÃO CONFIGURADO!
    echo.
    echo 1. Configure o .env com suas credenciais MySQL
    echo 2. Execute: php artisan migrate --seed
    echo.
    echo Continuar mesmo assim? (s/n)
    set /p CONTINUAR=
    if /i not "%CONTINUAR%"=="s" exit /b 1
)
echo.

REM Matar processos na porta 8000
echo 🔍 Verificando porta 8000...
for /f "tokens=5" %%a in ('netstat -aon ^| findstr :8000') do (
    echo 🔪 Matando processo %%a na porta 8000...
    taskkill /F /PID %%a >nul 2>&1
)
echo.

REM Iniciar Vite (se NPM disponível)
if not defined SKIP_NPM (
    echo 🎨 Iniciando Vite (frontend)...
    start "Vite - IAGUS" cmd /c "npm run dev"
    timeout /t 2 /nobreak >nul
    echo ✅ Vite iniciado!
    echo.
)

REM Iniciar servidor Laravel
echo 🚀 Iniciando servidor Laravel...
echo.
echo ============================================
echo   ✅ SERVIDOR RODANDO!
echo ============================================
echo.
echo 🌐 Aplicação: http://localhost:8000
echo 👤 Admin: admin@iagus.org.br / iagus2026
echo.
echo Pressione Ctrl+C para parar
echo.

php artisan serve
