@auth
    <script>
        window.Laravel = window.Laravel || {};
        window.Laravel.userId = {{ auth()->id() }};
    </script>
@endauth
<header id="main-header"
    class="bg-primary text-primary-content shadow-lg sticky top-0 z-50 transition-transform duration-300">
    <audio id="notif-audio" style="display:none;">
        <source src="/sounds/received.ogg" type="audio/ogg">
    </audio>
    <div x-data="{ menuOpen: false }" class="navbar container mx-auto min-w-0 w-full">
        <div class="navbar-start">
            <!-- Botón hamburguesa/X -->
            <button @click="menuOpen = !menuOpen" class="btn btn-ghost lg:hidden" aria-label="Abrir menú"
                :aria-label="menuOpen ? 'Cerrar menú' : 'Abrir menú'">
                <template x-if="!menuOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </template>
            </button>
            <a href="/" class="btn btn-ghost normal-case text-xl text-primary-content flex items-center gap-2">
                <img src="/img/logo.svg" alt="Logo" class="h-8 w-8 inline-block align-middle" />
                <span class="hidden xs:inline sm:inline md:inline lg:inline xl:inline 2xl:inline" id="logo-text">Birbum</span>
                <style>
                @media (max-width: 410px) {
                    #logo-text { display: none !important; }
                }
                @media (max-width: 640px) {
                    .navbar-end:has(.btn), .navbar-end:has(.avatar) {
                        /* Si hay muchos iconos, oculta el texto del logo */
                        #logo-text { display: none !important; }
                    }
                }
                </style>
            </a>
        </div>

        <!-- Overlay menú hamburguesa pantalla completa: solo los enlaces principales, grandes y centrados -->
        <div x-show="menuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[120] bg-base-100 text-base-content flex flex-col items-center justify-center space-y-8 text-3xl font-bold lg:hidden overflow-y-auto min-w-0 w-full px-4"
            style="display: none;" x-effect="document.body.style.overflow = menuOpen ? 'hidden' : ''">
            <!-- Botón X dentro del menú, fijo arriba a la izquierda -->
            <button @click="menuOpen = false" class="fixed top-4 left-4 btn btn-ghost btn-circle text-3xl z-[200]"
                aria-label="Cerrar menú">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <a href="/" @click="menuOpen = false" class="hover:text-primary transition-colors">Inicio</a>
            <a href="/threads" @click="menuOpen = false" class="hover:text-primary transition-colors">Hilos</a>
            <a href="/events" @click="menuOpen = false" class="hover:text-primary transition-colors">Eventos</a>
            <a href="/contacto" @click="menuOpen = false" class="hover:text-primary transition-colors">Contacto</a>
            @auth
                @if (Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" @click="menuOpen = false"
                        class="hover:text-warning transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-warning" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Admin</span>
                    </a>
                @endif
            @endauth
        </div>
        <div class="navbar-center hidden lg:flex min-w-0">
            <ul class="menu menu-horizontal px-1 min-w-0 text-base sm:text-lg md:text-xl">
                <li><a href="/" class="text-white [data-theme=light]:text-gray-900">Inicio</a></li>
                <li><a href="/threads" class="text-white [data-theme=light]:text-gray-900">Hilos</a></li>
                <li><a href="/events" class="text-white [data-theme=light]:text-gray-900">Eventos</a></li>
                <li><a href="/contacto" class="text-white [data-theme=light]:text-gray-900">Contacto</a></li>
                @auth
                    @if (Auth::user()->is_admin)
                        <li>
                            <a href="{{ route('admin.dashboard') }}" title="Panel Admin"
                                class="flex items-center gap-1 text-white [data-theme=light]:text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="hidden xl:inline">Admin</span>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>

        <!-- Botón de cambiar tema DaisyUI light/dark -->
        <div class="navbar-end pl-0 ml-0">
            <!-- DaisyUI theme toggle -->
            <label class="swap swap-rotate mr-2 h-8 w-8 sm:h-10 sm:w-10">
                <input type="checkbox" id="theme-toggle-checkbox" class="theme-controller hidden"
                    data-toggle-theme="dark,light" />
                <script>
                    // Sencillo: sincroniza el checkbox y el data-theme/localStorage
                    document.addEventListener('DOMContentLoaded', function() {
                        const checkbox = document.getElementById('theme-toggle-checkbox');
                        // Inicializa el estado según localStorage
                        let theme = localStorage.getItem('theme') || 'light';
                        document.documentElement.setAttribute('data-theme', theme);
                        checkbox.checked = theme === 'dark';
                        // Al cambiar el checkbox, cambia el tema
                        checkbox.addEventListener('change', function() {
                            const newTheme = checkbox.checked ? 'dark' : 'light';
                            document.documentElement.setAttribute('data-theme', newTheme);
                            localStorage.setItem('theme', newTheme);
                        });
                    });
                </script>
                <!-- sun icon -->
                <svg class="swap-off h-8 w-8 sm:h-10 sm:w-10 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                </svg>
                <!-- moon icon -->
                <svg class="swap-on h-8 w-8 sm:h-10 sm:w-10 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                </svg>
            </label>
            @auth
                <!-- Notificaciones -->
                <x-notification-menu />
                <!-- Botón para crear hilos (normal en escritorio, FAB en móvil) -->
                <!-- Escritorio: botón normal -->
                <a href="{{ route('threads.create') }}" class="btn btn-primary mr-2 hidden sm:inline-flex">Crear hilo</a>
                <!-- Avatar circular con inicial del usuario y menú -->
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar w-8 h-8 sm:w-10 sm:h-10">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Avatar"
                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover bg-base-200" />
                        @else
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-base-200 flex items-center justify-center">
                                <span class="font-bold text-base sm:text-lg text-gray-800 leading-none select-none" style="line-height: 2rem;">
                                    {{ strtoupper(mb_substr(Auth::user()->name, 0, 1, 'UTF-8')) }}
                                </span>
                            </div>
                        @endif
                    </label>
                    <ul tabindex="0" class="mt-3 p-3 shadow menu dropdown-content bg-base-100 rounded-box min-w-[11rem] max-w-[14rem] sm:min-w-[13rem] sm:max-w-[16rem] md:min-w-[15rem] md:max-w-[20rem] lg:min-w-[18rem] lg:max-w-[24rem]">
                        <li><a href="{{ route('profile.show', Auth::user()) }}" class="text-base-content">Ver perfil</a>
                        </li>
                        <li><a href="{{ route('profile.edit') }}" class="text-base-content">Editar perfil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-base-content">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">Entrar</a>
            @endauth
            <script>
                // --- Notificaciones: carga progresiva ---
                // --- Sonido de notificación ---
                let lastNotificationIds = [];
                // Declarar variables globales para notificaciones
                var notifAudio, list, empty, markall;

                // Definir funciones en scope global
                window.renderNotification = function(n) {
                    const div = document.createElement('div');
                    // Mejor contraste: fondo y texto adaptados a modo claro/oscuro
                    let baseClass = 'p-3 rounded w-full ';
                    if (n.is_read) {
                        baseClass += 'bg-base-200 text-base-content/70';
                    } else {
                        baseClass += 'bg-yellow-300 dark:bg-yellow-600 border-l-4 border-yellow-500 dark:border-yellow-400 font-bold text-gray-900 dark:text-yellow-50 shadow-sm';
                    }
                    div.className = baseClass;
                    div.innerHTML = `<a href="${n.go_url}" class="flex flex-col gap-1 w-full">
        <span>Nuevo comentario en tu hilo <b>${n.thread_title}</b></span>
        <span class='text-xs text-base-content/70'>por ${n.comment_user_name}</span>
        <span class='text-xs text-base-content/50 truncate'>"${n.comment_content.length > 60 ? n.comment_content.substring(0, 57) + '...' : n.comment_content}"</span>
    </a>`;
                    return div;
                }

                window.loadNotifications = function() {
                    // Inicializar referencias si no existen
                    notifAudio = notifAudio || document.getElementById('notif-audio');
                    list = list || document.getElementById('notifications-list');
                    empty = empty || document.getElementById('notifications-empty');
                    markall = markall || document.getElementById('notifications-markall');
                    empty.classList.add('hidden');
                    list.innerHTML = '';
                    // Mostrar loading
                    let loading = document.getElementById('notifications-loading');
                    if (!loading) {
                        loading = document.createElement('div');
                        loading.id = 'notifications-loading';
                        loading.className = 'flex justify-center items-center py-6';
                        loading.innerHTML = '<span class="loading loading-spinner loading-lg text-primary"></span>';
                        list.appendChild(loading);
                    } else {
                        list.appendChild(loading);
                    }
                    fetch(`/notificaciones/lista`)
                        .then(r => r.json())
                        .then(res => {
                            // Ocultar loading
                            const loadingDiv = document.getElementById('notifications-loading');
                            if (loadingDiv) loadingDiv.remove();
                            const markAllForm = document.getElementById('markAllForm');
                            const deleteAllForm = document.getElementById('deleteAllForm');
                            // Mostrar o quitar el badge rojo SOLO según si hay notificaciones
                            if (!res.data || res.data.length === 0) {
                                empty.classList.remove('hidden');
                                markall.classList.add('hidden');
                                lastNotificationIds = [];
                                document.querySelectorAll('.dropdown-end .badge-error').forEach(b => b.remove());
                                return;
                            }
                            // Mostrar el badge rojo SOLO si hay notificaciones no leídas
                            let badge = document.querySelector('.dropdown-end .badge-error');
                            let allRead = true;
                            let anyUnread = false;
                            res.data.forEach(n => {
                                list.appendChild(window.renderNotification(n));
                                if (!n.is_read) {
                                    allRead = false;
                                    anyUnread = true;
                                }
                            });
                            // Badge rojo solo si hay alguna no leída
                            if (anyUnread) {
                                if (!badge) {
                                    badge = document.createElement('span');
                                    badge.className = 'badge badge-error badge-xs absolute top-0 right-0';
                                    const notifBtn = document.querySelector('.dropdown-end .btn-circle');
                                    if (notifBtn) notifBtn.appendChild(badge);
                                }
                            } else {
                                if (badge) badge.remove();
                            }
                            markall.classList.remove('hidden');
                            if (allRead) {
                                markAllForm.style.display = 'none';
                                deleteAllForm.style.display = '';
                            } else {
                                markAllForm.style.display = '';
                                deleteAllForm.style.display = 'none';
                            }
                        });
                }

                // --- Notificaciones en tiempo real con Echo ---
                document.addEventListener('DOMContentLoaded', function() {
                    if (window.Laravel && window.Laravel.userId && window.Echo) {
                        window.Echo.private('App.Models.User.' + window.Laravel.userId)
                            .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => {
                                if (notifAudio) {
                                    notifAudio.currentTime = 0;
                                    notifAudio.play();
                                }
                                // Mostrar el badge rojo SIEMPRE que llegue una notificación
                                let badge = document.querySelector('.dropdown-end .badge-error');
                                if (!badge) {
                                    badge = document.createElement('span');
                                    badge.className = 'badge badge-error badge-xs absolute top-0 right-0';
                                    const notifBtn = document.querySelector('.dropdown-end .btn-circle');
                                    if (notifBtn) notifBtn.appendChild(badge);
                                }
                                if (typeof loadNotifications === 'function') {
                                    loadNotifications();
                                }
                            });
                    }
                    // Cargar SIEMPRE las notificaciones al abrir el menú de notificaciones
                    const notifBtn = document.querySelector('.dropdown.dropdown-end > label.btn-circle');
                    if (notifBtn) {
                        notifBtn.addEventListener('focus', function() {
                            loadNotifications();
                        });
                        notifBtn.addEventListener('click', function() {
                            loadNotifications();
                        });
                    }
                });
                
            </script>
            <script>
                function markNotificationRead(id) {
                    fetch('/notificaciones/' + id + '/leer', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                    }).finally(() => {
                        if (typeof loadNotifications === 'function') {
                            loadNotifications();
                        }
                    });
                }

                function markNotificationReadAndRedirect(id, url) {
                    fetch('/notificaciones/' + id + '/leer', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                    }).finally(() => {
                        if (typeof loadNotifications === 'function') {
                            loadNotifications();
                        }
                        window.location.href = url;
                    });
                }
            </script>
        </div>
    </div>
    <script>
        // Oculta el header al hacer scroll hacia abajo y lo muestra al subir SOLO en escritorio (lg:)
        let lastScroll = 0;
        const header = document.getElementById('main-header');


        window.addEventListener('scroll', function() {
            // Detecta si el overlay del menú hamburguesa está visible (abierto)
            const overlay = document.querySelector('[x-show="menuOpen"]');
            let isMenuOpen = false;
            if (overlay) {
                // Alpine oculta con display:none, pero también puede estar en transición
                const style = getComputedStyle(overlay);
                isMenuOpen = style.display !== 'none' && style.visibility !== 'hidden' && overlay.offsetParent !==
                    null && overlay.offsetHeight > 0;
            }
            if (isMenuOpen) {
                header.removeAttribute('style');
                return;
            }
            const currentScroll = window.pageYOffset;
            if (currentScroll > lastScroll && currentScroll > 80) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
                header.removeAttribute('style');
            }
            lastScroll = currentScroll;
        });
    </script>
</header>
