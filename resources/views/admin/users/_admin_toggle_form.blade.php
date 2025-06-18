<form method="POST" action="{{ route('admin.users.update', $user) }}" class="inline">
    @csrf
    @method('PUT')
    <input type="hidden" name="name" value="{{ $user->name }}">
    <input type="hidden" name="email" value="{{ $user->email }}">
    <input type="hidden" name="is_admin" value="{{ $user->is_admin ? 0 : 1 }}">
    <button type="submit" class="btn btn-xs {{ $user->is_admin ? 'btn-warning' : 'btn-success' }}" @if(auth()->id() === $user->id) disabled @endif>
        {{ $user->is_admin ? 'Quitar admin' : 'Hacer admin' }}
    </button>
</form>
