<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventAttendeesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ProfileController;
use App\Models\Thread;
use App\Models\User;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ProfileFollowersController;
use App\Http\Controllers\ThreadVoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;

// Ruta de prueba para verificar el acceso al logo
Route::get('/test-url', function () {
    return view('test-url');
});

// Rutas de administración

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/banner', [AdminController::class, 'editBanner'])->name('admin.edit-banner');
    Route::post('/admin/banner', [AdminController::class, 'updateBanner'])->name('admin.update-banner');

    // Gestión de usuarios
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

// Events

Route::get('/events', [EventController::class, 'index'])->name('events.index');
// Solo admins pueden crear, guardar, editar y eliminar eventos
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Ver asistentes de un evento
Route::get('/events/{event}/attendees', [EventAttendeesController::class, 'index'])->name('events.attendees');

// Apuntarse y desapuntarse a eventos
Route::middleware(['auth'])->group(function () {
    Route::post('/events/{event}/join', [EventController::class, 'join'])->name('events.join');
    Route::post('/events/{event}/leave', [EventController::class, 'leave'])->name('events.leave');
});

Route::get('/contacto', [ContactController::class, 'show'])->name('contact.show');

Route::get('/', function () {
    $recentThreads = Thread::with('user')->orderBy('created_at', 'desc')->take(5)->get();
    // Ranking: top 5 usuarios con más hilos
    $topUsers = User::withCount('threads')
        ->orderByDesc('threads_count')
        ->take(5)
        ->get();
    // Top 5 hilos más votados
    $topThreads = Thread::with('user')
        ->orderByDesc('votes')
        ->orderByDesc('created_at')
        ->take(5)
        ->get();
    return view('welcome', [
        'recentThreads' => $recentThreads,
        'topUsers' => $topUsers,
        'topThreads' => $topThreads
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Perfil propio (privado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Gestión de categorías (solo admin)
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::get('/admin/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/admin/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
});


// Perfil público de cualquier usuario
Route::get('/users/{user}', function (User $user) {
    // Carga contadores de seguidores/seguidos
    $user->loadCount(['followers', 'following']);
    // Carga hilos del usuario, más recientes primero, paginados
    $threads = $user->threads()->with('user', 'comments')->orderBy('created_at', 'desc')->paginate(5);
    return view('profile.show', compact('user', 'threads'));
})->name('profile.show');

// Ver seguidores de un usuario
Route::get('/users/{user}/followers', [ProfileFollowersController::class, 'index'])->name('profile.followers');

// Seguir y dejar de seguir
Route::middleware('auth')->group(function () {
    Route::post('/users/{user}/follow', [FollowerController::class, 'follow'])->name('users.follow');
    Route::post('/users/{user}/unfollow', [FollowerController::class, 'unfollow'])->name('users.unfollow');
});




// Rutas de threads: protegidas primero, públicas después (para evitar conflicto de resource)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('threads', ThreadController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->names([
            'create' => 'threads.create',
            'store' => 'threads.store',
            'edit' => 'threads.edit',
            'update' => 'threads.update',
            'destroy' => 'threads.destroy',
        ]);
});


Route::resource('threads', ThreadController::class)
    ->only(['index', 'show'])
    ->names([
        'index' => 'threads.index',
        'show' => 'threads.show',
    ]);


// Rutas para votar y quitar voto (solo autenticados)

Route::post('/threads/{thread}/upvote', [ThreadVoteController::class, 'upvote'])->middleware(['auth', 'verified'])->name('threads.upvote');
Route::delete('/threads/{thread}/unvote', [ThreadVoteController::class, 'unvote'])->middleware(['auth', 'verified'])->name('threads.unvote');

// Ruta adicional para comentarios (protegida y verificada)



Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});



use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Marcar notificación como leída
Route::post('/notificaciones/{id}/leer', function ($id, Request $request) {
    $user = Auth::user();
    if ($user) {
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['ok' => true]);
        }
    }
    return response()->json(['ok' => false], 404);
})->middleware('auth');




// Ruta para marcar notificación como leída y redirigir al hilo

Route::get('/notificaciones/{id}/ir', function ($id) {
    $user = Auth::user();
    $notification = $user->notifications()->where('id', $id)->first();
    if ($notification) {
        $notification->markAsRead();
        $threadId = $notification->data['thread_id'];
        return redirect()->route('threads.show', ['thread' => $threadId]);
    }
    return redirect()->route('threads.index');
})->middleware('auth')->name('notifications.go');



// Ruta para marcar todas las notificaciones como leídas (ahora en el controlador)
Route::post('/notificaciones/marcar-todo-leido', [NotificationController::class, 'markAllRead'])->middleware('auth')->name('notifications.markAllRead');


// API para obtener las 20 notificaciones más recientes del usuario autenticado
Route::get('/notificaciones/lista', function (\Illuminate\Http\Request $request) {
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'No autenticado'], 401);
    }
    $notifications = $user->notifications()->orderBy('created_at', 'desc')->take(20)->get();
    $data = $notifications->map(function($notification) {
        return [
            'id' => $notification->id,
            'is_read' => $notification->read_at !== null,
            'thread_title' => $notification->data['thread_title'] ?? '',
            'comment_user_name' => $notification->data['comment_user_name'] ?? '',
            'comment_content' => $notification->data['comment_content'] ?? '',
            'go_url' => route('notifications.go', $notification->id),
        ];
    });
    return response()->json([
        'data' => $data,
    ]);
})->middleware('auth');
// Borrar todas las notificaciones del usuario autenticado

Route::post('/notificaciones/borrar-todas', [NotificationController::class, 'deleteAll'])->middleware('auth')->name('notifications.deleteAll');

require __DIR__.'/auth.php';
