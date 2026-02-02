<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('instructions')->nullable()->comment('Instruções para os inscritos');
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
            $table->string('location_name');
            $table->text('location_address')->nullable();
            $table->integer('capacity')->nullable()->comment('Limite de vagas');
            $table->integer('price_cents')->default(0)->comment('Preço em centavos (0 = gratuito)');
            $table->string('currency', 3)->default('BRL');
            $table->dateTime('registration_open_at')->nullable();
            $table->dateTime('registration_close_at')->nullable();
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->string('image_url')->nullable();
            $table->timestamps();
            
            $table->index('slug');
            $table->index('status');
            $table->index('start_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
