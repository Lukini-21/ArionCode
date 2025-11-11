<?php

namespace App\Policies;

use App\Contracts\User\Role;
use App\Models\Project;
use App\Models\Task;
use App\Support\Auth\User;

/**
 *
 */
class TaskPolicy
{
    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function view(User $user, Task $task): bool
    {
        if ($user->hasRole(Role::Admin) && $task->project->organization_id === $user->orgId) {
            return true;
        }

        if ($task->project->members->contains('user_id', $user->uuid)) {
            return true;
        }

        return $task->assignee_id === $user->uuid;
    }

    /**
     * @param User $user
     * @param Project $task
     * @return bool
     */
    public function create(User $user, ?Project $project = null): bool
    {
        if ($user->hasRole(Role::Admin)) {
            return true;
        }

        if ($user->hasRole(Role::Manager) && $project) {
            return $project->members->contains('user_id', $user->uuid);
        }

        return false;
    }

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function update(User $user, Task $task): bool
    {
        // Only assignee, managers, or admins can update tasks
        return
            $user->hasRole(Role::Admin)
            || ($user->hasRole(Role::Manager) &&
                $task->project->members->contains('user_id', $user->uuid))
            || ($task->assignee_id === $user->uuid);
    }

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->hasRole(Role::Admin) || $user->hasRole(Role::Manager);
    }
}
