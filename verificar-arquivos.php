<?php
/**
 * Verificar arquivos críticos
 */

$basePath = dirname(__DIR__);

echo "<h1>Verificação de Arquivos Críticos</h1><pre>";

$files = [
    'CompatibilityServiceProvider' => $basePath . '/app/Providers/CompatibilityServiceProvider.php',
    'bootstrap/app.php' => $basePath . '/bootstrap/app.php',
    'Controller.php' => $basePath . '/app/Http/Controllers/Controller.php',
];

foreach ($files as $name => $path) {
    echo "\n{$name}:\n";
    echo "  Existe: " . (file_exists($path) ? '✅ Sim' : '❌ NÃO') . "\n";
    if (file_exists($path)) {
        echo "  Tamanho: " . filesize($path) . " bytes\n";
    }
}

echo "\n</pre>";

echo "<h2>SOLUÇÃO</h2>";
echo "<p>Faça upload destes arquivos que faltam:</p>";
echo "<ul>";
echo "<li><strong>app/Providers/CompatibilityServiceProvider.php</strong></li>";
echo "<li><strong>bootstrap/app.php</strong></li>";
echo "<li><strong>app/Http/Controllers/Controller.php</strong></li>";
echo "</ul>";
