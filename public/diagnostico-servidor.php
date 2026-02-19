<?php
/**
 * IAGUS - Diagnóstico do Servidor
 * Upload para public/ e acesse: https://iagus.com.br/diagnostico-servidor.php
 * DELETE APÓS USAR!
 */

header('Content-Type: text/html; charset=UTF-8');

echo '<!DOCTYPE html><html><head><title>IAGUS Diagnóstico</title>';
echo '<style>body{font-family:monospace;padding:20px;background:#1a1a2e;color:#eee}';
echo '.ok{color:#0f0}.err{color:#f44}.warn{color:#ff0}h2{color:#00d4ff;border-bottom:1px solid #333;padding-bottom:5px}';
echo 'pre{background:#111;padding:10px;border-radius:5px;overflow-x:auto}</style></head><body>';
echo '<h1>IAGUS - Diagnóstico do Servidor</h1>';

// 1. PHP Info básico
echo '<h2>1. PHP</h2>';
echo '<p>Versão: <b>' . PHP_VERSION . '</b></p>';
echo '<p>SAPI: <b>' . php_sapi_name() . '</b></p>';
echo '<p>SO: <b>' . PHP_OS . '</b></p>';

// 2. Paths
echo '<h2>2. Caminhos</h2>';
echo '<p>__FILE__: <b>' . __FILE__ . '</b></p>';
echo '<p>__DIR__: <b>' . __DIR__ . '</b></p>';
echo '<p>DOCUMENT_ROOT: <b>' . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . '</b></p>';
echo '<p>SCRIPT_FILENAME: <b>' . ($_SERVER['SCRIPT_FILENAME'] ?? 'N/A') . '</b></p>';
echo '<p>REQUEST_URI: <b>' . ($_SERVER['REQUEST_URI'] ?? 'N/A') . '</b></p>';

$baseDir = dirname(__DIR__); // iagus.com.br/
$publicDir = __DIR__; // iagus.com.br/public/

// 3. Permissões de diretórios
echo '<h2>3. Permissões de Diretórios</h2>';
$dirs = [
    $baseDir => 'iagus.com.br/',
    $publicDir => 'iagus.com.br/public/',
    $baseDir . '/storage' => 'storage/',
    $baseDir . '/storage/framework' => 'storage/framework/',
    $baseDir . '/storage/logs' => 'storage/logs/',
    $baseDir . '/bootstrap/cache' => 'bootstrap/cache/',
    $baseDir . '/vendor' => 'vendor/',
];

foreach ($dirs as $path => $label) {
    if (is_dir($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $owner = function_exists('posix_getpwuid') ? posix_getpwuid(fileowner($path))['name'] : fileowner($path);
        $group = function_exists('posix_getgrgid') ? posix_getgrgid(filegroup($path))['gid'] : filegroup($path);
        $class = ($perms >= '0755') ? 'ok' : 'err';
        echo "<p class='$class'>$label → <b>$perms</b> (owner: $owner, group: $group)</p>";
    } else {
        echo "<p class='err'>$label → <b>NÃO EXISTE</b></p>";
    }
}

// 4. Arquivos críticos
echo '<h2>4. Arquivos Críticos</h2>';
$files = [
    $baseDir . '/.env' => '.env',
    $baseDir . '/.htaccess' => '.htaccess (raiz)',
    $publicDir . '/.htaccess' => 'public/.htaccess',
    $publicDir . '/index.php' => 'public/index.php',
    $baseDir . '/artisan' => 'artisan',
    $baseDir . '/vendor/autoload.php' => 'vendor/autoload.php',
    $baseDir . '/bootstrap/app.php' => 'bootstrap/app.php',
    $baseDir . '/storage/app/.gitignore' => 'storage/app/.gitignore',
];

foreach ($files as $path => $label) {
    if (file_exists($path)) {
        $size = filesize($path);
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $class = 'ok';
        if ($label === '.env' && $size < 100) $class = 'warn';
        echo "<p class='$class'>$label → <b>$perms</b> ({$size} bytes)</p>";
    } else {
        $class = ($label === '.htaccess (raiz)') ? 'warn' : 'err';
        echo "<p class='$class'>$label → <b>NÃO EXISTE</b></p>";
    }
}

// 4b. Check for BACKUP files that shouldn't be there
echo '<h2>4b. Arquivos BACKUP (devem ser removidos)</h2>';
$backups = glob($baseDir . '/*BACKUP*') + glob($publicDir . '/*BACKUP*');
if (empty($backups)) {
    echo "<p class='ok'>Nenhum arquivo BACKUP encontrado ✓</p>";
} else {
    foreach ($backups as $b) {
        echo "<p class='warn'>BACKUP encontrado: " . basename($b) . " em " . dirname($b) . "</p>";
    }
}

// 5. .htaccess content
echo '<h2>5. Conteúdo dos .htaccess</h2>';
foreach ([$baseDir . '/.htaccess', $publicDir . '/.htaccess'] as $htfile) {
    $label = str_replace($baseDir, '', $htfile);
    if (file_exists($htfile)) {
        echo "<p><b>$label:</b></p><pre>" . htmlspecialchars(file_get_contents($htfile)) . "</pre>";
    } else {
        echo "<p class='warn'>$label não existe</p>";
    }
}

// 6. .env check (sem mostrar senhas)
echo '<h2>6. .env (sem senhas)</h2>';
$envPath = $baseDir . '/.env';
if (file_exists($envPath)) {
    $env = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    echo '<pre>';
    foreach ($env as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        $parts = explode('=', $line, 2);
        $key = $parts[0] ?? '';
        $val = $parts[1] ?? '';
        // Mask sensitive values
        if (preg_match('/(PASSWORD|SECRET|KEY|TOKEN)/i', $key) && $key !== 'APP_KEY') {
            echo htmlspecialchars($key) . '=***MASKED***' . "\n";
        } else {
            echo htmlspecialchars($line) . "\n";
        }
    }
    echo '</pre>';
} else {
    echo "<p class='err'>.env NÃO ENCONTRADO!</p>";
}

// 7. Storage link
echo '<h2>7. Storage Link</h2>';
$storageLink = $publicDir . '/storage';
if (is_link($storageLink)) {
    $target = readlink($storageLink);
    echo "<p class='ok'>Symlink OK → $target</p>";
} elseif (is_dir($storageLink)) {
    echo "<p class='warn'>É um diretório (não symlink)</p>";
} else {
    echo "<p class='err'>NÃO EXISTE - precisa rodar artisan storage:link</p>";
}

// 8. Test Laravel bootstrap
echo '<h2>8. Laravel Bootstrap Test</h2>';
try {
    $autoload = $baseDir . '/vendor/autoload.php';
    if (!file_exists($autoload)) {
        throw new \Exception('vendor/autoload.php não encontrado!');
    }
    require $autoload;
    
    $app = require_once $baseDir . '/bootstrap/app.php';
    echo "<p class='ok'>Laravel bootstrap OK ✓</p>";
    echo '<p>Laravel Version: <b>' . \Illuminate\Foundation\Application::VERSION . '</b></p>';
} catch (\Throwable $e) {
    echo "<p class='err'>ERRO: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre class='err'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

// 9. Database connection
echo '<h2>9. Banco de Dados</h2>';
try {
    $dbHost = env('DB_HOST', '127.0.0.1');
    $dbName = env('DB_DATABASE', '');
    $dbUser = env('DB_USERNAME', '');
    $dbPass = env('DB_PASSWORD', '');
    
    if (empty($dbName)) {
        throw new \Exception('DB_DATABASE não configurado no .env');
    }
    
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p class='ok'>Conexão OK ✓ - " . count($tables) . " tabelas</p>";
    echo '<p>Tabelas: ' . implode(', ', $tables) . '</p>';
} catch (\Throwable $e) {
    echo "<p class='err'>ERRO DB: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// 10. Apache error log (últimas linhas se acessível)
echo '<h2>10. Error Log</h2>';
$errorLog = ini_get('error_log');
echo "<p>error_log config: <b>" . ($errorLog ?: 'default') . "</b></p>";

$possibleLogs = [
    $baseDir . '/storage/logs/laravel.log',
    $baseDir . '/error_log',
    $publicDir . '/error_log',
];

foreach ($possibleLogs as $logFile) {
    $label = str_replace($baseDir, '', $logFile);
    if (file_exists($logFile)) {
        $size = filesize($logFile);
        echo "<p><b>$label</b> ({$size} bytes) - últimas 10 linhas:</p>";
        $lines = file($logFile);
        $last = array_slice($lines, -10);
        echo '<pre>' . htmlspecialchars(implode('', $last)) . '</pre>';
    }
}

// 11. Listar arquivos no public/
echo '<h2>11. Arquivos em public/</h2>';
$publicFiles = scandir($publicDir);
echo '<pre>';
foreach ($publicFiles as $f) {
    if ($f === '.' || $f === '..') continue;
    $fullPath = $publicDir . '/' . $f;
    $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
    $type = is_dir($fullPath) ? 'DIR' : 'FILE';
    $size = is_file($fullPath) ? filesize($fullPath) : '-';
    printf("%-4s %-6s %8s  %s\n", $perms, $type, $size, $f);
}
echo '</pre>';

// 12. Apache modules
echo '<h2>12. Apache Modules</h2>';
if (function_exists('apache_get_modules')) {
    $mods = apache_get_modules();
    $important = ['mod_rewrite', 'mod_security', 'mod_security2', 'mod_headers', 'mod_expires'];
    foreach ($important as $m) {
        $has = in_array($m, $mods);
        $class = $has ? 'ok' : 'warn';
        echo "<p class='$class'>$m: " . ($has ? 'SIM' : 'NÃO') . "</p>";
    }
} else {
    echo "<p class='warn'>apache_get_modules() não disponível</p>";
}

echo '<hr><p style="color:#666">Gerado em: ' . date('Y-m-d H:i:s') . ' | <b>DELETE ESTE ARQUIVO APÓS USAR!</b></p>';
echo '</body></html>';
