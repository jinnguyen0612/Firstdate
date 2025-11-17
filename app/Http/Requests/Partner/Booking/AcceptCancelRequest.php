<?php

namespace App\Http\Requests\Partner\Booking;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Booking\BookingStatus;
use App\Models\Booking;
use Illuminate\Contracts\Validation\Validator;

class AcceptCancelRequest extends BaseRequest
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
            'reason' => ['required'],
            'checkbox' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'reason.required' => 'Vui lòng nhập lí do hủy.',
        ];
    }
}
