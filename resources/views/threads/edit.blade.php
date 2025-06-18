<x-app-layout :title="'Editar hilo'">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
      <x-breadcrumbs :links="[
        ['url' => url('/'), 'label' => 'Inicio'],
        ['url' => route('threads.index'), 'label' => 'Hilos'],
        ['label' => 'Editar hilo']
      ]" />
      <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-primary">Editar Hilo</h1>
      </div>
      @if ($errors->any())
        <div class="alert alert-error mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      <form method="POST" action="{{ route('threads.update', $thread) }}" class="card bg-base-100 shadow-xl">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text font-medium">Título</span>
              <span class="label-text-alt text-primary">Obligatorio</span>
            </label>
            <input type="text" name="title" class="input input-bordered w-full" required minlength="10" maxlength="255" value="{{ old('title', $thread->title) }}" />
          </div>
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text font-medium">Contenido</span>
              <span class="label-text-alt text-primary">Obligatorio</span>
            </label>
            <textarea name="content" class="textarea w-full h-64 border-none focus:outline-none textarea-bordered" required minlength="30">{{ old('content', $thread->content) }}</textarea>
          </div>
          <!-- Imagen (opcional) -->
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text font-medium">Imagen (opcional)</span>
            </label>
            <input type="file" name="image" accept="image/*" class="file-input file-input-bordered w-full" />
            @if($thread->image)
              <div class="mt-2">
                <span class="text-xs text-base-content/70">Imagen actual:</span><br>
                <a href="/{{ $thread->image }}" target="_blank" rel="noopener">
                  <img src="/{{ $thread->image }}" alt="Imagen actual del hilo" class="rounded max-h-40 border mt-1 inline-block" style="max-width: 200px;">
                </a>
              </div>
            @endif
            @error('image')<div class="text-error text-sm">{{ $message }}</div>@enderror
          </div>
          @if(auth()->user() && auth()->user()->is_admin)
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text font-medium">Categoría</span>
              <span class="label-text-alt text-primary">Obligatorio</span>
            </label>
            <select name="category_id" class="select select-bordered w-full" required>
              <option value="">Selecciona una categoría</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $thread->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
          @endif
          <div class="flex flex-col sm:flex-row gap-4 justify-end mt-4">
            <a href="{{ route('threads.show', $thread) }}" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </div>
      </form>
    </div>
</div>
</x-app-layout>
