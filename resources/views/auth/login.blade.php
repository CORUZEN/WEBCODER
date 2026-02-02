@extends('layouts.app')

@section('title', 'Entrar - IAGUS')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Entrar na sua conta</h1>
            <p class="mt-2 text-gray-600">
                Não tem uma conta? 
                <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Criar conta
                </a>
            </p>
        </div>
        
        <div class="card">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="label">E-mail</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        class="input @error('email') border-red-500 @enderror"
                    >
                    @error('email')
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
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-600">Lembrar de mim</span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary w-full">
                    Entrar
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
