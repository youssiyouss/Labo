<?php

namespace App\Policies;

use App\Projet;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Projet  $projet
     * @return mixed
     */
    public function view(User $user, Projet $projet)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Projet  $projet
     * @return mixed
     */
    public function update(User $user, Projet $projet)
    {
        return  $user->id === $projet->chefDeGroupe;
    }

    public function voir(User $user, int $chefDeGroupe)
    {
        return  $user->id === $chefDeGroupe;
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Projet  $projet
     * @return mixed
     */
    public function delete(User $user, Projet $projet)
    {
        return  $user->id === $projet->chefDeGroupe || $user->grade ==='Directeur';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Projet  $projet
     * @return mixed
     */
    public function restore(User $user, Projet $projet)
    {
        return  $user->id === $projet->chefDeGroupe || $user->grade === 'Directeur';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Projet  $projet
     * @return mixed
     */
    public function forceDelete(User $user, Projet $projet)
    {
        //
    }
}
