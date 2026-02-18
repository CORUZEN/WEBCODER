# Script de inicialização para PowerShell
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "  IAGUS - Iniciando Servidor Local" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# Detectar PHP automaticamente
Write-Host "Procurando PHP..." -ForegroundColor Yellow

$phpPaths = @(
    "C:\Users\$env:USERNAME\.config\herd\bin\php84\php.exe",
    "C:\Users\$env:USERNAME\.config\herd\bin\php83\php.exe",
    "C:\Users\$env:USERNAME\.config\herd\bin\php82\php.exe",
    "C:\Users\$env:USERNAME\.config\herd\bin\php.exe",
    "C:\Users\$env:USERNAME\AppData\Local\Herd\bin\php84\php.exe",
    "C:\Users\$env:USERNAME\AppData\Local\Herd\bin\php.exe",
    "C:\laragon\bin\php\php-8.4.0\php.exe",
    "C:\laragon\bin\php\php-8.3.0\php.exe",
    "C:\laragon\bin\php\php-8.2.12\php.exe",
    "C:\laragon\bin\php\php-8.2.0\php.exe",
    "C:\xampp\php\php.exe",
    "C:\wamp64\bin\php\php8.4.0\php.exe",
    "C:\wamp64\bin\php\php8.3.0\php.exe",
    "C:\wamp64\bin\php\php8.2.0\php.exe"
)

$phpCmd = $null

# Primeiro tenta encontrar no PATH
$phpInPath = Get-Command php -ErrorAction SilentlyContinue
if ($phpInPath) {
    $phpCmd = "php"
    Write-Host "PHP encontrado no PATH!" -ForegroundColor Green
} else {
    # Procurar em locais comuns
    foreach ($path in $phpPaths) {
        if (Test-Path $path) {
            $phpCmd = $path
            Write-Host "PHP encontrado: $path" -ForegroundColor Green
            break
        }
    }
}

if (-not $phpCmd) {
    Write-Host "PHP nao encontrado!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Instale uma das opcoes:" -ForegroundColor Yellow
    Write-Host "  1. Laravel Herd: https://herd.laravel.com/windows" -ForegroundColor White
    Write-Host "  2. Laragon: https://laragon.org/download/" -ForegroundColor White
    Write-Host "  3. XAMPP: https://www.apachefriends.org/" -ForegroundColor White
    Write-Host ""
    Write-Host "Ou adicione o PHP ao PATH do sistema." -ForegroundColor Yellow
    Write-Host ""
    Read-Host "Pressione Enter para sair"
    exit 1
}
Write-Host ""

# Matar processos nas portas
Write-Host "Verificando portas..." -ForegroundColor Yellow
$port3001 = Get-NetTCPConnection -LocalPort 3001 -ErrorAction SilentlyContinue
if ($port3001) {
    Write-Host "  Encerrando processo na porta 3001..." -ForegroundColor Yellow
    Stop-Process -Id $port3001.OwningProcess -Force -ErrorAction SilentlyContinue
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

# Verificar e instalar dependências composer se necessário
if (!(Test-Path "vendor\nunomaduro\collision")) {
    Write-Host "Instalando dependencias (composer install)..." -ForegroundColor Yellow
    $composerPaths = @(
        "C:\Users\$env:USERNAME\.config\herd\bin\composer.bat",
        "composer"
    )
    $composerCmd = $null
    foreach ($cp in $composerPaths) {
        if (Get-Command $cp -ErrorAction SilentlyContinue) { $composerCmd = $cp; break }
        if (Test-Path $cp) { $composerCmd = $cp; break }
    }
    if ($composerCmd) {
        & $composerCmd install --working-dir="$PSScriptRoot" 2>$null
        Write-Host "Dependencias instaladas!" -ForegroundColor Green
    } else {
        Write-Host "Composer nao encontrado - pulando instalacao" -ForegroundColor Red
    }
    Write-Host ""
}

# Limpar cache
Write-Host "Limpando cache..." -ForegroundColor Yellow
# Garantir que o diretório de cache existe
New-Item -ItemType Directory -Force -Path "$PSScriptRoot\storage\framework\cache\data" | Out-Null
& $phpCmd artisan cache:clear 2>$null
& $phpCmd artisan config:clear 2>$null
& $phpCmd artisan route:clear 2>$null
& $phpCmd artisan view:clear 2>$null
Write-Host "Cache limpo!" -ForegroundColor Green
Write-Host ""

# Executar migrations
Write-Host "Configurando banco de dados..." -ForegroundColor Yellow
& $phpCmd artisan migrate --force
& $phpCmd artisan db:seed --force 2>&1 | Where-Object { $_ -notmatch 'UniqueConstraint' }
if ($LASTEXITCODE -eq 0) {
    Write-Host "Banco configurado!" -ForegroundColor Green
} else {
    Write-Host "Banco ja configurado!" -ForegroundColor Green
}
Write-Host ""

# Remover public/hot antigo antes de iniciar
if (Test-Path "public\hot") { Remove-Item "public\hot" -Force }

# Matar processos Node antigos (Vite)
Get-Process -Name "node" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue

# Iniciar Vite em background
Write-Host "Iniciando Vite..." -ForegroundColor Yellow
Start-Process -FilePath "npm" -ArgumentList "run", "dev" -WindowStyle Hidden -ErrorAction SilentlyContinue

# Aguardar Vite criar public/hot (confirma que esta pronto)
$viteTimeout = 30
$viteElapsed = 0
Write-Host "Aguardando Vite iniciar" -NoNewline -ForegroundColor Yellow
while (!(Test-Path "public\hot") -and $viteElapsed -lt $viteTimeout) {
    Start-Sleep -Seconds 1
    $viteElapsed++
    Write-Host "." -NoNewline -ForegroundColor Yellow
}
Write-Host "" 
if (Test-Path "public\hot") {
    Write-Host "Vite iniciado e pronto!" -ForegroundColor Green
} else {
    Write-Host "Vite demorou muito - continuando sem HMR" -ForegroundColor Red
}
Write-Host ""

# Mensagens finais
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "  SERVIDOR PRONTO!" -ForegroundColor Green
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Aplicacao: " -NoNewline
Write-Host "http://localhost:3001" -ForegroundColor Yellow
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

# Limpar public/hot ao sair
trap {
    if (Test-Path "public\hot") { Remove-Item "public\hot" -Force -ErrorAction SilentlyContinue }
    break
}

# Iniciar Laravel na porta 3001
try {
    & $phpCmd artisan serve --port=3001
} finally {
    if (Test-Path "public\hot") { Remove-Item "public\hot" -Force -ErrorAction SilentlyContinue }
}
