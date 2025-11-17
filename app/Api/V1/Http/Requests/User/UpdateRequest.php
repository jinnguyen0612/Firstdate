<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\User\Gender;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'fullname' => ['nullable', 'string'],
            'phone' => [
                'nullable',
                'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
            ],
            'email' => ['nullable', 'email'],
            'gender' => ['nullable', 'string'],
            'district_id' => ['nullable'],
            'lng' => ['nullable'],
            'lat' => ['nullable'],
            'max_age_find' => ['nullable'],
            'looking_for' => ['nullable'],
            'avatar' => ['nullable'],
            'thumbnails' => ['nullable'],
            'is_hide' => ['nullable'],
            'is_subsidy_offer' => ['nullable', 'boolean'],
            'birthday' => ['nullable', 'date_format:Y-m-d'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $email = $this->email;
            $phone_verified = $this->phone_number;
            $userId = auth()->id();

            if (
                $email && User::where('id', '!=', $userId)
                ->where('email', $email)
                ->exists()
            ) {
                $validator->errors()->add('email', __('Email đã được đăng ký.'));
            }

            if (
                $phone_verified && User::where('phone_number', $phone_verified)
                ->where('id', '!=', $userId)
                ->exists()
            ) {
                $validator->errors()->add('phone_number', __('Số điện thoại đã được đăng ký.'));
            }
        });
    }

    public function messages()
    {
        return [
            'fullname.string' => 'Họ và tên phải là chuỗi ký tự.',
            'birthday.string' => 'Ngày sinh phải là chuỗi ký tự.',
            'email.email' => 'Email không hợp lệ.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
            'bank_name.required_if' => 'Tên ngân hàng là bắt buộc khi chọn kiểm tra.',
            'bank_account_number.required_if' => 'Số tài khoản ngân hàng là bắt buộc khi chọn kiểm tra.',
            'bank_account.required_if' => 'Chủ tài khoản ngân hàng là bắt buộc khi chọn kiểm tra.',
        ];
    }
}
