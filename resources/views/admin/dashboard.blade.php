<x-app-layout :title="'Panel de Administración'">
    <div class="max-w-4xl mx-auto px-4 py-12">
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['label' => 'Admin']
        ]" />
        <h1 class="text-3xl font-bold mb-8">Panel de Administración</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('admin.categories.index') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
                <div class="card-body">
                    <h2 class="card-title">Gestionar categorías</h2>
                    <p>Crear, editar y eliminar categorías del foro.</p>
                </div>
            </a>
            <a href="{{ route('events.index') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
                <div class="card-body">
                    <h2 class="card-title">Gestionar eventos</h2>
                    <p>Ver, crear, editar y eliminar eventos.</p>
                </div>
            </a>
            <a href="{{ route('threads.index') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
                <div class="card-body">
                    <h2 class="card-title">Gestionar hilos</h2>
                    <p>Ver, crear, editar y eliminar hilos del foro.</p>
                </div>
            </a>
            <a href="{{ route('admin.users.index') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
                <div class="card-body">
                    <h2 class="card-title">Gestionar usuarios</h2>
                    <p>Ver, editar y eliminar usuarios.</p>
                </div>
            </a>
            <a href="{{ route('admin.edit-banner') }}" class="card bg-base-100 shadow hover:shadow-lg transition">
                <div class="card-body">
                    <h2 class="card-title">Editar banner global</h2>
                    <p>Modificar el mensaje informativo global del sitio.</p>
                </div>
            </a>
        </div>
        @if(!empty($bannerMessage))
            <div class="mb-6">
                <div class="w-full bg-yellow-400 text-yellow-900 text-center py-2 px-4 font-semibold shadow-md z-40">
                    <span class="inline-block align-middle">
                        {{ $bannerMessage }}
                    </span>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
