@extends('layouts.app')

@section('title', 'Pagamento Realizado - IAGUS')

@section('content')

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="card text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold mb-4">Pagamento Realizado!</h1>
            
            <p class="text-gray-600 mb-6">
                Seu pagamento foi processado com sucesso. Você receberá uma confirmação por e-mail em breve.
            </p>
            
            <div class="space-y-3">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary w-full">
                    Ver minhas inscrições
                </a>
                <a href="{{ route('events.index') }}" class="btn btn-secondary w-full">
                    Ver mais eventos
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
