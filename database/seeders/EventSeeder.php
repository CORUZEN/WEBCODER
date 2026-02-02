<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'title' => 'Retiro de Jovens 2026',
            'slug' => 'retiro-jovens-2026',
            'description' => '<p>Um final de semana transformador com louvor, ensino bíblico e comunhão.</p><p>Inclui: hospedagem, alimentação completa e materiais.</p>',
            'instructions' => 'Trazer: Bíblia, caderno, roupas confortáveis, roupa de banho e toalha.',
            'start_at' => now()->addDays(30),
            'end_at' => now()->addDays(32),
            'location_name' => 'Sítio Recanto da Paz',
            'location_address' => 'Zona Rural, Garanhuns - PE',
            'capacity' => 50,
            'price_cents' => 15000, // R$ 150,00
            'registration_open_at' => now(),
            'registration_close_at' => now()->addDays(25),
            'status' => 'published',
        ]);

        Event::create([
            'title' => 'Conferência Anual IAGUS',
            'slug' => 'conferencia-anual-2026',
            'description' => '<p>Três noites de ministração poderosa com pregadores convidados.</p><p>Tema: "Renovação e Propósito"</p>',
            'instructions' => 'Evento gratuito. Vagas limitadas. Chegue com antecedência.',
            'start_at' => now()->addDays(15),
            'end_at' => now()->addDays(17),
            'location_name' => 'Igreja Anglicana de Garanhuns',
            'location_address' => 'Rua exemplo, 123 - Centro, Garanhuns - PE',
            'capacity' => 200,
            'price_cents' => 0, // Gratuito
            'registration_open_at' => now(),
            'registration_close_at' => now()->addDays(14),
            'status' => 'published',
        ]);

        Event::create([
            'title' => 'Curso de Discipulado',
            'slug' => 'curso-discipulado-2026',
            'description' => '<p>Curso intensivo de 8 semanas sobre fundamentos da fé cristã.</p>',
            'instructions' => 'Material incluso. Aulas às quartas-feiras, 19h30.',
            'start_at' => now()->addDays(7),
            'end_at' => now()->addDays(63),
            'location_name' => 'Igreja Anglicana de Garanhuns',
            'location_address' => 'Rua exemplo, 123 - Centro, Garanhuns - PE',
            'capacity' => 30,
            'price_cents' => 5000, // R$ 50,00
            'registration_open_at' => now(),
            'registration_close_at' => now()->addDays(5),
            'status' => 'published',
        ]);

        Event::create([
            'title' => 'Acampamento de Famílias',
            'slug' => 'acampamento-familias-2026',
            'description' => '<p>Final de semana especial para fortalecer laços familiares através da fé.</p>',
            'instructions' => 'Evento para famílias completas. Crianças devem estar acompanhadas dos pais.',
            'start_at' => now()->addDays(60),
            'end_at' => now()->addDays(62),
            'location_name' => 'Camping Vale Verde',
            'location_address' => 'BR-423, Km 12 - Garanhuns - PE',
            'capacity' => 40,
            'price_cents' => 20000, // R$ 200,00
            'registration_open_at' => now()->addDays(10),
            'registration_close_at' => now()->addDays(55),
            'status' => 'draft',
        ]);
    }
}
