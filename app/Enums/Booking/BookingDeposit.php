<?php

namespace App\Enums\Booking;


use App\Admin\Support\Enum;

enum BookingDeposit: string
{
    use Enum;

    case Pending = 'pending'; // Cho duyet -> khi chuyen khoan
    case Paid = 'paid';
    case Refunded = 'refunded';
    case Forfeited = 'forfeited';

}
