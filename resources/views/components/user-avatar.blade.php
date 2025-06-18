@props([
    'user',
    'size' => 'w-10 h-10', // tailwind classes, e.g. w-10 h-10
    'class' => ''
])
@if($user && $user->avatar)
    <img class="rounded-full object-cover {{ $size }} {{ $class }}" src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->name }}">
@else
    <div class="rounded-full bg-base-200 flex items-center justify-center {{ $size }} {{ $class }}">
        <span class="font-bold text-lg text-gray-800">
            {{ strtoupper(mb_substr($user->name ?? 'U', 0, 1, 'UTF-8')) }}
        </span>
    </div>
@endif
