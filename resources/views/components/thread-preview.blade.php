<div class="card thread-card bg-base-100 shadow mb-4 hover:shadow-xl transition-shadow cursor-pointer group"
     onclick="window.location='{{ route('threads.show', $thread) }}'"
     style="position: relative;"
     tabindex="0"
     role="button"
     onkeydown="if(event.key==='Enter'||event.key===' '){window.location='{{ route('threads.show', $thread) }}';}">
  <div class="card-body p-4">
    <div class="flex items-start justify-between">
      <div class="flex-1">
        <div class="flex items-center gap-2">
          @if($thread->user)
            <a href="{{ route('profile.show', $thread->user) }}" class="shrink-0 mr-0" onclick="event.stopPropagation();">
              <x-user-avatar :user="$thread->user" size="w-12 h-12" />
            </a>
          @else
            <span class="shrink-0 mr-0">
              <x-user-avatar :user="null" size="w-12 h-12" />
            </span>
          @endif
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 min-w-0">
              <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl xl:text-3xl font-bold group-hover:text-primary min-w-0 flex items-center">
                <span class="truncate block max-w-[12rem] sm:max-w-xs md:max-w-sm lg:max-w-md whitespace-nowrap overflow-hidden align-middle min-w-0"
                      title="{{ $thread->title }}">
                  {{ $thread->title }}
                </span>
                <!-- Contador de respuestas SOLO en móvil, al lado del título -->
                <span class="flex sm:hidden items-center gap-1 ml-1">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span class="font-semibold">{{ $thread->comments->count() }}</span>
                </span>
              </h3>
            </div>
            <p class="text-sm text-gray-500">
              Publicado por @if($thread->user)
                <a href="{{ route('profile.show', $thread->user) }}" class="font-medium text-primary hover:underline" onclick="event.stopPropagation();">{{ $thread->user->name }}</a>
              @else
                <span class="font-medium text-primary">Usuario eliminado</span>
              @endif
              • {{ $thread->created_at->diffForHumans() }}
            </p>
          </div>
        </div>
        
      </div>
      <!-- Bloque de respuestas clásico solo en sm o superior -->
      <div class="hidden sm:flex flex-col items-center justify-center flex-shrink-0 ml-4">
        <div class="bg-base-200 rounded-lg shadow p-2 w-20 text-center">
          <div class="text-xs text-base-content/70 font-semibold mb-1">Respuestas</div>
          <div class="text-lg font-bold text-base-content">{{ $thread->comments->count() }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
