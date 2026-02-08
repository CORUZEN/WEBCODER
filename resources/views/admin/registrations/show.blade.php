@extends('layouts.app')

@section('title', 'Inscrição #' . $registration->code . ' - Admin')

@section('content')

<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.registrations.index') }}" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold">Inscrição #{{ $registration->code }}</h1>
                    <p class="text-primary-100">Detalhes completos da inscrição</p>
                </div>
            </div>
            
            <!-- Status Badge -->
            <div>
                @if($registration->status === 'paid')
                    <span class="badge badge-success text-lg">Pago</span>
                @elseif($registration->status === 'pending_payment')
                    <span class="badge badge-warning text-lg">Pendente</span>
                @elseif($registration->status === 'registered')
                    <span class="badge badge-primary text-lg">Confirmado</span>
                @elseif($registration->status === 'cancelled')
                    <span class="badge badge-danger text-lg">Cancelado</span>
                @elseif($registration->status === 'refunded')
                    <span class="badge badge-secondary text-lg">Reembolsado</span>
                @else
                    <span class="badge badge-secondary text-lg">{{ $registration->status }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Coluna Principal -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Informações do Participante -->
                <div class="card">
                    <h3 class="text-xl font-bold mb-6">Participante</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm text-gray-500">Nome Completo</label>
                            <p class="text-gray-800 font-semibold text-lg">{{ $registration->user->name }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <p class="text-gray-800">{{ $registration->user->email }}</p>
                        </div>
                        
                        @if($registration->user->phone)
                        <div>
                            <label class="text-sm text-gray-500">Telefone</label>
                            <p class="text-gray-800">{{ $registration->user->phone }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <label class="text-sm text-gray-500">Cadastrado em</label>
                            <p class="text-gray-800">{{ $registration->user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Informações do Evento -->
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold">Evento</h3>
                        <a href="{{ route('admin.eventos.show', $registration->event) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            Ver evento completo →
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-500">Título</label>
                            <p class="text-gray-800 font-semibold text-lg">{{ $registration->event->title }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500">Data</label>
                                <p class="text-gray-800">{{ $registration->event->start_at->format('d/m/Y H:i') }}</p>
                                @if($registration->event->end_at)
                                    <p class="text-sm text-gray-600">até {{ $registration->event->end_at->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                            
                            <div>
                                <label class="text-sm text-gray-500">Local</label>
                                <p class="text-gray-800">{{ $registration->event->location_name }}</p>
                                @if($registration->event->location_address)
                                    <p class="text-sm text-gray-600">{{ $registration->event->location_address }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm text-gray-500">Preço</label>
                            <p class="text-gray-800 font-semibold">{{ $registration->event->priceFormatted() }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Informações de Pagamento -->
                @if(!$registration->event->isFree())
                <div class="card">
                    <h3 class="text-xl font-bold mb-6">Pagamento</h3>
                    
                    @if($registration->payment)
                        <div class="space-y-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="text-sm text-gray-500">Status</label>
                                    <p class="text-gray-800">
                                        @if($registration->payment->status === 'approved')
                                            <span class="badge badge-success">Aprovado</span>
                                        @elseif($registration->payment->status === 'pending')
                                            <span class="badge badge-warning">Pendente</span>
                                        @elseif($registration->payment->status === 'rejected')
                                            <span class="badge badge-danger">Rejeitado</span>
                                        @elseif($registration->payment->status === 'cancelled')
                                            <span class="badge badge-secondary">Cancelado</span>
                                        @elseif($registration->payment->status === 'refunded')
                                            <span class="badge badge-secondary">Reembolsado</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $registration->payment->status }}</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="text-sm text-gray-500">Valor</label>
                                    <p class="text-gray-800 font-semibold">
                                        R$ {{ number_format($registration->payment->amount_cents / 100, 2, ',', '.') }}
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="text-sm text-gray-500">Provedor</label>
                                    <p class="text-gray-800 capitalize">{{ $registration->payment->provider }}</p>
                                </div>
                            </div>
                            
                            @if($registration->payment->mp_payment_id)
                            <div>
                                <label class="text-sm text-gray-500">ID do Pagamento (Mercado Pago)</label>
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $registration->payment->mp_payment_id }}</code>
                            </div>
                            @endif
                            
                            @if($registration->payment->mp_preference_id)
                            <div>
                                <label class="text-sm text-gray-500">ID da Preferência</label>
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $registration->payment->mp_preference_id }}</code>
                            </div>
                            @endif
                            
                            @if($registration->payment->status_detail)
                            <div>
                                <label class="text-sm text-gray-500">Detalhes</label>
                                <p class="text-gray-800">{{ $registration->payment->status_detail }}</p>
                            </div>
                            @endif
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-gray-500">Criado em</label>
                                    <p class="text-gray-800">{{ $registration->payment->created_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm text-gray-500">Atualizado em</label>
                                    <p class="text-gray-800">{{ $registration->payment->updated_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <p class="text-gray-500">Nenhum pagamento registrado ainda</p>
                            <p class="text-sm text-gray-400 mt-1">O pagamento será criado quando o participante iniciar o checkout</p>
                        </div>
                    @endif
                </div>
                @endif
                
                <!-- Notas Administrativas -->
                @if($registration->notes)
                <div class="card bg-yellow-50 border border-yellow-200">
                    <h3 class="text-lg font-bold mb-3 text-yellow-800">Notas Administrativas</h3>
                    <p class="text-gray-700">{{ $registration->notes }}</p>
                </div>
                @endif
                
            </div>
            
            <!-- Coluna Lateral -->
            <div class="space-y-6">
                
                <!-- Resumo -->
                <div class="card">
                    <h3 class="text-lg font-bold mb-4">Resumo</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-gray-500">Código</label>
                            <code class="block text-sm bg-primary-50 text-primary-700 px-3 py-2 rounded font-mono">
                                {{ $registration->code }}
                            </code>
                        </div>
                        
                        <div>
                            <label class="text-sm text-gray-500">Status da Inscrição</label>
                            <p class="text-gray-800 font-semibold">{{ $registration->statusLabel() }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm text-gray-500">Data da Inscrição</label>
                            <p class="text-gray-800">{{ $registration->created_at->format('d/m/Y H:i') }}</p>
                            <p class="text-xs text-gray-500">{{ $registration->created_at->diffForHumans() }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm text-gray-500">Última Atualização</label>
                            <p class="text-gray-800">{{ $registration->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Ações -->
                <div class="card">
                    <h3 class="text-lg font-bold mb-4">Ações</h3>
                    
                    <div class="space-y-3">
                        
                        <!-- Ver Evento -->
                        <a href="{{ route('admin.eventos.show', $registration->event) }}" class="btn btn-secondary w-full text-center">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Ver Evento
                        </a>
                        
                        <!-- Ver Todas as Inscrições -->
                        <a href="{{ route('admin.registrations.index', ['event_id' => $registration->event_id]) }}" class="btn btn-secondary w-full text-center">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Outras Inscrições
                        </a>
                        
                        <!-- Cancelar Inscrição -->
                        @if(!$registration->isCancelled())
                        <form action="{{ route('admin.registrations.cancel', $registration) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar esta inscrição?');">
                            @csrf
                            <button type="submit" class="btn bg-red-600 text-white hover:bg-red-700 w-full">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar Inscrição
                            </button>
                        </form>
                        @endif
                        
                    </div>
                </div>
                
                <!-- Links Úteis -->
                @if($registration->payment && $registration->payment->mp_payment_id)
                <div class="card bg-blue-50 border border-blue-200">
                    <h3 class="text-sm font-bold mb-3 text-blue-800">Links do Mercado Pago</h3>
                    <div class="space-y-2 text-xs">
                        <a 
                            href="https://www.mercadopago.com.br/activities/{{ $registration->payment->mp_payment_id }}" 
                            target="_blank" 
                            class="block text-blue-600 hover:text-blue-800"
                        >
                            Ver no Mercado Pago →
                        </a>
                    </div>
                </div>
                @endif
                
            </div>
            
        </div>
        
    </div>
</section>

@endsection
