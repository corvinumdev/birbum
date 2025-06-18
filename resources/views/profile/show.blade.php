<x-app-layout :title="'Perfil de ' . $user->name">
    <div class="max-w-3xl mx-auto px-4 py-12">
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['label' => 'Perfil público']
        ]" />
        <div class="card bg-base-100 shadow-lg p-8 flex flex-col items-center">
            <div class="mb-4">
                <x-user-avatar :user="$user" class="h-24 w-24 border-2 border-primary" />
            </div>
            <h1 class="text-2xl font-bold text-base-content mb-2">{{ $user->name }}</h1>
            @if($user->bio)
                <div class="prose text-base-content mb-4 max-w-xl break-words">{!! nl2br(e($user->bio)) !!}</div>
            @endif
            <div class="flex flex-col sm:flex-row gap-4 mt-4">
                <div class="text-center">
                    <div class="text-sm text-base-content/70">Miembro desde</div>
                    <div class="font-semibold">{{ $user->created_at->format('d M Y') }}</div>
                </div>
                <!-- Seguidores/Seguidos (placeholder, puedes mejorar con lógica real) -->
                <div class="text-center">
                    <div class="text-sm text-base-content/70">Seguidores</div>
                    <div class="font-semibold">
                        <a href="{{ route('profile.followers', $user) }}" class="hover:underline hover:text-primary transition">
                            {{ $user->followers_count ?? 0 }}
                        </a>
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-base-content/70">Siguiendo</div>
                    <div class="font-semibold">{{ $user->following_count ?? 0 }}</div>
                </div>
            </div>
            <!-- Botón de seguir (placeholder, lógica real pendiente) -->
            @auth
                @if(auth()->id() !== $user->id)
                    @php
                        $isFollowing = auth()->user()->following->contains($user->id);
                    @endphp
                    @if($isFollowing)
                        <form method="POST" action="{{ route('users.unfollow', $user) }}" class="mt-6">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Dejar de seguir</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('users.follow', $user) }}" class="mt-6">
                            @csrf
                            <button type="submit" class="btn btn-primary">Seguir</button>
                        </form>
                    @endif
                @endif
            @endauth
        </div>
        <!-- Hilos creados por el usuario -->
        <div class="mt-10 w-full" id="hilos">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m9 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Hilos publicados
            </h2>
            <div>
                @forelse($threads as $thread)
                    <x-thread-preview :thread="$thread" />
                @empty
                    <div class="p-8 text-center text-base-content/70">Este usuario no ha creado ningún hilo.</div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
