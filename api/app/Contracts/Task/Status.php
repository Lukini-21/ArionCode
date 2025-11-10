<?php

namespace App\Contracts\Task;

enum Status: string
{
    case Todo = 'todo';
    case Done = 'done';
    case Backlog = 'backlog';
    case InProgress = 'in_progress';
    case Review = 'review';
    case Blocked = 'blocked';
}
