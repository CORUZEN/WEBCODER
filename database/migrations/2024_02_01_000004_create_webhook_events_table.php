<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhook_events', function (Blueprint $table) {
            $table->id();
            $table->enum('provider', ['mercadopago'])->default('mercadopago');
            $table->string('event_type')->nullable();
            $table->string('request_id')->nullable()->comment('ID único da requisição');
            $table->timestamp('received_at')->useCurrent();
            $table->longText('payload_json')->comment('Payload completo do webhook');
            $table->timestamp('processed_at')->nullable();
            $table->enum('processing_status', ['received', 'processed', 'failed'])->default('received');
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index('event_type');
            $table->index('processing_status');
            $table->index('received_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_events');
    }
};
