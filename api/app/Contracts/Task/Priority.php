<?php

namespace App\Contracts\Task;

enum Priority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Critical = 'critical';
}
