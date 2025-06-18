<x-app-layout :title="'Hilos'">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Migas de pan DaisyUI -->
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['label' => 'Hilos']
        ]" />
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h1 class="card-title text-2xl font-bold mb-4">Foro de discusión</h1>


                <!-- Cabecera con buscador y botón para crear nuevo hilo -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <div class="flex flex-col sm:flex-row w-full md:w-auto gap-3">
                        <div class="flex w-full max-w-2xl flex-col sm:flex-row gap-3 items-stretch mx-auto">
                            <form method="GET" class="relative flex-1 min-w-0">
                                <input type="text" name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Buscar hilos... (pulsa Enter o el icono)"
                                    class="w-full px-4 py-2 border border-primary bg-base-100 text-base-content placeholder-base-content/70 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary shadow-sm text-lg sm:text-xl min-w-0 pr-12">
                                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" aria-label="Buscar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: block; margin: 0 auto;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </form>
                            <a href="{{ route('threads.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center justify-center whitespace-nowrap sm:h-auto h-12 sm:self-auto self-stretch">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Crear nuevo hilo
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Filtros de categoría -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <a href="{{ route('threads.index') }}" class="{{ !request('category') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }} px-3 py-1 rounded-full text-sm font-medium">Todos</a>
                    @php($categories = \App\Models\Category::orderBy('name')->get())
                    @foreach($categories as $cat)
                        <a href="{{ route('threads.index', ['category' => $cat->id]) }}"
                           class="{{ request('category') == $cat->id ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }} px-3 py-1 rounded-full text-sm font-medium">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
                <!-- Lista de hilos -->
                <div>
                    @forelse($threads as $thread)
                        <x-thread-preview :thread="$thread" />
                    @empty
                    <div class="p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No hay hilos de discusión</h3>
                        <p class="mt-1 text-gray-500">Parece que aún no hay temas de discusión. ¡Sé el primero en crear uno!</p>
                        <div class="mt-6">
                            <a href="{{ route('threads.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                Crear nuevo hilo
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- Paginación -->
        <div class="mt-6">
            {{ $threads->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>