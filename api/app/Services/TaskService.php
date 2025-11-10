<?php

namespace App\Services;

use App\Contracts\ActivityLog\EntityType;
use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdated;
use App\Events\TaskAssigned;
use App\Http\Requests\Task\CommentRequest;
use App\Http\Requests\Task\SetStatusRequest;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Http\Requests\Task\TaskDeleteRequest;
use App\Http\Requests\Task\TaskListRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

/**
 * Task service
 */
class TaskService extends AbstractService
{
    /**
     * Task list
     *
     * @param TaskListRequest $request
     * @return LengthAwarePaginator
     */
    public function list(TaskListRequest $request): LengthAwarePaginator
    {
        $cacheKey = auth()->user()->uuid . "_" . EntityType::Task->value;
        return Cache::tags($this->getCacheTags())->remember($cacheKey, 180, function () use ($request) {
            return Task::query()
                ->with(['dependentOn', 'dependentOn', 'comments'])
                ->where($this->filter($request))
                ->orderBy($request->input('sortBy', 'id'), $request->input('sortOrder', 'asc'))
                ->paginate($request->get('per_page', 20));
        });
    }

    /**
     * @param int $id
     * @return Task
     */
    public function get(int $id): Task
    {
        return Task::query()->findOrFail($id);
    }

    /**
     * List filter
     *
     * @param TaskListRequest $request
     * @return Callable
     */
    private function filter(TaskListRequest $request): callable
    {
        return function ($query) use ($request) {
            $query->when($request->filled('search'), fn($query) => $query->whereLike('name', "%{$request->input('search')}%"));
            foreach (['status', 'priority', 'assignee_id'] as $field) {
                $query->when($request->filled($field), fn($query) => $query->where($field, $request->input($field)));
            }
            // other filters
        };
    }

    /**
     * @param TaskCreateRequest $request
     * @return Task
     */
    public function create(TaskCreateRequest $request): Task
    {
        $task = Task::query()->create($request->validated());
        event(new EntityCreated(EntityType::Task, $task, auth()->user()));
        $this->sendAssignNotification($task);
        $this->clearCache();

        return $task;
    }

    /**
     * @param TaskUpdateRequest $request
     * @return Task
     */
    public function update(TaskUpdateRequest $request): Model
    {
        /** @var Task $task */
        $task = $request->getModel();
        $assigneeId = $task->assignee_id;
        $task->update($request->validated());
        event(new EntityUpdated(EntityType::Task, $task, auth()->user()));
        if (!empty($task->assignee_id) && $task->assignee_id !== $assigneeId) {
            $this->sendAssignNotification($task);
        }
        $this->clearCache();

        return $task;
    }

    /**
     * @param TaskDeleteRequest $request
     * @return bool|null
     */
    public function delete(TaskDeleteRequest $request): ?bool
    {
        event(new EntityDeleted(EntityType::Task, $request->getModel(), auth()->user()));
        $result = $request->getModel()->delete();
        Cache::tags([EntityType::Task->value])->flush();

        return $result;
    }

    /**
     * @param SetStatusRequest $request
     * @return void
     */
    public function setStatus(SetStatusRequest $request): void
    {
        event(new EntityUpdated(EntityType::Task, $request->getModel(), auth()->user()));

        $request->getModel()->update($request->validated());
        $this->clearCache();
    }

    /**
     * @param CommentRequest $request
     * @return void
     */
    public function addComment(CommentRequest $request): void
    {
        $request->getModel()->comments()->create([
            'body' => $request->input('comment'),
            'author_id' => $request->user()->uuid,
        ]);
        $this->clearCache();
    }

    /**
     * @param Task $task
     * @return void
     */
    public function sendAssignNotification(Task $task): void
    {
        if (!empty($task->assignee_id)) {
            event(new TaskAssigned($task));
        }
    }

    protected function getCacheTags(): array
    {
        return [EntityType::Task->value, 'user_' . auth()->user()->uuid];
    }
}