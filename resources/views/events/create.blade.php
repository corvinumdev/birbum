<x-app-layout :title="'Nuevo evento'">
<div class="max-w-xl mx-auto py-8">
    <!-- Migas de pan DaisyUI -->
    <x-breadcrumbs :links="[
        ['url' => url('/'), 'label' => 'Inicio'],
        ['url' => route('events.index'), 'label' => 'Eventos'],
        ['label' => 'Nuevo evento']
    ]" />
    <h1 class="text-2xl font-bold mb-6">Publicar nuevo evento</h1>
    <form method="POST" action="{{ route('events.store') }}" class="space-y-4" enctype="multipart/form-data">
        @csrf
        <div>
            <label class="block font-semibold mb-1">Imagen de portada</label>
            <input type="file" name="cover_image" class="file-input file-input-bordered w-full" accept="image/*">
            @error('cover_image')<div class="text-error text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block font-semibold mb-1">Título</label>
            <input type="text" name="title" class="input input-bordered w-full" value="{{ old('title') }}" required>
            @error('title')<div class="text-error text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block font-semibold mb-1">Descripción</label>
            <textarea name="description" class="textarea textarea-bordered w-full" rows="4" required>{{ old('description') }}</textarea>
            @error('description')<div class="text-error text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block font-semibold mb-1">Fecha</label>
            <input type="date" name="date" class="input input-bordered w-full" value="{{ old('date') }}" required min="{{ date('Y-m-d') }}">
            @error('date')<div class="text-error text-sm">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Publicar evento</button>
    </form>
</div>
</x-app-layout>
