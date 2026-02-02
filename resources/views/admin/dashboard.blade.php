@extends('layouts.app')

@section('title', 'Painel Administrativo - IAGUS')

@section('content')

<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Painel Administrativo</h1>
        <p>Bem-vindo, {{ auth()->user()->name }}</p>
    </div>
</div>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
                <div class="text-3xl font-bold mb-2">{{ $stats['total_events'] }}</div>
                <div class="text-blue-100">Total de Eventos</div>
            </div>
            
            <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
                <div class="text-3xl font-bold mb-2">{{ $stats['total_registrations'] }}</div>
                <div class="text-green-100">Total de Inscrições</div>
            </div>
            
            <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
                <div class="text-3xl font-bold mb-2">{{ $stats['paid_registrations'] }}</div>
                <div class="text-purple-100">Inscrições Pagas</div>
            </div>
            
            <div class="card bg-gradient-to-br from-yellow-500 to-yellow-600 text-white">
                <div class="text-3xl font-bold mb-2">R$ {{ number_format($stats['total_revenue'] / 100, 2, ',', '.') }}</div>
                <div class="text-yellow-100">Receita Total</div>
            </div>
        </div>
        
        <!-- Navigation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <a href="{{ route('admin.eventos.index') }}" class="card hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold mb-1">Eventos</h3>
                        <p class="text-gray-600">Gerenciar eventos</p>
                    </div>
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </a>
            
            <a href="{{ route('admin.registrations.index') }}" class="card hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold mb-1">Inscrições</h3>
                        <p class="text-gray-600">Ver todas as inscrições</p>
                    </div>
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </a>
            
            <a href="{{ route('admin.eventos.create') }}" class="card hover:shadow-xl transition bg-primary-50 border-2 border-primary-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold mb-1 text-primary-700">Novo Evento</h3>
                        <p class="text-primary-600">Criar evento</p>
                    </div>
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </a>
        </div>
        
        <!-- Próximos Eventos -->
        @if($upcomingEvents->count() > 0)
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Próximos Eventos</h2>
            <div class="card">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4">Evento</th>
                                <th class="text-left py-3 px-4">Data</th>
                                <th class="text-center py-3 px-4">Inscritos</th>
                                <th class="text-center py-3 px-4">Vagas</th>
                                <th class="text-right py-3 px-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingEvents as $event)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="font-semibold">{{ $event->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $event->location_name }}</div>
                                </td>
                                <td class="py-3 px-4">{{ $event->start_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4 text-center">{{ $event->registrations()->count() }}</td>
                                <td class="py-3 px-4 text-center">{{ $event->capacity ?? '∞' }}</td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.eventos.show', $event) }}" class="text-primary-600 hover:text-primary-700">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Inscrições Recentes -->
        @if($recentRegistrations->count() > 0)
        <div>
            <h2 class="text-2xl font-bold mb-6">Inscrições Recentes</h2>
            <div class="card">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4">Nome</th>
                                <th class="text-left py-3 px-4">Evento</th>
                                <th class="text-center py-3 px-4">Status</th>
                                <th class="text-left py-3 px-4">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRegistrations as $registration)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="font-semibold">{{ $registration->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $registration->user->email }}</div>
                                </td>
                                <td class="py-3 px-4">{{ $registration->event->title }}</td>
                                <td class="py-3 px-4 text-center">{!! $registration->statusBadge() !!}</td>
                                <td class="py-3 px-4">{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
    </div>
</section>

@endsection
