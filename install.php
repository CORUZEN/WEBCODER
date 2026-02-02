<?php
/**
 * Script de Instalação IAGUS via Web
 * Acesse: http://seu-dominio.com.br/install.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = __DIR__;
$envPath = $baseDir . '/.env';

// Configurações do banco de dados
$dbConfig = [
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'abdonc73_iagus',
    'DB_USERNAME' => 'abdonc73_iagus',  // AJUSTE AQUI se necessário
    'DB_PASSWORD' => '',  // COLOQUE A SENHA AQUI
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalação IAGUS</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #2563eb; }
        .step { margin: 20px 0; padding: 15px; background: #f9fafb; border-left: 4px solid #2563eb; }
        .success { color: #059669; }
        .error { color: #dc2626; }
        .warning { color: #d97706; }
        button { background: #2563eb; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #1d4ed8; }
        pre { background: #1f2937; color: #f3f4f6; padding: 15px; border-radius: 4px; overflow-x: auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Instalação do Sistema IAGUS</h1>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = $_POST['db_host'] ?? 'localhost';
    $dbPort = $_POST['db_port'] ?? '3306';
    $dbName = $_POST['db_name'] ?? '';
    $dbUser = $_POST['db_user'] ?? '';
    $dbPass = $_POST['db_pass'] ?? '';
    $mpPublicKey = $_POST['mp_public_key'] ?? '';
    $mpAccessToken = $_POST['mp_access_token'] ?? '';

    echo "<div class='step'>";
    echo "<h2>📋 Passo 1: Testando Conexão com Banco de Dados</h2>";
    
    try {
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        echo "<p class='success'>✅ Conexão com banco de dados estabelecida com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>❌ Erro ao conectar: " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div></div></body></html>";
        exit;
    }
    echo "</div>";

    // Atualizar .env
    echo "<div class='step'>";
    echo "<h2>⚙️ Passo 2: Configurando .env</h2>";
    
    if (file_exists($envPath)) {
        $envContent = file_get_contents($envPath);
        
        // Atualizar configurações
        $envContent = preg_replace('/^DB_CONNECTION=.*/m', 'DB_CONNECTION=mysql', $envContent);
        $envContent = preg_replace('/^DB_HOST=.*/m', "DB_HOST={$dbHost}", $envContent);
        $envContent = preg_replace('/^DB_PORT=.*/m', "DB_PORT={$dbPort}", $envContent);
        $envContent = preg_replace('/^DB_DATABASE=.*/m', "DB_DATABASE={$dbName}", $envContent);
        $envContent = preg_replace('/^DB_USERNAME=.*/m', "DB_USERNAME={$dbUser}", $envContent);
        $envContent = preg_replace('/^DB_PASSWORD=.*/m', "DB_PASSWORD={$dbPass}", $envContent);
        
        if ($mpPublicKey) {
            $envContent = preg_replace('/^MP_PUBLIC_KEY=.*/m', "MP_PUBLIC_KEY={$mpPublicKey}", $envContent);
        }
        if ($mpAccessToken) {
            $envContent = preg_replace('/^MP_ACCESS_TOKEN=.*/m', "MP_ACCESS_TOKEN={$mpAccessToken}", $envContent);
        }
        
        $envContent = preg_replace('/^APP_ENV=.*/m', 'APP_ENV=production', $envContent);
        $envContent = preg_replace('/^APP_DEBUG=.*/m', 'APP_DEBUG=false', $envContent);
        
        if (file_put_contents($envPath, $envContent)) {
            echo "<p class='success'>✅ Arquivo .env atualizado com sucesso!</p>";
        } else {
            echo "<p class='error'>❌ Erro ao atualizar .env</p>";
        }
    } else {
        echo "<p class='error'>❌ Arquivo .env não encontrado!</p>";
    }
    echo "</div>";

    // Criar tabelas
    echo "<div class='step'>";
    echo "<h2>🗄️ Passo 3: Criando Tabelas do Banco de Dados</h2>";
    
    try {
        // Tabela users
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            email_verified_at TIMESTAMP NULL,
            password VARCHAR(255) NOT NULL,
            cpf VARCHAR(14) UNIQUE,
            phone VARCHAR(20),
            is_admin TINYINT(1) DEFAULT 0,
            remember_token VARCHAR(100),
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            INDEX idx_email (email),
            INDEX idx_cpf (cpf)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "<p class='success'>✅ Tabela 'users' criada</p>";

        // Tabela events
        $pdo->exec("CREATE TABLE IF NOT EXISTS events (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            event_date DATETIME NOT NULL,
            location VARCHAR(255) NOT NULL,
            max_participants INT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            image_url VARCHAR(255),
            is_active TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            INDEX idx_event_date (event_date),
            INDEX idx_is_active (is_active)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "<p class='success'>✅ Tabela 'events' criada</p>";

        // Tabela registrations
        $pdo->exec("CREATE TABLE IF NOT EXISTS registrations (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            event_id BIGINT UNSIGNED NOT NULL,
            status VARCHAR(50) DEFAULT 'pending',
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
            INDEX idx_user_id (user_id),
            INDEX idx_event_id (event_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "<p class='success'>✅ Tabela 'registrations' criada</p>";

        // Tabela payments
        $pdo->exec("CREATE TABLE IF NOT EXISTS payments (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            registration_id BIGINT UNSIGNED NOT NULL,
            mercado_pago_id VARCHAR(255),
            status VARCHAR(50) DEFAULT 'pending',
            amount DECIMAL(10,2) NOT NULL,
            payment_method VARCHAR(50),
            paid_at TIMESTAMP NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (registration_id) REFERENCES registrations(id) ON DELETE CASCADE,
            INDEX idx_registration_id (registration_id),
            INDEX idx_mercado_pago_id (mercado_pago_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "<p class='success'>✅ Tabela 'payments' criada</p>";

        // Tabela webhook_events
        $pdo->exec("CREATE TABLE IF NOT EXISTS webhook_events (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            event_type VARCHAR(100) NOT NULL,
            payload TEXT NOT NULL,
            processed TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            INDEX idx_event_type (event_type),
            INDEX idx_processed (processed)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "<p class='success'>✅ Tabela 'webhook_events' criada</p>";

        echo "<p class='success'><strong>🎉 Todas as tabelas foram criadas com sucesso!</strong></p>";
    } catch (PDOException $e) {
        echo "<p class='error'>❌ Erro ao criar tabelas: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    echo "</div>";

    // Criar usuário admin
    echo "<div class='step'>";
    echo "<h2>👤 Passo 4: Criando Usuário Administrador</h2>";
    
    try {
        $adminEmail = 'admin@iagus.org.br';
        $adminPassword = password_hash('iagus2026', PASSWORD_BCRYPT);
        
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$adminEmail]);
        
        if (!$stmt->fetch()) {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin, created_at, updated_at) VALUES (?, ?, ?, 1, NOW(), NOW())");
            $stmt->execute(['Administrador', $adminEmail, $adminPassword]);
            echo "<p class='success'>✅ Usuário administrador criado!</p>";
            echo "<p><strong>Email:</strong> admin@iagus.org.br</p>";
            echo "<p><strong>Senha:</strong> iagus2026</p>";
        } else {
            echo "<p class='warning'>⚠️ Usuário administrador já existe</p>";
        }
    } catch (PDOException $e) {
        echo "<p class='error'>❌ Erro ao criar admin: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    echo "</div>";

    // Instruções finais
    echo "<div class='step'>";
    echo "<h2>✅ Instalação Concluída!</h2>";
    echo "<p class='success'>O sistema foi instalado com sucesso!</p>";
    echo "<h3>Próximos Passos:</h3>";
    echo "<ol>";
    echo "<li><strong>IMPORTANTE:</strong> Delete este arquivo (install.php) por segurança</li>";
    echo "<li>Configure o public_html para apontar para a pasta /laravel/public</li>";
    echo "<li>Acesse o painel administrativo em: <a href='/admin/login'>/admin/login</a></li>";
    echo "<li>Use as credenciais: admin@iagus.org.br / iagus2026</li>";
    echo "</ol>";
    echo "<p class='warning'>⚠️ Lembre-se de adicionar suas chaves do Mercado Pago no .env se ainda não o fez!</p>";
    echo "</div>";

} else {
    // Formulário de instalação
    ?>
    <div class="step">
        <h2>📝 Configuração Inicial</h2>
        <p>Preencha os dados abaixo para instalar o sistema IAGUS:</p>
        
        <form method="POST">
            <h3>🗄️ Configurações do Banco de Dados</h3>
            
            <div class="form-group">
                <label for="db_host">Host do Banco:</label>
                <input type="text" id="db_host" name="db_host" value="localhost" required>
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
            </div>
            
            <div class="form-group">
                <label for="db_pass">Senha:</label>
                <input type="password" id="db_pass" name="db_pass" required>
            </div>
            
            <h3>💳 Mercado Pago (Opcional - pode configurar depois)</h3>
            
            <div class="form-group">
                <label for="mp_public_key">Public Key:</label>
                <input type="text" id="mp_public_key" name="mp_public_key" placeholder="APP_USR-...">
            </div>
            
            <div class="form-group">
                <label for="mp_access_token">Access Token:</label>
                <input type="text" id="mp_access_token" name="mp_access_token" placeholder="APP_USR-...">
            </div>
            
            <button type="submit">🚀 Instalar Sistema</button>
        </form>
    </div>
    <?php
}
?>
    </div>
</body>
</html>
