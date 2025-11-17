<?php

namespace App\Admin\Http\Requests\RejectReason;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;

class RejectReasonRequest extends BaseRequest
{
    protected function methodPut(): array
    {
        return [
            'reasons' => ['required', 'array'],
            'reasons.*.id' => ['nullable'],
            'reasons.*.reason' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'reasons.*.reason.required' => 'Lý do không được để trống.',
        ];
    }

}