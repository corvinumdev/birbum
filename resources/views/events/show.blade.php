<x-app-layout :title="$event->title">
<div class="max-w-2xl mx-auto py-8">
    <!-- Migas de pan DaisyUI -->
    <x-breadcrumbs :links="[
        ['url' => url('/'), 'label' => 'Inicio'],
        ['url' => route('events.index'), 'label' => 'Eventos'],
        ['label' => $event->title]
    ]" />
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            @if($event->cover_image)
                <img src="/{{ $event->cover_image }}" alt="Imagen de portada" class="mb-4 rounded w-full max-h-80 object-cover">
            @endif
            <h1 class="card-title text-3xl font-bold mb-2">{{ $event->title }}</h1>
            <div class="text-gray-500 mb-4">{{ $event->date->format('d/m/Y') }}</div>
            <div class="prose max-w-none">{{ $event->description }}</div>
        </div>
    </div>
    <div class="flex items-center gap-4 mt-6">
        <a href="{{ route('events.index') }}" class="btn btn-outline w-full sm:w-auto">&larr; Volver a eventos</a>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">Editar evento</a>
                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este evento?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error">Eliminar evento</button>
                </form>
            @else
                @if(!$event->attendees->contains(auth()->id()))
                    <form action="{{ route('events.join', $event) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Apuntarme</button>
                    </form>
                @else
                    <form action="{{ route('events.leave', $event) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">Cancelar asistencia</button>
                    </form>
                @endif
            @endif
        @endauth
            <div class="mt-6">
                <span class="font-semibold">Asistentes ({{ $event->attendees->count() }}):</span>
                <a href="{{ route('events.attendees', $event) }}" class="ml-2 text-primary hover:underline text-sm">Ver todos</a>
            </div>
    </div>
</div>
</x-app-layout>
