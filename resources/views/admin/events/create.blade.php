@extends('layouts.app')

@section('title', 'Criar Novo Evento - Admin')

@section('content')

<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.eventos.index') }}" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold">Criar Novo Evento</h1>
        </div>
    </div>
</div>

<section class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <form action="{{ route('admin.eventos.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Informações Básicas -->
            <div class="card">
                <h3 class="text-xl font-bold mb-6">Informações Básicas</h3>
                
                <div class="space-y-6">
                    <!-- Título -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Título do Evento *
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('title') border-red-500 @enderror"
                            required
                        >
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                            Slug (URL amigável)
                            <span class="text-gray-500 text-xs">(deixe vazio para gerar automaticamente)</span>
                        </label>
                        <input 
                            type="text" 
                            id="slug" 
                            name="slug" 
                            value="{{ old('slug') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                            placeholder="retiro-de-carnaval-2026"
                        >
                        @error('slug')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Descrição -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descrição *
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror"
                            required
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Instruções -->
                    <div>
                        <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">
                            Instruções para os Participantes
                            <span class="text-gray-500 text-xs">(o que levar, horário de chegada, etc.)</span>
                        </label>
                        <textarea 
                            id="instructions" 
                            name="instructions" 
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >{{ old('instructions') }}</textarea>
                    </div>
                    
                    <!-- URL da Imagem -->
                    <div>
                        <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                            URL da Imagem
                        </label>
                        <input 
                            type="url" 
                            id="image_url" 
                            name="image_url" 
                            value="{{ old('image_url') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="https://exemplo.com/imagem-evento.jpg"
                        >
                    </div>
                </div>
            </div>
            
            <!-- Data e Local -->
            <div class="card">
                <h3 class="text-xl font-bold mb-6">Data e Local</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Data de Início -->
                    <div>
                        <label for="start_at" class="block text-sm font-medium text-gray-700 mb-2">
                            Data e Hora de Início *
                        </label>
                        <input 
                            type="datetime-local" 
                            id="start_at" 
                            name="start_at" 
                            value="{{ old('start_at') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('start_at') border-red-500 @enderror"
                            required
                        >
                        @error('start_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Data de Término -->
                    <div>
                        <label for="end_at" class="block text-sm font-medium text-gray-700 mb-2">
                            Data e Hora de Término
                        </label>
                        <input 
                            type="datetime-local" 
                            id="end_at" 
                            name="end_at" 
                            value="{{ old('end_at') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                    </div>
                    
                    <!-- Nome do Local -->
                    <div>
                        <label for="location_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nome do Local *
                        </label>
                        <input 
                            type="text" 
                            id="location_name" 
                            name="location_name" 
                            value="{{ old('location_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('location_name') border-red-500 @enderror"
                            placeholder="Sítio Esperança"
                            required
                        >
                        @error('location_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Endereço -->
                    <div>
                        <label for="location_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Endereço Completo
                        </label>
                        <input 
                            type="text" 
                            id="location_address" 
                            name="location_address" 
                            value="{{ old('location_address') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Rua Exemplo, 123 - Garanhuns/PE"
                        >
                    </div>
                </div>
            </div>
            
            <!-- Inscrições e Vagas -->
            <div class="card">
                <h3 class="text-xl font-bold mb-6">Inscrições e Vagas</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Capacidade -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                            Capacidade (Número de Vagas)
                            <span class="text-gray-500 text-xs">(deixe vazio para ilimitado)</span>
                        </label>
                        <input 
                            type="number" 
                            id="capacity" 
                            name="capacity" 
                            value="{{ old('capacity') }}"
                            min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="50"
                        >
                    </div>
                    
                    <!-- Preço -->
                    <div>
                        <label for="price_cents" class="block text-sm font-medium text-gray-700 mb-2">
                            Preço (em centavos) *
                            <span class="text-gray-500 text-xs">(0 para gratuito, 5000 para R$ 50,00)</span>
                        </label>
                        <input 
                            type="number" 
                            id="price_cents" 
                            name="price_cents" 
                            value="{{ old('price_cents', 0) }}"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('price_cents') border-red-500 @enderror"
                            required
                        >
                        @error('price_cents')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Abertura das Inscrições -->
                    <div>
                        <label for="registration_open_at" class="block text-sm font-medium text-gray-700 mb-2">
                            Abertura das Inscrições
                        </label>
                        <input 
                            type="datetime-local" 
                            id="registration_open_at" 
                            name="registration_open_at" 
                            value="{{ old('registration_open_at') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                    </div>
                    
                    <!-- Fechamento das Inscrições -->
                    <div>
                        <label for="registration_close_at" class="block text-sm font-medium text-gray-700 mb-2">
                            Fechamento das Inscrições
                        </label>
                        <input 
                            type="datetime-local" 
                            id="registration_close_at" 
                            name="registration_close_at" 
                            value="{{ old('registration_close_at') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                    </div>
                </div>
            </div>
            
            <!-- Status -->
            <div class="card">
                <h3 class="text-xl font-bold mb-6">Publicação</h3>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status *
                    </label>
                    <select 
                        id="status" 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('status') border-red-500 @enderror"
                        required
                    >
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Rascunho</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                        <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Fechado</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <div class="mt-3 space-y-2 text-sm text-gray-600">
                        <p><strong>Rascunho:</strong> Evento não aparece no site público</p>
                        <p><strong>Publicado:</strong> Evento visível e disponível para inscrições</p>
                        <p><strong>Fechado:</strong> Evento visível mas inscrições bloqueadas</p>
                    </div>
                </div>
            </div>
            
            <!-- Botões -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.eventos.index') }}" class="text-gray-600 hover:text-gray-800">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Criar Evento
                </button>
            </div>
            
        </form>
        
    </div>
</section>

@endsection
