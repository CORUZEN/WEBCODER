@extends('layouts.app')

@section('title', 'Criar Conta - IAGUS')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Criar sua conta</h1>
            <p class="mt-2 text-gray-600">
                Já tem uma conta? 
                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Entrar
                </a>
            </p>
        </div>
        
        <div class="card">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="label">Nome completo</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required 
                        autofocus
                        class="input @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="label">E-mail</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="input @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="phone" class="label">Telefone (opcional)</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}"
                        placeholder="(87) 9 9999-9999"
                        class="input @error('phone') border-red-500 @enderror"
                    >
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="label">Senha</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="input @error('password') border-red-500 @enderror"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="label">Confirmar senha</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        class="input"
                    >
                </div>
                
                <button type="submit" class="btn btn-primary w-full">
                    Criar conta
                </button>
                
                <p class="text-xs text-gray-500 text-center">
                    Ao criar uma conta, você concorda com nossa política de privacidade.
                </p>
            </form>
        </div>
    </div>
</div>

@endsection
