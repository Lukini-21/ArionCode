<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\UserResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Task $task  */
        $task = $this->resource;
        $assigned = $task->assignee_id  ?
            UserResource::make($task->assignee) : null;

        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'due_date' => $task->due_at,
            'status' => $task->status,
            'priority' => $task->priority,
            'assigned_to' => $assigned,
            'created_at' => $task->created_at,
            'depends_on' => $task->dependentOn->pluck('id'),
            'depended_tasks' => $task->dependedTasks->pluck('id'),
            'comments' => $task->comments,
        ];
    }
}
