<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário admin
        User::create([
            'name' => 'Administrador IAGUS',
            'email' => 'admin@iagus.org.br',
            'phone' => '87999999999',
            'password' => Hash::make('iagus2026'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Criar usuário de teste
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'phone' => '87988888888',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Chamar seeder de eventos
        $this->call([
            EventSeeder::class,
        ]);
    }
}
