<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Favicon SVG -->
        <link rel="icon" type="image/svg+xml" href="/img/logo.svg">

        <!-- Fuentes -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Script para aplicar el tema guardado antes de cargar el CSS -->
    <script>
      (function() {
        try {
          var theme = localStorage.getItem('theme');
          if (!theme) {
            // Detectar preferencia del sistema
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
              theme = 'dark';
            } else {
              theme = 'light';
            }
          }
          document.documentElement.setAttribute('data-theme', theme);
        } catch(e) {
          document.documentElement.setAttribute('data-theme', 'light');
        }
      })();
    </script>
    </head>
    <body class="font-sans antialiased min-h-screen flex flex-col bg-base-200 text-base-content">



        <!-- Banner global informativo desde archivo -->
        @php
            $bannerPath = storage_path('app/banner.txt');
            $bannerMessage = '';
            if (file_exists($bannerPath)) {
                $bannerMessage = trim(file_get_contents($bannerPath));
            }
        @endphp
        @if(!empty($bannerMessage))
            <div class="w-full bg-yellow-400 text-yellow-900 text-center py-2 px-4 font-semibold shadow-md z-40">
                <span class="inline-block align-middle">
                    {{ $bannerMessage }}
                </span>
            </div>
        @endif

        <!-- Header global DaisyUI -->
        <x-header />

        <!-- Encabezado de la página -->
        @isset($header)
            <header class="bg-base-100 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Contenido de la página -->
        <main class="flex-1">
            @yield('content')
            @isset($slot)
                {{ $slot }}
            @endisset
        </main>
        <x-footer />
        @auth
            @if (!request()->routeIs('profile.edit'))
                <!-- FAB móvil: Crear hilo -->
                <a href="{{ route('threads.create') }}"
                   class="fixed bottom-6 right-6 z-[120] btn btn-primary btn-circle shadow-lg sm:hidden flex items-center justify-center w-16 h-16 text-3xl"
                   style="box-shadow: 0 4px 24px 0 rgba(0,0,0,0.18);"
                   aria-label="Crear hilo">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            @endif
        @endauth
        @stack('scripts')
    </body>
</html>
