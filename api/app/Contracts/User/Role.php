<?php

namespace App\Contracts\User;

enum Role: string
{
    case Member = 'member';
    case Manager = 'manager';
    case Admin = 'admin';
}
