<?php

// Script para executar migrations diretamente
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

echo "===========================================\n";
echo "  IAGUS - Setup do Banco de Dados\n";
echo "===========================================\n\n";

try {
    // Criar banco SQLite
    $dbPath = __DIR__.'/database/database.sqlite';
    if (!file_exists($dbPath)) {
        echo "Criando banco SQLite...\n";
        touch($dbPath);
        echo "✓ Banco criado\n\n";
    }
    
    // Executar migrations via PDO direto
    echo "Criando tabelas...\n";
    
    $pdo = new PDO('sqlite:'.$dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Migration: users
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            email_verified_at DATETIME,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'user',
            remember_token VARCHAR(100),
            created_at DATETIME,
            updated_at DATETIME
        )
    ");
    echo "✓ Tabela users\n";
    
    // Migration: events
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS events (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            event_date DATETIME NOT NULL,
            location VARCHAR(255) NOT NULL,
            price DECIMAL(10,2) DEFAULT 0.00,
            max_capacity INTEGER,
            registration_open_at DATETIME,
            registration_close_at DATETIME,
            instructions TEXT,
            status VARCHAR(50) DEFAULT 'active',
            created_at DATETIME,
            updated_at DATETIME
        )
    ");
    echo "✓ Tabela events\n";
    
    // Migration: registrations
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS registrations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            event_id INTEGER NOT NULL,
            registration_code VARCHAR(50) UNIQUE,
            status VARCHAR(50) DEFAULT 'pending',
            created_at DATETIME,
            updated_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
        )
    ");
    echo "✓ Tabela registrations\n";
    
    // Migration: payments
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS payments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            registration_id INTEGER NOT NULL,
            mp_preference_id VARCHAR(255),
            mp_payment_id VARCHAR(255),
            status VARCHAR(50) DEFAULT 'pending',
            amount DECIMAL(10,2) NOT NULL,
            payment_method VARCHAR(100),
            paid_at DATETIME,
            created_at DATETIME,
            updated_at DATETIME,
            FOREIGN KEY (registration_id) REFERENCES registrations(id) ON DELETE CASCADE
        )
    ");
    echo "✓ Tabela payments\n";
    
    // Migration: webhook_events
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS webhook_events (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            event_type VARCHAR(100),
            payload TEXT,
            processed_at DATETIME,
            created_at DATETIME,
            updated_at DATETIME
        )
    ");
    echo "✓ Tabela webhook_events\n\n";
    
    // Seeders
    echo "Inserindo dados iniciais...\n";
    
    // Admin user
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['admin@iagus.org.br']);
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("
            INSERT INTO users (name, email, password, role, created_at, updated_at)
            VALUES ('Admin IAGUS', 'admin@iagus.org.br', '".password_hash('iagus2026', PASSWORD_BCRYPT)."', 'admin', datetime('now'), datetime('now'))
        ");
        echo "✓ Usuário admin criado\n";
    }
    
    // Test user
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['joao@example.com']);
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("
            INSERT INTO users (name, email, password, role, created_at, updated_at)
            VALUES ('João Silva', 'joao@example.com', '".password_hash('password', PASSWORD_BCRYPT)."', 'user', datetime('now'), datetime('now'))
        ");
        echo "✓ Usuário de teste criado\n";
    }
    
    // Sample events
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM events");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("
            INSERT INTO events (title, description, event_date, location, price, max_capacity, registration_open_at, registration_close_at, status, created_at, updated_at)
            VALUES 
            ('Culto Dominical', 'Culto de celebração e adoração', datetime('now', '+7 days'), 'Igreja Anglicana - Garanhuns/PE', 0.00, 100, datetime('now'), datetime('now', '+6 days'), 'active', datetime('now'), datetime('now')),
            ('Conferência Jovem 2026', 'Encontro anual da juventude anglicana', datetime('now', '+30 days'), 'Centro de Convenções', 50.00, 200, datetime('now'), datetime('now', '+25 days'), 'active', datetime('now'), datetime('now')),
            ('Retiro Espiritual', 'Fim de semana de renovação espiritual', datetime('now', '+60 days'), 'Sítio Recanto da Paz', 150.00, 50, datetime('now'), datetime('now', '+55 days'), 'active', datetime('now'), datetime('now')),
            ('Workshop de Música', 'Capacitação para o ministério de louvor', datetime('now', '+90 days'), 'Salão Paroquial', 30.00, 30, datetime('now'), datetime('now', '+85 days'), 'active', datetime('now'), datetime('now'))
        ");
        echo "✓ Eventos de exemplo criados\n";
    }
    
    echo "\n===========================================\n";
    echo "  ✓ Banco de dados configurado!\n";
    echo "===========================================\n\n";
    echo "Credenciais:\n";
    echo "  Admin: admin@iagus.org.br / iagus2026\n";
    echo "  User:  joao@example.com / password\n\n";
    
} catch (Exception $e) {
    echo "\n✗ ERRO: " . $e->getMessage() . "\n";
    exit(1);
}
