@extends('layouts.app')

@section('title', 'Criar Conta - IAGUS')

@section('hide_footer', true)
@section('html_class', 'h-full')
@section('body_class', 'h-full overflow-hidden')
@section('main_class', 'overflow-y-auto')

@push('styles')
<style>
    .auth-bg {
        background-color: #0f172a;
        background-image:
            radial-gradient(ellipse at 20% 50%, rgba(30, 64, 175, 0.3) 0%, transparent 60%),
            radial-gradient(ellipse at 80% 20%, rgba(79, 70, 229, 0.2) 0%, transparent 50%),
            radial-gradient(ellipse at 60% 80%, rgba(15, 118, 110, 0.15) 0%, transparent 50%);
    }
    .auth-card {
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(20px);
        box-shadow:
            0 0 0 1px rgba(255,255,255,0.1),
            0 4px 6px -1px rgba(0,0,0,0.3),
            0 20px 60px -10px rgba(0,0,0,0.5),
            0 40px 80px -20px rgba(15,23,42,0.4);
        border-radius: 1.25rem;
    }
    .auth-input {
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .auth-input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.12);
        outline: none;
    }
    .auth-btn {
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
        transition: all 0.2s;
        box-shadow: 0 4px 15px rgba(30,64,175,0.35);
    }
    .auth-btn:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        box-shadow: 0 6px 20px rgba(30,64,175,0.5);
        transform: translateY(-1px);
    }
    .auth-btn:active {
        transform: translateY(0);
    }
</style>
@endpush

@section('content')

<div class="auth-bg flex flex-col items-center justify-center min-h-full px-4 gap-5">

    <div class="auth-card w-full max-w-sm p-7">

        {{-- Cabeçalho --}}
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Criar sua conta</h1>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-3">
            @csrf

            {{-- Nome --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nome completo</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        placeholder="Seu nome completo"
                        class="auth-input w-full pl-9 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 @error('name') border-red-400 bg-red-50 @enderror">
                </div>
                @error('name')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- E-mail --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-mail</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        placeholder="seu@email.com"
                        class="auth-input w-full pl-9 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 @error('email') border-red-400 bg-red-50 @enderror">
                </div>
                @error('email')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Telefone --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Telefone <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        placeholder="(87) 9 9999-9999"
                        class="auth-input w-full pl-9 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 @error('phone') border-red-400 bg-red-50 @enderror">
                </div>
                @error('phone')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Senha --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Senha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required
                        placeholder="Mínimo 8 caracteres"
                        class="auth-input w-full pl-9 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 @error('password') border-red-400 bg-red-50 @enderror">
                </div>
                @error('password')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Confirmar senha --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirmar senha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        placeholder="Repita a senha"
                        class="auth-input w-full pl-9 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400">
                </div>
            </div>

            {{-- Botão --}}
            <button type="submit" class="auth-btn w-full py-2.5 px-4 text-white text-sm font-semibold rounded-lg mt-1">
                Criar conta gratuita
            </button>

            <p class="text-xs text-gray-400 text-center pt-1">
                Ao criar uma conta, você concorda com nossa
                <span class="text-gray-500 font-medium">política de privacidade</span>.
            </p>
        </form>

        <hr class="border-gray-200 my-6">
        <p class="text-center text-sm text-gray-500">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:text-blue-800 hover:underline ml-1">
                Entrar
            </a>
        </p>

    </div>

    <p class="text-center text-xs tracking-widest uppercase font-medium text-white/30">
        Powered by <span class="text-white/50 font-semibold">Coruzen</span>
    </p>
</div>

@endsection
