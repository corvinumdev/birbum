<x-app-layout :title="'Eventos'">
<div class="max-w-2xl mx-auto px-2 sm:px-4 py-8">
    <!-- Migas de pan DaisyUI -->
    <x-breadcrumbs :links="[
        ['url' => url('/'), 'label' => 'Inicio'],
        ['label' => 'Eventos']
    ]" />
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <h1 class="card-title text-3xl font-bold mb-6">Eventos</h1>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('events.create') }}" class="btn btn-primary mb-6">Publicar nuevo evento</a>
                @endif
            @endauth
            <div class="space-y-4">
                @forelse($events as $event)
                    <div class="card bg-base-100 shadow flex-row gap-4 items-start">
                        @if($event->cover_image)
                            <figure class="pl-4 py-4">
                                <img src="/{{ $event->cover_image }}" alt="Imagen de portada" class="w-24 h-24 object-cover rounded">
                            </figure>
                        @endif
                        <div class="card-body flex-1 py-4 pr-4">
                            <a href="{{ route('events.show', $event) }}" class="card-title text-xl font-semibold hover:text-primary">{{ $event->title }}</a>
                            <div class="text-sm text-gray-500">{{ $event->date->format('d/m/Y') }}</div>
                            <p class="mt-2 text-gray-700">{{ Str::limit($event->description, 120) }}</p>
                        </div>
                    </div>
                @empty
                    <p>No hay eventos publicados.</p>
                @endforelse
            </div>
            <div class="mt-6">{{ $events->links() }}</div>
        </div>
    </div>
</div>
</x-app-layout>
