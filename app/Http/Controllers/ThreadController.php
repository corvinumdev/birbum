<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Thread;

class ThreadController extends Controller
{

    //Muestra la lista de hilos del foro.
    public function index()
    {
        // Búsqueda de hilos por título, contenido y categoría
        $query = Thread::with(['user', 'category']);
        if (request()->filled('search')) {
            $search = request('search');
            $query->where('title', 'like', "%$search%") ;
        }
        if (request()->filled('category')) {
            $query->where('category_id', request('category'));
        }
        $threads = $query->orderBy('created_at', 'desc')->paginate(5);
        // Si en el futuro hay hilos destacados, se pueden obtener aquí
        $pinnedThreads = collect();
        return view('threads.index', compact('threads', 'pinnedThreads'));
    }

    /**
     * Muestra el formulario para crear un nuevo hilo.
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Guarda un nuevo hilo en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => ['required', 'exists:categories,id'],
            'image' => 'nullable|image|max:4096',
        ]);

        // Permitir que cualquier usuario asigne la categoría
        $categoryId = $validated['category_id'];

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid('thread_') . '.' . $image->getClientOriginalExtension();
            $image->storeAs('threads', $filename, 'public');
            $imagePath = 'storage/threads/' . $filename;
        }

        $thread = Thread::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => $request->user()->id,
            'category_id' => $categoryId,
            'image' => $imagePath,
        ]);

        // Redirigir al listado de hilos con mensaje de éxito
        return redirect()->route('threads.index')->with('success', '¡Hilo creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $thread = Thread::with('user')->findOrFail($id);
        return view('threads.show', compact('thread'));
    }

    public function edit($id)
    {
        $thread = Thread::findOrFail($id);
        // Solo el autor o admin puede editar
        if (auth()->id() !== $thread->user_id && !auth()->user()->is_admin) {
            abort(403, 'No tienes permiso para editar este hilo.');
        }
        $categories = [];
        if (auth()->user()->is_admin) {
            $categories = Category::orderBy('name')->get();
        }
        return view('threads.edit', compact('thread', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);
        if (auth()->id() !== $thread->user_id && !auth()->user()->is_admin) {
            abort(403, 'No tienes permiso para editar este hilo.');
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => ['nullable', 'exists:categories,id'],
            'image' => 'nullable|image|max:4096',
        ]);
        $thread->title = $validated['title'];
        $thread->content = $validated['content'];
        if (auth()->user()->is_admin) {
            $thread->category_id = $validated['category_id'];
        }

        // Procesar imagen si se subió
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($thread->image && str_starts_with($thread->image, 'storage/threads/')) {
                $imagePath = str_replace('storage/', '', $thread->image);
                Storage::disk('public')->delete($imagePath);
            }
            $image = $request->file('image');
            $filename = uniqid('thread_') . '.' . $image->getClientOriginalExtension();
            $image->storeAs('threads', $filename, 'public');
            $thread->image = 'storage/threads/' . $filename;
        }

        $thread->save();
        return redirect()->route('threads.show', $thread)->with('success', 'Hilo actualizado correctamente.');
    }

    // Elimina un hilo del foro (solo autor o admin).
    public function destroy(string $id)
    {
        $thread = Thread::findOrFail($id);
        // Solo el autor o un admin puede borrar
        if (auth()->id() !== $thread->user_id && !auth()->user()->is_admin) {
            abort(403, 'No tienes permiso para eliminar este hilo.');
        }
        $thread->delete();
        return redirect()->route('threads.index')->with('success', 'Hilo eliminado correctamente.');
    }
}
