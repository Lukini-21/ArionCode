<?php

namespace App\Contracts\ActivityLog;

enum EntityAction: string
{
    case Deleted = 'deleted';
    case Created = 'created';
    case Updated = 'updated';
}
