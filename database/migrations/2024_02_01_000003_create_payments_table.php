<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->enum('provider', ['mercadopago'])->default('mercadopago');
            $table->string('mp_preference_id')->nullable()->comment('ID da preferência no Mercado Pago');
            $table->string('mp_payment_id')->nullable()->comment('ID do pagamento no Mercado Pago');
            $table->string('external_reference')->nullable()->comment('Referência externa (registration code)');
            $table->integer('amount_cents')->comment('Valor em centavos');
            $table->string('currency', 3)->default('BRL');
            $table->enum('status', [
                'created',      // Criado (preferência gerada)
                'pending',      // Pendente
                'approved',     // Aprovado
                'rejected',     // Rejeitado
                'cancelled',    // Cancelado
                'refunded',     // Reembolsado
                'charged_back'  // Chargeback
            ])->default('created');
            $table->string('status_detail')->nullable();
            $table->text('payload_json')->nullable()->comment('Dados completos para auditoria');
            $table->timestamps();
            
            $table->index('mp_preference_id');
            $table->index('mp_payment_id');
            $table->index('external_reference');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
