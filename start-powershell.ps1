# Script de inicialização para PowerShell
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "  IAGUS - Iniciando Servidor Local" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# Verificar se o PHP está disponível
Write-Host "Verificando PHP..." -ForegroundColor Yellow
$phpVersion = php -v 2>$null
if ($LASTEXITCODE -ne 0) {
    Write-Host "PHP nao encontrado!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Verifique se o Laravel Herd foi instalado corretamente:" -ForegroundColor Yellow
    Write-Host "  1. Abra o aplicativo Herd" -ForegroundColor White
    Write-Host "  2. Verifique se esta rodando" -ForegroundColor White
    Write-Host "  3. Reinicie o computador se necessario" -ForegroundColor White
    Write-Host ""
    exit 1
}
Write-Host "PHP encontrado!" -ForegroundColor Green
Write-Host ""

# Matar processos nas portas
Write-Host "Verificando portas..." -ForegroundColor Yellow
$port8000 = Get-NetTCPConnection -LocalPort 8000 -ErrorAction SilentlyContinue
if ($port8000) {
    Write-Host "  Encerrando processo na porta 8000..." -ForegroundColor Yellow
    Stop-Process -Id $port8000.OwningProcess -Force -ErrorAction SilentlyContinue
}

$port5173 = Get-NetTCPConnection -LocalPort 5173 -ErrorAction SilentlyContinue
if ($port5173) {
    Write-Host "  Encerrando processo na porta 5173..." -ForegroundColor Yellow
    Stop-Process -Id $port5173.OwningProcess -Force -ErrorAction SilentlyContinue
}
Write-Host "Portas liberadas!" -ForegroundColor Green
Write-Host ""

# Criar banco SQLite se não existir
if (!(Test-Path "database\database.sqlite")) {
    Write-Host "Criando banco SQLite..." -ForegroundColor Yellow
    New-Item -ItemType File -Path "database\database.sqlite" -Force | Out-Null
    Write-Host "Banco criado!" -ForegroundColor Green
    Write-Host ""
}

# Limpar cache
Write-Host "Limpando cache..." -ForegroundColor Yellow
php artisan cache:clear 2>$null
php artisan config:clear 2>$null
php artisan route:clear 2>$null
php artisan view:clear 2>$null
Write-Host "Cache limpo!" -ForegroundColor Green
Write-Host ""

# Executar migrations
Write-Host "Configurando banco de dados..." -ForegroundColor Yellow
php artisan migrate --seed --force 2>$null
if ($LASTEXITCODE -eq 0) {
    Write-Host "Banco configurado!" -ForegroundColor Green
} else {
    Write-Host "Banco ja configurado!" -ForegroundColor Green
}
Write-Host ""

# Iniciar Vite em background
Write-Host "Iniciando Vite..." -ForegroundColor Yellow
Start-Process -FilePath "npm" -ArgumentList "run", "dev" -WindowStyle Hidden
Start-Sleep -Seconds 2
Write-Host "Vite iniciado!" -ForegroundColor Green
Write-Host ""

# Mensagens finais
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "  SERVIDOR PRONTO!" -ForegroundColor Green
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Aplicacao: " -NoNewline
Write-Host "http://localhost:8000" -ForegroundColor Yellow
Write-Host "Vite HMR:  " -NoNewline
Write-Host "http://localhost:5173" -ForegroundColor Yellow
Write-Host ""
Write-Host "Admin: " -NoNewline -ForegroundColor White
Write-Host "admin@iagus.org.br" -NoNewline -ForegroundColor Yellow
Write-Host " / " -NoNewline -ForegroundColor White
Write-Host "iagus2026" -ForegroundColor Yellow
Write-Host "User:  " -NoNewline -ForegroundColor White
Write-Host "joao@example.com" -NoNewline -ForegroundColor Yellow
Write-Host " / " -NoNewline -ForegroundColor White
Write-Host "password" -ForegroundColor Yellow
Write-Host ""
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "Pressione Ctrl+C para parar o servidor" -ForegroundColor Yellow
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# Iniciar Laravel
php artisan serve
