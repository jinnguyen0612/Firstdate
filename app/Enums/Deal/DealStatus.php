<?php

namespace App\Enums\Deal;


use App\Admin\Support\Enum;

enum DealStatus: string
{
    use Enum;

    case Pending = 'pending';
    case Cancelled = 'cancelled';
    case Confirmed = 'confirmed';

    public function badge()
    {
        return match ($this) {
            DealStatus::Pending => 'bg-primary',
            DealStatus::Confirmed => 'bg-green',
            DealStatus::Cancelled => 'bg-red',
        };
    }
}
