<?php

namespace App\Policies;

use App\User;
use App\Port;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any ports.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return $user->guard(['web'])->can('port.show');
    }

    /**
     * Determine whether the user can view the port.
     *
     * @param  \App\User  $user
     * @param  \App\Port  $port
     * @return mixed
     */
    public function view(User $user/*, Port $port*/)
    {
        return $user->guard(['web'])->can('port.show');
    }

    /**
     * Determine whether the user can create ports.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->guard(['web'])->can('port.create');
    }

    /**
     * Determine whether the user can update the port.
     *
     * @param  \App\User  $user
     * @param  \App\Port  $port
     * @return mixed
     */
    public function update(User $user/*, Port $port*/)
    {
        return $user->guard(['web'])->can('port.update');
    }

    /**
     * Determine whether the user can delete the port.
     *
     * @param  \App\User  $user
     * @param  \App\Port  $port
     * @return mixed
     */
    public function delete(User $user/*, Port $port*/)
    {
        return $user->guard(['web'])->can('port.destroy');
    }

    /**
     * Determine whether the user can restore the port.
     *
     * @param  \App\User  $user
     * @param  \App\Port  $port
     * @return mixed
     */
    public function restore(User $user, Port $port)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the port.
     *
     * @param  \App\User  $user
     * @param  \App\Port  $port
     * @return mixed
     */
    public function forceDelete(User $user, Port $port)
    {
        //
    }
}
