<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique()->comment('Código único da inscrição (ex: IAGUS-2026-000123)');
            $table->enum('status', [
                'registered',      // Inscrito (gratuito ou aguardando pagamento)
                'pending_payment', // Aguardando pagamento
                'paid',           // Pago
                'cancelled',      // Cancelado
                'refunded'        // Reembolsado
            ])->default('registered');
            $table->text('notes')->nullable()->comment('Observações administrativas');
            $table->timestamps();
            
            // Evitar inscrições duplicadas
            $table->unique(['user_id', 'event_id']);
            
            $table->index('code');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
