@extends('layouts.app')

@section('title', 'Finalizar Pagamento - IAGUS')

@section('content')

<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="card mb-6">
            <h1 class="text-2xl font-bold mb-6">Finalizar Pagamento</h1>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h2 class="font-semibold mb-2">{{ $registration->event->title }}</h2>
                <div class="text-sm text-gray-600 space-y-1">
                    <div>Data: {{ $registration->event->start_at->format('d/m/Y - H:i') }}</div>
                    <div>Código da inscrição: <span class="font-mono">{{ $registration->code }}</span></div>
                </div>
            </div>
            
            <div class="flex justify-between items-center py-4 border-t border-b mb-6">
                <span class="text-lg font-semibold">Valor total:</span>
                <span class="text-2xl font-bold text-primary-600">{{ $registration->event->priceFormatted() }}</span>
            </div>
            
            <div class="mb-6">
                <p class="text-gray-600 mb-4">
                    Você será redirecionado para o Mercado Pago para realizar o pagamento de forma segura.
                </p>
                <p class="text-sm text-gray-500">
                    ✓ Ambiente seguro<br>
                    ✓ Várias formas de pagamento<br>
                    ✓ Confirmação automática
                </p>
            </div>
            
            <!-- Mercado Pago Button -->
            <div id="wallet_container"></div>
            
        </div>
        
        <div class="text-center">
            <a href="{{ route('user.registrations.show', $registration->code) }}" class="text-gray-600 hover:text-gray-900">
                ← Voltar para a inscrição
            </a>
        </div>
        
    </div>
</div>

@endsection

@push('scripts')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago('{{ config('services.mercadopago.public_key') }}', {
        locale: 'pt-BR'
    });
    
    mp.bricks().create("wallet", "wallet_container", {
        initialization: {
            preferenceId: '{{ $preferenceId }}',
        },
        customization: {
            texts: {
                valueProp: 'smart_option',
            },
        },
    });
</script>
@endpush
