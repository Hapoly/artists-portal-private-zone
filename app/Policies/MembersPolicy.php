<?php

namespace App\Policies;

use App\User;
use App\Members;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembersPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the members.
     *
     * @param  \App\User  $user
     * @param  \App\Members  $members
     * @return mixed
     */
    public function view(User $user, Members $members)
    {
        return true;
    }

    /**
     * Determine whether the user can create members.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the members.
     *
     * @param  \App\User  $user
     * @param  \App\Members  $members
     * @return mixed
     */
    public function update(User $user, Members $members)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the members.
     *
     * @param  \App\User  $user
     * @param  \App\Members  $members
     * @return mixed
     */
    public function delete(User $user, Members $members)
    {
        return true;
    }
}
