<?php
/**
 * Script de Diagnóstico de Permissões
 * Coloque na pasta public como diagnostico.php
 */

echo "<h1>Diagnóstico de Permissões</h1>";
echo "<pre>";

$basePath = dirname(__DIR__);

echo "=== VERIFICANDO ESTRUTURA ===\n\n";

$paths = [
    'Base Path' => $basePath,
    'Public Path' => __DIR__,
    'Storage Path' => $basePath . '/storage',
    'Bootstrap Cache' => $basePath . '/bootstrap/cache',
];

foreach ($paths as $name => $path) {
    echo "{$name}: {$path}\n";
    echo "  Existe: " . (file_exists($path) ? '✅ Sim' : '❌ Não') . "\n";
    if (file_exists($path)) {
        echo "  Permissões: " . substr(sprintf('%o', fileperms($path)), -4) . "\n";
        echo "  Gravável: " . (is_writable($path) ? '✅ Sim' : '❌ Não') . "\n";
    }
    echo "\n";
}

echo "\n=== ARQUIVOS CRÍTICOS ===\n\n";

$files = [
    'index.php' => __DIR__ . '/index.php',
    '.htaccess' => __DIR__ . '/.htaccess',
    '.env' => $basePath . '/.env',
];

foreach ($files as $name => $file) {
    echo "{$name}: {$file}\n";
    echo "  Existe: " . (file_exists($file) ? '✅ Sim' : '❌ Não') . "\n";
    if (file_exists($file)) {
        echo "  Permissões: " . substr(sprintf('%o', fileperms($file)), -4) . "\n";
        echo "  Tamanho: " . filesize($file) . " bytes\n";
    }
    echo "\n";
}

echo "\n=== COMANDOS PARA CORRIGIR ===\n\n";
echo "Execute via SSH:\n\n";
echo "cd /home1/abdonc73/iagus.com.br\n";
echo "chmod -R 755 .\n";
echo "chmod -R 775 storage bootstrap/cache\n";
echo "find storage -type f -exec chmod 664 {} \\;\n";
echo "find bootstrap/cache -type f -exec chmod 664 {} \\;\n";

echo "</pre>";
