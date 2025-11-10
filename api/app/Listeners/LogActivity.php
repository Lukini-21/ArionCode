<?php

namespace App\Listeners;

use App\Events\AbstractEntityAction;
use App\Models\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogActivity implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AbstractEntityAction $event): void
    {
        ActivityLog::create([
            'subject_type' => $event->entityType,
            'subject_id' => $event->entity->id ?? null,
            'action' => class_basename($event),
            'actor_id' => $event->actor?->uuid ?? null,
            'changes' => json_encode($event->entity->toArray()),
        ]);
    }
}
