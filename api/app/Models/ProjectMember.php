<?php

namespace App\Models;

use App\Contracts\ActivityLog\EntityType;
use App\Contracts\User\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Project member model
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null updated_at
 * @property Role $role
 * @property Project $project
 * @property \App\Support\Auth\User $member
 */
class ProjectMember extends BaseModel
{
    /**
     * @var \class-string[]
     */
    protected $casts = [
        'role' => Role::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'starts_at',
        'ends_at',
        'user_id',
        'role',
        'project_id',
    ];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return \App\Support\Auth\User|null
     */
    public function getMemberAttribute()
    {
        $user = \App\Support\Auth\User::getByField("uuid", $this->user_id);
        $user->role = $this->role;

        return $user;
    }

    /**
     * @return EntityType
     */
    public function getEntityType(): EntityType
    {
        return EntityType::ProjectMember;
    }
}
