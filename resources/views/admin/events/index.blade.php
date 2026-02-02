@extends('layouts.app')

@section('title', 'Gerenciar Eventos - Admin')

@section('content')

<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">Eventos</h1>
            <a href="{{ route('admin.eventos.create') }}" class="btn btn-primary">
                + Novo Evento
            </a>
        </div>
    </div>
</div>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($events->count() > 0)
            <div class="card">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4">Evento</th>
                                <th class="text-left py-3 px-4">Data</th>
                                <th class="text-center py-3 px-4">Inscritos</th>
                                <th class="text-center py-3 px-4">Status</th>
                                <th class="text-right py-3 px-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="font-semibold">{{ $event->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $event->priceFormatted() }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    {{ $event->start_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    {{ $event->registrations()->count() }}
                                    @if($event->capacity)
                                        / {{ $event->capacity }}
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($event->status === 'published')
                                        <span class="badge badge-success">Publicado</span>
                                    @elseif($event->status === 'draft')
                                        <span class="badge badge-warning">Rascunho</span>
                                    @else
                                        <span class="badge badge-danger">Fechado</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right space-x-2">
                                    <a href="{{ route('admin.eventos.show', $event) }}" class="text-primary-600 hover:text-primary-700">
                                        Ver
                                    </a>
                                    <a href="{{ route('admin.eventos.edit', $event) }}" class="text-blue-600 hover:text-blue-700">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-6">
                {{ $events->links() }}
            </div>
        @else
            <div class="card text-center py-12">
                <p class="text-gray-500 mb-4">Nenhum evento criado ainda.</p>
                <a href="{{ route('admin.eventos.create') }}" class="btn btn-primary">
                    Criar primeiro evento
                </a>
            </div>
        @endif
        
    </div>
</section>

@endsection
