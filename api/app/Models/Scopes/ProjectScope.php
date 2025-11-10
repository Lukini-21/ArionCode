<?php

namespace App\Models\Scopes;

use App\Contracts\User\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ProjectScope implements Scope
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

        $builder->whereHas('organization', function (Builder $q) use ($user) {
            $q->whereHas('users', function (Builder $q) use ($user) {
                $q->where('user_id', $user->uuid);
            })->when(!empty($user->orgId), function (Builder $q) use ($user) {
                $q->where('id', $user->orgId);
            });
        });

        // --- Org Admin
        if ($user->hasRole(Role::Admin)) {
            return;
        }

        // --- Project Manager / Member
        if ($user->hasRole(Role::Manager)) {
            $builder->where(function ($query) use ($user) {
                // Where is member
                $query->whereHas('members', function ($q) use ($user) {
                    $q->where('user_id', $user->uuid);
                });

                // Public projects
                $query->orWhere(function ($q) use ($user) {
                    $q->where('is_public', true)
                        ->whereHas('organization', function ($q2) use ($user) {
                            $q2->where('id', $user->orgId);
                        });
                });
            });
        }
    }
}
