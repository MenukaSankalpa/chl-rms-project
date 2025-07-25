<?php

namespace App\Policies;

use App\User;
use App\Voyage;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoyagePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any voyages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return $user->guard(['web'])->can('voyage.show');
    }

    /**
     * Determine whether the user can view the voyage.
     *
     * @param  \App\User  $user
     * @param  \App\Voyage  $voyage
     * @return mixed
     */
    public function view(User $user)
    {
        //
        return $user->guard(['web'])->can('voyage.show');
    }

    /**
     * Determine whether the user can create voyages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user->guard(['web'])->can('voyage.create');

    }

    /**
     * Determine whether the user can update the voyage.
     *
     * @param  \App\User  $user
     * @param  \App\Voyage  $voyage
     * @return mixed
     */
    public function update(User $user)
    {
        //
        return $user->guard(['web'])->can('voyage.update');

    }

    /**
     * Determine whether the user can delete the voyage.
     *
     * @param  \App\User  $user
     * @param  \App\Voyage  $voyage
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        return $user->guard(['web'])->can('voyage.destroy');

    }

    /**
     * Determine whether the user can restore the voyage.
     *
     * @param  \App\User  $user
     * @param  \App\Voyage  $voyage
     * @return mixed
     */
    public function restore(User $user, Voyage $voyage)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the voyage.
     *
     * @param  \App\User  $user
     * @param  \App\Voyage  $voyage
     * @return mixed
     */
    public function forceDelete(User $user, Voyage $voyage)
    {
        //
    }
}
