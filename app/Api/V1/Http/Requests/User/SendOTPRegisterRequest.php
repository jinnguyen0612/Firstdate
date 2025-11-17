<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendOTPRegisterRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'email' => ['required',function ($attribute, $value, $fail) {
                    if (\App\Models\User::where('email', $value)->exists()) {
                        $fail('Email đã tồn tại tài khoản.');
                    }
                },
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập email.',
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
