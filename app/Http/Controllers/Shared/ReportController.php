<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Afficher la liste des signalements (pour admin)
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Report::class);

        $query = Report::with(['reporter', 'reported', 'resolver'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('reported_type', $request->type);
        }

        $reports = $query->paginate(20);

        return view('shared.reports.index', compact('reports'));
    }

    /**
     * Créer un nouveau signalement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reported_type' => 'required|string|in:App\Models\User,App\Models\Donation,App\Models\Review',
            'reported_id' => 'required|integer',
            'reason' => 'required|string|in:inappropriate,spam,fraud,other',
            'description' => 'required|string|min:10|max:500',
        ]);

        $validated['reporter_id'] = Auth::id();
        $validated['status'] = 'pending';

        // Vérifier que l'élément existe
        $modelClass = $validated['reported_type'];
        if (!class_exists($modelClass)) {
            return back()->with('error', 'Type de contenu invalide.');
        }

        $reportedItem = $modelClass::find($validated['reported_id']);
        if (!$reportedItem) {
            return back()->with('error', 'Le contenu signalé n\'existe pas.');
        }

        // Vérifier que l'utilisateur ne se signale pas lui-même
        if ($reportedItem instanceof \App\Models\User && $reportedItem->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas vous signaler vous-même.');
        }

        Report::create($validated);

        return back()->with('success', 'Signalement envoyé. Merci pour votre vigilance.');
    }

    /**
     * Afficher un signalement
     */
    public function show(Report $report)
    {
        $this->authorize('view', $report);

        $report->load(['reporter', 'reported', 'resolver']);

        return view('shared.reports.show', compact('report'));
    }

    /**
     * Mettre à jour le statut d'un signalement (pour admin)
     */
    public function update(Request $request, Report $report)
    {
        $this->authorize('update', $report);

        $validated = $request->validate([
            'status' => 'required|in:pending,investigating,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $updateData = $validated;

        if ($validated['status'] === 'resolved' || $validated['status'] === 'dismissed') {
            $updateData['resolved_at'] = now();
            $updateData['resolved_by'] = Auth::id();
        }

        $report->update($updateData);

        return back()->with('success', 'Statut du signalement mis à jour.');
    }

    /**
     * Mes signalements (pour utilisateur)
     */
    public function myReports()
    {
        $reports = Auth::user()->reportsMade()
            ->with('reported')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('shared.reports.my-reports', compact('reports'));
    }
}
