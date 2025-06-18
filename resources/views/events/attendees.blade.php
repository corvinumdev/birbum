@extends('layouts.app')

@section('title', 'Asistentes a ' . $event->title)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 mb-6 text-sm text-primary hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Volver al evento
    </a>
    <h1 class="text-2xl font-bold mb-6">Asistentes a "{{ $event->title }}"</h1>
    <div class="bg-base-100 shadow rounded-lg divide-y divide-base-200">
        @forelse($attendees as $attendee)
            <div class="flex items-center gap-4 p-4">
                <x-user-avatar :user="$attendee" class="h-12 w-12" />
                <div class="flex-1">
                    <a href="{{ route('profile.show', $attendee) }}" class="font-semibold text-base-content hover:text-primary">{{ $attendee->name }}</a>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-base-content/70">Nadie se ha apuntado aún.</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $attendees->links() }}</div>
</div>
@endsection
