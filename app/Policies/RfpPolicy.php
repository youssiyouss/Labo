<?php

namespace App\Policies;

use App\Rfp;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RfpPolicy
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
     * @param  \App\Rfp  $rfp
     * @return mixed
     */
    public function view(User $user, Rfp $rfp)
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
     * @param  \App\Rfp  $rfp
     * @return mixed
     */
    public function update(User $user, Rfp $rfp)
    {
       // return $user->grade === 'Directeur';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Rfp  $rfp
     * @return mixed
     */
    public function delete(User $user, Rfp $rfp)
    {
        return $user->grade === 'Directeur';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Rfp  $rfp
     * @return mixed
     */
    public function restore(User $user, Rfp $rfp)
    {
        return $user->grade === 'Directeur';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Rfp  $rfp
     * @return mixed
     */
    public function forceDelete(User $user, Rfp $rfp)
    {
        return $user->grade === 'Directeur';
    }
}
