<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AssociationNeed;

class AssociationNeedPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['association', 'admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AssociationNeed $need): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->id === $need->association_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('association');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AssociationNeed $need): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->id === $need->association_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AssociationNeed $need): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->id === $need->association_id;
    }

    /**
     * Determine whether the user can toggle the model status.
     */
    public function toggle(User $user, AssociationNeed $need): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->id === $need->association_id;
    }
}
