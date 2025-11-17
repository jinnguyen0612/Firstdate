<?php

namespace App\Api\V1\Http\Resources\Transaction;

use App\Enums\Transaction\TransactionType;

class TransactionMessage
{
    public static function message($type, $message)
    {
        return match ($type) {
            TransactionType::Deposit->value     => "Nạp {$message['value']} tim vào ví.",
            TransactionType::Withdraw->value    => "Rút {$message['value']} từ ví về tài khoản.",
            TransactionType::Payment->value     => "Thanh toán {$message['value']} tim cho {$message['service']}.",
            TransactionType::Refund->value      => "Hoàn {$message['value']} tim do {$message['service']}.",
            TransactionType::Receive->value     => "Nhận {$message['value']} tim từ {$message['service']}.",
            default                             => "",
        };
    }
}