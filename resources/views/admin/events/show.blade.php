@extends('layouts.app')

@section('title', $event->title . ' - Admin')

@section('content')

<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.eventos.index') }}" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold">{{ $event->title }}</h1>
                    <p class="text-primary-100">{{ $event->start_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.events.export', $event) }}" class="btn bg-white text-primary-700 hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Exportar CSV
                </a>
                <a href="{{ route('admin.eventos.edit', $event) }}" class="btn bg-white text-primary-700 hover:bg-gray-100">
                    Editar Evento
                </a>
            </div>
        </div>
    </div>
</div>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
                <div class="text-3xl font-bold mb-2">{{ $stats['total'] }}</div>
                <div class="text-blue-100">Total</div>
            </div>
            
            <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
                <div class="text-3xl font-bold mb-2">{{ $stats['paid'] }}</div>
                <div class="text-green-100">Pagos</div>
            </div>
            
            <div class="card bg-gradient-to-br from-yellow-500 to-yellow-600 text-white">
                <div class="text-3xl font-bold mb-2">{{ $stats['pending_payment'] }}</div>
                <div class="text-yellow-100">Pendentes</div>
            </div>
            
            <div class="card bg-gradient-to-br from-gray-500 to-gray-600 text-white">
                <div class="text-3xl font-bold mb-2">{{ $stats['registered'] }}</div>
                <div class="text-gray-100">Gratuitos</div>
            </div>
            
            <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
                <div class="text-2xl font-bold mb-2">R$ {{ number_format($stats['revenue'] / 100, 2, ',', '.') }}</div>
                <div class="text-purple-100">Receita</div>
            </div>
        </div>
        
        <!-- Detalhes do Evento -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            
            <!-- Coluna Principal -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Informações -->
                <div class="card">
                    <h3 class="text-xl font-bold mb-4">Informações do Evento</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-500">Descrição</label>
                            <p class="text-gray-800">{{ $event->description }}</p>
                        </div>
                        
                        @if($event->instructions)
                        <div>
                            <label class="text-sm text-gray-500">Instruções</label>
                            <p class="text-gray-800">{{ $event->instructions }}</p>
                        </div>
                        @endif
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500">Data e Hora</label>
                                <p class="text-gray-800">{{ $event->start_at->format('d/m/Y H:i') }}</p>
                                @if($event->end_at)
                                    <p class="text-sm text-gray-600">até {{ $event->end_at->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                            
                            <div>
                                <label class="text-sm text-gray-500">Local</label>
                                <p class="text-gray-800">{{ $event->location_name }}</p>
                                @if($event->location_address)
                                    <p class="text-sm text-gray-600">{{ $event->location_address }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Inscritos -->
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold">Inscritos ({{ $registrations->total() }})</h3>
                        
                        <!-- Filtro rápido -->
                        <div class="flex items-center space-x-2">
                            <select 
                                class="px-3 py-1 border border-gray-300 rounded-lg text-sm"
                                onchange="window.location.href = '?status=' + this.value"
                            >
                                <option value="">Todos</option>
                                <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Gratuitos</option>
                                <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>Pendentes</option>
                                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Pagos</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelados</option>
                            </select>
                        </div>
                    </div>
                    
                    @if($registrations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-3 px-4">Código</th>
                                        <th class="text-left py-3 px-4">Nome</th>
                                        <th class="text-left py-3 px-4">Email</th>
                                        <th class="text-center py-3 px-4">Status</th>
                                        <th class="text-center py-3 px-4">Data</th>
                                        <th class="text-right py-3 px-4">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $registration)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $registration->code }}</code>
                                        </td>
                                        <td class="py-3 px-4">{{ $registration->user->name }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-600">{{ $registration->user->email }}</td>
                                        <td class="py-3 px-4 text-center">
                                            @if($registration->status === 'paid')
                                                <span class="badge badge-success">Pago</span>
                                            @elseif($registration->status === 'pending_payment')
                                                <span class="badge badge-warning">Pendente</span>
                                            @elseif($registration->status === 'registered')
                                                <span class="badge badge-primary">Confirmado</span>
                                            @elseif($registration->status === 'cancelled')
                                                <span class="badge badge-danger">Cancelado</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $registration->status }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-center text-sm">
                                            {{ $registration->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <a href="{{ route('admin.registrations.show', $registration) }}" class="text-primary-600 hover:text-primary-700 text-sm">
                                                Ver detalhes
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            {{ $registrations->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Nenhuma inscrição ainda.</p>
                    @endif
                </div>
                
            </div>
            
            <!-- Coluna Lateral -->
            <div class="space-y-6">
                
                <!-- Status -->
                <div class="card">
                    <h3 class="text-lg font-bold mb-4">Status</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-gray-500">Publicação</label>
                            <div class="mt-1">
                                @if($event->status === 'published')
                                    <span class="badge badge-success">Publicado</span>
                                @elseif($event->status === 'draft')
                                    <span class="badge badge-warning">Rascunho</span>
                                @else
                                    <span class="badge badge-danger">Fechado</span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm text-gray-500">Preço</label>
                            <p class="text-gray-800 font-semibold">{{ $event->priceFormatted() }}</p>
                        </div>
                        
                        @if($event->capacity)
                        <div>
                            <label class="text-sm text-gray-500">Vagas</label>
                            <p class="text-gray-800">
                                {{ $event->registrations()->count() }} / {{ $event->capacity }}
                                <span class="text-sm text-gray-600">
                                    ({{ $event->availableSpots() }} disponíveis)
                                </span>
                            </p>
                            
                            <!-- Barra de progresso -->
                            <div class="mt-2 bg-gray-200 rounded-full h-2">
                                @php
                                    $percentage = $event->capacity > 0 ? ($event->registrations()->count() / $event->capacity * 100) : 0;
                                @endphp
                                <div 
                                    class="bg-primary-600 h-2 rounded-full" 
                                    style="width: {{ min($percentage, 100) }}%"
                                ></div>
                            </div>
                        </div>
                        @else
                        <div>
                            <label class="text-sm text-gray-500">Vagas</label>
                            <p class="text-gray-800">Ilimitadas</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Inscrições -->
                <div class="card">
                    <h3 class="text-lg font-bold mb-4">Período de Inscrição</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-gray-500">Abertura</label>
                            <p class="text-gray-800">
                                {{ $event->registration_open_at ? $event->registration_open_at->format('d/m/Y H:i') : 'Imediata' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="text-sm text-gray-500">Fechamento</label>
                            <p class="text-gray-800">
                                {{ $event->registration_close_at ? $event->registration_close_at->format('d/m/Y H:i') : 'Sem limite' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="text-sm text-gray-500">Situação</label>
                            <p class="text-gray-800">
                                @if($event->isRegistrationOpen())
                                    <span class="badge badge-success">Abertas</span>
                                @else
                                    <span class="badge badge-danger">Fechadas</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Ações -->
                <div class="card">
                    <h3 class="text-lg font-bold mb-4">Ações</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="btn btn-secondary w-full text-center">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Ver no Site
                        </a>
                        
                        <a href="{{ route('admin.eventos.edit', $event) }}" class="btn btn-primary w-full text-center">
                            Editar Evento
                        </a>
                        
                        @if($event->registrations()->count() === 0)
                        <form action="{{ route('admin.eventos.destroy', $event) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este evento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn bg-red-600 text-white hover:bg-red-700 w-full">
                                Excluir Evento
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                
            </div>
            
        </div>
        
    </div>
</section>

@endsection
