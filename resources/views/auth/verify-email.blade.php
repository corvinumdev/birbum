<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        ¡Gracias por registrarte! Antes de continuar, por favor verifica tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar. Si no recibiste el correo, te podemos enviar otro sin problema.<br>
        <span class="block mt-2 text-xs text-base-content/70">
            <strong>Nota:</strong> Si al hacer clic en "Verificar correo" el sistema te pide iniciar sesión, simplemente ingresa con tu cuenta y tu correo se verificará automáticamente.
        <br>
        <strong>¿Ya verificaste tu correo desde otro dispositivo?</strong> Si es así, puedes refrescar esta página para continuar.
        </span>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            Se ha enviado un nuevo enlace de verificación al correo electrónico que proporcionaste durante el registro.
        </div>
    @endif

    <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-2">
        <div class="flex gap-2">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>
                    Reenviar correo de verificación
                </x-primary-button>
            </form>
            <button onclick="window.location.reload()" type="button" class="btn btn-outline btn-sm">
                Refrescar estado
            </button>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>
