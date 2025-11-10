<?php

namespace App\Listeners;

use App\Contracts\ActivityLog\EntityType;
use App\Contracts\Notification\Type;
use App\Events\TaskAssigned;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class SendEntityNotification implements ShouldQueue
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
    public function handle(TaskAssigned $event): void
    {
        Notification::create([
            'message' => "Task assigned: '{$event->task->title}'", // todo: create templates + locale
            'user_id' => $event->task->assignee_id,
            'type' => Type::Task,
        ]);
        Cache::tags([EntityType::Notification->value, 'user_' . $event->task->assignee_id])->flush();
        // todo: send email logic using queue
    }
}
