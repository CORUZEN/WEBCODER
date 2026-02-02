<?php

// Teste simples para verificar o erro
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

try {
    echo "Testando Laravel...\n";
    
    // Tentar acessar o filesystem
    $files = $app->make('files');
    echo "Files OK\n";
    
} catch (\Exception $e) {
    echo "ERRO: " . $e->getMessage() . "\n";
    echo "Classe esperada: " . get_class($e) . "\n";
    
    // Listar services registrados
    echo "\n Services disponíveis:\n";
    $bindings = $app->getBindings();
    foreach (array_keys($bindings) as $key) {
        if (strpos($key, 'file') !== false || strpos($key, 'File') !== false) {
            echo "  - $key\n";
        }
    }
}
