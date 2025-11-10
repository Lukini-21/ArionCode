<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Organization model
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Collection<OrganizationUser> $users
 * @property Collection<Project> $projects
 */
class Organization extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $casts = [
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
      'deleted_at' => 'datetime',
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new OrganizationScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(OrganizationUser::class, 'organization_id');
    }

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'organization_id');
    }
}
