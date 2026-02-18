<?php
// ARQUIVO TEMPORÁRIO - DELETE APÓS USO!
// Acesse: https://iagus.com.br/setup-run.php?token=IAGUS2026SETUP
// Depois delete pelo File Manager: public/setup-run.php

if (($_GET['token'] ?? '') !== 'IAGUS2026SETUP') {
    http_response_code(403);
    die('Proibido.');
}

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);
chdir($root);

require $root . '/vendor/autoload.php';

$app = require_once $root . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo '<pre style="font-family:monospace;background:#1a1a1a;color:#00ff00;padding:20px;font-size:13px;">';
echo "=== SETUP IAGUS ===\n\n";

$commands = [
    ['optimize:clear',   []],
    ['migrate:fresh',    ['--force' => true, '--seed' => true]],
    ['storage:link',     []],
    ['optimize',         []],
];

foreach ($commands as [$cmd, $args]) {
    echo "▶ php artisan $cmd\n";
    try {
        $status = $kernel->call($cmd, $args);
        echo $kernel->output();
        echo ($status === 0 ? "✅ OK\n" : "⚠️  Exit: $status\n") . "\n";
    } catch (Exception $e) {
        echo "❌ Erro: " . $e->getMessage() . "\n\n";
    }
}

foreach ([$root . '/storage', $root . '/bootstrap/cache'] as $dir) {
    if (is_dir($dir)) {
        @chmod($dir, 0775);
        echo "✅ chmod 775 " . basename($dir) . "\n";
    }
}

echo "\n=== CONCLUÍDO ===\n";
echo "⚠️  DELETE ESTE ARQUIVO AGORA via File Manager (public/setup-run.php)!\n";
echo '</pre>';
