<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class ThreadVoteController extends Controller
{
    public function upvote(Request $request, Thread $thread)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para votar.');
        }

        if ($thread->votedBy($user)) {
            return redirect()->back()->with('error', 'Ya has votado este hilo.');
        }

        $thread->votes()->create([
            'user_id' => $user->id,
        ]);
        $thread->increment('votes');

        return redirect()->back()->with('success', '¡Voto registrado!');
    }

    public function unvote(Request $request, Thread $thread)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para quitar el voto.');
        }

        $vote = $thread->votes()->where('user_id', $user->id)->first();
        if (!$vote) {
            return redirect()->back()->with('error', 'No has votado este hilo.');
        }

        $vote->delete();
        $thread->decrement('votes');

        return redirect()->back()->with('success', '¡Voto retirado!');
    }
}
