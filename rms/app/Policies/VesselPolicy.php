<?php

namespace App\Policies;

use App\User;
use App\Vessel;
use Illuminate\Auth\Access\HandlesAuthorization;

class VesselPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any vessels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->guard(['web'])->can('vessel.show');
    }

    /**
     * Determine whether the user can view the vessel.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->guard(['web'])->can('vessel.show');
    }

    /**
     * Determine whether the user can create vessels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->guard(['web'])->can('vessel.create');
    }

    /**
     * Determine whether the user can update the vessel.
     *
     * @param  \App\User  $user
     * @param  \App\Vessel  $vessel
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->guard(['web'])->can('vessel.update');
    }

    /**
     * Determine whether the user can delete the vessel.
     *
     * @param  \App\User  $user
     * @param  \App\Vessel  $vessel
     * @return mixed
     */
    public function delete(User $user, Vessel $vessel)
    {
        return $user->guard(['web'])->can('vessel.destroy');
    }

    /**
     * Determine whether the user can restore the vessel.
     *
     * @param  \App\User  $user
     * @param  \App\Vessel  $vessel
     * @return mixed
     */
    public function restore(User $user, Vessel $vessel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the vessel.
     *
     * @param  \App\User  $user
     * @param  \App\Vessel  $vessel
     * @return mixed
     */
    public function forceDelete(User $user, Vessel $vessel)
    {
        //
    }
}
