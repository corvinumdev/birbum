<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use App\Events\NewComment;
use App\Notifications\ThreadCommented;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Events\CommentDeleted;

class CommentController extends Controller
{
    public function store(Request $request, $threadId)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:2|max:2000',
        ]);

        // Cargar el thread junto con el usuario
        $thread = Thread::with('user')->findOrFail($threadId);

        $comment = new Comment([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        $thread->comments()->save($comment);
        $comment->load('user');


        // Notificar al autor del hilo si no es el mismo que comenta
        if ($thread->user && $thread->user->id !== Auth::id()) {
            $thread->user->notify(new ThreadCommented($thread, $comment));

            // Limitar a 20 notificaciones: borrar las más antiguas si hay más de 20
            $notificaciones = $thread->user->notifications()->orderBy('created_at', 'desc')->get();
            if ($notificaciones->count() > 20) {
                $idsParaBorrar = $notificaciones->slice(20)->pluck('id');
                if ($idsParaBorrar->count() > 0) {
                    $thread->user->notifications()->whereIn('id', $idsParaBorrar)->forceDelete();
                }
            }
        }

        // Emitir evento broadcast para comentarios en tiempo real
        broadcast(new NewComment($comment));

        // Si la petición espera JSON (por ejemplo, fetch), responder con JSON
        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'ok' => true,
                'message' => 'Comentario publicado correctamente.',
                'comment' => $comment,
            ]);
        }

        // Si es petición normal, redirigir
        return redirect()->route('threads.show', $thread)->with('success', 'Comentario publicado correctamente.');
    }

    public function destroy(Request $request, $commentId)
    {
        try {
            $comment = Comment::findOrFail($commentId);
            // Autorización manual: solo el autor o admin puede borrar
            $user = $request->user();
            if (!$user || ($user->id !== $comment->user_id && !$user->is_admin)) {
                return response()->json(['ok' => false, 'error' => 'No autorizado'], 403);
            }
            $threadId = $comment->thread_id;
            $comment->delete();
            // Emitir evento broadcast para borrar en vivo
            broadcast(new CommentDeleted($commentId, $threadId))->toOthers();
            return response()->json(['ok' => true]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }
}