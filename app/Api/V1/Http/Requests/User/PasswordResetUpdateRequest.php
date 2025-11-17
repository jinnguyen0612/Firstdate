<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;

class PasswordResetUpdateRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'email' => ['required', 'exists:App\Models\User,email'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email này không tồn tại trong hệ thống.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ];
    }
}
