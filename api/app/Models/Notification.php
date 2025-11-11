<?php

namespace App\Models;

use App\Contracts\Notification\Type;
use App\Contracts\User\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Organization model
 *
 * @property int $id
 * @property int $organization_id
 * @property string $user_id
 * @property Role $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Organization $organization
 */
class Notification extends Model
{
    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'role' => Role::class,
        'type' => Type::class,
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'message',
        'user_id',
        'type',
        'read_at'
    ];

    /**
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(function ($query) {
            $query->where('user_id', auth()->user()->uuid);
        });
    }
}
