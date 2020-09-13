<?php

namespace App\Policies;

use App\Livrable;
use App\Tache;
use App\User;
use App\Projet;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\HandlesAuthorization;

class TachePolicy
{
    use HandlesAuthorization;


    public function access(User $user ,int $projet)
    {
        return $user->id === $projet;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user,int $projet)
    {
        return $user->id === $projet;

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tache  $tache
     * @return mixed
     */
    public function view(User $user, Livrable $livrables)
    {
     //   return $user->id === $livrables->id_respo;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     *
     * @return mixed
     */
    public function create(User $user,int $projet)
    {
        return $user->id === $projet ; // je peux ajouter une tache que lorsque le projet courent m'appartient
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tache  $tache
     * @return mixed
     */
    public function update(User $user, Projet $projet)
    {

        return $user->id === $projet->chefDegroupe;
    //    return $user->projetGere === $tache->ID_projet; // je peux modifier une tache que lorsque cette tache appartient au projet que je gére
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tache  $tache
     * @return mixed
     */
    public function delete(User $user, Projet $projet)
    {
        return $user->id === $projet->chefDegroupe;
     //   return $user->projetGere === $tache->ID_projet; // je peux pas supprimer une tache que lorsque cette tache appartient au projet que je gére

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tache  $tache
     * @return mixed
     */
    public function restore(User $user, Tache $tache)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tache  $tache
     * @return mixed
     */
    public function forceDelete(User $user, Tache $tache)
    {
        //
    }
}
