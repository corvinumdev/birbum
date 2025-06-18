<x-app-layout :title="$thread->title">
@push('scripts')
<script>
    window.threadId = {{ $thread->id }};
    @auth
        window.authUserId = {{ auth()->id() }};
        window.authUserIsAdmin = {{ auth()->user()->is_admin ? 'true' : 'false' }};
    @else
        window.authUserId = null;
        window.authUserIsAdmin = false;
    @endauth
</script>
@vite('resources/js/echo-comments.js')
@endpush
    <div class="container mx-auto px-4 py-8 overflow-x-auto">
        <!-- Migas de pan DaisyUI -->
        <x-breadcrumbs :links="[
            ['url' => url('/'), 'label' => 'Inicio'],
            ['url' => route('threads.index'), 'label' => 'Hilos'],
            ['label' => $thread->title]
        ]" />
        <div class="bg-base-100 rounded-lg shadow p-6 text-base-content overflow-x-auto">
            <div class="mb-4 flex items-center min-w-0">
                <x-user-avatar :user="$thread->user" size="w-12 h-12" class="mr-4" />
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-base-content break-words break-all whitespace-normal w-full min-w-0">{{ $thread->title }}</h1>
                        <!-- Votos del hilo -->
                        <div class="flex items-center gap-1">
                            @auth
                                @if(!$thread->votedBy(auth()->user()))
                                    <form action="{{ route('threads.upvote', $thread) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-1 group bg-transparent border-0 p-0 m-0 cursor-pointer" style="background: none;">
                                            <span class="text-base-content font-semibold">{{ $thread->votes }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary group-hover:scale-110 transition-transform">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('threads.unvote', $thread) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center gap-1 group bg-transparent border-0 p-0 m-0 cursor-pointer" style="background: none;">
                                            <span class="text-base-content font-semibold">{{ $thread->votes }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary opacity-60 group-hover:scale-110 transition-transform">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                            @guest
                                <span class="text-base-content font-semibold">{{ $thread->votes }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary opacity-60">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                </svg>
                            @endguest

                        </div>
                        
                    </div>
                    <div class="text-sm text-base-content/70 break-words min-w-0">
                        Por @if($thread->user)
                          <a href="{{ route('profile.show', $thread->user) }}" class="font-medium text-primary hover:underline">{{ $thread->user->name }}</a>
                        @else
                          Usuario eliminado
                        @endif • {{ $thread->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            <div class="prose max-w-none text-base-content break-words whitespace-pre-line min-w-0">
                @if($thread->image)
                  <div class="mb-4">
                    <a href="/{{ $thread->image }}" target="_blank" rel="noopener" title="Ampliar imagen">
                      <img src="/{{ $thread->image }}" alt="Imagen del hilo" class="rounded max-h-80 border shadow hover:scale-105 transition-transform duration-200 cursor-zoom-in mx-auto" style="max-width: 100%;">
                    </a>
                  </div>
                @endif
                {!! nl2br(e($thread->content)) !!}
            </div>
        </div>
        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center">
            <div class="flex flex-col gap-2 sm:flex-row">
                <a href="{{ route('threads.index') }}" class="btn btn-outline w-full sm:w-auto">&larr; Volver a Hilos</a>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <button id="mostrar-comentario" class="btn btn-primary w-full sm:w-auto">Comentar</button>
                @can('delete', $thread)
                <form action="{{ route('threads.destroy', $thread) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este hilo?');" class="inline-block w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error w-full sm:w-auto ml-0 sm:ml-2">Eliminar hilo</button>
                </form>
                @endcan
            </div>
        </div>
        <!-- Sección de comentarios -->
        <div id="comentar" class="mt-12">
            <div class="card bg-base-100 shadow-lg" id="comments-section">
                <div class="card-body">
                    <h2 class="card-title text-xl font-semibold mb-4">Comentarios</h2>
                    @auth
                    <form id="form-comentario" method="POST" action="{{ route('comments.store', $thread) }}" class="mb-8 bg-base-200 p-4 rounded-lg shadow w-full" style="display:none;">
                        @csrf
                        <div class="mb-2">
                            <textarea name="content" class="textarea textarea-bordered w-full" rows="3" placeholder="Escribe tu comentario..." required minlength="2" maxlength="2000"></textarea>
                            <div id="comment-error" class="text-red-500 text-sm mt-1" style="display:none;"></div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-primary w-full sm:w-auto" id="btn-enviar-comentario">Publicar comentario</button>
                        </div>
                    </form>
                    @else
                        <div class="mb-8 text-center text-gray-600">
                            <a href="{{ route('login') }}" class="text-primary underline">Inicia sesión</a> para comentar.
                        </div>
                    @endauth
                    <div class="space-y-6">
                        @forelse($thread->comments()->with('user')->latest()->get() as $comment)
    <div class="bg-base-100 p-4 rounded shadow flex flex-col sm:flex-row gap-3 text-base-content w-full overflow-x-auto comment-item" data-comment-id="{{ $comment->id }}">
        <x-user-avatar :user="$comment->user" />
        <div class="flex-1 min-w-0">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 mb-1 min-w-0">
                @if($comment->user)
                  <a href="{{ route('profile.show', $comment->user) }}" class="font-semibold text-base-content hover:underline break-words min-w-0">{{ $comment->user->name }}</a>
                @else
                  <span class="font-semibold text-base-content break-words min-w-0">Usuario eliminado</span>
                @endif
                <span class="text-xs text-base-content/70 break-words min-w-0">{{ $comment->created_at->diffForHumans() }}</span>
                @can('delete', $comment)
                <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="ml-2 d-inline delete-comment-form" data-comment-id="{{ $comment->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-error" title="Borrar comentario" onclick="return confirm('¿Seguro que deseas borrar este comentario?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </form>
                @endcan
            </div>
            <div class="text-base-content break-words whitespace-pre-line min-w-0">{!! nl2br(e($comment->content)) !!}</div>
        </div>
    </div>
                        @empty
                            <div class="text-gray-500 text-center">Aún no hay comentarios. ¡Sé el primero en comentar!</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('mostrar-comentario');
            var form = document.getElementById('form-comentario');
            var textarea = form ? form.querySelector('textarea[name="content"]') : null;
            var errorDiv = document.getElementById('comment-error');
            var btnEnviar = document.getElementById('btn-enviar-comentario');

            if(btn && form) {
                btn.addEventListener('click', function() {
                    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
                    if(form.style.display === 'block') {
                        form.scrollIntoView({behavior: 'smooth'});
                    }
                });
            }

            // Interceptar submit para fetch
            if(form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    if (errorDiv) {
                        errorDiv.style.display = 'none';
                        errorDiv.textContent = '';
                    }
                    if (btnEnviar) btnEnviar.disabled = true;
                    try {
                        const formData = new FormData(form);
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                            },
                            body: formData
                        });
                        if (response.ok) {
                            // Limpiar textarea y feedback
                            if (textarea) textarea.value = '';
                            if (errorDiv) {
                                errorDiv.style.display = 'none';
                                errorDiv.textContent = '';
                            }
                            // El comentario se renderiza solo al recibir el evento Echo
                        } else if (response.status === 422) {
                            const data = await response.json();
                            if (data.errors && data.errors.content) {
                                if (errorDiv) {
                                    errorDiv.textContent = data.errors.content[0];
                                    errorDiv.style.display = 'block';
                                }
                            } else {
                                if (errorDiv) {
                                    errorDiv.textContent = 'Error inesperado al enviar el comentario.';
                                    errorDiv.style.display = 'block';
                                }
                            }
                        } else {
                            if (errorDiv) {
                                errorDiv.textContent = 'Error inesperado al enviar el comentario.';
                                errorDiv.style.display = 'block';
                            }
                        }
                    } catch (err) {
                        if (errorDiv) {
                            errorDiv.textContent = 'Error de red. Intenta de nuevo.';
                            errorDiv.style.display = 'block';
                        }
                    } finally {
                        if (btnEnviar) btnEnviar.disabled = false;
                    }
                });
            }

            // Borrado en vivo de comentarios con fetch
            document.body.addEventListener('submit', async function (e) {
                const form = e.target;
                if (form.classList.contains('delete-comment-form')) {
                    e.preventDefault();
                    if (!confirm('¿Seguro que deseas borrar este comentario?')) return;
                    const commentId = form.getAttribute('data-comment-id');
                    const action = form.getAttribute('action');
                    const token = form.querySelector('input[name="_token"]').value;
                    try {
                        const response = await fetch(action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                            body: new URLSearchParams({
                                _method: 'DELETE',
                                _token: token
                            })
                        });
                        if (response.ok) {
                            // El comentario se elimina en la UI por Echo/Pusher
                        } else {
                            alert('No se pudo borrar el comentario.');
                        }
                    } catch (err) {
                        alert('Error de red al borrar el comentario.');
                    }
                }
            });
        });
        </script>
    </div>
 </x-app-layout>
