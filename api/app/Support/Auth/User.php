<?php

namespace App\Support\Auth;

use App\Contracts\User\Role;
use Illuminate\Auth\GenericUser;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * @property string $uuid
 * @property integer $orgId
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string[] $roles
 */
class User extends GenericUser
{
    use Authorizable;

    public function hasRole(Role $role): bool
    {
        return in_array($role->value, $this->attributes['roles']);
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}