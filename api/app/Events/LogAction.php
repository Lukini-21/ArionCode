<?php

namespace App\Events;

use App\Contracts\ActivityLog\EntityAction;
use App\Contracts\ActivityLog\EntityType;
use App\Support\Auth\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogAction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public EntityType $entityType;
    public Model $entity;
    public EntityAction $action;
    public ?User $actor;

    public function __construct(EntityType $entityType, Model $entity, EntityAction $action, ?User $actor = null)
    {
        $this->action = $action;
        $this->entityType = $entityType;
        $this->entity = $entity;
        $this->actor = $actor;
    }
}