<?php

namespace App\Contracts\ActivityLog;

enum EntityType: string
{
    case Project = 'project';
    case Task = 'task';
    case Organization = 'organization';
    case Notification = 'notification';
}
