<?php

namespace App\Enums\Process;


use App\Admin\Support\Enum;

enum ProcessType: string
{
    use Enum;

    case PayDeposit = 'pay_deposit';
    case MakeDeal = 'make_deal';

}
