<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Apuntarse a un evento
    public function join(Event $event)
    {
        $user = auth()->user();
        if (!$event->attendees()->where('user_id', $user->id)->exists()) {
            $event->attendees()->attach($user->id);
        }
        return back()->with('status', 'Te has apuntado al evento.');
    }

    // Desapuntarse de un evento
    public function leave(Event $event)
    {
        $user = auth()->user();
        $event->attendees()->detach($user->id);
        return back()->with('status', 'Has cancelado tu asistencia al evento.');
    }

    // Eliminar evento
    public function destroy(Event $event)
    {
        // Solo el usuario creador o admin puede borrar
        if (auth()->id() !== $event->user_id && !auth()->user()?->is_admin) {
            abort(403);
        }
        // Eliminar imagen si existe
        if ($event->cover_image && str_starts_with($event->cover_image, 'storage/events/')) {
            $imagePath = str_replace('storage/', '', $event->cover_image);
            \Storage::disk('public')->delete($imagePath);
        }
        $event->delete();
        return redirect()->route('events.index')->with('status', 'Evento eliminado correctamente');
    }

    // List all events
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('events.index', compact('events'));
    }

    // Show create form
    public function create()
    {
        return view('events.create');
    }

    // Store new event
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => ['required', 'date', 'after_or_equal:today'],
            'cover_image' => 'nullable|image|max:4096',
        ], [
            'date.after_or_equal' => 'La fecha del evento no puede ser anterior a hoy.'
        ]);
        $validated['user_id'] = auth()->id();

        // Procesar imagen si se subió
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = uniqid('event_') . '.' . $image->getClientOriginalExtension();
            $image->storeAs('events', $filename, 'public');
            $validated['cover_image'] = 'storage/events/' . $filename;
        }

        $event = Event::create($validated);
        return redirect()->route('events.show', $event);
    }

    // Show event details
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    // Show edit form
    public function edit(Event $event)
    {
        // Solo el usuario creador o admin puede editar
        if (auth()->id() !== $event->user_id && !auth()->user()?->is_admin) {
            abort(403);
        }
        return view('events.edit', compact('event'));
    }

    // Update event
    public function update(Request $request, Event $event)
    {
        // Solo el usuario creador o admin puede editar
        if (auth()->id() !== $event->user_id && !auth()->user()?->is_admin) {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => ['required', 'date', 'after_or_equal:today'],
            'cover_image' => 'nullable|image|max:4096',
        ], [
            'date.after_or_equal' => 'La fecha del evento no puede ser anterior a hoy.'
        ]);

        // Procesar imagen si se subió
        if ($request->hasFile('cover_image')) {
            // Eliminar imagen anterior si existe
            if ($event->cover_image && str_starts_with($event->cover_image, 'storage/events/')) {
                $imagePath = str_replace('storage/', '', $event->cover_image);
                \Storage::disk('public')->delete($imagePath);
            }
            $image = $request->file('cover_image');
            $filename = uniqid('event_') . '.' . $image->getClientOriginalExtension();
            $image->storeAs('events', $filename, 'public');
            $validated['cover_image'] = 'storage/events/' . $filename;
        }

        $event->update($validated);
        return redirect()->route('events.show', $event)->with('status', 'Evento actualizado correctamente');
    }
}
