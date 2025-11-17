<?php

namespace App\Enums\Booking;


use App\Admin\Support\Enum;

enum BookingStatus: string
{
    use Enum;

    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Processing = 'processing';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    public function badge()
    {
        return match ($this) {
            BookingStatus::Pending => 'bg-gray',
            BookingStatus::Confirmed => 'bg-info',
            BookingStatus::Processing => 'bg-primary',
            BookingStatus::Cancelled => 'bg-danger',
            BookingStatus::Completed => 'bg-success',
        };
    }

    public function getPartnerDescription()
    {
        return match ($this) {
            BookingStatus::Pending => 'Mới',
            BookingStatus::Confirmed => 'Đã lên lịch',
            BookingStatus::Processing => 'Đang diễn ra',
            BookingStatus::Cancelled => 'Đã hủy',
            BookingStatus::Completed => 'Đã hoàn thành',
        };
    }

    public function getPartnerTextColor()
    {
        return match ($this) {
            BookingStatus::Pending => 'text-info',
            BookingStatus::Confirmed => 'text-warning',
            BookingStatus::Processing => 'text-default',
            BookingStatus::Cancelled => 'text-gray',
            BookingStatus::Completed => 'text-success',
        };
    }
}
