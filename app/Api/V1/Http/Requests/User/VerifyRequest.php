<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;

class VerifyRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'email' => ['required', 'exists:App\Models\User,email'],
            'token_active_account' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email là bắt buộc.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
            'token_active_account.required' => 'Mã kích hoạt tài khoản là bắt buộc.',
        ];
    }
}
