<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Affiche la liste des FAQs
     */
    public function index()
    {
        $this->authorize('viewAny', Faq::class);

        $faqs = Faq::orderBy('category')
            ->orderBy('order_index')
            ->paginate(20);

        // Statistiques
        $stats = [
            'total' => Faq::count(),
            'visible' => Faq::where('is_visible', true)->count(),
            'by_category' => Faq::groupBy('category')
                ->selectRaw('category, COUNT(*) as count')
                ->pluck('count', 'category'),
        ];

        // Catégories disponibles
        $categories = Faq::distinct()->pluck('category')->sort();

        return view('admin.faqs.index', compact('faqs', 'stats', 'categories'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $this->authorize('create', Faq::class);

        return view('admin.faqs.create');
    }

    /**
     * Stocke une nouvelle FAQ
     */
    public function store(Request $request)
    {
        $this->authorize('create', Faq::class);

        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'question' => 'required|string|max:1000',
            'answer' => 'required|string|max:5000',
            'order_index' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]);

        // Si pas de order_index, prendre le dernier + 1
        if (!isset($validated['order_index'])) {
            $validated['order_index'] = Faq::max('order_index') + 1;
        }

        $faq = Faq::create($validated);

        return redirect()->route('admin.faqs.show', $faq)
            ->with('success', 'FAQ créée avec succès.');
    }

    /**
     * Affiche les détails d'une FAQ
     */
    public function show(Faq $faq)
    {
        $this->authorize('view', $faq);

        return view('admin.faqs.show', compact('faq'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Faq $faq)
    {
        $this->authorize('update', $faq);

        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Met à jour une FAQ
     */
    public function update(Request $request, Faq $faq)
    {
        $this->authorize('update', $faq);

        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'question' => 'required|string|max:1000',
            'answer' => 'required|string|max:5000',
            'order_index' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]);

        if (!isset($validated['order_index'])) {
            $validated['order_index'] = $faq->order_index;
        }

        $faq->update($validated);

        return redirect()->route('admin.faqs.show', $faq)
            ->with('success', 'FAQ mise à jour avec succès.');
    }

    /**
     * Supprime une FAQ
     */
    public function destroy(Faq $faq)
    {
        $this->authorize('delete', $faq);

        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ supprimée.');
    }

    /**
     * Bascule la visibilité d'une FAQ
     */
    public function toggle(Faq $faq)
    {
        $this->authorize('update', $faq);

        $faq->update([
            'is_visible' => !$faq->is_visible,
        ]);

        $message = $faq->is_visible ? 'visible' : 'masquée';

        return back()->with('success', "FAQ $message.");
    }

    /**
     * Réordonne les FAQs (AJAX)
     */
    public function reorder(Request $request)
    {
        $this->authorize('update', Faq::class);

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:faqs,id',
        ]);

        foreach ($validated['order'] as $index => $faqId) {
            Faq::where('id', $faqId)->update(['order_index' => $index]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Filtre les FAQs par catégorie
     */
    public function filterByCategory(Request $request)
    {
        $this->authorize('viewAny', Faq::class);

        $category = $request->get('category');

        $faqs = Faq::when($category, function ($query) use ($category) {
            return $query->where('category', $category);
        })
            ->orderBy('category')
            ->orderBy('order_index')
            ->paginate(20);

        $categories = Faq::distinct()->pluck('category')->sort();

        return view('admin.faqs.index', compact('faqs', 'categories', 'category'));
    }
}
