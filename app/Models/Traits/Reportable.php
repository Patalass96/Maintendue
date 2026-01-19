<?php

namespace App\Models\Traits;

use App\Models\Report;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Reportable
{
    /**
     * Get all reports for this model.
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reported');
    }

    /**
     * Check if this model has been reported.
     */
    public function hasBeenReported(): bool
    {
        return $this->reports()->exists();
    }

    /**
     * Get the number of reports.
     */
    public function reportsCount(): int
    {
        return $this->reports()->count();
    }

    /**
     * Get pending reports.
     */
    public function pendingReports()
    {
        return $this->reports()->where('status', 'pending')->get();
    }

    /**
     * Check if this model has pending reports.
     */
    public function hasPendingReports(): bool
    {
        return $this->reports()->where('status', 'pending')->exists();
    }
}