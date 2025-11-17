<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'fullname' => ['required', 'string'],
            'is_checked' => ['nullable'],
            'phone' => [
                'nullable',
                'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
            ],
            'bank_name' => [
                'required_if:is_checked,1',
            ],
            'bank_account_number' => [
                'required_if:is_checked,1',
            ],
            'bank_account' => [
                'required_if:is_checked,1',
            ],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $email = $this->email;
            $phone = $this->phone;

            if ($email && User::where('email', $email)->where('active', 1)->exists()) {
                $validator->errors()->add('email', __('Email đã được đăng ký.'));
            }

            if ($phone && User::where('phone', $phone)->where('is_phone', 1)->exists()) {
                $validator->errors()->add('phone', __('Số điện thoại đã được đăng ký.'));
            }
        });
    }
}
