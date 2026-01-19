<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Models\AdminAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModerationController extends Controller
{
    /**
     * Afficher la liste des signalements
     */
    public function reports(Request $request)
    {
        $query = Report::with(['reporter', 'reported', 'resolver'])
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('reported_type', $request->type);
        }

        $reports = $query->paginate(20);
        
        $stats = [
            'total' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
        ];

        return view('admin.moderation.reports', compact('reports', 'stats'));
    }

    /**
     * Afficher un signalement
     */
    public function showReport(Report $report)
    {
        $report->load(['reporter', 'reported', 'resolver']);
        
        // Récupérer l'historique des actions
        $actions = AdminAction::where('target_type', get_class($report->reported))
            ->where('target_id', $report->reported_id)
            ->with('administrator')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.moderation.report-show', compact('report', 'actions'));
    }

    /**
     * Résoudre un signalement
     */
    public function resolveReport(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:resolved,rejected',
            'admin_notes' => 'required|string|min:10',
            'action_taken' => 'nullable|string'
        ]);

        $report->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'resolved_at' => now(),
            'resolved_by' => Auth::id(),
        ]);

        // Enregistrer l'action d'administration
        AdminAction::create([
            'admin_id' => Auth::id(),
            'action_type' => 'report_resolved',
            'target_type' => get_class($report->reported),
            'target_id' => $report->reported_id,
            'description' => "Signalement {$validated['status']} : {$validated['admin_notes']}",
            'metadata' => [
                'report_id' => $report->id,
                'status' => $validated['status'],
                'action_taken' => $validated['action_taken'] ?? null
            ]
        ]);

        // Si une action a été prise sur le contenu signalé
        if ($request->filled('action_taken')) {
            $this->takeActionOnReported($report, $validated['action_taken']);
        }

        return back()->with('success', 'Signalement traité avec succès.');
    }

    /**
     * Prendre une action sur le contenu signalé
     */
    private function takeActionOnReported(Report $report, $action)
    {
        $target = $report->reported;

        switch ($action) {
            case 'suspend_user':
                if ($target instanceof User) {
                    $target->update(['is_suspended' => true, 'suspended_until' => now()->addDays(7)]);
                }
                break;

            case 'delete_content':
                $target->delete();
                break;

            case 'hide_content':
                if (method_exists($target, 'update')) {
                    $target->update(['is_visible' => false]);
                }
                break;

            case 'warn_user':
                if ($target instanceof User) {
                    // Envoyer un avertissement
                    $target->notify(
                        'warning',
                        'Avertissement',
                        "Vous avez reçu un avertissement pour violation des règles.",
                        ['report_id' => $report->id]
                    );
                }
                break;
        }
    }

    /**
     * Liste des utilisateurs à modérer
     */
    public function users(Request $request)
    {
        $query = User::withCount(['donations', 'reports', 'reviews']);

        if ($request->filled('status')) {
            if ($request->status === 'suspended') {
                $query->where('is_suspended', true);
            } elseif ($request->status === 'active') {
                $query->where('is_suspended', false);
            }
        }

        if ($request->filled('role')) {
            if ($request->role === 'association') {
                $query->where('is_association', true);
            } elseif ($request->role === 'donor') {
                $query->where('is_association', false);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.moderation.users', compact('users'));
    }

    /**
     * Actions sur les utilisateurs
     */
    public function userActions(Request $request, User $user)
    {
        $validated = $request->validate([
            'action' => 'required|in:suspend,warn,delete,restore',
            'reason' => 'required|string|min:10',
            'duration' => 'nullable|integer|min:1'
        ]);

        $admin = Auth::user();

        switch ($validated['action']) {
            case 'suspend':
                $duration = $validated['duration'] ?? 7;
                $user->update([
                    'is_suspended' => true,
                    'suspended_until' => now()->addDays($duration),
                    'suspension_reason' => $validated['reason']
                ]);
                
                $actionType = 'user_suspended';
                break;

            case 'warn':
                // Envoyer un avertissement
                $user->notify(
                    'warning',
                    'Avertissement administrateur',
                    $validated['reason'],
                    ['type' => 'admin_warning']
                );
                
                $actionType = 'user_warned';
                break;

            case 'delete':
                // Soft delete ou suppression complète
                $user->delete();
                $actionType = 'user_deleted';
                break;

            case 'restore':
                $user->update(['is_suspended' => false, 'suspended_until' => null]);
                $actionType = 'user_restored';
                break;
        }

        // Enregistrer l'action
        AdminAction::create([
            'admin_id' => $admin->id,
            'action_type' => $actionType,
            'target_type' => User::class,
            'target_id' => $user->id,
            'description' => $validated['reason'],
            'metadata' => [
                'action' => $validated['action'],
                'duration' => $validated['duration'] ?? null
            ]
        ]);

        return back()->with('success', 'Action effectuée avec succès.');
    }

    /**
     * Journal des actions d'administration
     */
    public function actionLogs(Request $request)
    {
        $query = AdminAction::with(['administrator', 'target'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        if ($request->filled('target_type')) {
            $query->where('target_type', $request->target_type);
        }

        $actions = $query->paginate(30);

        $admins = User::where('role', 'admin')->get();
        $actionTypes = AdminAction::distinct('action_type')->pluck('action_type');
        $targetTypes = AdminAction::distinct('target_type')->pluck('target_type');

        return view('admin.moderation.action-logs', compact('actions', 'admins', 'actionTypes', 'targetTypes'));
    }
}