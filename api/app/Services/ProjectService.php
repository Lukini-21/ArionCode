<?php

namespace App\Services;

use App\Contracts\ActivityLog\EntityType;
use App\Contracts\User\Role;
use App\Http\Requests\Project\AssignMembersRequest;
use App\Http\Requests\Project\ProjectCreateRequest;
use App\Http\Requests\Project\ProjectDeleteRequest;
use App\Http\Requests\Project\ProjectListRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Http\Requests\Project\SetStatusRequest;
use App\Models\Project;
use App\Support\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Project service
 */
class ProjectService extends AbstractService
{
    /**
     * Task list
     *
     * @param ProjectListRequest $request
     * @return LengthAwarePaginator
     */
    public function list(ProjectListRequest $request): LengthAwarePaginator
    {
        $cacheKey = auth()->user()->uuid . "_" . EntityType::Project->value;
        return Cache::tags($this->getCacheTags())->remember($cacheKey, 180, function () use ($request) {
            return Project::query()
                ->with(['members', 'tasks'])
                ->where($this->filter($request))
                ->orderBy($request->input('sortBy', 'id'), $request->input('sortOrder', 'asc'))
                ->paginate($request->get('per_page', 20));
        });
    }

    /**
     * @param int $id
     * @return Project
     */
    public function get(int $id): Project
    {
        return Project::query()->findOrFail($id);
    }

    /**
     * @param ProjectCreateRequest $request
     * @return Project
     */
    public function create(ProjectCreateRequest $request): Project
    {
        /** @var User $user */
        $user = auth()->user();

        return DB::transaction(function () use ($request, $user) {
            $project = Project::query()->create([
                ...$request->validated(),
                'organization_id' => $user->orgId
            ]);

            $project->members()->create([
                'user_id' => $user->uuid,
                'role' => Role::Manager
            ]);

            $this->clearCache();
            return $project;
        });
    }

    /**
     * @param ProjectUpdateRequest $request
     * @return Model
     */
    public function update(ProjectUpdateRequest $request): Model
    {
        $project = $request->getModel();
        $project->update($request->validated());
        $this->clearCache();

        return $project;
    }

    /**
     * @param ProjectDeleteRequest $request
     * @return bool|null
     */
    public function delete(ProjectDeleteRequest $request): ?bool
    {
        $result = $request->getModel()->delete();
        $this->clearCache();

        return $result;
    }

    /**
     * List filter
     *
     * @param ProjectListRequest $request
     * @return Callable
     */
    private function filter(ProjectListRequest $request): Callable
    {
        return function ($query) use ($request) {
            $query->when($request->filled('search'), fn($query) => $query->whereLike('name', "%{$request->input('search')}%"));
            $query->when($request->filled('status'), fn($query) => $query->where('status', $request->input('status')));
            // other filters
        };
    }

    /**
     * @param SetStatusRequest $request
     * @return void
     */
    public function setStatus(SetStatusRequest $request): void
    {
        $this->clearCache();

        $request->getModel()->update($request->validated());
    }

    /**
     * @param AssignMembersRequest $request
     * @return void
     */
    public function assignMembers(AssignMembersRequest $request)
    {
        $project = $request->getModel();
        $userIds = $request->validated()['ids'] ?? null;

        foreach ($userIds as $id) {
            $project->members()->firstOrCreate(['user_id' => $id]);
        }
    }

    protected function getCacheTags(): array
    {
        return [EntityType::Project->value, 'user_' . auth()->user()->uuid];
    }
}