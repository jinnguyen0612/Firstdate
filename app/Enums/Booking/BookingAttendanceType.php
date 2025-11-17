<?php

namespace App\Enums\Booking;


use App\Admin\Support\Enum;

enum BookingAttendanceType: string
{
    use Enum;

    case Late = 'late';
    case Absent = 'absent';
    case Attended = 'attended';

}
