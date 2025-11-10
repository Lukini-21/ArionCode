<?php

namespace App\Services;

use App\Contracts\ActivityLog\EntityType;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class NotificationService extends AbstractService
{
    /**
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(Request $request)
    {$this->clearCache();
        $cacheKey = auth()->user()->uuid . "_" . EntityType::Notification->value;
        return Cache::tags($this->getCacheTags())->remember($cacheKey, 180, function () use ($request) {
            return Notification::query()
                ->when($request->input('unread', false), function ($query) {
                    return $query->whereNull('read_at');
                })
                ->orderBy($request->input('sortBy', 'id'), $request->input('sortOrder', 'asc'))
                ->paginate($request->get('per_page', 20));
        });
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return Notification::findOrFail($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return Notification::findOrFail($id)->delete();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function setAsRead(int $id): void
    {
        Notification::findOrFail($id)->update(['read_at' => now()]);
        $this->clearCache();
    }

    /**
     * @return array
     */
    protected function getCacheTags(): array
    {
        return [EntityType::Notification->value, 'user_' . auth()->user()->uuid];
    }
}