<x-app-layout :title="'Crear nuevo hilo'">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
      <!-- Migas de pan -->
      <x-breadcrumbs :links="[
        ['url' => url('/'), 'label' => 'Inicio'],
        ['label' => 'Crear nuevo hilo']
      ]" />
      <!-- Título de la página -->
      <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-primary">Crear Nuevo Hilo</h1>
        <p class="text-base-content opacity-75 mt-2">Comparte tus experiencias, conocimientos o preguntas sobre aves con nuestra comunidad</p>
      </div>
      <!-- Mensaje de error -->
      @if ($errors->any())
        <div class="alert alert-error mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      <!-- Migas de pan DaisyUI -->
      <x-breadcrumbs :links="[
        ['url' => url('/'), 'label' => 'Inicio'],
        ['url' => route('threads.index'), 'label' => 'Hilos'],
        ['label' => 'Crear nuevo hilo']
      ]" />
      <!-- Formulario de creación de hilo -->
      <form method="POST" action="{{ route('threads.store') }}" enctype="multipart/form-data" class="card bg-base-100 shadow-xl">
        @csrf
        <div class="card-body">
          <!-- Categoría (obligatoria para todos) -->
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text font-medium">Categoría</span>
              <span class="label-text-alt text-primary">Obligatorio</span>
            </label>
            <select name="category_id" class="select select-bordered w-full" required>
              <option value="">Selecciona una categoría</option>
              @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
          <!-- Título -->
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text font-medium">Título</span>
              <span class="label-text-alt text-primary">Obligatorio</span>
            </label>
            <input type="text" name="title" placeholder="Escribe un título claro y descriptivo" class="input input-bordered w-full" required minlength="10" maxlength="255" value="{{ old('title') }}" />
            <div class="flex w-full justify-between gap-2 mt-1">
              <span class="label-text-alt">Mínimo 10 caracteres</span>
              <span class="label-text-alt w-32 text-right" id="title-char-count"></span>
            </div>
          </div>
          <!-- Contenido -->
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text font-medium">Contenido</span>
              <span class="label-text-alt text-primary">Obligatorio</span>
            </label>
            <textarea name="content" class="textarea w-full h-64 border-none focus:outline-none textarea-bordered" placeholder="Escribe aquí tu contenido. Puedes incluir detalles, imágenes, preguntas o cualquier información relevante." required minlength="30">{{ old('content') }}</textarea>
            <div class="flex w-full justify-between gap-2 mt-1">
              <span class="label-text-alt">Mínimo 30 caracteres</span>
              <span class="label-text-alt w-32 text-right" id="content-char-count"></span>
            </div>
          </div>
          <!-- Imagen (opcional) -->
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text font-medium">Imagen (opcional)</span>
            </label>
            <input type="file" name="image" accept="image/*" class="file-input file-input-bordered w-full" />
            @error('image')<div class="text-error text-sm">{{ $message }}</div>@enderror
          </div>
          <!-- Botones de acción -->
          <div class="flex flex-col sm:flex-row gap-4 justify-end mt-4">
            <a href="{{ route('threads.index') }}" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">Publicar hilo</button>
          </div>
        </div>
      </form>
      <!-- Tips para crear un buen hilo -->
      <div class="card bg-base-200 shadow-lg mt-8">
        <div class="card-body">
          <h2 class="card-title text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>
            Tips para crear un buen hilo
          </h2>
          <ul class="list-disc list-inside space-y-2">
            <li>Utiliza un título claro y descriptivo que resuma el contenido de tu hilo</li>
            <li>Incluye todos los detalles relevantes en el primer mensaje</li>
            <li>Si compartes una observación, menciona la ubicación, fecha y condiciones</li>
            <li>Para preguntas de identificación, añade fotos claras desde varios ángulos</li>
            <li>Revisa si ya existe un hilo similar antes de crear uno nuevo</li>
            <li>Utiliza etiquetas relevantes para facilitar que otros encuentren tu hilo</li>
          </ul>
        </div>
      </div>
    </div>
</div>
<script>
  // Script para contadores de caracteres
  document.addEventListener('DOMContentLoaded', function() {
    // Contador para el título
    const titleInput = document.querySelector('input[name="title"]');
    const titleCounter = document.getElementById('title-char-count');
    function updateTitleCounter() {
      titleCounter.textContent = `${titleInput.value.length}/255`;
      if (titleInput.value.length > 90) {
        titleCounter.classList.add('text-warning');
      } else {
        titleCounter.classList.remove('text-warning');
      }
    }
    updateTitleCounter();
    titleInput.addEventListener('input', updateTitleCounter);

    // Contador para el contenido
    const contentTextarea = document.querySelector('textarea[name="content"]');
    const contentCounter = document.getElementById('content-char-count');
    function updateContentCounter() {
      contentCounter.textContent = `${contentTextarea.value.length}/255`;
    }
    updateContentCounter();
    contentTextarea.addEventListener('input', updateContentCounter);
  });
</script>
 </x-app-layout>
