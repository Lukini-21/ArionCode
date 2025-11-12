<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
class TaskAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Task
     */
    public Task $task;

    /**
     * Create a new event instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function broadcastOn(): array
    {
        // каждому пользователю — свой приватный канал
        return [new PrivateChannel('users.' . $this->task->assignee_id)];
    }

    public function broadcastAs(): string
    {
        return 'TaskAssigned';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->task->id,
            'title' => $this->task->title,
            'status' => $this->task->status,
        ];
    }
}
