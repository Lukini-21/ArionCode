<?php

namespace App\Models;

use App\Contracts\ActivityLog\EntityType;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class TaskComment extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'task_id',
        'author_id',
        'body',
    ];

    /**
     * @return EntityType
     */
    public function getEntityType(): EntityType
    {
        return EntityType::TaskComment;
    }

    /**
     * @return \App\Support\Auth\User|null
     */
    public function getAuthorAttribute()
    {
        return \App\Support\Auth\User::getByField("uuid", $this->author_id);
    }
}
