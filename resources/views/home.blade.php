@extends('layouts.app')

@section('title', 'IAGUS - Igreja Anglicana de Garanhuns')

@section('content')

<!-- Hero Section - Início -->
<section id="inicio" class="relative h-[calc(100dvh-64px)] min-h-[600px] flex items-center justify-center bg-primary-700 text-white overflow-hidden">
    <!-- Background - Elegant Aurora Effect -->
    <div class="absolute inset-0">
        <!-- Base gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800"></div>
        
        <!-- Aurora light effect 1 -->
        <div class="absolute top-0 left-1/4 w-1/2 h-full bg-gradient-to-b from-cyan-300/20 via-primary-400/10 to-transparent blur-3xl"></div>
        
        <!-- Aurora light effect 2 -->
        <div class="absolute top-1/3 right-0 w-1/3 h-2/3 bg-gradient-to-l from-sky-300/15 via-primary-500/10 to-transparent blur-3xl"></div>
        
        <!-- Aurora light effect 3 -->
        <div class="absolute bottom-0 left-0 w-2/3 h-1/2 bg-gradient-to-tr from-primary-400/20 via-primary-600/10 to-transparent blur-3xl"></div>
        
        <!-- Elegant spotlight top -->
        <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-b from-white/10 to-transparent rounded-full blur-3xl"></div>
        
        <!-- Subtle glow orbs -->
        <div class="absolute top-1/4 left-1/6 w-64 h-64 bg-primary-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/6 w-80 h-80 bg-primary-500/15 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col justify-center h-full">
        <div class="animate-fade-in">
            <p class="text-lg md:text-xl mb-4 text-primary-100 tracking-wider uppercase">Bem-vindo à</p>
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                Uma família para<br><span class="text-primary-200">pertencer</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto text-primary-100">
                Conheça a IAGUS e participe dos nossos cultos e eventos em Garanhuns.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#conheca" class="btn bg-white text-primary-600 hover:bg-gray-100 px-8 py-4 text-lg font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300">
                    Quero visitar
                </a>
                <a href="#eventos" class="btn bg-primary-500 hover:bg-primary-400 px-8 py-4 text-lg font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-white/30">
                    Ver próximos eventos
                </a>
            </div>
        </div>
    </div>
    
    <!-- Scroll indicator - positioned at bottom of section -->
    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
        <a href="#conheca" class="text-white/60 hover:text-white transition-colors p-2 block">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </a>
    </div>
</section>

<!-- O que esperar na sua visita -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">O que esperar na sua visita</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Uma experiência acolhedora e transformadora em cada momento</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="group text-center p-6 rounded-2xl hover:bg-gray-50 transition-all duration-300">
                <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">Recepção e acolhimento</h3>
                <p class="text-gray-600 leading-relaxed">Nossa equipe estará pronta para recebê-lo com um sorriso e tornar sua visita especial.</p>
            </div>
            
            <div class="group text-center p-6 rounded-2xl hover:bg-gray-50 transition-all duration-300">
                <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">Louvor e oração</h3>
                <p class="text-gray-600 leading-relaxed">Momento de adoração sincera e comunhão com Deus através da música.</p>
            </div>
            
            <div class="group text-center p-6 rounded-2xl hover:bg-gray-50 transition-all duration-300">
                <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">Mensagem bíblica</h3>
                <p class="text-gray-600 leading-relaxed">Ensino relevante e aplicável para o dia a dia, baseado na Palavra de Deus.</p>
            </div>
            
            <div class="group text-center p-6 rounded-2xl hover:bg-gray-50 transition-all duration-300">
                <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">Ambiente familiar</h3>
                <p class="text-gray-600 leading-relaxed">Espaço acolhedor para famílias, jovens e crianças se sentirem em casa.</p>
            </div>
        </div>
    </div>
</section>

<!-- Conheça - Sobre -->
<section id="conheca" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-primary-600 font-semibold tracking-wider uppercase">Sobre Nós</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-2 mb-6">Conheça a IAGUS</h2>
                
                <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                    <p>
                        A <strong>Igreja Anglicana de Garanhuns (IAGUS)</strong> é uma comunidade de fé cristã que busca viver e compartilhar o amor de Deus em Garanhuns e região.
                    </p>
                    <p>
                        Nossa missão é ser uma <strong>família acolhedora</strong> onde cada pessoa pode pertencer, crescer na fé e servir ao próximo.
                    </p>
                </div>
                
                <div class="mt-8 grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Acolhimento</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Comunidade</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Ensino Bíblico</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Serviço</span>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="absolute -inset-4 bg-primary-200 rounded-3xl transform rotate-3"></div>
                <div class="relative bg-white rounded-2xl p-8 shadow-xl">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Venha como você está</h3>
                        <p class="text-gray-600 mb-6">
                            Não importa de onde você vem ou o que está enfrentando. Aqui você encontrará uma família pronta para recebê-lo.
                        </p>
                        <a href="#contato" class="btn btn-primary w-full">
                            Fale conosco
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cultos - Agenda -->
<section id="cultos" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-600 font-semibold tracking-wider uppercase">Horários</span>
            <h2 class="text-4xl font-bold text-gray-900 mt-2 mb-4">Cultos e Agenda</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Participe dos nossos encontros semanais</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Domingo -->
            <div class="group relative bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl p-8 text-white overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="relative">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Domingo - Manhã</h3>
                    <p class="text-4xl font-bold mb-2">9:00</p>
                    <p class="text-primary-100">Culto de Celebração</p>
                    <p class="text-sm text-primary-200 mt-2">Louvor, adoração e mensagem bíblica</p>
                </div>
            </div>
            
            <!-- Quarta -->
            <div class="group relative bg-gradient-to-br from-secondary-500 to-secondary-700 rounded-2xl p-8 text-white overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="relative">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Quarta-feira - Noite</h3>
                    <p class="text-4xl font-bold mb-2">19:30</p>
                    <p class="text-secondary-100">Culto de Oração e Ensino</p>
                    <p class="text-sm text-secondary-200 mt-2">Momento de oração e estudo bíblico</p>
                </div>
            </div>
        </div>
        
        <!-- Info adicional -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div class="flex items-center justify-center gap-3 text-gray-600">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Estacionamento disponível</span>
            </div>
            <div class="flex items-center justify-center gap-3 text-gray-600">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Ambiente familiar</span>
            </div>
            <div class="flex items-center justify-center gap-3 text-gray-600">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Ministério infantil</span>
            </div>
        </div>
    </div>
</section>

<!-- Eventos -->
<section id="eventos" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
            <div>
                <span class="text-primary-600 font-semibold tracking-wider uppercase">Programação</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-2">Próximos Eventos</h2>
            </div>
            <a href="{{ route('events.index') }}" class="mt-4 md:mt-0 text-primary-600 hover:text-primary-700 font-medium flex items-center gap-2">
                Ver todos os eventos
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        
        @if($upcomingEvents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($upcomingEvents as $event)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                <div class="h-48 bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/50 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $event->start_at->format('d/m/Y - H:i') }}
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 group-hover:text-primary-600 transition-colors">{{ $event->title }}</h3>
                    <div class="flex items-center gap-2 text-gray-600 mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $event->location_name }}
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <span class="font-bold text-primary-600 text-lg">{{ $event->priceFormatted() }}</span>
                        <a href="{{ route('events.show', $event->slug) }}" class="btn btn-primary text-sm">
                            Ver detalhes
                        </a>
                    </div>
                    @if($event->capacity)
                    <div class="mt-3 text-sm text-gray-500 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        {{ $event->availableSpots() }} vagas disponíveis
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-2xl">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum evento programado</h3>
            <p class="text-gray-600">Em breve teremos novos eventos. Fique ligado!</p>
        </div>
        @endif
    </div>
</section>

<!-- Juventude -->
<section id="juventude" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Conteúdo Principal -->
                <div class="p-10 lg:p-14">
                    <span class="inline-block px-4 py-1.5 bg-primary-100 text-primary-700 font-semibold text-sm tracking-wider uppercase rounded-full mb-4">Jovens</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Juventude IAGUS</h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        "Um lugar seguro para pertencer, crescer e servir."
                    </p>
                    
                    <!-- Cards de Atividades -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-xl">👥</span>
                                <h4 class="font-bold text-gray-900">Grupos Pequenos</h4>
                            </div>
                            <p class="text-sm text-gray-600">Estudo e comunhão</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-xl">🎯</span>
                                <h4 class="font-bold text-gray-900">Discipulado</h4>
                            </div>
                            <p class="text-sm text-gray-600">Mentoria espiritual</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-xl">🙌</span>
                                <h4 class="font-bold text-gray-900">Ministérios</h4>
                            </div>
                            <p class="text-sm text-gray-600">Oportunidades de servir</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-xl">🏕️</span>
                                <h4 class="font-bold text-gray-900">Eventos</h4>
                            </div>
                            <p class="text-sm text-gray-600">Retiros e atividades</p>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Se você está recomeçando, buscando fé ou só quer conversar: você é bem-vindo!
                    </p>
                    
                    <a href="#contato" class="btn bg-primary-600 text-white hover:bg-primary-700 inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-colors">
                        Falar com a juventude
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
                
                <!-- Painel Lateral -->
                <div class="relative bg-gradient-to-br from-primary-600 to-primary-800 hidden lg:block">
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent"></div>
                    <div class="h-full flex items-center justify-center p-14">
                        <div class="text-center text-white">
                            <div class="w-40 h-40 bg-white/15 rounded-full flex items-center justify-center mx-auto mb-8 backdrop-blur-sm border border-white/20">
                                <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold mb-2">Sextas - 19:30h</p>
                            <p class="text-primary-200 text-lg">Encontro semanal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contato -->
<section id="contato" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-600 font-semibold tracking-wider uppercase">Fale Conosco</span>
            <h2 class="text-4xl font-bold text-gray-900 mt-2 mb-4">Entre em Contato</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Estamos aqui para responder suas dúvidas e orar por você</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Localização -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 text-center group">
                <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Localização</h3>
                <p class="text-gray-600">Garanhuns - PE</p>
            </div>
            
            <!-- E-mail -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 text-center group">
                <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">E-mail</h3>
                <a href="mailto:contato@iagus.org.br" class="text-primary-600 hover:text-primary-700 font-medium">
                    contato@iagus.org.br
                </a>
            </div>
            
            <!-- WhatsApp -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 text-center group">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">WhatsApp</h3>
                <a href="https://wa.me/5587999999999" target="_blank" class="text-green-600 hover:text-green-700 font-medium">
                    (87) 9 9999-9999
                </a>
            </div>
            
            <!-- Instagram -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 text-center group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Instagram</h3>
                <a href="https://instagram.com/iagus_garanhuns" target="_blank" class="inline-flex items-center gap-2 text-pink-600 hover:text-pink-700 font-medium transition-colors">
                    <span>@iagus_garanhuns</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Horário de Atendimento -->
        <div class="mt-12 bg-white rounded-2xl p-8 shadow-lg max-w-2xl mx-auto text-center">
            <h3 class="text-2xl font-bold mb-4">Horário de Atendimento</h3>
            <p class="text-gray-700 mb-2">
                <strong>Segunda a Sexta:</strong> 9h às 17h
            </p>
            <p class="text-gray-700 mb-4">
                <strong>Sábado e Domingo:</strong> Durante os cultos
            </p>
            <p class="text-gray-500">
                Ficamos felizes em responder suas dúvidas!
            </p>
        </div>
    </div>
</section>

@endsection
