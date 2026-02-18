<?php
/**
 * Diagnóstico de erros - REMOVER APÓS DIAGNÓSTICO
 * Acesse: https://iagus.com.br/check.php
 */

// Segurança básica
$allowed = ['177.', '189.', '201.', '186.', '::1', '127.'];
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$ok = false;
foreach ($allowed as $prefix) {
    if (str_starts_with($ip, $prefix)) { $ok = true; break; }
}
// Descomente para restringir acesso por IP:
// if (!$ok) { http_response_code(403); exit('Acesso negado'); }

$basePath = dirname(__DIR__);

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Diagnóstico IAGUS</title></head><body>";
echo "<style>pre{background:#1f2937;color:#f3f4f6;padding:15px;border-radius:8px;overflow-x:auto;font-size:12px}h2{color:#1d4ed8}table{border-collapse:collapse}td,th{border:1px solid #ddd;padding:8px}td:first-child{font-weight:bold}</style>";

echo "<h1>Diagnóstico IAGUS - " . date('d/m/Y H:i:s') . "</h1>";

// Diretório raiz
echo "<h2>Estrutura de diretórios do servidor</h2><pre>";
$root = '/home1/abdonc73/iagus.com.br';
$dirs = ['vendor', 'vendor/laravel', 'public/build', 'bootstrap/cache', 'storage'];
foreach ($dirs as $d) {
    $full = "$root/$d";
    $exists = file_exists($full);
    $count = $exists && is_dir($full) ? count(glob("$full/*")) : 0;
    echo str_pad($d, 30) . ($exists ? "✅ EXISTS ($count items)" : "❌ MISSING") . "\n";
}
// Verificar vendor/autoload.php especificamente
echo "\nvendor/autoload.php: " . (file_exists("$root/vendor/autoload.php") ? "✅ EXISTS" : "❌ MISSING") . "\n";
// Listar repositórios disponíveis
echo "\n=== Repositórios cPanel ===\n";
$repoBase = '/home1/abdonc73/repositories';
if (is_dir($repoBase)) {
    foreach (glob("$repoBase/*") as $repo) {
        $hasVendor = file_exists("$repo/vendor/autoload.php");
        echo basename($repo) . " → vendor/autoload.php: " . ($hasVendor ? "✅" : "❌") . "\n";
    }
}
echo "</pre>";

// Compiler e PHP
echo "<h2>PHP e Composer</h2><table>";
echo "<tr><td>PHP versão</td><td>" . PHP_VERSION . "</td></tr>";
$phpPaths = ['/usr/local/bin/php', '/usr/bin/php', '/opt/cpanel/ea-php84/root/usr/bin/php', '/opt/cpanel/ea-php83/root/usr/bin/php'];
foreach ($phpPaths as $p) {
    if (file_exists($p)) echo "<tr><td>PHP bin</td><td style='color:green'>{$p} ✅</td></tr>";
}
$composerPaths = ['/usr/local/bin/composer', '/usr/bin/composer', '/opt/cpanel/composer/bin/composer', $basePath.'/composer.phar'];
foreach ($composerPaths as $p) {
    $exists = file_exists($p);
    echo "<tr><td>Composer: {$p}</td><td style='color:" . ($exists?'green':'red') . "'>" . ($exists?'✅ encontrado':'❌ não existe') . "</td></tr>";
}
// Testar exec
$composerOutput = @shell_exec('which composer 2>&1');
echo "<tr><td>which composer</td><td>" . htmlspecialchars($composerOutput ?: '(vazio)') . "</td></tr>";
$phpOutput = @shell_exec('which php 2>&1');
echo "<tr><td>which php</td><td>" . htmlspecialchars($phpOutput ?: '(vazio)') . "</td></tr>";
echo "</table>";

// Arquivos críticos
echo "<h2>Arquivos Críticos</h2><table>";
$files = [
    'vendor/autoload.php' => $basePath . '/vendor/autoload.php',
    '.env' => $basePath . '/.env',
    'storage/logs/' => $basePath . '/storage/logs',
    'bootstrap/cache/' => $basePath . '/bootstrap/cache',
    'public/build/manifest.json' => $basePath . '/public/build/manifest.json',
];
foreach ($files as $name => $path) {
    $exists = file_exists($path);
    $writable = is_dir($path) ? is_writable($path) : true;
    $color = $exists ? ($writable ? 'green' : 'orange') : 'red';
    echo "<tr><td>{$name}</td><td style='color:{$color}'>" . ($exists ? ($writable ? '✅ OK' : '⚠️ Sem escrita') : '❌ FALTANDO') . "</td></tr>";
}
echo "</table>";

// Vendor platform check
$platformCheck = $basePath . '/vendor/composer/platform_check.php';
echo "<h2>Platform Check</h2><table>";
echo "<tr><td>platform_check.php existe</td><td>" . (file_exists($platformCheck) ? '⚠️ SIM (pode bloquear)' : '✅ NÃO (correto com platform-check:false)') . "</td></tr>";
echo "</table>";

// .env básico (sem mostrar senhas)
echo "<h2>.env (apenas chaves)</h2><table>";
$envFile = $basePath . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $val = trim($parts[1]);
            // Mascarar valores sensíveis
            if (str_contains(strtolower($key), 'password') || str_contains(strtolower($key), 'secret') || str_contains(strtolower($key), 'key')) {
                $val = strlen($val) > 0 ? '***' . substr($val, -4) : '(vazio)';
            }
            echo "<tr><td>{$key}</td><td>{$val}</td></tr>";
        }
    }
} else {
    echo "<tr><td colspan='2' style='color:red'>❌ .env NÃO ENCONTRADO!</td></tr>";
}
echo "</table>";

// Log de erros Laravel
echo "<h2>Últimas 80 linhas do laravel.log</h2>";
$logFile = $basePath . '/storage/logs/laravel.log';
echo "<pre>";
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -80);
    echo htmlspecialchars(implode('', $lastLines));
} else {
    echo "Log não encontrado em: {$logFile}";
    // Tentar error_log do Apache
    $errorLog = $basePath . '/public/error_log';
    if (file_exists($errorLog)) {
        echo "\n\n=== error_log do Apache (últimas 30 linhas) ===\n";
        $errLines = file($errorLog);
        echo htmlspecialchars(implode('', array_slice($errLines, -30)));
    }
}
echo "</pre>";

echo "</body></html>";
