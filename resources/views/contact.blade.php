<x-app-layout :title="'Contacto'">
    <div class="max-w-xl mx-auto px-4 py-12">
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['label' => 'Contacto']
        ]" />
        <h1 class="text-3xl font-bold mb-6">Contacto</h1>
        <div class="card bg-base-100 shadow-xl p-8">
            <p class="mb-4 text-base-content opacity-80">
                Si tienes alguna pregunta, sugerencia o comentario, puedes escribirnos directamente a:
            </p>
            <div class="flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-primary">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
                <a href="mailto:corvinumdev@gmail.com" class="text-primary font-semibold underline">corvinumdev@gmail.com</a>
            </div>
            <p class="text-base-content opacity-70">
                Te responderemos lo antes posible. ¡Gracias por tu interés en Birbum!
            </p>
        </div>
    </div>
</x-app-layout>
