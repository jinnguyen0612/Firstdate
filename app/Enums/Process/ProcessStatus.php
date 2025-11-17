<?php

namespace App\Enums\Process;


use App\Admin\Support\Enum;

enum ProcessStatus: string
{
    use Enum;

    case Running = 'running';
    case Hold = 'hold';
    case Cancelled = 'cancelled';
    case Done = 'done';

}
