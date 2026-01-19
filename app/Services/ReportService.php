<?php

namespace App\Services;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ReportService
{
    /**
     * Créer un rapport
     */
    public function create(User $reporter, string $reportableType, int $reportableId, string $reason, ?string $description = null): Report
    {
        return Report::create([
            'reporter_id' => $reporter->id,
            'reportable_type' => $reportableType,
            'reportable_id' => $reportableId,
            'reason' => $reason,
            'description' => $description,
            'status' => 'pending',
        ]);
    }

    /**
     * Obtenir les rapports en attente
     */
    public function getPendingReports(int $limit = 15): Collection
    {
        return Report::where('status', 'pending')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Marquer un rapport comme examiné
     */
    public function markAsReviewed(Report $report, User $admin): void
    {
        $report->update([
            'reviewed_at' => now(),
            'reviewed_by' => $admin->id,
        ]);
    }

    /**
     * Résoudre un rapport
     */
    public function resolve(Report $report, User $admin, string $resolution, ?string $adminNotes = null): void
    {
        $report->update([
            'status' => 'resolved',
            'resolution' => $resolution,
            'admin_notes' => $adminNotes,
            'resolved_at' => now(),
            'resolved_by' => $admin->id,
        ]);
    }

    /**
     * Rejeter un rapport
     */
    public function dismiss(Report $report, User $admin, ?string $reason = null): void
    {
        $report->update([
            'status' => 'dismissed',
            'admin_notes' => $reason,
            'resolved_at' => now(),
            'resolved_by' => $admin->id,
        ]);
    }

    /**
     * Obtenir les rapports par statut
     */
    public function getByStatus(string $status, int $limit = 15): Collection
    {
        return Report::where('status', $status)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Obtenir les rapports par type
     */
    public function getByType(string $reportableType, int $limit = 15): Collection
    {
        return Report::where('reportable_type', $reportableType)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Obtenir les statistiques des rapports
     */
    public function getStats(): array
    {
        return [
            'total' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
            'dismissed' => Report::where('status', 'dismissed')->count(),
        ];
    }

    /**
     * Obtenir les rapports pour un utilisateur rapporteur
     */
    public function getByReporter(User $user, int $limit = 10): Collection
    {
        return $user->reportsSubmitted()
            ->latest()
            ->limit($limit)
            ->get();
    }
}
