<?php

namespace App\Api\V1\Http\Requests\Teacher;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\User\Gender;
use App\Models\Teacher;
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
            'birthday' => ['nullable', 'string'],
            'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/'],
            'gender' => ['nullable', new Enum(Gender::class)],
            'avatar' => ['nullable'],
            'address' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'fullname.string' => 'Họ và tên phải là chuỗi ký tự.',
            'birthday.string' => 'Ngày sinh phải là chuỗi ký tự.',
            'email.email' => 'Email không hợp lệ.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
            'gender.enum' => 'Giới tính không hợp lệ.',
            'bank_name.required_if' => 'Tên ngân hàng là bắt buộc khi chọn kiểm tra.',
            'bank_account_number.required_if' => 'Số tài khoản ngân hàng là bắt buộc khi chọn kiểm tra.',
            'bank_account.required_if' => 'Chủ tài khoản ngân hàng là bắt buộc khi chọn kiểm tra.',
        ];
    }
}
