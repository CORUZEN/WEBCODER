<?php
// ARQUIVO TEMPORÁRIO - DELETE APÓS USO!
// Faça upload para: public/setup-run.php
// Acesse: https://iagus.com.br/setup-run.php
// Depois delete este arquivo pelo File Manager

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);
chdir($root);

require $root . '/vendor/autoload.php';

$app = require_once $root . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo '<pre style="font-family:monospace;background:#1a1a1a;color:#00ff00;padding:20px;">';
echo "=== SETUP IAGUS ===\n\n";

$commands = [
    ['migrate', ['--force' => true]],
    ['optimize:clear', []],
    ['optimize', []],
    ['storage:link', ['--relative' => true]],
];

foreach ($commands as [$cmd, $args]) {
    echo "▶ php artisan $cmd\n";
    try {
        $status = $kernel->call($cmd, $args);
        echo $kernel->output();
        echo ($status === 0 ? "✅ OK\n" : "⚠️ Exit: $status\n") . "\n";
    } catch (Exception $e) {
        echo "❌ Erro: " . $e->getMessage() . "\n\n";
    }
}

foreach ([$root . '/storage', $root . '/bootstrap/cache'] as $dir) {
    if (is_dir($dir)) {
        chmod($dir, 0775);
        echo "✅ chmod 775 " . basename($dir) . "\n";
    }
}

echo "\n=== CONCLUÍDO ===\n";
echo "⚠️  DELETE ESTE ARQUIVO AGORA!\n";
echo '</pre>';
