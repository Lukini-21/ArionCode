<?php

namespace App\Models;

use App\Contracts\ActivityLog\EntityAction;
use App\Contracts\ActivityLog\EntityType;
use App\Events\LogAction;
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
            event(new LogAction($model->getEntityType(), $model, EntityAction::Deleted, auth()->user()));
        });

        static::created(function (self $model) {
            event(new LogAction($model->getEntityType(), $model, EntityAction::Created, auth()->user()));
        });

        static::updated(function (self $model) {
            event(new LogAction($model->getEntityType(), $model, EntityAction::Updated, auth()->user()));
        });
    }

    abstract public function getEntityType(): EntityType;
}