<x-app-layout :title="'Usuarios'">
    <div class="max-w-5xl mx-auto px-4 py-12">
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['url' => route('admin.dashboard'), 'label' => 'Admin'],
            ['label' => 'Usuarios']
        ]" />
        <h1 class="text-2xl font-bold mb-6">Gestión de usuarios</h1>
        <div x-data="{ show: false, message: '' }"
             x-init="@if(session('status')) show = true; message = '{{ session('status') }}'; setTimeout(() => show = false, 3000); @endif">
            <template x-if="show">
                <div class="toast toast-top toast-end z-50">
                    <div class="alert alert-success"> <span x-text="message"></span> </div>
                </div>
            </template>
        </div>
        @if($errors->any())
            <div class="alert alert-error mb-4">{{ $errors->first() }}</div>
        @endif
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, email o ID" class="input input-bordered w-full max-w-xs" />
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Limpiar</a>
        </form>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge badge-success">Sí</span>
                                @else
                                    <span class="badge badge-ghost">No</span>
                                @endif
                            </td>
                            <td class="flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-xs btn-info">Editar</a>
                                @if(auth()->id() !== $user->id)
                                    @include('admin.users._admin_toggle_form', ['user' => $user])
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-error">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No se encontraron usuarios.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $users->withQueryString()->links() }}
        </div>
        <div class="mt-8 flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">&larr; Volver al panel</a>
        </div>
    </div>
</x-app-layout>
