<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    // Borra todas las notificaciones del usuario autenticado.
    public function deleteAll(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            $user->notifications()->forceDelete();
        }
        return redirect()->back();
    }

    // Marca todas las notificaciones del usuario autenticado como leídas.
    public function markAllRead(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
        return redirect()->back();
    }
}
