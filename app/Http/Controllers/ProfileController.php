<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Forzar el locale a español para los mensajes de validación
        app()->setLocale('es');
        \Log::info('Entrando a update de perfil para user_id: ' . $request->user()->id);

        $user = $request->user();
        // Excluir avatar del fill para evitar sobreescribir con el nombre temporal
        $user->fill(collect($request->validated())->except('avatar')->toArray());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        \Log::info('Antes de manejar avatar para user_id: ' . $user->id);

        // Manejar subida de avatar
        if ($request->hasFile('avatar')) {
            \Log::info('Se subió un nuevo avatar para user_id: ' . $user->id);
            // Eliminar avatar anterior si existe y no es el mismo que el nuevo
            if ($user->avatar) {
                $oldPath = storage_path('app/public/avatars/' . $user->avatar);
                \Log::info('Intentando borrar avatar anterior: ' . $oldPath);
                if (file_exists($oldPath)) {
                    try {
                        unlink($oldPath);
                        \Log::info('Avatar anterior borrado: ' . $oldPath);
                    } catch (\Throwable $e) {
                        \Log::error('No se pudo borrar el avatar anterior: ' . $oldPath . ' - ' . $e->getMessage());
                    }
                } else {
                    \Log::info('El avatar anterior no existe: ' . $oldPath);
                }
            }
            $avatar = $request->file('avatar');
            $filename = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
            try {
                $avatar->storeAs('avatars', $filename, 'public');
                \Log::info('Nuevo avatar guardado en storage/app/public/avatars: ' . $filename);
            } catch (\Exception $e) {
                \Log::error('No se pudo guardar el nuevo avatar: ' . $e->getMessage());
                return Redirect::route('profile.edit')->withErrors(['avatar' => 'No se pudo guardar el avatar. Verifica permisos.']);
            }
            $user->avatar = $filename;
        }

        $user->save();
        \Log::info('Perfil actualizado correctamente para user_id: ' . $user->id);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
