<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;

class ProfileRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPut()
    {
        if (auth('admin')->user()) {
            $this->validate = [
                'fullname' => ['required', 'string', 'max:255'],
                'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:App\Models\Admin,phone,' . auth('admin')->user()->id],
                'address' => ['nullable'],
                'birthday' => ['nullable'],
                'gender' => ['required'],
                'avatar' => ['nullable'],
            ];
            return $this->validate;
        } else {
            $this->validate = [
                'fullname' => ['required', 'string', 'max:255'],
                'phone' => ['nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/'],
                'province_id' => ['nullable', 'exists:App\Models\Province,id'],
                'district_id' => ['nullable', 'exists:App\Models\District,id'],
                'ward_id' => ['nullable', 'exists:App\Models\Ward,id'],
                'email' => ['nullable'],
                'address' => ['nullable'],
                'birthday' => ['nullable'],
                'gender' => ['nullable'],
                'avatar' => ['nullable'],
                'is_checked' => ['nullable'],
                'bank_name' => [
                    'required_if:is_checked,1',
                ],
                'bank_account_number' => [
                    'required_if:is_checked,1',
                ],
                'bank_account' => [
                    'required_if:is_checked,1',
                ],
            ];
            return $this->validate;
        }
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if (!auth('admin')->user()) {
                $email = $this->email;
                $phone = $this->phone;
                $user = auth()->user();

                if (
                    $email && User::where('email', $email)
                    ->where('active', 1)
                    ->where('id', '!=', $user->id)
                    ->exists()
                ) {
                    $validator->errors()->add('email', __('Email đã được đăng ký.'));
                }

                if (
                    !$user->phone && !isset($this->email)
                ) {
                    $validator->errors()->add('email', __('Email đăng nhập không được bỏ trống.'));
                }

                if (
                    !empty($this->province_id) && (empty($this->district_id) || empty($this->ward_id))
                ) {
                    $validator->errors()->add('province_id', __('Vui lòng chọn đầy đủ thông tin địa chỉ.'));
                }

                if (
                    $phone && User::where('phone', $phone)
                    ->where('id', '!=', $user->id)
                    ->exists()
                ) {
                    $validator->errors()->add('phone', __('Số điện thoại đã được đăng ký.'));
                }
            }
        });
    }
}
