<?php

namespace App\Enums\Transaction;


use App\Admin\Support\Enum;

enum TransactionType: string
{
    use Enum;

    
    case Send = 'send';
    case Receive = 'receive';
    case Deposit = 'deposit'; 
    case Withdraw = 'withdraw';
    case Payment = 'payment';
    case Refund = 'refund';

    public function badge()
    {
        return match ($this) {
            TransactionType::Send => 'bg-primary',
            TransactionType::Receive => 'bg-success',
            TransactionType::Deposit => 'bg-success',
            TransactionType::Withdraw => 'bg-danger',
            TransactionType::Payment => 'bg-warning',
            TransactionType::Refund => 'bg-purple',
        };
    }
}
