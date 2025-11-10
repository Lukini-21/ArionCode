<?php

namespace App\Contracts\Project;

enum Status: string
{
    case Active = 'active';
    case Planning = 'planning';
    case Completed = 'completed';
    case Hold = 'hold';
}