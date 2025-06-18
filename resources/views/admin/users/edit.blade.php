<x-app-layout :title="'Editar usuario'">
    <div class="max-w-xl mx-auto px-4 py-12">
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['url' => route('admin.dashboard'), 'label' => 'Admin'],
            ['url' => route('admin.users.index'), 'label' => 'Usuarios'],
            ['label' => 'Editar usuario']
        ]" />
        <h1 class="text-2xl font-bold mb-6">Editar usuario</h1>
        @if($errors->any())
            <div class="alert alert-error mb-4">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block font-semibold mb-2">Nombre:</label>
                <input id="name" name="name" type="text" class="input input-bordered w-full" value="{{ old('name', $user->name) }}" required maxlength="255" />
            </div>
            <div class="mb-4">
                <label for="email" class="block font-semibold mb-2">Email:</label>
                <input id="email" name="email" type="email" class="input input-bordered w-full" value="{{ old('email', $user->email) }}" required maxlength="255" />
            </div>
            <div class="mb-4 flex items-center gap-2">
                <input id="is_admin" name="is_admin" type="checkbox" class="checkbox" value="1" @if(old('is_admin', $user->is_admin)) checked @endif />
                <label for="is_admin" class="font-semibold">Administrador</label>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
        <div class="mt-8">
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error" @if(auth()->id() === $user->id) disabled @endif>Eliminar usuario</button>
            </form>
        </div>
    </div>
</x-app-layout>
