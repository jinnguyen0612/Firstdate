<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;

class VerifyOTPRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'email' => ['required', 'exists:App\Models\Otp,email'],
            'token_account' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email là bắt buộc.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
            'token_account.required' => 'Mã kích hoạt tài khoản là bắt buộc.',
        ];
    }
}
