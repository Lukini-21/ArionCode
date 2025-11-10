<?php

namespace App\Services;

use App\Contracts\ActivityLog\EntityType;
use App\Models\Organization;
use App\Models\OrganizationUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class OrganizationService extends AbstractService
{
    /**
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection<int, OrganizationUser>
     */
    public function getUserAvailableOrganizations(string $userId): Collection
    {
        $cacheKey = auth()->user()->uuid . "_" . EntityType::Organization->value;
        return Cache::tags($this->getCacheTags())->remember($cacheKey, 180, function () use ($userId) {
            return OrganizationUser::query()
                ->select(['organization_users.role', 'organizations.*'])
                ->join('organizations', 'organizations.id', '=', 'organization_users.organization_id')
                ->whereNull('organizations.deleted_at')
                ->where('user_id', $userId)->get();
        });
    }

    /**
     * @param FormRequest $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(FormRequest $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Organization::query()->paginate($request->get('per_page', 20));
    }

    /**
     * @param int $id
     * @return Organization
     */
    public function get(int $id): Organization
    {
        return Organization::query()->findOrFail($id);
    }

    /**
     * @return array
     */
    protected function getCacheTags(): array
    {
        return [EntityType::Organization->value, 'user_' . auth()->user()->uuid];
    }
}