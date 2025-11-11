<?php

namespace App\Policies;

use App\Contracts\User\Role;
use App\Models\Organization;
use App\Support\Auth\User;

/**
 *
 */
class OrganizationPolicy
{
    /**
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    public function view(User $user, Organization $organization): bool
    {
        return $user->hasRole(Role::Admin) || $organization->users->contains('user_id', $user->uuid);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::Admin);
    }

    /**
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    public function update(User $user, Organization $organization): bool
    {
        return $user->hasRole(Role::Admin)
            && $organization->users->contains(fn($u) =>
                $u->user_id === $user->uuid && $u->role === Role::Admin
            );
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(Role::Admin);
    }
}
