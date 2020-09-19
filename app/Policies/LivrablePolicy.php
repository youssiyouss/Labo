<?php

namespace App\Policies;

use App\Livrable;
use App\User;
use App\Projet;
use Illuminate\Auth\Access\HandlesAuthorization;

class LivrablePolicy
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

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Livrable  $livrable
     * @return mixed
     */
    public function view(User $user, Livrable $livrable)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Livrable  $livrable
     * @return mixed
     */
    public function update(User $user, Livrable $livrable)
    {

        return $user->id === $livrable->id_respo;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Livrable  $livrable
     * @return mixed
     */
    public function delete(User $user, Projet $projet)
    {
        return $user->id === $projet->chefDeGroupe;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Livrable  $livrable
     * @return mixed
     */
    public function restore(User $user, Livrable $livrable)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Livrable  $livrable
     * @return mixed
     */
    public function forceDelete(User $user, Livrable $livrable)
    {
        //
    }
}
