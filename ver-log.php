<?php
/**
 * Ver últimas linhas do log de erro
 * Acesse: http://iagus.com.br/ver-log.php
 */

$basePath = dirname(__DIR__);
$logFile = $basePath . '/storage/logs/laravel.log';

echo "<h1>Logs de Erro Laravel</h1>";
echo "<pre style='background: #1f2937; color: #f3f4f6; padding: 20px; border-radius: 8px; overflow-x: auto;'>";

if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -100); // Últimas 100 linhas
    echo htmlspecialchars(implode('', $lastLines));
} else {
    echo "Arquivo de log não encontrado em: {$logFile}\n\n";
    echo "Verificando permissões de storage...\n\n";
    
    $storagePath = $basePath . '/storage';
    echo "Storage existe: " . (file_exists($storagePath) ? 'Sim' : 'Não') . "\n";
    if (file_exists($storagePath)) {
        echo "Storage gravável: " . (is_writable($storagePath) ? 'Sim' : 'NÃO - PROBLEMA AQUI!') . "\n";
        echo "Permissões: " . substr(sprintf('%o', fileperms($storagePath)), -4) . "\n\n";
    }
    
    $logsPath = $basePath . '/storage/logs';
    echo "Logs existe: " . (file_exists($logsPath) ? 'Sim' : 'Não') . "\n";
    if (file_exists($logsPath)) {
        echo "Logs gravável: " . (is_writable($logsPath) ? 'Sim' : 'NÃO - PROBLEMA AQUI!') . "\n";
        echo "Permissões: " . substr(sprintf('%o', fileperms($logsPath)), -4) . "\n\n";
    }
    
    echo "\n=== SOLUÇÃO ===\n";
    echo "Execute via SSH:\n";
    echo "cd /home1/abdonc73/iagus.com.br\n";
    echo "chmod -R 775 storage bootstrap/cache\n";
    echo "chown -R \$USER:nobody storage bootstrap/cache\n";
}

echo "</pre>";

echo "<br><a href='/diagnostico.php'>Ver Diagnóstico Completo</a>";
