<x-app-layout :title="'Inicio'">
    <div class="container mx-auto px-4 py-8">
        <!-- Sección principal (Hero) -->
        <div class="hero bird-bg rounded-box mb-8">
            <div class="hero-overlay bg-opacity-60 rounded-box"></div>
            <div class="hero-content text-center text-neutral-content py-10">
                <div class="max-w-md">
                    <h1 class="mb-5 text-4xl font-bold">Bienvenido al Foro de Pájaros</h1>
                    <p class="mb-5">Comparte tus experiencias, conocimientos y pasión por las aves con entusiastas de
                        todo el mundo.</p>
                    <a href="{{ route('threads.create') }}" class="btn btn-primary">Crear nuevo hilo</a>
                </div>
            </div>
        </div>

        <!-- Contenedor de rankings y tops -->
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ranking de usuarios -->
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-2xl font-bold mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Ranking de usuarios más activos
                        </h2>
                        <ol class="divide-y divide-base-200">
                            @forelse($topUsers as $user)
                                <li class="flex items-center gap-4 py-3">
                                    <a href="{{ route('profile.show', $user) }}" class="shrink-0"
                                        title="Ver perfil de {{ $user->name }}">
                                        <x-user-avatar :user="$user" size="w-10 h-10" />
                                    </a>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('profile.show', $user) }}"
                                            class="font-semibold text-base-content hover:text-primary transition">{{ $user->name }}</a>
                                        <div class="text-sm text-base-content/70">{{ $user->threads_count }} hilos</div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-3 text-base-content/70">Aún no hay usuarios activos.</li>
                            @endforelse
                        </ol>
                    </div>
                </div>
                <!-- Top hilos más votados -->
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-2xl font-bold mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-warning" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Top hilos más votados
                        </h2>
                        <ol class="divide-y divide-base-200">
                            @forelse($topThreads as $thread)
                                <li class="flex items-center gap-4 py-3">
                                    @if ($thread->user)
                                        <a href="{{ route('profile.show', $thread->user) }}" class="shrink-0"
                                            title="Ver perfil de {{ $thread->user->name }}">
                                            <x-user-avatar :user="$thread->user" size="w-10 h-10" />
                                        </a>
                                    @else
                                        <span class="shrink-0">
                                            <x-user-avatar :user="null" size="w-10 h-10" />
                                        </span>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('threads.show', $thread) }}"
                                            class="font-semibold text-base-content hover:text-primary transition block truncate">{{ $thread->title }}</a>
                                        <div class="text-sm text-base-content/70">{{ $thread->votes }} votos</div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-3 text-base-content/70">Aún no hay hilos votados.</li>
                            @endforelse
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hilos recientes (solo los 5 últimos, sin paginación) -->
        <div class="mb-8">
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h2 class="card-title text-2xl font-bold mb-4">Hilos Recientes</h2>
                    @foreach ($recentThreads as $thread)
                        <div class="card thread-card bg-base-100 shadow mb-4 hover:shadow-xl transition-shadow cursor-pointer group"
                            onclick="window.location='{{ route('threads.show', $thread) }}'"
                            style="position: relative;" tabindex="0" role="button"
                            onkeydown="if(event.key==='Enter'||event.key===' '){window.location='{{ route('threads.show', $thread) }}';}">
                            <div class="card-body p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            @if ($thread->user)
                                                <a href="{{ route('profile.show', $thread->user) }}"
                                                    class="shrink-0 mr-0" onclick="event.stopPropagation();">
                                                    <x-user-avatar :user="$thread->user" size="w-12 h-12" />
                                                </a>
                                            @else
                                                <span class="shrink-0 mr-0">
                                                    <x-user-avatar :user="null" size="w-12 h-12" />
                                                </span>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <h3
                                                        class="text-base sm:text-lg md:text-xl lg:text-2xl xl:text-3xl font-bold group-hover:text-primary min-w-0 flex items-center">
                                                        <span
                                                            class="truncate block max-w-[12rem] sm:max-w-xs md:max-w-sm lg:max-w-md whitespace-nowrap overflow-hidden align-middle min-w-0"
                                                            title="{{ $thread->title }}">
                                                            {{ $thread->title }}
                                                        </span>
                                                        <!-- Contador de respuestas SOLO en móvil, al lado del título -->
                                                        <span class="flex sm:hidden items-center gap-1 ml-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                                            </svg>
                                                            <span
                                                                class="font-semibold">{{ $thread->comments->count() }}</span>
                                                        </span>
                                                    </h3>
                                                </div>
                                                <p class="text-sm text-gray-500">
                                                    Publicado por @if ($thread->user)
                                                        <a href="{{ route('profile.show', $thread->user) }}"
                                                            class="font-medium text-primary hover:underline"
                                                            onclick="event.stopPropagation();">{{ $thread->user->name }}</a>
                                                    @else
                                                        <span class="font-medium text-primary">Usuario eliminado</span>
                                                    @endif
                                                    • {{ $thread->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- Bloque de respuestas clásico solo en sm o superior -->
                                    <div class="hidden sm:flex flex-col items-center justify-center flex-shrink-0 ml-4">
                                        <div class="bg-base-200 rounded-lg shadow p-2 w-20 text-center">
                                            <div class="text-xs text-base-content/70 font-semibold mb-1">Respuestas
                                            </div>
                                            <div class="text-lg font-bold text-base-content">
                                                {{ $thread->comments->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    

    <!-- Llamada a la acción -->
    <div class="mt-8 text-center">
        <div class="card bg-base-200 shadow-lg">
            <div class="card-body">
                <h2 class="card-title justify-center">¿No encuentras lo que buscas?</h2>
                <p>Crea un nuevo tema de discusión y comparte tus conocimientos o preguntas con la comunidad.</p>
                <div class="card-actions justify-center mt-4">
                    <a href="{{ route('threads.create') }}" class="btn btn-primary btn-lg">Crear nuevo hilo</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    

    <!-- FAQ Section (realmente al final de la página, en su propio cuadro) -->
    <div class="container mx-auto px-4 pb-12 mt-24">
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold mb-4 text-primary">Preguntas Frecuentes (FAQ)</h2>
                <div class="space-y-4">
                    <div>
                        <div class="font-semibold text-base-content mb-1">¿Cómo recupero mi contraseña?</div>
                        <div class="text-base-content/70">Puedes restablecer tu contraseña desde la página de <a href="{{ route('password.request') }}" class="text-primary underline">recuperación de contraseña</a>.</div>
                    </div>
                    <div>
                        <div class="font-semibold text-base-content mb-1">¿Cómo participo en el foro?</div>
                        <div class="text-base-content/70">Debes registrarte e iniciar sesión. Luego podrás crear hilos, responder y participar en las discusiones.</div>
                    </div>
                    <div>
                        <div class="font-semibold text-base-content mb-1">¿Cómo reporto un problema o bug?</div>
                        <div class="text-base-content/70">Puedes escribirnos directamente al correo <a href="mailto:corvinumdev@gmail.com" class="text-primary underline">corvinumdev@gmail.com</a> explicando el problema.</div>
                    </div>
                    <div>
                        <div class="font-semibold text-base-content mb-1">¿Puedo cambiar mi nombre de usuario?</div>
                        <div class="text-base-content/70">
                            Puedes cambiar tu nombre de usuario accediendo a tu <a href="{{ route('profile.edit') }}" class="text-primary underline">perfil</a>.
                            Si tienes algún problema, contáctanos por correo.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
