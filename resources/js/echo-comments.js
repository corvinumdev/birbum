import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;
Pusher.logToConsole = true;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY || 'tu_app_key',
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'tu_app_cluster',
    forceTLS: true,
    encrypted: true,
});

if (window.threadId && window.Echo) {
    window.Echo.private('thread.' + window.threadId)
        .listen('.NewComment', (e) => {
            renderNewComment(e);
        })
        .listen('.CommentDeleted', (e) => {
            removeCommentFromUI(e.commentId);
        });
}

function removeCommentFromUI(commentId) {
    const commentDiv = document.querySelector(`.comment-item[data-comment-id="${commentId}"]`);
    if (commentDiv) {
        commentDiv.remove();
    }
    const commentsContainer = document.querySelector('.space-y-6');
    if (commentsContainer && commentsContainer.children.length === 0) {
        const emptyMsg = document.createElement('div');
        emptyMsg.className = 'text-gray-500 text-center';
        emptyMsg.textContent = 'Aún no hay comentarios. ¡Sé el primero en comentar!';
        commentsContainer.appendChild(emptyMsg);
    }
}

function renderNewComment(e) {
    const commentsContainer = document.querySelector('.space-y-6');
    if (!commentsContainer) {
        console.warn('[PUSHER] No se encontró el contenedor de comentarios');
        return;
    }
    if (!e || !e.comment) {
        console.warn('[Broadcast] El evento no contiene comment:', e);
        return;
    }
    const emptyMsg = commentsContainer.querySelector('.text-gray-500');
    if (emptyMsg) emptyMsg.remove();
    const comment = e.comment;
    const user = comment.user;
    const userAvatar = user && user.avatar
        ? `<img class="rounded-full object-cover w-10 h-10" src="/storage/avatars/${user.avatar}" alt="${user.name}">`
        : `<div class="rounded-full bg-base-200 flex items-center justify-center w-10 h-10">
                <span class="font-bold text-lg text-white dark:text-white">${(user && user.name ? user.name.charAt(0).toUpperCase() : 'U')}</span>
           </div>`;
    const userName = user && user.name ? `<a href="/users/${user.id}" class="font-semibold text-base-content hover:underline break-words min-w-0">${user.name}</a>` : '<span class="font-semibold text-base-content break-words min-w-0">Usuario eliminado</span>';
    const createdAt = comment.created_at_human || '';
    const content = comment.content.replace(/\n/g, '<br>');
    let deleteButton = '';
    if (
        window.authUserId && (
            window.authUserId == comment.user_id || window.authUserIsAdmin === true || window.authUserIsAdmin === 'true'
        )
    ) {
        const csrf = document.querySelector('input[name="_token"]')?.value || '';
        deleteButton = `
            <form method="POST" action="/comments/${comment.id}" class="ml-2 d-inline delete-comment-form" data-comment-id="${comment.id}">
                <input type="hidden" name="_token" value="${csrf}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-xs btn-error" title="Borrar comentario" onclick="return confirm('¿Seguro que deseas borrar este comentario?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </form>
        `;
    }
    const div = document.createElement('div');
    div.className = 'bg-base-100 p-4 rounded shadow flex flex-col sm:flex-row gap-3 text-base-content w-full overflow-x-auto comment-item';
    div.setAttribute('data-comment-id', comment.id);
    div.innerHTML = `
        ${userAvatar}
        <div class="flex-1 min-w-0">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 mb-1 min-w-0">
                ${userName}
                <span class="text-xs text-base-content/70 break-words min-w-0">${createdAt}</span>
                ${deleteButton}
            </div>
            <div class="text-base-content break-words whitespace-pre-line min-w-0">${content}</div>
        </div>
    `;
    commentsContainer.prepend(div);
}
