@extends('layouts.app')

@section('title', 'Minha Conta - IAGUS')

@section('content')

<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Olá, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600">Bem-vindo(a) de volta</p>
    </div>
</div>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h2 class="text-2xl font-bold mb-6">Minhas Inscrições</h2>
        
        @if($registrations->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($registrations as $registration)
                    <div class="card">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-lg">{{ $registration->event->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $registration->event->start_at->format('d/m/Y - H:i') }}</p>
                            </div>
                            {!! $registration->statusBadge() !!}
                        </div>
                        
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex justify-between">
                                <span>Código:</span>
                                <span class="font-mono">{{ $registration->code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Local:</span>
                                <span>{{ $registration->event->location_name }}</span>
                            </div>
                            @if($registration->event->isPaid())
                                <div class="flex justify-between">
                                    <span>Valor:</span>
                                    <span>{{ $registration->event->priceFormatted() }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('user.registrations.show', $registration->code) }}" class="btn btn-secondary flex-1">
                                Ver detalhes
                            </a>
                            
                            @if($registration->isPending() && $registration->event->isPaid())
                                <a href="{{ route('payment.create', $registration->code) }}" class="btn btn-primary flex-1">
                                    Pagar agora
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card text-center py-12">
                <p class="text-gray-500 mb-4">Você ainda não tem inscrições.</p>
                <a href="{{ route('events.index') }}" class="btn btn-primary">
                    Ver eventos disponíveis
                </a>
            </div>
        @endif
        
    </div>
</section>

@endsection
