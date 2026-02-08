@extends('layouts.app')

@section('title', 'Gerenciar Inscrições - Admin')

@section('content')

<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Gerenciar Inscrições</h1>
        <p class="text-primary-100">Visualize e gerencie todas as inscrições</p>
    </div>
</div>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filtros -->
        <div class="card mb-8">
            <form method="GET" action="{{ route('admin.registrations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <!-- Buscar -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Buscar
                    </label>
                    <input 
                        type="text" 
                        id="search" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Nome, email ou código"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                </div>
                
                <!-- Evento -->
                <div>
                    <label for="event_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Evento
                    </label>
                    <select 
                        id="event_id" 
                        name="event_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                        <option value="">Todos os eventos</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select 
                        id="status" 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                        <option value="">Todos</option>
                        <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Confirmado (Gratuito)</option>
                        <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>Pendente de Pagamento</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Pago</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Reembolsado</option>
                    </select>
                </div>
                
                <!-- Botões -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="btn btn-primary flex-1">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
                        Limpar
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Resultados -->
        @if($registrations->count() > 0)
            <div class="card mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">
                        {{ $registrations->total() }} {{ Str::plural('inscrição', $registrations->total()) }}
                    </h3>
                    
                    @if(request()->hasAny(['search', 'event_id', 'status']))
                    <span class="text-sm text-gray-500">Resultados filtrados</span>
                    @endif
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4">Código</th>
                                <th class="text-left py-3 px-4">Participante</th>
                                <th class="text-left py-3 px-4">Evento</th>
                                <th class="text-center py-3 px-4">Status</th>
                                <th class="text-center py-3 px-4">Pagamento</th>
                                <th class="text-center py-3 px-4">Data</th>
                                <th class="text-right py-3 px-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $registration)
                            <tr class="border-b hover:bg-gray-50">
                                <!-- Código -->
                                <td class="py-3 px-4">
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $registration->code }}</code>
                                </td>
                                
                                <!-- Participante -->
                                <td class="py-3 px-4">
                                    <div class="font-semibold">{{ $registration->user->name }}</div>
                                    <div class="text-sm text-gray-600">{{ $registration->user->email }}</div>
                                    @if($registration->user->phone)
                                        <div class="text-xs text-gray-500">{{ $registration->user->phone }}</div>
                                    @endif
                                </td>
                                
                                <!-- Evento -->
                                <td class="py-3 px-4">
                                    <div class="font-medium">{{ Str::limit($registration->event->title, 40) }}</div>
                                    <div class="text-sm text-gray-600">{{ $registration->event->start_at->format('d/m/Y') }}</div>
                                </td>
                                
                                <!-- Status -->
                                <td class="py-3 px-4 text-center">
                                    @if($registration->status === 'paid')
                                        <span class="badge badge-success">Pago</span>
                                    @elseif($registration->status === 'pending_payment')
                                        <span class="badge badge-warning">Pendente</span>
                                    @elseif($registration->status === 'registered')
                                        <span class="badge badge-primary">Confirmado</span>
                                    @elseif($registration->status === 'cancelled')
                                        <span class="badge badge-danger">Cancelado</span>
                                    @elseif($registration->status === 'refunded')
                                        <span class="badge badge-secondary">Reembolsado</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $registration->status }}</span>
                                    @endif
                                </td>
                                
                                <!-- Pagamento -->
                                <td class="py-3 px-4 text-center">
                                    @if($registration->event->isFree())
                                        <span class="text-sm text-gray-500">Gratuito</span>
                                    @elseif($registration->payment)
                                        <div class="text-sm">
                                            @if($registration->payment->status === 'approved')
                                                <span class="text-green-600">✓ Aprovado</span>
                                            @elseif($registration->payment->status === 'pending')
                                                <span class="text-yellow-600">⏱ Pendente</span>
                                            @elseif($registration->payment->status === 'rejected')
                                                <span class="text-red-600">✗ Rejeitado</span>
                                            @else
                                                <span class="text-gray-500">{{ $registration->payment->status }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">Sem pagamento</span>
                                    @endif
                                </td>
                                
                                <!-- Data -->
                                <td class="py-3 px-4 text-center text-sm">
                                    <div>{{ $registration->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $registration->created_at->format('H:i') }}</div>
                                </td>
                                
                                <!-- Ações -->
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.registrations.show', $registration) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                        Ver detalhes
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Paginação -->
            <div class="mt-6">
                {{ $registrations->appends(request()->query())->links() }}
            </div>
            
        @else
            <div class="card text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 mb-4">
                    @if(request()->hasAny(['search', 'event_id', 'status']))
                        Nenhuma inscrição encontrada com os filtros aplicados.
                    @else
                        Nenhuma inscrição registrada ainda.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'event_id', 'status']))
                    <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
                        Limpar filtros
                    </a>
                @endif
            </div>
        @endif
        
    </div>
</section>

@endsection
