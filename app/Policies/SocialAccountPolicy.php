<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SocialAccount;

class SocialAccountPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Chaque utilisateur peut voir ses comptes
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SocialAccount $account): bool
    {
        return $user->id === $account->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Tout utilisateur authentifié peut connecter des comptes
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SocialAccount $account): bool
    {
        return $user->id === $account->user_id;
    }

    /**
     * Determine whether the user can disconnect the model.
     */
    public function disconnect(User $user, SocialAccount $account): bool
    {
        return $user->id === $account->user_id;
    }
}
