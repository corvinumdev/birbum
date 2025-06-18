<section class="text-base-content">
    <header>
        <h2 class="text-lg font-medium">
            Información del perfil
        </h2>

        <p class="mt-1 text-sm">
            Actualiza la información de tu perfil y tu dirección de correo electrónico.
        </p>
    </header>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        <div>
            <x-input-label for="avatar" value="Avatar" />
            <div class="flex items-center justify-between mt-2 gap-4">
                <div class="flex-1 flex flex-col gap-2">
                    <label for="avatar" class="cursor-pointer group relative w-fit">
                        <span class="text-sm opacity-70 mb-1 block">Haz clic en el avatar para cambiar la imagen</span>
                        <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*" onchange="this.form.submit()" />
                        <span class="sr-only">Seleccionar imagen de avatar</span>
                    </label>
                </div>
                <label for="avatar" class="cursor-pointer group relative">
                    <x-user-avatar :user="$user" class="h-16 w-16 border-2 border-primary group-hover:opacity-70 transition" />
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 bg-primary text-white text-xs rounded px-2 py-0.5 opacity-90 group-hover:opacity-100 transition pointer-events-none">Cambiar</span>
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nombre" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2">
                        Tu correo electrónico no está verificado.

                        <button form="send-verification" class="underline text-sm text-base-content hover:text-primary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            Haz clic aquí para reenviar el correo de verificación.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            Se ha enviado un nuevo enlace de verificación a tu correo electrónico.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="bio" value="Biografía" />
            <textarea id="bio" name="bio" class="mt-1 block w-full textarea textarea-bordered" rows="4" maxlength="255" oninput="updateBioCounterProfile()">{{ old('bio', $user->bio) }}</textarea>
            <div class="flex justify-end mt-1">
                <span class="label-text-alt text-xs text-gray-500" id="bio-char-count-profile"></span>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Guardar</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-base-content"
                >Guardado.</p>
            @endif
        </div>
    </form>
<script>
  function updateBioCounterProfile() {
    const textarea = document.getElementById('bio');
    const counter = document.getElementById('bio-char-count-profile');
    if (textarea && counter) {
      counter.textContent = `${textarea.value.length}/255`;
    }
  }
  document.addEventListener('DOMContentLoaded', updateBioCounterProfile);
</script>
</section>
