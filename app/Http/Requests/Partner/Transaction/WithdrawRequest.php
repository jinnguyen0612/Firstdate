<?php

namespace App\Http\Requests\Partner\Transaction;

use App\Admin\Traits\AuthService;
use App\Api\V1\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;


class WithdrawRequest extends BaseRequest
{
    use AuthService;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'amount' => ['required'],
            'description' => ['nullable'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $currentPartner = $this->getCurrentPartner();
            if($currentPartner->bank_name == null || $currentPartner->bank_acc_name == null || $currentPartner->bank_acc_number == null){
                $validator->errors()->add('amount', __('Tài khoản chưa liên kết ngân hàng vui lòng liên kết ngân hàng để thực hiện lệnh.'));
                return;
            }

            if ($this->amount > $currentPartner->wallet) {
                $validator->errors()->add('amount', __('Ví của bạn không đủ số dư để thực hiện lệnh.'));
                return;
            }
        });
    }
}