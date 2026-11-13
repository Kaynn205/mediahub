<?php

namespace App\Policies;

use App\Models\Contenu;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContenuPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contenu $contenu): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contenu $contenu): bool
    {
        return $contenu->auteur && $contenu->auteur->user_id === $user->id;
    }
    public function delete(User $user, Contenu $contenu): bool
    {
        return $this->update($user, $contenu);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contenu $contenu): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contenu $contenu): bool
    {
        return false;
    }
}
