<?php

namespace App\Models\Scopes;

use App\Contracts\User\Role;
use App\Support\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrganizationScope implements Scope
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
        if ($user->hasRole(Role::Admin)) {
            $builder->whereHas('users', function (Builder $q) use ($user) {
                $q->where('user_id', $user->uuid)
                    ->where('role', Role::Admin);
            });
            return;
        }

        if ($user->hasRole(Role::Manager) || $user->hasRole(Role::Member)) {
            $builder->whereHas('users', function ($q) use ($user) {
                $q->where('user_id', $user->uuid);
            });
            return;
        }

        if ($user->orgId) {
            $builder->where('id', $user->orgId);
        }
    }
}
