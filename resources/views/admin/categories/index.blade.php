<x-app-layout :title="'Categorías'">
    <div class="max-w-3xl mx-auto px-4 py-12">
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['url' => route('admin.dashboard'), 'label' => 'Admin'],
            ['label' => 'Categorías']
        ]" />
        <h1 class="text-2xl font-bold mb-6">Gestión de categorías</h1>
        @if(session('status'))
            <div class="alert alert-success mb-4">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error mb-4">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.categories.store') }}" class="mb-8 card bg-base-100 shadow p-6">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-semibold mb-2">Nombre:</label>
                <input id="name" name="name" type="text" class="input input-bordered w-full" required maxlength="100" />
            </div>
            <div class="mb-4">
                <label for="description" class="block font-semibold mb-2">Descripción:</label>
                <textarea id="description" name="description" class="input input-bordered w-full" maxlength="255"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Crear categoría</button>
        </form>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td class="flex gap-2">
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-error">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No hay categorías.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
