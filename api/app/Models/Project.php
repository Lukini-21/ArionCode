<?php

namespace App\Models;

use App\Contracts\Project\Status;
use App\Contracts\User\Role;
use App\Models\Scopes\ProjectScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Project model
 *
 * @property int $id
 * @property int $organization_id
 * @property int $manager_id
 * @property string $name
 * @property string $description
 * @property bool $is_public
 * @property Status $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $starts_at
 * @property Carbon|null $ends_at
 * @property Carbon|null $deleted_at
 * @property Organization $organization
 * @property Collection<ProjectMember> $members
 * @property Collection<Task> $task
 */
class Project extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $casts = [
        'status' => Status::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'description',
        'status',
        'starts_at',
        'ends_at',
        'is_public',
        'organization_id',
        'manager_id',
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new ProjectScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members(): HasMany
    {
        return $this->hasMany(ProjectMember::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
       return $this->belongsTo(Organization::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
