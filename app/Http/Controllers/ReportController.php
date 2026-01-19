<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Models\Donation;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Affiche la liste des signalements (Admin)
     */
    public function index()
    {
        $this->authorize('viewAny', Report::class);

        $reports = Report::with(['reporter', 'resolver', 'reported'])
            ->latest()
            ->paginate(15);

        // Statistiques
        $stats = [
            'total' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'reviewed' => Report::where('status', 'reviewed')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
            'dismissed' => Report::where('status', 'dismissed')->count(),
        ];

        return view('reports.index', compact('reports', 'stats'));
    }

    /**
     * Affiche les détails d'un signalement
     */
    public function show(Report $report)
    {
        $this->authorize('view', $report);

        $report->load(['reporter', 'resolver', 'reported']);

        return view('reports.show', compact('report'));
    }

    /**
     * Crée un nouveau signalement (utilisateurs authentifiés)
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Stocke un nouveau signalement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reported_type' => 'required|string|in:Donation,User,Association',
            'reported_id' => 'required|integer|exists_reportable:' . $request->reported_type,
            'reason' => 'required|string|in:spam,inappropriate,fraud,other',
            'description' => 'required|string|min:20|max:1000',
        ]);

        // Vérifier que l'utilisateur n'a pas déjà signalé la même entité
        $existingReport = Report::where('reporter_id', Auth::id())
            ->where('reported_type', $validated['reported_type'])
            ->where('reported_id', $validated['reported_id'])
            ->where('status', '!=', 'dismissed')
            ->exists();

        if ($existingReport) {
            return back()->with('error', 'Vous avez déjà signalé cette entité.');
        }

        $report = Report::create([
            'reporter_id' => Auth::id(),
            'reported_type' => 'App\Models\\' . $validated['reported_type'],
            'reported_id' => $validated['reported_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Notifier les administrateurs
        $this->notifyAdminsAboutReport($report);

        return redirect()->route('home')
            ->with('success', 'Signalement envoyé avec succès. Merci pour votre vigilance.');
    }

    /**
     * Marque un signalement comme examiné
     */
    public function markAsReviewed(Report $report)
    {
        $this->authorize('update', $report);

        $report->update(['status' => 'reviewed']);

        return back()->with('success', 'Signalement marqué comme examiné.');
    }

    /**
     * Résout un signalement avec action (suppression, suspension, etc.)
     */
    public function resolve(Request $request, Report $report)
    {
        $this->authorize('update', $report);

        $validated = $request->validate([
            'admin_notes' => 'required|string|min:10|max:1000',
            'action' => 'nullable|string|in:none,warn,suspend,remove',
        ]);

        DB::transaction(function () use ($report, $validated) {
            // Mettre à jour le signalement
            $report->update([
                'status' => 'resolved',
                'admin_notes' => $validated['admin_notes'],
                'resolved_by' => Auth::id(),
                'resolved_at' => now(),
            ]);

            // Appliquer l'action si nécessaire
            if ($validated['action'] === 'warn') {
                $this->warnUser($report->reported);
            } elseif ($validated['action'] === 'suspend') {
                $this->suspendUser($report->reported);
            } elseif ($validated['action'] === 'remove') {
                $this->removeContent($report->reported);
            }
        });

        return back()->with('success', 'Signalement résolu avec succès.');
    }

    /**
     * Rejette un signalement (le marque comme rejeté)
     */
    public function dismiss(Request $request, Report $report)
    {
        $this->authorize('update', $report);

        $validated = $request->validate([
            'admin_notes' => 'required|string|min:10|max:500',
        ]);

        $report->update([
            'status' => 'dismissed',
            'admin_notes' => $validated['admin_notes'],
            'resolved_by' => Auth::id(),
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Signalement rejeté.');
    }

    /**
     * Supprime un signalement
     */
    public function destroy(Report $report)
    {
        $this->authorize('delete', $report);

        $report->delete();

        return redirect()->route('admin.reports')
            ->with('success', 'Signalement supprimé.');
    }

    /**
     * Avertit un utilisateur
     */
    private function warnUser($reported)
    {
        if ($reported instanceof User) {
            $reported->increment('warning_count');

            // Suspendre si 3 avertissements
            if ($reported->warning_count >= 3) {
                $reported->update([
                    'is_suspended' => true,
                    'suspended_until' => now()->addDays(7),
                    'suspension_reason' => 'Trop d\'avertissements reçus.',
                ]);
            }
        }
    }

    /**
     * Suspend un utilisateur
     */
    private function suspendUser($reported)
    {
        if ($reported instanceof User) {
            $reported->update([
                'is_suspended' => true,
                'suspended_until' => now()->addDays(30),
                'suspension_reason' => 'Compte suspendu suite à un signalement validé.',
            ]);
        }
    }

    /**
     * Supprime le contenu signalé
     */
    private function removeContent($reported)
    {
        if ($reported instanceof Donation) {
            $reported->delete();
        } elseif ($reported instanceof User) {
            $reported->delete();
        } elseif ($reported instanceof Association) {
            $reported->delete();
        }
    }

    /**
     * Notifie les administrateurs d'un nouveau signalement
     */
    private function notifyAdminsAboutReport(Report $report)
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            // Vous pouvez implémenter une notification
            // $admin->notify(new NewReportNotification($report));
        }
    }

    /**
     * Filtre les signalements
     */
    public function filter(Request $request)
    {
        $this->authorize('viewAny', Report::class);

        $query = Report::with(['reporter', 'resolver', 'reported']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('reason') && $request->reason) {
            $query->where('reason', $request->reason);
        }

        if ($request->has('reported_type') && $request->reported_type) {
            $query->where('reported_type', 'App\Models\\' . $request->reported_type);
        }

        $reports = $query->latest()->paginate(15);

        return view('reports.index', compact('reports'));
    }
}
