<?php

namespace App\Models;

use App\Contracts\ActivityLog\EntityType;
use App\Contracts\User\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Organization users model
 *
 * @property int $id
 * @property Organization $organization
 * @property int $organization_id
 * @property int $user_id
 * @property Role $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class OrganizationUser extends BaseModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * @var \class-string[]
     */
    protected $casts = [
        'role' => Role::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return EntityType
     */
    public function getEntityType(): EntityType
    {
        return EntityType::OrganizationMember;
    }

    /**
     * @return \App\Support\Auth\User|null
     */
    public function getUserAttribute()
    {
        $user = \App\Support\Auth\User::getByField("uuid", $this->user_id);
        $user->role = $this->role;

        return $user;
    }
}
