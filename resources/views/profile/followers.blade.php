@extends('layouts.app')

@section('title', 'Seguidores de ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <a href="{{ route('profile.show', $user) }}" class="inline-flex items-center gap-2 mb-6 text-sm text-primary hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Volver al perfil de {{ $user->name }}
    </a>
    <x-breadcrumbs :links="[
        ['url' => url('/'), 'label' => 'Inicio'],
        ['url' => route('profile.show', $user), 'label' => 'Perfil de ' . $user->name],
        ['label' => 'Seguidores']
    ]" />
    <h1 class="text-2xl font-bold mb-6">Seguidores de {{ $user->name }}</h1>
    <div class="bg-base-100 shadow rounded-lg divide-y divide-base-200">
        @forelse($followers as $follower)
            <div class="flex items-center gap-4 p-4">
                <x-user-avatar :user="$follower" class="h-12 w-12" />
                <div class="flex-1">
                    <a href="{{ route('profile.show', $follower) }}" class="font-semibold text-base-content hover:text-primary">{{ $follower->name }}</a>

                </div>
                @auth
                    @if(auth()->id() !== $follower->id)
                        @php $isFollowing = auth()->user()->following->contains($follower->id); @endphp
                        @if($isFollowing)
                            <form method="POST" action="{{ route('users.unfollow', $follower) }}">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-secondary">Dejar de seguir</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('users.follow', $follower) }}">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-primary">Seguir</button>
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        @empty
            <div class="p-8 text-center text-base-content/70">Este usuario aún no tiene seguidores.</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $followers->links() }}</div>
</div>
@endsection
