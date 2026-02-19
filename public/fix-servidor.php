<?php
/**
 * IAGUS - Fix & Setup Script
 * Upload para public/ e acesse: https://iagus.com.br/fix-servidor.php
 * DELETE APÓS USAR!
 */

set_time_limit(300);
header('Content-Type: text/html; charset=UTF-8');

echo '<!DOCTYPE html><html><head><title>IAGUS Fix</title>';
echo '<style>body{font-family:monospace;padding:20px;background:#1a1a2e;color:#eee}';
echo '.ok{color:#0f0}.err{color:#f44}.warn{color:#ff0}.info{color:#00d4ff}';
echo 'h2{color:#00d4ff;border-bottom:1px solid #333;padding-bottom:5px}';
echo 'pre{background:#111;padding:10px;border-radius:5px;overflow-x:auto}</style></head><body>';
echo '<h1>IAGUS - Fix & Setup</h1>';

$baseDir = dirname(__DIR__);
$publicDir = __DIR__;

function runCmd($cmd) {
    $output = [];
    $code = 0;
    exec($cmd . ' 2>&1', $output, $code);
    return ['output' => implode("\n", $output), 'code' => $code];
}

function status($ok, $msg) {
    $class = $ok ? 'ok' : 'err';
    $icon = $ok ? '✅' : '❌';
    echo "<p class='$class'>$icon $msg</p>";
    return $ok;
}

// STEP 1: Fix directory permissions
echo '<h2>1. Corrigir Permissões de Diretórios</h2>';

$dirsToFix = [
    $baseDir => '0755',
    $publicDir => '0755',
    $baseDir . '/storage' => '0775',
    $baseDir . '/storage/app' => '0775',
    $baseDir . '/storage/app/public' => '0775',
    $baseDir . '/storage/framework' => '0775',
    $baseDir . '/storage/framework/sessions' => '0775',
    $baseDir . '/storage/framework/views' => '0775',
    $baseDir . '/storage/framework/cache' => '0775',
    $baseDir . '/storage/framework/cache/data' => '0775',
    $baseDir . '/storage/logs' => '0775',
    $baseDir . '/bootstrap' => '0755',
    $baseDir . '/bootstrap/cache' => '0775',
    $baseDir . '/vendor' => '0755',
    $baseDir . '/config' => '0755',
    $baseDir . '/resources' => '0755',
    $baseDir . '/routes' => '0755',
    $baseDir . '/app' => '0755',
    $baseDir . '/database' => '0755',
    $publicDir . '/build' => '0755',
];

foreach ($dirsToFix as $dir => $perm) {
    $label = str_replace($baseDir, '', $dir) ?: '/';
    if (!is_dir($dir)) {
        @mkdir($dir, octdec($perm), true);
        if (is_dir($dir)) {
            echo "<p class='warn'>📁 Criado: $label ($perm)</p>";
        } else {
            echo "<p class='err'>❌ Não conseguiu criar: $label</p>";
        }
    } else {
        $current = substr(sprintf('%o', fileperms($dir)), -4);
        @chmod($dir, octdec($perm));
        $new = substr(sprintf('%o', fileperms($dir)), -4);
        if ($current !== $new) {
            echo "<p class='ok'>🔧 $label: $current → $new</p>";
        } else {
            echo "<p class='ok'>✅ $label: $current (OK)</p>";
        }
    }
}

// STEP 2: Fix file permissions
echo '<h2>2. Corrigir Permissões de Arquivos Críticos</h2>';

$filesToFix = [
    $publicDir . '/index.php' => '0644',
    $publicDir . '/.htaccess' => '0644',
    $baseDir . '/.env' => '0644',
    $baseDir . '/artisan' => '0755',
    $baseDir . '/composer.json' => '0644',
];

foreach ($filesToFix as $file => $perm) {
    $label = str_replace($baseDir, '', $file);
    if (file_exists($file)) {
        $current = substr(sprintf('%o', fileperms($file)), -4);
        @chmod($file, octdec($perm));
        $new = substr(sprintf('%o', fileperms($file)), -4);
        echo "<p class='ok'>✅ $label: $new (" . filesize($file) . " bytes)</p>";
    } else {
        echo "<p class='err'>❌ $label: NÃO EXISTE</p>";
    }
}

// STEP 3: Remove BACKUP files
echo '<h2>3. Remover arquivos BACKUP</h2>';
$backups = array_merge(
    glob($baseDir . '/*BACKUP*') ?: [],
    glob($publicDir . '/*BACKUP*') ?: [],
    glob($baseDir . '/.*BACKUP*') ?: [],
    glob($publicDir . '/.*BACKUP*') ?: []
);
if (empty($backups)) {
    echo "<p class='ok'>✅ Nenhum arquivo BACKUP</p>";
} else {
    foreach ($backups as $b) {
        if (@unlink($b)) {
            echo "<p class='ok'>🗑️ Removido: " . basename($b) . "</p>";
        } else {
            echo "<p class='err'>❌ Não removeu: $b</p>";
        }
    }
}

// STEP 4: Verify/Create public/.htaccess
echo '<h2>4. Verificar public/.htaccess</h2>';
$publicHtaccess = $publicDir . '/.htaccess';
$correctContent = '<IfModule mod_rewrite.c>
    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
';

if (file_exists($publicHtaccess)) {
    $current = file_get_contents($publicHtaccess);
    if (trim($current) === trim($correctContent)) {
        echo "<p class='ok'>✅ public/.htaccess correto</p>";
    } else {
        file_put_contents($publicHtaccess, $correctContent);
        echo "<p class='warn'>🔧 public/.htaccess atualizado</p>";
    }
} else {
    file_put_contents($publicHtaccess, $correctContent);
    echo "<p class='warn'>📄 public/.htaccess criado</p>";
}

// STEP 5: Remove root .htaccess (not needed when DocumentRoot is public/)
echo '<h2>5. Verificar .htaccess raiz</h2>';
$rootHtaccess = $baseDir . '/.htaccess';
if (file_exists($rootHtaccess)) {
    $content = file_get_contents($rootHtaccess);
    echo "<p class='warn'>⚠️ .htaccess raiz existe (desnecessário com DocumentRoot=public/)</p>";
    echo "<pre>" . htmlspecialchars($content) . "</pre>";
    // Rename it to disable
    if (@rename($rootHtaccess, $rootHtaccess . '.disabled')) {
        echo "<p class='ok'>🔧 Renomeado para .htaccess.disabled</p>";
    }
} else {
    echo "<p class='ok'>✅ Sem .htaccess na raiz (correto para DocumentRoot=public/)</p>";
}

// STEP 6: Verify index.php
echo '<h2>6. Verificar public/index.php</h2>';
$indexPhp = $publicDir . '/index.php';
if (file_exists($indexPhp)) {
    $size = filesize($indexPhp);
    $content = file_get_contents($indexPhp);
    if ($size < 100) {
        echo "<p class='err'>❌ index.php muito pequeno ({$size} bytes) - pode estar corrompido!</p>";
        echo "<pre>" . htmlspecialchars($content) . "</pre>";
    } elseif (strpos($content, 'Illuminate') !== false || strpos($content, 'bootstrap') !== false) {
        echo "<p class='ok'>✅ index.php parece ser Laravel ({$size} bytes)</p>";
    } else {
        echo "<p class='warn'>⚠️ index.php não parece ser Laravel ({$size} bytes)</p>";
        echo "<pre>" . htmlspecialchars(substr($content, 0, 500)) . "</pre>";
    }
} else {
    echo "<p class='err'>❌ public/index.php NÃO EXISTE!</p>";
}

// STEP 7: Run artisan commands
echo '<h2>7. Artisan Commands</h2>';

$php = '/opt/cpanel/ea-php83/root/usr/bin/php';
if (!file_exists($php)) {
    $php = 'php'; // fallback
}

$artisan = $baseDir . '/artisan';
if (!file_exists($artisan)) {
    echo "<p class='err'>❌ artisan não encontrado!</p>";
} else {
    $commands = [
        'optimize:clear' => 'Limpar cache',
        'config:clear' => 'Limpar config cache',
        'route:clear' => 'Limpar route cache',
        'view:clear' => 'Limpar view cache',
    ];
    
    foreach ($commands as $cmd => $label) {
        $result = runCmd("cd $baseDir && $php artisan $cmd");
        $ok = $result['code'] === 0;
        status($ok, "$label ($cmd): " . trim($result['output']));
    }
    
    // Storage link
    echo '<br>';
    $storageLink = $publicDir . '/storage';
    if (is_link($storageLink)) {
        echo "<p class='ok'>✅ Storage link já existe → " . readlink($storageLink) . "</p>";
    } else {
        $result = runCmd("cd $baseDir && $php artisan storage:link");
        status($result['code'] === 0, "storage:link: " . trim($result['output']));
    }
    
    // Migrate
    echo '<br>';
    $result = runCmd("cd $baseDir && $php artisan migrate --force");
    status($result['code'] === 0, "migrate: " . trim($result['output']));
    
    // Optimize
    $result = runCmd("cd $baseDir && $php artisan optimize");
    status($result['code'] === 0, "optimize: " . trim($result['output']));
}

// STEP 8: .env verification
echo '<h2>8. Verificar .env</h2>';
$envPath = $baseDir . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    $checks = [
        'APP_ENV' => 'production',
        'APP_DEBUG' => 'false',
        'APP_URL' => 'https://iagus.com.br',
        'DB_DATABASE' => 'abdonc73_iagus',
    ];
    foreach ($checks as $key => $expected) {
        if (preg_match("/^{$key}=(.*)$/m", $envContent, $m)) {
            $val = trim($m[1]);
            $ok = ($val === $expected);
            $class = $ok ? 'ok' : 'warn';
            echo "<p class='$class'>{$key}={$val}" . ($ok ? ' ✅' : " (esperado: $expected)") . "</p>";
        } else {
            echo "<p class='err'>❌ {$key} não encontrado no .env</p>";
        }
    }
} else {
    echo "<p class='err'>❌ .env NÃO ENCONTRADO!</p>";
}

// STEP 9: Quick HTTP test
echo '<h2>9. Teste Final</h2>';
echo "<p class='info'>Se tudo acima está OK, o site deve funcionar.</p>";
echo "<p><a href='/' style='color:#0f0;font-size:18px'>→ Testar site agora (clique aqui)</a></p>";

echo '<hr><p style="color:#f44;font-size:16px"><b>⚠️ DELETE ESTE ARQUIVO APÓS USAR!</b></p>';
echo '<p style="color:#666">Gerado em: ' . date('Y-m-d H:i:s') . '</p>';
echo '</body></html>';
