<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileFollowersController extends Controller
{
    public function index(User $user)
    {
        // Paginación de seguidores
        $followers = $user->followers()->paginate(20);
        return view('profile.followers', compact('user', 'followers'));
    }
}
