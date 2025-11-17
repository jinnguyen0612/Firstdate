<?php

namespace App\Enums\Weekday;

use App\Supports\Enum;

enum Weekday: int
{
    use Enum;
    case Sunday = 0;
    case Monday = 1;
    case Tuesday = 2;
    case Wednessday = 3;
    case Thursday = 4;
    case Frisday = 5;
    case Saturday = 6;
}
