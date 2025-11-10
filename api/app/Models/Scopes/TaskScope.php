<?php

namespace App\Models\Scopes;

use App\Contracts\User\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TaskScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        /** @var \App\Support\Auth\User $user */
        $user = auth()->user();

        if (!$user) {
            $builder->whereRaw('1 = 0');
            return;
        }

        if ($user->orgId) {
            $builder->whereHas('project.organization', function (Builder $q) use ($user) {
                $q->where('id', $user->orgId);
            });
        }

        // --- Admin
        if ($user->hasRole(Role::Admin)) {
            $builder->whereHas('project.organization', function (Builder $q) use ($user) {
                $q->where('id', $user->orgId);
            });
            return;
        }

        // --- Manager
        if ($user->hasRole(Role::Manager)) {
            $builder->whereHas('project.members', function (Builder $q) use ($user) {
                $q->where('user_id', $user->uuid)
                    ->where('role', Role::Manager);
            });
            return;
        }

        // --- Member
        if ($user->hasRole(Role::Member)) {
            $builder->where(function ($q) use ($user) {
                $q->where('assignee_id', $user->uuid)
                    ->orWhereHas('project', function ($q2) use ($user) {
                        $q2->where('is_public', true)
                            ->whereHas('organization', function ($q3) use ($user) {
                                $q3->where('id', $user->orgId);
                            });
                    });
            });
        }
    }
}
