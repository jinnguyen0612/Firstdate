<?php

namespace App\Admin\Http\Requests\User;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\User\DatingTime;
use App\Enums\User\Gender;
use App\Enums\User\LookingFor;
use App\Enums\User\Relationship;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UserRequest extends BaseRequest
{
    protected function methodPost(): array
    {
        return [
            'email' => ['required', 'email', 'unique:App\Models\User,email'],
            'phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:App\Models\User,phone'],
            'fullname' => ['required', 'string'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'gender' => ['required', new Enum(Gender::class)],
            'looking_for' => ['required', new Enum(LookingFor::class)],
            'description' => ['nullable'],
            'max_age_find' => ['required'],
            'province' => ['required'],
            'district' => ['required'],
            'lat' => ['required'],
            'lng' => ['required'],
            'avatar' => ['nullable', 'string'],
            'thumbnails' => ['nullable'],
            'is_hide' => ['required'],
            'dating_time' => ['required', 'array'],
            'dating_time.*' => [new Enum(DatingTime::class)],
            'relationship' => ['required', 'array'],
            'relationship.*' => [new Enum(Relationship::class)],
        ];
    }

    protected function methodPut(): array
    {
        $id = request()->route('id') ?? request()->get('id');

        return [
            'id' => ['required','exists:App\Models\User,id'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', Rule::unique('users', 'phone')->ignore($id)],
            'fullname' => ['required', 'string'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'gender' => ['required', new Enum(Gender::class)],
            'looking_for' => ['required', new Enum(LookingFor::class)],
            'description' => ['nullable'],
            'max_age_find' => ['required'],
            'province' => ['required'],
            'district' => ['required'],
            'lat' => ['required'],
            'lng' => ['required'],
            'avatar' => ['nullable', 'string'],
            'thumbnails' => ['nullable'],
            'is_hide' => ['required'],
            'dating_time' => ['nullable', 'array'],
            'dating_time.*' => [new Enum(DatingTime::class)],
            'relationship' => ['nullable', 'array'],
            'relationship.*' => [new Enum(Relationship::class)],
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Fullname is required',
            'email.unique' => 'Email already exists',
            'phone.regex' => 'Phone number format is invalid',
            'gender.required' => 'Gender is required',
            'password.confirmed' => 'Password confirmation does not match',
            'active.required' => 'Active status is required',
        ];
    }
}
