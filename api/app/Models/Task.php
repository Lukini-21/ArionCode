<?php

namespace App\Models;

use App\Contracts\Task\Priority;
use App\Contracts\Task\Status;
use App\Models\Scopes\TaskScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Task model
 *
 * @property int $id
 * @property int $project_id
 * @property string $title
 * @property string $description
 * @property Status $status
 * @property Priority $priority
 * @property Carbon|null $due_at
 * @property int $assignee_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Project $project
 * @property Collection<Task> $dependedTasks
 * @property Collection<Task> $dependentOn
 * @property Collection<TaskComment> $comments
 * @property \App\Support\Auth\User $assignee
 */
class Task extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_at',
        'assignee_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'priority' => Priority::class,
        'status' => Status::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'due_at' => 'datetime',
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TaskScope);
    }

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
    public function getAssigneeAttribute()
    {
        $assigneeId = $this->assignee_id;
        $mockUsers = collect(config('demo.users', []));

        $mockUserData = $mockUsers->firstWhere('uuid', $assigneeId);

        return $mockUserData
            ? new \App\Support\Auth\User($mockUserData)
            : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dependedTasks()
    {
        return $this->belongsToMany(
            Task::class,
            'task_dependencies',
            'task_id',
            'depends_on_task_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dependentOn()
    {
        return $this->belongsToMany(
            Task::class,
            'task_dependencies',
            'depends_on_task_id',
            'task_id'
        );
    }

    /**
     * @return HasMany
     */
    public function comments(): hasMany
    {
        return $this->hasMany(TaskComment::class);
    }
}
