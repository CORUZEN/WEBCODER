@extends('layouts.app')

@section('title', 'Inscrição ' . $registration->code . ' - IAGUS')

@section('content')

<div class="bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('user.dashboard') }}" class="text-primary-600 hover:text-primary-700 mb-4 inline-block">
            ← Voltar para minhas inscrições
        </a>
        <h1 class="text-3xl font-bold">Inscrição #{{ $registration->code }}</h1>
    </div>
</div>

<section class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Informações Principais -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <h2 class="text-2xl font-bold mb-4">{{ $registration->event->title }}</h2>
                    
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <div class="font-medium">Data e Horário</div>
                                <div class="text-gray-600">{{ $registration->event->start_at->format('d/m/Y - H:i') }}</div>
                                @if($registration->event->end_at)
                                    <div class="text-gray-600 text-sm">até {{ $registration->event->end_at->format('d/m/Y - H:i') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <div class="font-medium">Local</div>
                                <div class="text-gray-600">{{ $registration->event->location_name }}</div>
                                @if($registration->event->location_address)
                                    <div class="text-gray-600 text-sm">{{ $registration->event->location_address }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($registration->event->instructions && $registration->isPaid())
                    <div class="card bg-blue-50 border border-blue-200">
                        <h3 class="font-bold mb-3">📋 Instruções do Evento</h3>
                        <div class="text-gray-700">
                            {!! nl2br(e($registration->event->instructions)) !!}
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Status e Pagamento -->
            <div class="lg:col-span-1">
                <div class="card">
                    <h3 class="font-bold mb-4">Status da Inscrição</h3>
                    
                    <div class="text-center mb-4">
                        {!! $registration->statusBadge() !!}
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Código:</span>
                            <span class="font-mono">{{ $registration->code }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Data de inscrição:</span>
                            <span>{{ $registration->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        @if($registration->event->isPaid())
                            <div class="flex justify-between">
                                <span class="text-gray-600">Valor:</span>
                                <span class="font-semibold">{{ $registration->event->priceFormatted() }}</span>
                            </div>
                        @endif
                    </div>
                    
                    @if($registration->isPending() && $registration->payment)
                        <div class="mt-6 pt-6 border-t">
                            <a href="{{ route('payment.create', $registration->code) }}" class="btn btn-primary w-full">
                                Fazer pagamento
                            </a>
                        </div>
                    @endif
                    
                    @if($registration->isPaid())
                        <div class="mt-6 pt-6 border-t text-center">
                            <div class="text-green-600 font-semibold mb-2">✓ Pagamento confirmado!</div>
                            <p class="text-sm text-gray-600">Você está confirmado(a) para este evento.</p>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</section>

@endsection
