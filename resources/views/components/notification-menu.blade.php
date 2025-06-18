@php $unread = Auth::user()->unreadNotifications()->count(); @endphp
<div class="dropdown dropdown-end mr-2">
    <label tabindex="0" class="btn btn-ghost btn-circle relative">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary-content" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unread > 0)
            <span class="badge badge-error badge-xs absolute top-0 right-0"></span>
        @endif
    </label>
    <!-- Responsive: dropdown flotante en desktop, drawer fijo en móvil -->
    <div tabindex="0"
         class="mt-3 p-4 shadow dropdown-content bg-base-100 text-base-content dark:bg-gray-900 dark:text-white rounded-box
                w-[32rem] max-h-[36rem] overflow-auto
                min-w-[16rem] max-w-[95vw] sm:min-w-[22rem] sm:max-w-[28rem] md:min-w-[28rem] md:max-w-[32rem]"
         :class="window.innerWidth <= 640 ? 'fixed left-0 right-0 top-[4.5rem] z-[120] mt-0 rounded-none w-full max-w-full min-w-0 max-h-[calc(100dvh-4.5rem)]' : ''"
         style="transition: none;"
         x-data="{ updateDrawer() { this.$el.classList.toggle('fixed', window.innerWidth <= 640); this.$el.classList.toggle('dropdown-content', window.innerWidth > 640); } }"
         x-init="updateDrawer(); window.addEventListener('resize', updateDrawer)"
    >
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-base-200">
            <span class="font-bold text-base-content text-lg">Notificaciones</span>
        </div>
        <div id="notifications-list" class="flex flex-col gap-2 w-full overflow-y-auto bg-base-100 text-base-content dark:bg-gray-900 dark:text-white" style="max-height: 20rem;">
            <!-- Las notificaciones iniciales se cargan por JS -->
        </div>
        <div id="notifications-empty" class="p-4 hidden">
            <span class="text-base-content/70 text-center">No tienes notificaciones.</span>
        </div>
        <div id="notifications-markall" class="pt-3 border-t border-base-200 mt-4 flex justify-center bg-base-100 dark:bg-gray-900 sticky bottom-0 z-10 hidden">
            <form id="markAllForm" method="POST" action="{{ route('notifications.markAllRead') }}">
                @csrf
                <button id="markAllBtn" type="submit" class="btn btn-xs btn-outline btn-primary">
                    Marcar todo como leído
                </button>
            </form>
            <form id="deleteAllForm" method="POST" action="{{ route('notifications.deleteAll') }}" style="display:none;">
                @csrf
                <button id="deleteAllBtn" type="submit" class="btn btn-xs btn-outline btn-error">
                    Borrar todas las notificaciones
                </button>
            </form>
        </div>
    </div>
</div>
