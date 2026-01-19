<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CollectionPoint;

class CollectionPointPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CollectionPoint $collectionPoint): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CollectionPoint $collectionPoint): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CollectionPoint $collectionPoint): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CollectionPoint $collectionPoint): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CollectionPoint $collectionPoint): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can toggle the model status.
     */
    public function toggle(User $user, CollectionPoint $collectionPoint): bool
    {
        return $user->hasRole('admin');
    }
}
