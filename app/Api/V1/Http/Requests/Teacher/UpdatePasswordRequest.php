<?php

namespace App\Api\V1\Http\Requests\Teacher;

use App\Api\V1\Http\Requests\BaseRequest;

class UpdatePasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPost()
    {
        return [
            'old_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Mật khẩu cũ là bắt buộc.',
            'old_password.current_password' => 'Mật khẩu cũ không chính xác.',
            'password.required' => 'Mật khẩu mới là bắt buộc.',
            'password.string' => 'Mật khẩu mới phải là chuỗi ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ];
    }
}
