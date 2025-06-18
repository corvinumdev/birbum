<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowerController extends Controller
{
    public function follow(User $user)
    {
        $currentUser = Auth::user();
        if ($currentUser->id === $user->id) {
            return back()->with('error', 'No puedes seguirte a ti mismo.');
        }
        // Evita duplicados
        $currentUser->following()->syncWithoutDetaching([$user->id]);
        return back()->with('status', 'Ahora sigues a ' . $user->name);
    }

    public function unfollow(User $user)
    {
        $currentUser = Auth::user();
        $currentUser->following()->detach($user->id);
        return back()->with('status', 'Has dejado de seguir a ' . $user->name);
    }
}
