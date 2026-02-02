<?php
/**
 * Script de Teste de Conexão MySQL
 * Acesse: http://iagus.com.br/teste-conexao.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Conexão MySQL</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #2563eb; }
        .test { margin: 20px 0; padding: 15px; background: #f9fafb; border-left: 4px solid #9ca3af; }
        .success { border-left-color: #059669; }
        .error { border-left-color: #dc2626; }
        .info { color: #0369a1; }
        .ok { color: #059669; font-weight: bold; }
        .fail { color: #dc2626; font-weight: bold; }
        pre { background: #1f2937; color: #f3f4f6; padding: 15px; border-radius: 4px; overflow-x: auto; font-size: 12px; }
        button { background: #2563eb; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin: 5px; }
        button:hover { background: #1d4ed8; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .code { background: #fef3c7; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Diagnóstico de Conexão MySQL</h1>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = trim($_POST['db_host'] ?? 'localhost');
    $dbPort = trim($_POST['db_port'] ?? '3306');
    $dbName = trim($_POST['db_name'] ?? '');
    $dbUser = trim($_POST['db_user'] ?? '');
    $dbPass = $_POST['db_pass'] ?? '';

    echo "<h2>📊 Informações Fornecidas</h2>";
    echo "<div class='test'>";
    echo "<p><strong>Host:</strong> <span class='code'>{$dbHost}</span></p>";
    echo "<p><strong>Porta:</strong> <span class='code'>{$dbPort}</span></p>";
    echo "<p><strong>Banco:</strong> <span class='code'>{$dbName}</span></p>";
    echo "<p><strong>Usuário:</strong> <span class='code'>{$dbUser}</span></p>";
    echo "<p><strong>Senha:</strong> <span class='code'>" . str_repeat('*', strlen($dbPass)) . "</span> (" . strlen($dbPass) . " caracteres)</p>";
    echo "</div>";

    // Teste 1: Extensão PDO
    echo "<div class='test'>";
    echo "<h3>✓ Teste 1: Verificando Extensão PDO MySQL</h3>";
    if (extension_loaded('pdo_mysql')) {
        echo "<p class='ok'>✅ Extensão PDO MySQL está disponível</p>";
    } else {
        echo "<p class='fail'>❌ Extensão PDO MySQL NÃO está disponível</p>";
        echo "<p>Entre em contato com o suporte da HostGator para habilitar PDO MySQL</p>";
        echo "</div></div></body></html>";
        exit;
    }
    echo "</div>";

    // Teste 2: Conexão básica
    echo "<div class='test'>";
    echo "<h3>✓ Teste 2: Tentando Conexão Básica</h3>";
    
    try {
        $dsn = "mysql:host={$dbHost};port={$dbPort};charset=utf8mb4";
        echo "<p class='info'>DSN: <span class='code'>{$dsn}</span></p>";
        
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        
        echo "<p class='ok'>✅ Conexão ao servidor MySQL estabelecida com sucesso!</p>";
        
        // Teste 3: Verificar versão do MySQL
        $version = $pdo->query('SELECT VERSION()')->fetchColumn();
        echo "<p class='info'>Versão do MySQL: <span class='code'>{$version}</span></p>";
        
    } catch (PDOException $e) {
        echo "<p class='fail'>❌ Erro ao conectar ao servidor MySQL</p>";
        echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
        
        if (strpos($e->getMessage(), '1045') !== false) {
            echo "<p class='fail'><strong>PROBLEMA IDENTIFICADO:</strong> Usuário ou senha incorretos!</p>";
            echo "<p>Verifique:</p>";
            echo "<ul>";
            echo "<li>O nome de usuário deve começar com <span class='code'>abdoncr73_</span></li>";
            echo "<li>A senha está digitada corretamente (cuidado com espaços)</li>";
            echo "<li>Tente redefinir a senha no cPanel</li>";
            echo "</ul>";
        } elseif (strpos($e->getMessage(), '2002') !== false) {
            echo "<p class='fail'><strong>PROBLEMA IDENTIFICADO:</strong> Servidor MySQL não encontrado!</p>";
            echo "<p>Tente usar <span class='code'>localhost</span> em vez de 127.0.0.1</p>";
        }
        
        echo "</div></div></body></html>";
        exit;
    }
    echo "</div>";

    // Teste 4: Acessar banco específico
    echo "<div class='test'>";
    echo "<h3>✓ Teste 4: Tentando Acessar o Banco de Dados</h3>";
    
    try {
        $pdo->exec("USE `{$dbName}`");
        echo "<p class='ok'>✅ Banco de dados <span class='code'>{$dbName}</span> acessado com sucesso!</p>";
        
    } catch (PDOException $e) {
        echo "<p class='fail'>❌ Erro ao acessar o banco de dados</p>";
        echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
        
        if (strpos($e->getMessage(), '1044') !== false || strpos($e->getMessage(), '1049') !== false) {
            echo "<p class='fail'><strong>PROBLEMA IDENTIFICADO:</strong> Banco de dados não existe ou usuário não tem permissão!</p>";
            echo "<p>Verifique:</p>";
            echo "<ul>";
            echo "<li>O banco <span class='code'>{$dbName}</span> existe no cPanel?</li>";
            echo "<li>O usuário está vinculado ao banco?</li>";
            echo "<li>O usuário tem privilégios no banco?</li>";
            echo "</ul>";
        }
        
        echo "</div></div></body></html>";
        exit;
    }
    echo "</div>";

    // Teste 5: Listar privilégios
    echo "<div class='test'>";
    echo "<h3>✓ Teste 5: Verificando Privilégios do Usuário</h3>";
    
    try {
        $stmt = $pdo->query("SHOW GRANTS FOR CURRENT_USER()");
        $grants = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "<p class='ok'>✅ Privilégios encontrados:</p>";
        echo "<pre>";
        foreach ($grants as $grant) {
            echo htmlspecialchars($grant) . "\n";
        }
        echo "</pre>";
        
    } catch (PDOException $e) {
        echo "<p class='info'>Não foi possível listar privilégios (isso é normal)</p>";
    }
    echo "</div>";

    // Teste 6: Tentar criar uma tabela de teste
    echo "<div class='test'>";
    echo "<h3>✓ Teste 6: Testando Permissões de Escrita</h3>";
    
    try {
        $pdo->exec("DROP TABLE IF EXISTS test_conexao");
        $pdo->exec("CREATE TABLE test_conexao (id INT PRIMARY KEY, teste VARCHAR(50))");
        $pdo->exec("INSERT INTO test_conexao VALUES (1, 'Teste OK')");
        $result = $pdo->query("SELECT * FROM test_conexao")->fetch();
        $pdo->exec("DROP TABLE test_conexao");
        
        echo "<p class='ok'>✅ Permissões de leitura/escrita funcionando perfeitamente!</p>";
        echo "<p class='info'>Resultado do teste: <span class='code'>" . htmlspecialchars($result['teste']) . "</span></p>";
        
    } catch (PDOException $e) {
        echo "<p class='fail'>❌ Erro ao testar permissões de escrita</p>";
        echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    }
    echo "</div>";

    // Resumo Final
    echo "<div class='test success'>";
    echo "<h2>🎉 SUCESSO TOTAL!</h2>";
    echo "<p><strong>Todas as verificações passaram!</strong></p>";
    echo "<p>Você pode usar estas credenciais no install.php:</p>";
    echo "<ul>";
    echo "<li><strong>Host:</strong> {$dbHost}</li>";
    echo "<li><strong>Porta:</strong> {$dbPort}</li>";
    echo "<li><strong>Banco:</strong> {$dbName}</li>";
    echo "<li><strong>Usuário:</strong> {$dbUser}</li>";
    echo "<li><strong>Senha:</strong> (a mesma que você digitou)</li>";
    echo "</ul>";
    echo "<p><a href='install.php'><button type='button'>🚀 Ir para Instalação</button></a></p>";
    echo "</div>";

} else {
    // Formulário
    ?>
    <p>Este script vai testar a conexão com o banco de dados MySQL e identificar exatamente qual é o problema.</p>
    
    <form method="POST">
        <div class="form-group">
            <label for="db_host">Host do Banco:</label>
            <input type="text" id="db_host" name="db_host" value="localhost" required>
            <small>Geralmente é "localhost" no HostGator</small>
        </div>
        
        <div class="form-group">
            <label for="db_port">Porta:</label>
            <input type="text" id="db_port" name="db_port" value="3306" required>
        </div>
        
        <div class="form-group">
            <label for="db_name">Nome do Banco:</label>
            <input type="text" id="db_name" name="db_name" value="abdonc73_iagus" required>
        </div>
        
        <div class="form-group">
            <label for="db_user">Usuário:</label>
            <input type="text" id="db_user" name="db_user" value="abdonc73_iagus" required>
            <small>Deve começar com "abdonc73_"</small>
        </div>
        
        <div class="form-group">
            <label for="db_pass">Senha:</label>
            <input type="password" id="db_pass" name="db_pass" required>
            <small>Digite a senha exata que você definiu no cPanel</small>
        </div>
        
        <button type="submit">🔍 Testar Conexão</button>
    </form>
    
    <div class="test" style="margin-top: 30px;">
        <h3>💡 Dicas:</h3>
        <ul>
            <li>Certifique-se de que o banco de dados <span class="code">abdonc73_iagus</span> existe</li>
            <li>Certifique-se de que o usuário <span class="code">abdonc73_iagus</span> está vinculado ao banco</li>
            <li>Se a senha não funcionar, redefina no cPanel em "Bancos de dados MySQL®"</li>
            <li>Use uma senha simples primeiro para testar (só letras e números)</li>
        </ul>
    </div>
    <?php
}
?>
    </div>
</body>
</html>
