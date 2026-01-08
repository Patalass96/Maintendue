<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Affiche la liste des catégories (Vue Admin)
     */
    public function index()
    {
        // On récupère toutes les catégories triées par index
        $categories = Category::orderBy('order_index', 'asc')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Enregistre une nouvelle catégorie depuis la Modal JS
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
        ]);

        // Génération automatique du slug à partir du nom
        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = true; // Actif par défaut

        Category::create($validated);

        return redirect()->back()->with('success', 'Catégorie ajoutée avec succès !');
    }

    /**
     * Supprime une catégorie
     */
    public function destroy(Category $category)
    {
        // Vérifie si la catégorie a des dons liés avant de supprimer
        if ($category->donations()->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer : cette catégorie contient des dons.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Catégorie supprimée.');
    }
}