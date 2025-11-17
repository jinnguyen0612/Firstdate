<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Validation\Validator;
use App\Api\V1\Repositories\Answer\AnswerRepositoryInterface;
use App\Enums\User\UserStatus;

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
            'phone' => [
                'required',
                'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                'unique:users,phone'
            ],
            'email' => ['required', 'email', 'unique:users,email'],
            'pin' => ['required', 'string', 'min:6', 'max:6'],
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
            'pin.required' => 'Mã PIN không được để trống.',
            'pin.min' => 'Mã PIN phải có đúng 6 ký tự.',
            'pin.max' => 'Mã PIN phải có đúng 6 ký tự.',
        ];
    }
}
