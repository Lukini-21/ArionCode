<?php

namespace App\Support\Auth;

use App\Contracts\User\Role;
use Illuminate\Auth\GenericUser;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * Mocked user model to avoid using DB `users` table
 *
 * @property string $uuid
 * @property integer $orgId
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string[] $roles
 * @property string $role
 */
class User extends GenericUser
{
    use Authorizable;

    /**
     * @param Role $role
     * @return bool
     */
    public function hasRole(Role $role): bool
    {
        return in_array($role->value, $this->attributes['roles']);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Get mocked user by field
     *
     * @param string $field
     * @param string $value
     * @return self|null
     */
    public static function getByField(string $field, string $value): ?self
    {
        $mockUsers = collect(config('demo.users', []));

        $mockUserData = $mockUsers->firstWhere($field, $value);

        return $mockUserData
            ? new self($mockUserData)
            : null;
    }
}