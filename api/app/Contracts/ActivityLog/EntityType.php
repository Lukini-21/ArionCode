<?php

namespace App\Contracts\ActivityLog;

enum EntityType: string
{
    case Project = 'project';
    case Task = 'task';
    case Organization = 'organization';
    case Notification = 'notification';
    case TaskComment = 'task_comment';
    case ProjectMember = 'project_member';
    case OrganizationMember = 'organization_member';
}
