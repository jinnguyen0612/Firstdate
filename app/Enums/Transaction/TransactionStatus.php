<?php

namespace App\Enums\Transaction;


use App\Admin\Support\Enum;

enum TransactionStatus: string
{
    use Enum;

    case Pending = 'pending';

    case Success = 'success';

    case Failed = 'failed';

    public function badge()
    {
        return match ($this) {
            TransactionStatus::Pending => 'bg-primary',
            TransactionStatus::Success => 'bg-success',
            TransactionStatus::Failed => 'bg-danger',
        };
    }

    public static function badgePartner($status)
    {
        if (!$status instanceof self) {
            $status = self::from($status); // Convert string -> Enum
        }

        return match ($status) {
            self::Pending => 'bg-warning',
            self::Success => 'bg-success',
            self::Failed => 'bg-gray',
        };
    }

    public static function textPartner($status)
    {
        if (!$status instanceof self) {
            $status = self::from($status); // Convert string -> Enum
        }

        return match ($status) {
            self::Pending => 'text-warning',
            self::Success => 'text-success',
            self::Failed => 'text-danger',
        };
    }
}
