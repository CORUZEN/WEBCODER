<?php
/**
 * Limpar Cache do Laravel
 * Acesse: http://iagus.com.br/limpar-cache.php
 */

$basePath = dirname(__DIR__);

echo "<h1>Limpando Cache do Laravel</h1>";
echo "<pre style='background: #1f2937; color: #f3f4f6; padding: 20px; border-radius: 8px;'>";

// 1. Limpar cache de configuração
$configCache = $basePath . '/bootstrap/cache/config.php';
if (file_exists($configCache)) {
    unlink($configCache);
    echo "✅ Cache de configuração deletado\n";
} else {
    echo "ℹ️  Cache de configuração já estava limpo\n";
}

// 2. Limpar cache de rotas
$routesCache = $basePath . '/bootstrap/cache/routes-v7.php';
if (file_exists($routesCache)) {
    unlink($routesCache);
    echo "✅ Cache de rotas deletado\n";
} else {
    echo "ℹ️  Cache de rotas já estava limpo\n";
}

// 3. Limpar cache de events
$eventsCache = $basePath . '/bootstrap/cache/events.php';
if (file_exists($eventsCache)) {
    unlink($eventsCache);
    echo "✅ Cache de eventos deletado\n";
} else {
    echo "ℹ️  Cache de eventos já estava limpo\n";
}

// 4. Limpar cache de services
$servicesCache = $basePath . '/bootstrap/cache/services.php';
if (file_exists($servicesCache)) {
    unlink($servicesCache);
    echo "✅ Cache de services deletado\n";
} else {
    echo "ℹ️  Cache de services já estava limpo\n";
}

// 5. Limpar cache de packages
$packagesCache = $basePath . '/bootstrap/cache/packages.php';
if (file_exists($packagesCache)) {
    unlink($packagesCache);
    echo "✅ Cache de packages deletado\n";
} else {
    echo "ℹ️  Cache de packages já estava limpo\n";
}

// 6. Limpar storage/framework/cache
$cacheDir = $basePath . '/storage/framework/cache/data';
if (is_dir($cacheDir)) {
    $files = glob($cacheDir . '/*');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            $count++;
        }
    }
    echo "✅ {$count} arquivos de cache deletados de storage/framework/cache\n";
}

// 7. Limpar views compiladas
$viewsDir = $basePath . '/storage/framework/views';
if (is_dir($viewsDir)) {
    $files = glob($viewsDir . '/*.php');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            unlink($file);
            $count++;
        }
    }
    echo "✅ {$count} views compiladas deletadas\n";
}

echo "\n";
echo "🎉 CACHE LIMPO COM SUCESSO!\n\n";
echo "Agora acesse: http://iagus.com.br\n";

echo "</pre>";

echo "<br><a href='/' style='display:inline-block; background:#2563eb; color:white; padding:10px 20px; text-decoration:none; border-radius:4px;'>Ir para o Site</a>";
