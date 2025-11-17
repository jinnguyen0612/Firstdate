<?php

namespace App\Http\Requests\Partner\Booking;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Booking\BookingStatus;
use App\Models\Booking;
use App\Models\PartnerTable;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;

class AcceptRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'code' => ['required', 'exists:App\Models\Booking,code'],
            'time' => ['required'],
            'partner_table_id' => ['required', 'exists:App\Models\PartnerTable,id'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $from = $this->input('from'); // hh:mm:ss
            $to = $this->input('to');     // hh:mm:ss
            $time = $this->input('time'); // hh:mm

            // Chuyển về Carbon (hoặc DateTime) cùng format
            try {
                $fromTime = \Carbon\Carbon::createFromFormat('H:i:s', $from);
                $toTime   = \Carbon\Carbon::createFromFormat('H:i:s', $to);
                $timeVal  = \Carbon\Carbon::createFromFormat('H:i', $time);
            } catch (\Exception $e) {                
                return;
            }

            if ($timeVal->lt($fromTime) || $timeVal->gt($toTime)) {
                $validator->errors()->add(
                    'time',
                    'Thời gian xác nhận đặt chỗ phải trong khoảng ' .
                        $fromTime->format('H:i') . ' - ' . $toTime->format('H:i')
                );
            }
            $booking = Booking::where('code', $this->input('code'))->first();
            $table = PartnerTable::where('id', $this->input('partner_table_id'))->first();
            if($booking->partner_id != $table->partner_id) {
                $validator->errors()->add(
                    'partner_table_id',
                    'Bạn không thể chọn bàn không thuộc nhà hàng khách hàng đặt chổ.'
                );
            }
        });
    }


    public function messages()
    {
        return [
            'time.required' => 'Vui lòng nhập thời gian xác nhận đặt chổ.',
            'code.exists' => 'Mã đặt chổ không tồn tại.',
        ];
    }
}
