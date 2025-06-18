<x-app-layout :title="'Editar banner global'">
    <div class="max-w-2xl mx-auto px-4 py-12">
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['url' => route('admin.dashboard'), 'label' => 'Admin'],
            ['label' => 'Editar banner']
        ]" />
        <h1 class="text-2xl font-bold mb-6">Editar banner global informativo</h1>
        @if(session('status'))
            <div class="alert alert-success mb-4">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('admin.update-banner') }}" x-data="{ mensaje: '{{ old('banner_message', $bannerMessage) }}' }">
            @csrf
            <div class="mb-4">
                <label for="banner_message" class="block font-semibold mb-2">Mensaje del banner (dejar vacío para ocultar):</label>
                <textarea id="banner_message" name="banner_message" rows="3" maxlength="40" class="textarea textarea-bordered w-full" placeholder="Escribe el mensaje del banner..." x-model="mensaje">{{ old('banner_message', $bannerMessage) }}</textarea>
                <div class="text-sm text-gray-500 mt-1">Máximo 40 caracteres.</div>
                @error('banner_message')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block font-semibold mb-2">Previsualización:</label>
                <template x-if="mensaje.trim().length > 0">
                    <div class="w-full bg-yellow-400 text-yellow-900 text-center py-2 px-4 font-semibold shadow-md rounded">
                        <span class="inline-block align-middle" x-text="mensaje"></span>
                    </div>
                </template>
                <template x-if="mensaje.trim().length === 0">
                    <div class="text-gray-400 italic">(No se mostrará ningún banner)</div>
                </template>
            </div>
            <div class="flex items-center justify-between gap-2 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">&larr; Volver al panel</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
