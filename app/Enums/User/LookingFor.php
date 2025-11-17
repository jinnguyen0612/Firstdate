<?php

namespace App\Enums\User;

use App\Supports\Enum;

enum LookingFor: string
{
    use Enum;
    case Male = 'male';
    case Female = 'female';
    case Both = 'both';
}
