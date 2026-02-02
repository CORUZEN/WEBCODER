@extends('layouts.app')

@section('title', 'Erro no Pagamento - IAGUS')

@section('content')

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="card text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold mb-4">Erro no Pagamento</h1>
            
            <p class="text-gray-600 mb-6">
                Não foi possível processar seu pagamento. Por favor, tente novamente.
            </p>
            
            <div class="space-y-3">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary w-full">
                    Tentar novamente
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary w-full">
                    Falar com o suporte
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
