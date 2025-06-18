<x-app-layout :title="'Crear categoría'">
    <div class="max-w-xl mx-auto px-4 py-12">
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['url' => route('admin.dashboard'), 'label' => 'Admin'],
            ['url' => route('admin.categories.index'), 'label' => 'Categorías'],
            ['label' => 'Crear categoría']
        ]" />
        <h1 class="text-2xl font-bold mb-6">Crear nueva categoría</h1>
        @if($errors->any())
            <div class="alert alert-error mb-4">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.categories.store') }}" class="card bg-base-100 shadow p-6">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-semibold mb-2">Nombre:</label>
                <input id="name" name="name" type="text" class="input input-bordered w-full" required maxlength="100" />
            </div>
            <div class="mb-4">
                <label for="description" class="block font-semibold mb-2">Descripción:</label>
                <textarea id="description" name="description" class="input input-bordered w-full" maxlength="255"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Crear categoría</button>
            </div>
        </form>
    </div>
</x-app-layout>
