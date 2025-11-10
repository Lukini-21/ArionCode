<?php

namespace App\Events;

use App\Contracts\ActivityLog\EntityType;
use App\Support\Auth\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class AbstractEntityAction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public EntityType $entityType;
    public Model $entity;
    public ?User $actor;

    public function __construct(EntityType $entityType, Model $entity, ?User $actor = null)
    {
        $this->entityType = $entityType;
        $this->entity = $entity;
        $this->actor = $actor;
    }
}