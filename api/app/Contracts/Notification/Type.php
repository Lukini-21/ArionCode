<?php

namespace App\Contracts\Notification;

enum Type: string
{
    case Common = 'common';
    case Task = 'task';
    case Personal = 'personal';
    case Organization = 'organization';
    case Project = 'project';
}