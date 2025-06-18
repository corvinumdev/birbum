<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:255',
        ]);
        $category = Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);
        return redirect()->route('admin.categories.index')->with('status', 'Categoría creada correctamente.');
    }

        public function create()
    {
        return view('admin.categories.create');
    }
    
    public function destroy(Category $category)
    {
        // Opcional: proteger si tiene hilos asociados
        if ($category->threads()->count() > 0) {
            return back()->withErrors(['No puedes eliminar una categoría con hilos asociados.']);
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('status', 'Categoría eliminada correctamente.');
    }
}
