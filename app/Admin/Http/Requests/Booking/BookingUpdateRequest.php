<?php

namespace App\Admin\Http\Requests\Booking;

use App\Admin\Http\Requests\BaseRequest;

class BookingUpdateRequest extends BaseRequest
{
    protected function methodPut(): array
    {
        return [
            'id' => ['required','exists:App\Models\Booking,id'],
            'status' => ['required'],
        ];
    }

}
