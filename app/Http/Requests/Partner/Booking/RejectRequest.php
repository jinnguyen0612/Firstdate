<?php

namespace App\Http\Requests\Partner\Booking;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Booking\BookingStatus;
use App\Models\Booking;
use Illuminate\Contracts\Validation\Validator;

class RejectRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'id' => ['required', 'exists:App\Models\Booking,id'],
            'note' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'note.required' => 'Vui lòng nhập lí do từ chối.',
        ];
    }
}
