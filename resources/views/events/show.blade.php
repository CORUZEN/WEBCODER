@extends('layouts.app')

@section('title', $event->title . ' - IAGUS')

@section('content')

<div class="bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('events.index') }}" class="text-primary-600 hover:text-primary-700 mb-4 inline-block">
            ← Voltar para eventos
        </a>
        
        @if($event->image_url)
            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-64 object-cover rounded-lg mb-6">
        @endif
        
        <h1 class="text-4xl font-bold mb-4">{{ $event->title }}</h1>
        
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $event->start_at->format('d/m/Y - H:i') }}
            </div>
            
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ $event->location_name }}
            </div>
            
            <div class="flex items-center gap-2 font-semibold text-primary-600">
                {{ $event->priceFormatted() }}
            </div>
        </div>
    </div>
</div>

<section class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Conteúdo Principal -->
            <div class="lg:col-span-2">
                <div class="card mb-6">
                    <h2 class="text-2xl font-bold mb-4">Sobre o Evento</h2>
                    <div class="prose max-w-none">
                        {!! $event->description !!}
                    </div>
                </div>
                
                @if($event->instructions)
                    <div class="card bg-blue-50 border border-blue-200">
                        <h3 class="text-lg font-bold mb-3">📋 Instruções Importantes</h3>
                        <div class="text-gray-700">
                            {!! nl2br(e($event->instructions)) !!}
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="card sticky top-24">
                    <h3 class="text-xl font-bold mb-4">Inscrição</h3>
                    
                    @if($userRegistration)
                        <div class="alert alert-success mb-4">
                            <p class="font-semibold">✓ Você já está inscrito!</p>
                            <p class="text-sm mt-1">Código: {{ $userRegistration->code }}</p>
                        </div>
                        
                        <a href="{{ route('user.registrations.show', $userRegistration->code) }}" class="btn btn-secondary w-full mb-2">
                            Ver minha inscrição
                        </a>
                        
                        @if($userRegistration->isPending() && $event->isPaid())
                            <a href="{{ route('payment.create', $userRegistration->code) }}" class="btn btn-primary w-full">
                                Fazer pagamento
                            </a>
                        @endif
                    @else
                        @if(!$event->isRegistrationOpen())
                            <div class="alert alert-error">
                                Inscrições fechadas
                            </div>
                        @elseif($event->isFull())
                            <div class="alert alert-error">
                                Evento lotado
                            </div>
                        @else
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Investimento:</span>
                                    <span class="font-semibold text-primary-600">{{ $event->priceFormatted() }}</span>
                                </div>
                                
                                @if($event->capacity)
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Vagas disponíveis:</span>
                                        <span class="font-semibold">{{ $event->availableSpots() }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            @auth
                                <form method="POST" action="{{ route('registrations.store', $event) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-full">
                                        Inscrever-se agora
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary w-full mb-2">
                                    Entrar para inscrever-se
                                </a>
                                <p class="text-sm text-gray-600 text-center">
                                    Não tem conta? <a href="{{ route('register') }}" class="text-primary-600">Criar conta</a>
                                </p>
                            @endauth
                        @endif
                    @endif
                    
                    @if($event->location_address)
                        <div class="mt-6 pt-6 border-t">
                            <h4 class="font-semibold mb-2">📍 Local</h4>
                            <p class="text-sm text-gray-600">{{ $event->location_address }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
