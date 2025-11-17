<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendOTPRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'email.max' => 'Email không được dài quá 255 ký tự.',
            'email.exists' => 'Email này chưa được đăng ký trong hệ thống.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Dữ liệu không hợp lệ.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
