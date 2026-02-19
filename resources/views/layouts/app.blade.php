<!DOCTYPE html>
<html lang="pt-BR" class="@yield('html_class', '')">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IAGUS - Igreja Anglicana de Garanhuns')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="@yield('body_class', 'min-h-screen') flex flex-col">
    
    @include('layouts.navbar')
    
    <main class="flex-grow flex flex-col @yield('main_class', '')">
        @if(session('success'))
            <div class="alert alert-success max-w-7xl mx-auto mt-4 px-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error max-w-7xl mx-auto mt-4 px-4">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('info'))
            <div class="alert alert-info max-w-7xl mx-auto mt-4 px-4">
                {{ session('info') }}
            </div>
        @endif
        
        @yield('content')
    </main>
    
    @unless(View::hasSection('hide_footer'))
    @include('layouts.footer')
    @endunless
    
    @stack('scripts')
</body>
</html>
