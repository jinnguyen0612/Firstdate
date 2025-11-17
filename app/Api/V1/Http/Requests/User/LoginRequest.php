<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\User\UserStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'username' => ['required'],
            'otp' => ['required', 'string'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $username = $this->username;
            $otp      = $this->otp;
            // 1) Xác định là email hay phone
            $isEmail = filter_var($username, FILTER_VALIDATE_EMAIL) !== false;

            if ($isEmail) {
                $user = DB::table('users')->where('email', $username)->first();
            } else {
                $user = DB::table('users')->where('phone', $username)->first();
            }

            if (!$user) {
                $validator->errors()->add('username', __('Không tìm thấy tài khoản.'));
                return;
            }

            if (
                $user->status !== UserStatus::Active->value
                && $user->status !== UserStatus::Draft->value
            ) {
                $validator->errors()->add('username', __('Tài khoản không hợp lệ.'));
                return;
            }

            if ($user->status == UserStatus::Locked->value) {
                $validator->errors()->add('username', __('Tài khoản đã bị khóa.'));
                return;
            }
        });
    }


    public function messages()
    {
        return [
            'username.required' => 'Vui lòng nhập số điện thoại hoặc email',
            'otp.required' => 'Vui lòng nhập mã đăng nhập',
            'otp.min' => 'Mã đăng nhập không hợp lệ',
            'otp.max' => 'Mã đăng nhập không hợp lệ',
        ];
    }
}
