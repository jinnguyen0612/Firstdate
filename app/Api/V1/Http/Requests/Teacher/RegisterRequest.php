<?php

namespace App\Api\V1\Http\Requests\Teacher;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Models\Teacher;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'fullname' => ['required', 'string'],
            'phone' => [
                'nullable',
                'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                'unique:teachers,phone'
            ],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $email = $this->email;

            if ($email && Teacher::where('email', $email)->where('active', 1)->exists()) {
                $validator->errors()->add('email', __('Email đã được đăng ký.'));
            }
        });
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Họ và tên không được để trống.',
            'fullname.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'phone_verified.regex' => 'Số điện thoại không hợp lệ.',
            'phone_verified.unique' => 'Số điện thoại đã được sử dụng.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'bank_name.required_if' => 'Tên ngân hàng là bắt buộc khi bạn chọn kiểm tra.',
            'bank_account_number.required_if' => 'Số tài khoản ngân hàng là bắt buộc khi bạn chọn kiểm tra.',
            'bank_account.required_if' => 'Chủ tài khoản là bắt buộc khi bạn chọn kiểm tra.',
        ];
    }
}
