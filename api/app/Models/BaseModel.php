<?php

namespace App\Models;

use App\Contracts\ActivityLog\EntityType;
use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdated;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
abstract class BaseModel extends Model
{
    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::deleted(function (self $model) {
            event(new EntityDeleted($model->getEntityType(), $model, auth()->user()));
        });

        static::created(function (self $model) {
            event(new EntityCreated($model->getEntityType(), $model, auth()->user()));
        });

        static::updated(function (self $model) {
            event(new EntityUpdated($model->getEntityType(), $model, auth()->user()));
        });
    }

    abstract public function getEntityType(): EntityType;
}