<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error 404')</title>
    <!-- Favicon SVG -->
    <link rel="icon" type="image/svg+xml" href="/img/logo.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>
    <!-- Encabezado con menú de navegación tipo hamburguesa -->
    <x-header />

    <!-- Sección principal con imagen de error 404 -->
    <main class="container mx-auto px-4 py-12">
        <div class="flex flex-col items-center justify-center gap-8">
            <!-- Título del error -->
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-2">¡Ups! Error 404</h1>
                <p class="text-xl opacity-70">La página que estás buscando no existe</p>
            </div>

            <!-- Tarjeta con imagen de error 404 -->
            <div class="card w-full max-w-lg bg-base-200 shadow-xl">
                <figure class="px-6 pt-6">
                    <img src="/api/placeholder/600/400" alt="Error 404" class="rounded-xl" />
                </figure>
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Página no encontrada</h2>
                    <p>La página que intentas acceder no existe o ha sido movida.</p>
                    <div class="card-actions mt-4">
                        <a href="/" class="btn btn-primary btn-lg">Volver al inicio</a>
                    </div>
                </div>
            </div>

            <!-- Sugerencias adicionales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full max-w-2xl mt-8">
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body">
                        <h3 class="card-title">¿Buscabas algo?</h3>
                        <p>Utiliza nuestra barra de búsqueda para encontrar lo que necesitas.</p>
                        <div class="form-control mt-2">
                            <div class="input-group">
                                <input type="text" placeholder="Buscar…" class="input input-bordered w-full" />
                                <button class="btn btn-square">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body">
                        <h3 class="card-title">Enlaces populares</h3>
                        <ul class="list-disc list-inside">
                            <li><a href="/productos" class="link link-hover">Catálogo de productos</a></li>
                            <li><a href="/blog" class="link link-hover">Blog</a></li>
                            <li><a href="/contacto" class="link link-hover">Contáctanos</a></li>
                            <li><a href="/faq" class="link link-hover">Preguntas frecuentes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Pie de página -->
</body>
</html>