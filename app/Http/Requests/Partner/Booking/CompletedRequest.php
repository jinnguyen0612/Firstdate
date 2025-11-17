<?php

namespace App\Http\Requests\Partner\Booking;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Booking\BookingStatus;
use App\Models\Booking;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;

class CompletedRequest extends BaseRequest
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
            'total' => ['nullable'],
            'invoice' => ['nullable'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $booking = Booking::find($this->input('id'));

            if ($booking->status == BookingStatus::Processing->value) {
                if(!$this->input('total')) {
                    $validator->errors()->add('total', 'Vui lý nhập tống tiền.');
                }

                if(!$this->file('invoice')) {
                    $validator->errors()->add('invoice', 'Vui lý nhập hóa đơn.');
                }
            }
            if($booking->status == BookingStatus::Completed->value) {
                $validator->errors()->add('id', 'Cuộc hẹn này đã hoàn thành.');
            }
            if($booking->status == BookingStatus::Cancelled->value) {
                $validator->errors()->add('id', 'Cuộc hẹn này đã huỷ.');
            }
            if($booking->status == BookingStatus::Pending->value) {
                $validator->errors()->add('id', 'Cuộc hẹn này chưa được duyệt.');
            }
        });
    }
}
