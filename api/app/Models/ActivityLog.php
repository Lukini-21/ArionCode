<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Models changes log
 */
class ActivityLog extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'action',
        'actor_id',
        'subject_type',
        'subject_id',
        'changes',
    ];
}
