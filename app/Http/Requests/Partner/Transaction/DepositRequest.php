<?php

namespace App\Http\Requests\Partner\Transaction;

use App\Api\V1\Http\Requests\BaseRequest;

class DepositRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'image' => ['required'],
            'amount' => ['required'],
            'description' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'Vui lòng đính kèm hóa đơn giao dịch.',
            'amount.required' => 'Vui lòng nhập số tiền giao dịch.',
        ];
    }
}
