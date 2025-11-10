<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class TaskComment extends Model
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
     * @return \App\Support\Auth\User|null
     */
    public function getAuthorAttribute()
    {
        $assigneeId = $this->author_id;
        $mockUsers = collect(config('demo.users', []));

        $mockUserData = $mockUsers->firstWhere('uuid', $assigneeId);

        return $mockUserData
            ? new \App\Support\Auth\User($mockUserData)
            : null;
    }
}
