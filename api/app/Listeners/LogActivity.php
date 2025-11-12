<?php

namespace App\Listeners;

use App\Events\LogAction;
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
    public function handle(LogAction $event): void
    {
        ActivityLog::create([
            'subject_type' => $event->entityType,
            'subject_id' => $event->entity->id ?? null,
            'action' => $event->action->value,
            'actor_id' => $event->actor?->uuid ?? null,
            'changes' => json_encode($event->entity->toArray()),
        ]);
    }
}
