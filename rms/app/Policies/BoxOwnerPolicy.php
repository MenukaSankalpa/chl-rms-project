<?php

namespace App\Policies;

use App\User;
use App\BoxOwner;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoxOwnerPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any box owners.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return $user->guard(['web'])->can('box_owner.show');
    }

    /**
     * Determine whether the user can view the box owner.
     *
     * @param  \App\User  $user
     * @param  \App\BoxOwner  $boxOwner
     * @return mixed
     */
    public function view(User $user)
    {
        //
        return $user->guard(['web'])->can('box_owner.show');

    }

    /**
     * Determine whether the user can create box owners.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user->guard(['web'])->can('box_owner.create');

    }

    /**
     * Determine whether the user can update the box owner.
     *
     * @param  \App\User  $user
     * @param  \App\BoxOwner  $boxOwner
     * @return mixed
     */
    public function update(User $user)
    {
        //
        return $user->guard(['web'])->can('box_owner.update');

    }

    /**
     * Determine whether the user can delete the box owner.
     *
     * @param  \App\User  $user
     * @param  \App\BoxOwner  $boxOwner
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        return $user->guard(['web'])->can('box_owner.destroy');

    }

    /**
     * Determine whether the user can restore the box owner.
     *
     * @param  \App\User  $user
     * @param  \App\BoxOwner  $boxOwner
     * @return mixed
     */
    public function restore(User $user, BoxOwner $boxOwner)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the box owner.
     *
     * @param  \App\User  $user
     * @param  \App\BoxOwner  $boxOwner
     * @return mixed
     */
    public function forceDelete(User $user, BoxOwner $boxOwner)
    {
        //
    }
}
