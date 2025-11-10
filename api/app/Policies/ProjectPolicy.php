<?php

namespace App\Policies;

use App\Contracts\User\Role;
use App\Models\Project;
use App\Models\Task;
use App\Support\Auth\User;

/**
 *
 */
class ProjectPolicy
{
    /**
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Project $project): bool
    {
        // OrgAdmin — all
        if ($user->hasRole(Role::Admin) && $project->organization_id === $user->orgId) {
            return true;
        }

        // Project Manager или Member — only if member
        if ($project->members->contains('user_id', $user->uuid)) {
            return true;
        }

        // Only public
        if ($project->is_public && $project->organization_id === $user->orgId) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::Admin)
            || $user->hasRole(Role::Manager);
    }

    /**
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function update(User $user, Project $project): bool
    {
        return $user->hasRole(Role::Admin)
            || ($user->hasRole(Role::Manager) && $project->members->contains(fn($m) =>
                    $m->pivot->user_id === $user->uuid && $m->pivot->role === Role::Manager->value
                ));
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(Role::Admin);
    }

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function addMember(User $user, Task $task): bool
    {
        return $user->hasRole(Role::Admin)
            || ($user->hasRole(Role::Manager) && $task->project->members->contains(fn($m) =>
                    $m->pivot->user_id === $user->uuid && $m->pivot->role === Role::Manager->value
                ));
    }
}
