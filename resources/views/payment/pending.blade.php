@extends('layouts.app')

@section('title', 'Pagamento Processado - IAGUS')

@section('content')

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="card text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold mb-4">Pagamento em Processamento</h1>
            
            <p class="text-gray-600 mb-6">
                Seu pagamento está sendo processado. Você receberá uma confirmação por e-mail assim que for aprovado.
            </p>
            
            <div class="space-y-3">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary w-full">
                    Ver minhas inscrições
                </a>
                <a href="{{ route('home') }}" class="btn btn-secondary w-full">
                    Voltar para o início
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
